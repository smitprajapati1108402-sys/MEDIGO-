<?php
// ==============================================================================
// MediGo Hospital Management System - Master Unified Patient Database Connection
// Synchronized with Admin and Doctor modules
// ==============================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting Configuration
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide raw errors from client responses

// XAMPP Default MySQL Credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "medigo";

$db_connected = false;
$db_error = "";

// 1. Establish MySQL Connection
$conn = @new mysqli($db_host, $db_user, $db_pass);

if ($conn->connect_error) {
    $db_connected = false;
    $db_error = $conn->connect_error;
    if (defined('API_REQUEST')) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'MySQL Connection Error: ' . $conn->connect_error . '. Please ensure MySQL is started in XAMPP Control Panel.'
        ]);
        exit;
    }
} else {
    // 2. Automatically Create Database if it does not exist
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    if ($conn->select_db($db_name)) {
        $db_connected = true;
        $conn->set_charset('utf8mb4');

        // Helper function for Schema Auto-Migration: Ensure all required columns exist in tables
        $ensure_columns = function($conn, $table, $cols) {
            $existing_cols = [];
            $res = $conn->query("SHOW COLUMNS FROM `$table`");
            if ($res) {
                while ($c = $res->fetch_assoc()) {
                    $existing_cols[strtolower($c['Field'])] = true;
                }
                foreach ($cols as $col_name => $col_def) {
                    if (!isset($existing_cols[strtolower($col_name)])) {
                        $conn->query("ALTER TABLE `$table` ADD `$col_name` $col_def");
                    }
                }
            }
        };

        // TABLE 1: Patients
        $conn->query("CREATE TABLE IF NOT EXISTS `patients` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL UNIQUE,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) DEFAULT NULL,
            `password` VARCHAR(255) NOT NULL DEFAULT '123456',
            `dob` VARCHAR(30) DEFAULT '',
            `age` VARCHAR(30) DEFAULT '45 Yrs',
            `gender` VARCHAR(20) DEFAULT 'Male',
            `blood_group` VARCHAR(10) DEFAULT 'O+',
            `blood` VARCHAR(10) DEFAULT 'O+',
            `phone` VARCHAR(30) DEFAULT '+91 98711 22334',
            `address` VARCHAR(255) DEFAULT 'Ahmedabad, Gujarat',
            `doctor_assigned` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
            `disease` VARCHAR(150) DEFAULT 'Hypertension',
            `allergies` VARCHAR(255) DEFAULT 'None',
            `contact_name` VARCHAR(100) DEFAULT '',
            `relationship` VARCHAR(50) DEFAULT '',
            `contact_phone` VARCHAR(30) DEFAULT '',
            `admission_date` DATE DEFAULT (CURRENT_DATE),
            `last_visit` VARCHAR(50) DEFAULT 'Today',
            `status` VARCHAR(50) DEFAULT 'Active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $ensure_columns($conn, 'patients', [
            'name' => "VARCHAR(150) NOT NULL DEFAULT ''",
            'password' => "VARCHAR(255) NOT NULL DEFAULT '123456'",
            'patient_id' => "VARCHAR(50) NOT NULL",
            'blood_group' => "VARCHAR(10) DEFAULT 'O+'",
            'blood' => "VARCHAR(10) DEFAULT 'O+'",
            'phone' => "VARCHAR(30) DEFAULT '+91 98711 22334'",
            'dob' => "VARCHAR(30) DEFAULT ''",
            'age' => "VARCHAR(30) DEFAULT '45 Yrs'",
            'gender' => "VARCHAR(20) DEFAULT 'Male'",
            'allergies' => "VARCHAR(255) DEFAULT 'None'",
            'status' => "VARCHAR(50) DEFAULT 'Active'"
        ]);

        $conn->query("UPDATE `patients` SET `blood` = `blood_group` WHERE `blood` IS NULL OR `blood` = ''");
        $conn->query("UPDATE `patients` SET `blood_group` = `blood` WHERE `blood_group` IS NULL OR `blood_group` = ''");

        // TABLE 2: Doctors
        $conn->query("CREATE TABLE IF NOT EXISTS `doctors` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `doctor_id` VARCHAR(50) NOT NULL UNIQUE,
            `doc_id` VARCHAR(50) NULL,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `password` VARCHAR(255) NOT NULL DEFAULT 'doctor123',
            `role` VARCHAR(50) DEFAULT 'Doctor',
            `department` VARCHAR(100) NOT NULL DEFAULT 'Cardiology',
            `specialty` VARCHAR(150) NOT NULL DEFAULT 'Cardiology',
            `experience` VARCHAR(50) DEFAULT '5+ Years',
            `phone` VARCHAR(30) NOT NULL DEFAULT '+91 98765 43210',
            `timing` VARCHAR(100) DEFAULT '09:00 AM - 05:00 PM',
            `fee` DECIMAL(10,2) DEFAULT 500.00,
            `avatar` VARCHAR(255) DEFAULT '',
            `status` VARCHAR(50) DEFAULT 'Available',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $ensure_columns($conn, 'doctors', [
            'doc_id' => "VARCHAR(50) NULL",
            'password' => "VARCHAR(255) NOT NULL DEFAULT 'doctor123'",
            'role' => "VARCHAR(50) DEFAULT 'Doctor'",
            'department' => "VARCHAR(100) NOT NULL DEFAULT 'General Medicine'",
            'specialty' => "VARCHAR(150) NOT NULL DEFAULT 'General Medicine'",
            'experience' => "VARCHAR(50) DEFAULT '5+ Years'",
            'phone' => "VARCHAR(50) DEFAULT '+91 98765 43210'",
            'timing' => "VARCHAR(100) DEFAULT '09:00 AM - 05:00 PM'",
            'fee' => "DECIMAL(10,2) DEFAULT 500.00",
            'avatar' => "VARCHAR(255) DEFAULT ''",
            'status' => "VARCHAR(50) DEFAULT 'Available'"
        ]);

        $conn->query("UPDATE `doctors` SET `doc_id` = `doctor_id` WHERE `doc_id` IS NULL OR `doc_id` = ''");
        $conn->query("UPDATE `doctors` SET `doctor_id` = `doc_id` WHERE `doctor_id` IS NULL OR `doctor_id` = ''");

        // TABLE 3: Appointments
        $conn->query("CREATE TABLE IF NOT EXISTS `appointments` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `apt_id` VARCHAR(50) NULL,
            `appointment_id` VARCHAR(50) NULL,
            `doctor_id` VARCHAR(50) DEFAULT 'DOC-101',
            `doctor_name` VARCHAR(150) NOT NULL,
            `patient_id` VARCHAR(50) DEFAULT 'PAT-1001',
            `patient_name` VARCHAR(150) NOT NULL,
            `department` VARCHAR(100) DEFAULT 'General Medicine',
            `phone` VARCHAR(30) DEFAULT '',
            `patient_phone` VARCHAR(30) DEFAULT '',
            `appointment_date` DATE DEFAULT (CURRENT_DATE),
            `appointment_time` VARCHAR(50) DEFAULT '09:30 AM',
            `type` VARCHAR(150) DEFAULT 'Regular Checkup',
            `method` VARCHAR(50) DEFAULT 'Offline',
            `reason` TEXT DEFAULT NULL,
            `symptoms` TEXT DEFAULT NULL,
            `bp` VARCHAR(20) DEFAULT '120/80',
            `hr` VARCHAR(20) DEFAULT '72 bpm',
            `temp` VARCHAR(20) DEFAULT '98.6°F',
            `status` VARCHAR(50) DEFAULT 'Pending',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $ensure_columns($conn, 'appointments', [
            'apt_id' => "VARCHAR(50) NULL",
            'appointment_id' => "VARCHAR(50) NULL",
            'doctor_id' => "VARCHAR(50) DEFAULT 'DOC-101'",
            'patient_id' => "VARCHAR(50) DEFAULT 'PAT-1001'",
            'phone' => "VARCHAR(30) DEFAULT ''",
            'patient_phone' => "VARCHAR(30) DEFAULT ''",
            'department' => "VARCHAR(100) DEFAULT 'General Medicine'",
            'type' => "VARCHAR(150) DEFAULT 'Regular Checkup'",
            'method' => "VARCHAR(50) DEFAULT 'Offline'",
            'reason' => "TEXT DEFAULT NULL",
            'symptoms' => "TEXT DEFAULT NULL",
            'bp' => "VARCHAR(20) DEFAULT '120/80'",
            'hr' => "VARCHAR(20) DEFAULT '72 bpm'",
            'temp' => "VARCHAR(20) DEFAULT '98.6°F'",
            'status' => "VARCHAR(50) DEFAULT 'Pending'"
        ]);

        $conn->query("UPDATE `appointments` SET `apt_id` = `appointment_id` WHERE `apt_id` IS NULL OR `apt_id` = ''");
        $conn->query("UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        $conn->query("UPDATE `appointments` SET `apt_id` = CONCAT('APT-', 1000 + id) WHERE `apt_id` IS NULL OR `apt_id` = ''");
        $conn->query("UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        $conn->query("UPDATE `appointments` SET `patient_phone` = `phone` WHERE `patient_phone` IS NULL OR `patient_phone` = ''");
        $conn->query("UPDATE `appointments` SET `phone` = `patient_phone` WHERE `phone` IS NULL OR `phone` = ''");

        // TABLE 4: Prescriptions
        $conn->query("CREATE TABLE IF NOT EXISTS `prescriptions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `prescription_id` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) DEFAULT 'PAT-1001',
            `patient_name` VARCHAR(100) NOT NULL,
            `patient_age` VARCHAR(20) DEFAULT '40',
            `patient_gender` VARCHAR(20) DEFAULT 'Male',
            `doctor_name` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
            `doctor_id` VARCHAR(50) DEFAULT 'DOC-101',
            `diagnosis` VARCHAR(255) DEFAULT 'Clinical Diagnosis',
            `medicines` TEXT DEFAULT NULL,
            `instructions` TEXT DEFAULT NULL,
            `prescription_date` DATE DEFAULT (CURRENT_DATE),
            `status` VARCHAR(50) DEFAULT 'Active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // TABLE 5: Patient Reports
        $conn->query("CREATE TABLE IF NOT EXISTS `patient_reports` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `report_id` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) DEFAULT 'PAT-1001',
            `patient_name` VARCHAR(100) NOT NULL,
            `report_type` VARCHAR(100) DEFAULT 'Diagnostic Report',
            `category` VARCHAR(100) DEFAULT 'General',
            `doctor_name` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
            `file_path` VARCHAR(255) DEFAULT NULL,
            `file_size` VARCHAR(50) DEFAULT '350 KB',
            `report_date` DATE DEFAULT (CURRENT_DATE),
            `status` VARCHAR(50) DEFAULT 'Finalized',
            `summary` TEXT DEFAULT NULL,
            `results` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // TABLE 6: Patient Vitals
        $conn->query("CREATE TABLE IF NOT EXISTS `patient_vitals` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(100) NOT NULL,
            `heart_rate` INT DEFAULT 72,
            `bp` VARCHAR(20) DEFAULT '120/80',
            `blood_sugar` INT DEFAULT 98,
            `bmi` DECIMAL(5,2) DEFAULT 22.4,
            `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // TABLE 7: Medication Refills
        $conn->query("CREATE TABLE IF NOT EXISTS `medication_refills` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `refill_id` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(100) NOT NULL,
            `medicine_id` VARCHAR(50) NOT NULL,
            `medicine_name` VARCHAR(150) NOT NULL,
            `doctor_name` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
            `status` VARCHAR(50) DEFAULT 'Pending',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}

// Helper to sanitize inputs
function sanitize($conn, $data) {
    if (!$conn) return trim((string)$data);
    return mysqli_real_escape_string($conn, trim((string)$data));
}
?>
