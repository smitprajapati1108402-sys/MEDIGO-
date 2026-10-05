<?php
// ==============================================================================
// MediGo Hospital Management System - Master Unified Database Connection (XAMPP)
// Connects Admin, Doctor & Patient Modules Seamlessly
// ==============================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting Configuration
error_reporting(E_ALL);
ini_set('display_errors', 0); // Log errors internally, return clean JSON/UI to client

// XAMPP Default MySQL Credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "medigo";

$db_connected = false;
$db_error = "";

// 1. Establish MySQL Server Connection
$conn = @new mysqli($db_host, $db_user, $db_pass);

if ($conn->connect_error) {
    $db_connected = false;
    $db_error = $conn->connect_error;
    if (defined('API_REQUEST')) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'MySQL Connection Error: ' . $conn->connect_error . '. Please make sure MySQL is running in XAMPP Control Panel.'
        ]);
        exit;
    }
} else {
    // 2. Automatically Create Database if not exists
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    if ($conn->select_db($db_name)) {
        $db_connected = true;
        $conn->set_charset('utf8mb4');

        // Helper function: Auto-migrate & ensure missing columns exist
        $ensure_columns = function($conn, $table, $cols) {
            $existing = [];
            $res = $conn->query("SHOW COLUMNS FROM `$table`");
            if ($res) {
                while ($c = $res->fetch_assoc()) {
                    $existing[strtolower($c['Field'])] = true;
                }
                foreach ($cols as $col_name => $col_def) {
                    if (!isset($existing[strtolower($col_name)])) {
                        $conn->query("ALTER TABLE `$table` ADD `$col_name` $col_def");
                    }
                }
            }
        };

        // =========================================================================
        // TABLE 1: Admins
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(50) DEFAULT 'Admin',
            `security_key` VARCHAR(100) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 2: Doctors (Unified for Admin, Doctor Login & Patient Booking)
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `doctors` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `doctor_id` VARCHAR(50) NOT NULL UNIQUE,
            `doc_id` VARCHAR(50) NULL,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL DEFAULT 'doctor123',
            `role` VARCHAR(50) DEFAULT 'Doctor',
            `department` VARCHAR(100) NOT NULL DEFAULT 'Cardiology',
            `specialty` VARCHAR(150) NOT NULL DEFAULT 'Cardiology',
            `experience` VARCHAR(50) DEFAULT '5+ Years',
            `phone` VARCHAR(50) DEFAULT '+91 98765 43210',
            `timing` VARCHAR(100) DEFAULT '09:00 AM - 05:00 PM',
            `fee` DECIMAL(10,2) DEFAULT 500.00,
            `avatar` VARCHAR(255) DEFAULT '',
            `status` VARCHAR(50) DEFAULT 'Available',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

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

        // Sync doctor_id <-> doc_id
        $conn->query("UPDATE `doctors` SET `doc_id` = `doctor_id` WHERE `doc_id` IS NULL OR `doc_id` = ''");
        $conn->query("UPDATE `doctors` SET `doctor_id` = `doc_id` WHERE `doctor_id` IS NULL OR `doctor_id` = ''");

        // =========================================================================
        // TABLE 3: Patients (Unified for Patient Portal, Doctor Portal & Admin)
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `patients` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) DEFAULT NULL,
            `password` VARCHAR(255) NOT NULL DEFAULT '123456',
            `dob` VARCHAR(30) DEFAULT '',
            `age` VARCHAR(30) DEFAULT '35',
            `gender` VARCHAR(20) NOT NULL DEFAULT 'Male',
            `blood_group` VARCHAR(10) DEFAULT 'O+',
            `blood` VARCHAR(10) DEFAULT 'O+',
            `phone` VARCHAR(50) DEFAULT NULL,
            `address` TEXT DEFAULT NULL,
            `doctor_assigned` VARCHAR(150) DEFAULT NULL,
            `disease` VARCHAR(200) DEFAULT 'General Health',
            `allergies` VARCHAR(255) DEFAULT 'None',
            `contact_name` VARCHAR(100) DEFAULT '',
            `relationship` VARCHAR(50) DEFAULT '',
            `contact_phone` VARCHAR(50) DEFAULT '',
            `admission_date` DATE DEFAULT NULL,
            `last_visit` VARCHAR(50) DEFAULT 'Today',
            `status` VARCHAR(50) DEFAULT 'Admitted',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $ensure_columns($conn, 'patients', [
            'patient_id' => "VARCHAR(50) NOT NULL DEFAULT 'PAT-1001'",
            'name' => "VARCHAR(150) NOT NULL DEFAULT ''",
            'email' => "VARCHAR(150) DEFAULT NULL",
            'password' => "VARCHAR(255) NOT NULL DEFAULT '123456'",
            'dob' => "VARCHAR(30) DEFAULT ''",
            'age' => "VARCHAR(30) DEFAULT '35'",
            'gender' => "VARCHAR(20) NOT NULL DEFAULT 'Male'",
            'blood_group' => "VARCHAR(10) DEFAULT 'O+'",
            'blood' => "VARCHAR(10) DEFAULT 'O+'",
            'phone' => "VARCHAR(50) DEFAULT NULL",
            'address' => "TEXT DEFAULT NULL",
            'doctor_assigned' => "VARCHAR(150) DEFAULT 'Dr. Raj Patel'",
            'disease' => "VARCHAR(200) DEFAULT 'General Health'",
            'allergies' => "VARCHAR(255) DEFAULT 'None'",
            'contact_name' => "VARCHAR(100) DEFAULT ''",
            'relationship' => "VARCHAR(50) DEFAULT ''",
            'contact_phone' => "VARCHAR(50) DEFAULT ''",
            'admission_date' => "DATE DEFAULT NULL",
            'last_visit' => "VARCHAR(50) DEFAULT 'Today'",
            'status' => "VARCHAR(50) DEFAULT 'Admitted'"
        ]);

        // Sync blood_group and blood
        $conn->query("UPDATE `patients` SET `blood` = `blood_group` WHERE `blood` IS NULL OR `blood` = ''");
        $conn->query("UPDATE `patients` SET `blood_group` = `blood` WHERE `blood_group` IS NULL OR `blood_group` = ''");

        // =========================================================================
        // TABLE 4: Appointments (Unified Master Appointments Table)
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `appointments` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `apt_id` VARCHAR(50) NULL,
            `appointment_id` VARCHAR(50) NULL,
            `doctor_id` VARCHAR(50) DEFAULT 'DOC-101',
            `doctor_name` VARCHAR(150) NOT NULL,
            `patient_id` VARCHAR(50) DEFAULT 'PAT-1001',
            `patient_name` VARCHAR(150) NOT NULL,
            `phone` VARCHAR(50) DEFAULT NULL,
            `patient_phone` VARCHAR(50) DEFAULT NULL,
            `department` VARCHAR(100) DEFAULT 'General Medicine',
            `appointment_date` DATE NOT NULL,
            `appointment_time` VARCHAR(50) NOT NULL,
            `type` VARCHAR(150) DEFAULT 'Regular Checkup',
            `method` VARCHAR(50) DEFAULT 'Offline',
            `reason` TEXT DEFAULT NULL,
            `symptoms` TEXT DEFAULT NULL,
            `bp` VARCHAR(20) DEFAULT '120/80',
            `hr` VARCHAR(20) DEFAULT '72 bpm',
            `temp` VARCHAR(20) DEFAULT '98.6 °F',
            `status` VARCHAR(50) DEFAULT 'Confirmed',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $ensure_columns($conn, 'appointments', [
            'apt_id' => "VARCHAR(50) NULL",
            'appointment_id' => "VARCHAR(50) NULL",
            'doctor_id' => "VARCHAR(50) DEFAULT 'DOC-101'",
            'patient_id' => "VARCHAR(50) DEFAULT 'PAT-1001'",
            'phone' => "VARCHAR(50) DEFAULT '+91 98765 43210'",
            'patient_phone' => "VARCHAR(50) DEFAULT '+91 98765 43210'",
            'department' => "VARCHAR(100) DEFAULT 'General Medicine'",
            'type' => "VARCHAR(150) DEFAULT 'Regular Checkup'",
            'method' => "VARCHAR(50) DEFAULT 'Offline'",
            'reason' => "TEXT DEFAULT NULL",
            'symptoms' => "TEXT DEFAULT NULL",
            'bp' => "VARCHAR(20) DEFAULT '120/80'",
            'hr' => "VARCHAR(20) DEFAULT '72 bpm'",
            'temp' => "VARCHAR(20) DEFAULT '98.6 °F'",
            'status' => "VARCHAR(50) DEFAULT 'Confirmed'"
        ]);

        // Sync apt_id <-> appointment_id and phone <-> patient_phone
        $conn->query("UPDATE `appointments` SET `apt_id` = `appointment_id` WHERE `apt_id` IS NULL OR `apt_id` = ''");
        $conn->query("UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        $conn->query("UPDATE `appointments` SET `apt_id` = CONCAT('APT-', 1000 + id) WHERE `apt_id` IS NULL OR `apt_id` = ''");
        $conn->query("UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        $conn->query("UPDATE `appointments` SET `patient_phone` = `phone` WHERE `patient_phone` IS NULL OR `patient_phone` = ''");
        $conn->query("UPDATE `appointments` SET `phone` = `patient_phone` WHERE `phone` IS NULL OR `phone` = ''");

        // =========================================================================
        // TABLE 5: Prescriptions (Doctor writes -> Patient views -> Admin checks)
        // =========================================================================
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $ensure_columns($conn, 'prescriptions', [
            'doctor_id' => "VARCHAR(50) DEFAULT 'DOC-101'",
            'patient_age' => "VARCHAR(20) DEFAULT '40'",
            'patient_gender' => "VARCHAR(20) DEFAULT 'Male'",
            'status' => "VARCHAR(50) DEFAULT 'Active'"
        ]);

        // =========================================================================
        // TABLE 6: Patient Reports (Doctor/Patient uploads -> Admin/Doctor/Patient view)
        // =========================================================================
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $ensure_columns($conn, 'patient_reports', [
            'file_path' => "VARCHAR(255) DEFAULT NULL",
            'file_size' => "VARCHAR(50) DEFAULT '350 KB'",
            'status' => "VARCHAR(50) DEFAULT 'Finalized'"
        ]);

        // =========================================================================
        // TABLE 7: Patient Vitals
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `patient_vitals` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(100) NOT NULL,
            `heart_rate` INT DEFAULT 72,
            `bp` VARCHAR(20) DEFAULT '120/80',
            `blood_sugar` INT DEFAULT 98,
            `bmi` DECIMAL(5,2) DEFAULT 22.4,
            `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 8: Medication Refills
        // =========================================================================
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 9: Blood Bank Inventory
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `blood_bank` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `blood_group` VARCHAR(10) NOT NULL UNIQUE,
            `bags_available` INT DEFAULT 0,
            `status` VARCHAR(50) DEFAULT 'Sufficient',
            `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 10: Blood Transactions
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `blood_transactions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `donor_patient_name` VARCHAR(150) NOT NULL,
            `blood_group` VARCHAR(10) NOT NULL,
            `bags` INT NOT NULL DEFAULT 1,
            `type` VARCHAR(50) NOT NULL DEFAULT 'Donation',
            `contact` VARCHAR(50) DEFAULT NULL,
            `date` DATE NOT NULL,
            `status` VARCHAR(50) DEFAULT 'Completed',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 11: Pharmacy Inventory
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `pharmacy` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `medicine_name` VARCHAR(150) NOT NULL,
            `generic_name` VARCHAR(150) DEFAULT NULL,
            `category` VARCHAR(100) DEFAULT 'Tablets',
            `batch_no` VARCHAR(50) DEFAULT NULL,
            `quantity` INT DEFAULT 0,
            `price` DECIMAL(10,2) DEFAULT 0.00,
            `expiry_date` DATE DEFAULT NULL,
            `supplier` VARCHAR(150) DEFAULT 'MediGo Pharma',
            `status` VARCHAR(50) DEFAULT 'In Stock',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 12: Hospital Info
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `hospital_info` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `hospital_name` VARCHAR(200) NOT NULL DEFAULT 'MediGo Shield Hospital',
            `tagline` VARCHAR(200) DEFAULT 'Advanced Healthcare & Medical Services',
            `address` TEXT DEFAULT '100 Medical Center Way, Health City',
            `phone` VARCHAR(50) DEFAULT '+91 98765 43210',
            `emergency_contact` VARCHAR(50) DEFAULT '108 / 102',
            `email` VARCHAR(100) DEFAULT 'admin@medigo.com',
            `total_beds` INT DEFAULT 500,
            `icu_beds` INT DEFAULT 60,
            `ambulances` INT DEFAULT 12,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 13: Hospital Departments
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `departments` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `extension` VARCHAR(50) NOT NULL,
            `lead` VARCHAR(150) NOT NULL,
            `location` VARCHAR(150) NOT NULL,
            `status` VARCHAR(50) DEFAULT 'Active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 14: Broadcasts & Notices
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `broadcasts` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `priority` VARCHAR(50) DEFAULT 'info',
            `message` TEXT NOT NULL,
            `time` VARCHAR(50) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // TABLE 15: Contacts / Enquiries
        // =========================================================================
        $conn->query("CREATE TABLE IF NOT EXISTS `contacts` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) DEFAULT NULL,
            `phone` VARCHAR(50) DEFAULT NULL,
            `subject` VARCHAR(200) DEFAULT NULL,
            `message` TEXT NOT NULL,
            `status` VARCHAR(50) DEFAULT 'New',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // =========================================================================
        // SEED ESSENTIAL DATA IF EMPTY
        // =========================================================================

        // 1. Seed Admin
        $adminCheck = $conn->query("SELECT id FROM `admins` LIMIT 1");
        if ($adminCheck && $adminCheck->num_rows == 0) {
            $conn->query("INSERT INTO `admins` (`name`, `email`, `password`, `role`) VALUES 
                ('System Administrator', 'admin@medigo.com', 'admin123', 'Admin'),
                ('Admin User', 'admin', 'admin123', 'Admin')");
        }

        // 2. Seed Doctors
        $docCheck = $conn->query("SELECT id FROM `doctors` LIMIT 1");
        if ($docCheck && $docCheck->num_rows == 0) {
            $conn->query("INSERT INTO `doctors` (`doctor_id`, `doc_id`, `name`, `department`, `specialty`, `experience`, `email`, `password`, `phone`, `timing`, `fee`, `status`) VALUES
                ('DOC-SMIT-01', 'DOC-SMIT-01', 'Dr. PRAJAPATI SMIT MANOJKUMAR', 'Cardiology', 'Senior Cardiologist', '10+ Years', 'smit@gmail.com', 'smit123', '+91 98980 12345', '09:00 AM - 05:00 PM', 800.00, 'Available'),
                ('DOC-101', 'DOC-101', 'Dr. Raj Patel', 'Cardiology', 'Senior Cardiologist', '12+ Years', 'raj.patel@medigo.com', 'doctor123', '+91 98234 11223', '09:00 AM - 02:00 PM', 800.00, 'Available'),
                ('DOC-102', 'DOC-102', 'Dr. Jane Smith', 'Neurology', 'Chief Neurologist', '15+ Years', 'jane.smith@medigo.com', 'jane123', '+91 98456 33445', '10:00 AM - 04:00 PM', 1000.00, 'Available'),
                ('DOC-103', 'DOC-103', 'Dr. Robert Chen', 'Pediatrics', 'Child Specialist', '8+ Years', 'robert.chen@medigo.com', 'robert123', '+91 98112 55667', '02:00 PM - 08:00 PM', 600.00, 'Available'),
                ('DOC-104', 'DOC-104', 'Dr. Marcus Vance', 'Emergency Medicine', 'Trauma Surgeon', '10+ Years', 'marcus.v@medigo.com', 'marcus123', '+91 98776 99887', '24/7 On-Call', 900.00, 'Available')");
        }

        // 3. Seed Patients
        $patCheck = $conn->query("SELECT id FROM `patients` LIMIT 1");
        if ($patCheck && $patCheck->num_rows == 0) {
            $conn->query("INSERT INTO `patients` (`patient_id`, `name`, `email`, `password`, `age`, `gender`, `blood_group`, `blood`, `phone`, `address`, `doctor_assigned`, `disease`, `admission_date`, `status`) VALUES
                ('PAT-1001', 'Arjun Sharma', 'arjun.s@gmail.com', '123456', '45 Yrs', 'Male', 'O+', 'O+', '+91 98711 22334', 'Room 204, Ward B, Ahmedabad', 'Dr. Raj Patel', 'Hypertension Stage 2', CURDATE(), 'Admitted'),
                ('PAT-1002', 'Priya Verma', 'priya.v@gmail.com', '123456', '28 Yrs', 'Female', 'B+', 'B+', '+91 98622 33445', 'Room 105, Ward A, Ahmedabad', 'Dr. Jane Smith', 'Migraine Prophylaxis', CURDATE(), 'Admitted'),
                ('PAT-1003', 'Amit Shah', 'amit.shah@gmail.com', '123456', '56 Yrs', 'Male', 'B+', 'B+', '+91 97123 45678', 'Room 301, Cardiac Unit, Ahmedabad', 'Dr. Raj Patel', 'Ischemic Heart Disease', CURDATE(), 'Admitted'),
                ('PAT-1004', 'Rohan Gupta', 'rohan.g@gmail.com', '123456', '23 Yrs', 'Male', 'A+', 'A+', '+91 98533 44556', 'Vastrapur, Ahmedabad', 'Dr. Robert Chen', 'Seasonal Flu', CURDATE(), 'Discharged'),
                ('PAT-1005', 'Ananya Iyer', 'ananya.iyer@gmail.com', '123456', '34 Yrs', 'Female', 'B-', 'B-', '+91 95501 23456', 'Prahlad Nagar, Ahmedabad', 'Dr. Raj Patel', 'Hypothyroidism', CURDATE(), 'Treatment')");
        }

        // 4. Seed Appointments
        $appCheck = $conn->query("SELECT id FROM `appointments` LIMIT 1");
        if ($appCheck && $appCheck->num_rows == 0) {
            $conn->query("INSERT INTO `appointments` (`apt_id`, `appointment_id`, `doctor_id`, `doctor_name`, `patient_id`, `patient_name`, `phone`, `patient_phone`, `department`, `appointment_date`, `appointment_time`, `type`, `method`, `reason`, `symptoms`, `status`) VALUES
                ('APT-1092', 'APT-1092', 'DOC-101', 'Dr. Raj Patel', 'PAT-1001', 'Arjun Sharma', '+91 98711 22334', '+91 98711 22334', 'Cardiology', CURDATE(), '09:30 AM', 'Regular Checkup', 'Offline', 'Routine cardiovascular assessment & checkup.', 'Monthly hypertension follow-up', 'Confirmed'),
                ('APT-4820', 'APT-4820', 'DOC-102', 'Dr. Jane Smith', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Neurology', CURDATE(), '10:15 AM', 'Regular Checkup', 'Online', 'Follow-up consultation for migraine evaluation.', 'Migraine follow-up and prescription review', 'Confirmed'),
                ('APT-9931', 'APT-9931', 'DOC-101', 'Dr. Raj Patel', 'PAT-1003', 'Amit Shah', '+91 97123 45678', '+91 97123 45678', 'Cardiology', CURDATE(), '11:00 AM', 'Emergency Consultation', 'Offline', 'Chest discomfort evaluation.', 'Chest discomfort with palpitations', 'Confirmed'),
                ('APT-2248', 'APT-2248', 'DOC-103', 'Dr. Robert Chen', 'PAT-1004', 'Rohan Gupta', '+91 98533 44556', '+91 98533 44556', 'Pediatrics', CURDATE(), '12:30 PM', 'Regular Checkup', 'Online', 'Annual physical wellness examination.', 'General post viral checkup', 'Pending'),
                ('APT-3011', 'APT-3011', 'DOC-101', 'Dr. Raj Patel', 'PAT-1005', 'Ananya Iyer', '+91 95501 23456', '+91 95501 23456', 'Cardiology', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), '10:00 AM', 'Cardiology Followup', 'Offline', 'Thyroid & ECG follow-up', 'Thyroid & ECG follow-up', 'Confirmed'),
                ('APT-8821', 'APT-8821', 'DOC-104', 'Dr. Marcus Vance', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Emergency Medicine', CURDATE(), '02:00 PM', 'General Checkup', 'Offline', 'Patient cancelled due to urgent travel', 'Patient cancelled due to urgent travel', 'Cancelled')");
        }

        // 5. Seed Prescriptions
        $rxCheck = $conn->query("SELECT id FROM `prescriptions` LIMIT 1");
        if ($rxCheck && $rxCheck->num_rows == 0) {
            $conn->query("INSERT INTO `prescriptions` (`prescription_id`, `patient_id`, `patient_name`, `patient_age`, `patient_gender`, `doctor_name`, `doctor_id`, `diagnosis`, `medicines`, `instructions`, `prescription_date`, `status`) VALUES
                ('RX-8021', 'PAT-1001', 'Arjun Sharma', '45', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Hypertension Stage 2 & Dyslipidemia', 'Telmisartan 40mg (1-0-0), Atorvastatin 10mg (0-0-1), Amlodipine 5mg (0-0-1)', 'Take after meals. Low salt diet. Daily 30 min morning walk.', CURRENT_DATE, 'Active'),
                ('RX-8022', 'PAT-1002', 'Priya Verma', '28', 'Female', 'Dr. Jane Smith', 'DOC-102', 'Migraine Prophylaxis', 'Propranolol 20mg (1-0-1), Naproxen 250mg (SOS)', 'Hydrate well. Avoid screen exposure during attacks.', CURRENT_DATE, 'Active'),
                ('RX-8023', 'PAT-1003', 'Amit Shah', '56', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Ischemic Heart Disease Management', 'Clopidogrel 75mg (1-0-0), Rosuvastatin 20mg (0-0-1), Metoprolol 25mg (1-0-1)', 'Strict cardiac diet. Keep Sorbitrate 5mg accessible.', CURRENT_DATE, 'Active')");
        }

        // 6. Seed Reports
        $repCheck = $conn->query("SELECT id FROM `patient_reports` LIMIT 1");
        if ($repCheck && $repCheck->num_rows == 0) {
            $conn->query("INSERT INTO `patient_reports` (`report_id`, `patient_id`, `patient_name`, `report_type`, `category`, `doctor_name`, `file_size`, `report_date`, `status`, `summary`, `results`) VALUES
                ('REP-5021', 'PAT-1001', 'Arjun Sharma', 'Echocardiogram (ECG)', 'Cardiology', 'Dr. Raj Patel', '450 KB', CURRENT_DATE, 'Finalized', 'Normal Sinus Rhythm with LVH signs', 'LVEF: 60%, Mild Concentric LVH, Normal Valvular function'),
                ('REP-5022', 'PAT-1002', 'Priya Verma', 'Brain MRI Scan', 'Neurology', 'Dr. Jane Smith', '1.2 MB', CURRENT_DATE, 'Finalized', 'No acute intracranial pathology detected', 'Normal cerebral parenchyma, ventricles clear'),
                ('REP-5023', 'PAT-1003', 'Amit Shah', 'Coronary Angiography', 'Cardiology', 'Dr. Raj Patel', '820 KB', CURRENT_DATE, 'Finalized', '70% stenosis in LAD mid segment', 'Referred for elective angioplasty evaluation')");
        }

        // 7. Seed Hospital Info
        $hospCheck = $conn->query("SELECT id FROM `hospital_info` LIMIT 1");
        if ($hospCheck && $hospCheck->num_rows == 0) {
            $conn->query("INSERT INTO `hospital_info` (`hospital_name`, `tagline`, `address`, `phone`, `emergency_contact`, `email`, `total_beds`, `icu_beds`, `ambulances`) VALUES 
                ('MediGo Shield Hospital', 'Smart Hospital System & Medical Center', 'Opposite Medigo Park, Civil Lines', '+91 98765 43210', '108 / 102', 'contact@medigo.com', 450, 50, 8)");
        }

        // 8. Seed Departments
        $deptCheck = $conn->query("SELECT id FROM `departments` LIMIT 1");
        if ($deptCheck && $deptCheck->num_rows == 0) {
            $conn->query("INSERT INTO `departments` (`name`, `extension`, `lead`, `location`, `status`) VALUES
                ('Emergency Department', 'Ext 4911', 'Dr. Marcus Vance', 'Wing A, Floor 1', 'Active'),
                ('Cardiology', 'Ext 4022', 'Dr. Raj Patel', 'Wing B, Floor 3', 'Active'),
                ('Radiology & Imaging', 'Ext 4310', 'Dr. Julian Kovic', 'Wing A, Floor 1', 'Active'),
                ('Pediatrics Clinic', 'Ext 4150', 'Dr. Robert Chen', 'Wing C, Floor 2', 'Active'),
                ('Intensive Care Unit (ICU)', 'Ext 4800', 'Dr. Katherine Vance', 'Wing B, Floor 2', 'Active'),
                ('Neurology', 'Ext 4490', 'Dr. Jane Smith', 'Wing D, Floor 4', 'Active'),
                ('Pharmacy Services', 'Ext 4210', 'PharmD. Rita Glass', 'Lobby Level, Wing B', 'Active')");
        }

        // 9. Seed Blood Bank
        $bloodCheck = $conn->query("SELECT id FROM `blood_bank` LIMIT 1");
        if ($bloodCheck && $bloodCheck->num_rows == 0) {
            $conn->query("INSERT INTO `blood_bank` (`blood_group`, `bags_available`, `status`) VALUES
                ('A+', 24, 'Sufficient'),
                ('A-', 8, 'Low Stock'),
                ('B+', 32, 'Sufficient'),
                ('B-', 6, 'Critical'),
                ('AB+', 14, 'Moderate'),
                ('AB-', 4, 'Critical'),
                ('O+', 45, 'Sufficient'),
                ('O-', 5, 'Critical')");
        }

        // 10. Seed Pharmacy
        $pharmCheck = $conn->query("SELECT id FROM `pharmacy` LIMIT 1");
        if ($pharmCheck && $pharmCheck->num_rows == 0) {
            $conn->query("INSERT INTO `pharmacy` (`medicine_name`, `generic_name`, `category`, `batch_no`, `quantity`, `price`, `expiry_date`, `supplier`, `status`) VALUES
                ('Paracetamol 500mg', 'Acetaminophen', 'Analgesic', 'BAT-901', 450, 15.00, '2027-12-31', 'MediGo Pharma', 'In Stock'),
                ('Amoxicillin 250mg', 'Amoxicillin Trihydrate', 'Antibiotic', 'BAT-902', 35, 45.00, '2027-08-15', 'Apex Health', 'Low Stock'),
                ('Azithromycin 500mg', 'Azithromycin', 'Antibiotic', 'BAT-903', 120, 85.00, '2027-06-30', 'Sun Pharma', 'In Stock'),
                ('Metformin 850mg', 'Metformin HCL', 'Antidiabetic', 'BAT-904', 0, 30.00, '2026-11-20', 'Cipla Ltd', 'Out of Stock'),
                ('Atorvastatin 20mg', 'Atorvastatin Calcium', 'Cardiovascular', 'BAT-905', 200, 65.00, '2028-03-15', 'MediGo Pharma', 'In Stock')");
        }
    }
}

// Helper function to sanitize inputs across all modules
function sanitize($conn, $data) {
    if (!$conn) return trim((string)$data);
    return mysqli_real_escape_string($conn, trim((string)$data));
}
?>
