<?php
/**
 * Master Unified Database Connection & Auto-Migration for Medigo Doctor Management
 * Synchronized with Admin and Patient modules
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_OFF);

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'medigo';

$db_connected = false;
$db_error = '';

$conn = @mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    $db_connected = false;
    $db_error = mysqli_connect_error();
} else {
    // Ensure database exists
    $create_db_query = "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    mysqli_query($conn, $create_db_query);
    
    if (mysqli_select_db($conn, $db_name)) {
        $db_connected = true;
        mysqli_set_charset($conn, 'utf8mb4');

        // Helper function: Auto-migrate & ensure missing columns exist
        $ensure_columns = function($conn, $table, $cols) {
            $existing = [];
            $res = mysqli_query($conn, "SHOW COLUMNS FROM `$table`");
            if ($res) {
                while ($c = mysqli_fetch_assoc($res)) {
                    $existing[strtolower($c['Field'])] = true;
                }
                foreach ($cols as $col_name => $col_def) {
                    if (!isset($existing[strtolower($col_name)])) {
                        mysqli_query($conn, "ALTER TABLE `$table` ADD `$col_name` $col_def");
                    }
                }
            }
        };

        // Table 1: Admins
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(150) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(50) DEFAULT 'Admin',
            `security_key` VARCHAR(100) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Table 2: Doctors
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `doctors` (
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
            'status' => "VARCHAR(50) DEFAULT 'Available'",
            'qualification' => "VARCHAR(150) DEFAULT 'MBBS, MD (Cardiology)'",
            'reg_no' => "VARCHAR(100) DEFAULT 'MCI-88421-GUJ'",
            'room_no' => "VARCHAR(50) DEFAULT 'OPD Room 302, Wing B'",
            'bio' => "TEXT DEFAULT NULL",
            'signature' => "VARCHAR(255) DEFAULT ''",
            'two_factor' => "INT DEFAULT 0",
            'theme' => "VARCHAR(20) DEFAULT 'light'",
            'email_notif' => "INT DEFAULT 1",
            'sms_notif' => "INT DEFAULT 1",
            'appt_alert' => "INT DEFAULT 1"
        ]);

        mysqli_query($conn, "UPDATE `doctors` SET `doc_id` = `doctor_id` WHERE `doc_id` IS NULL OR `doc_id` = ''");
        mysqli_query($conn, "UPDATE `doctors` SET `doctor_id` = `doc_id` WHERE `doctor_id` IS NULL OR `doctor_id` = ''");

        // Seed default doctors
        $default_doctors = [
            ['doctor_id' => 'DOC-SMIT-01', 'doc_id' => 'DOC-SMIT-01', 'name' => 'Dr. PRAJAPATI SMIT MANOJKUMAR', 'email' => 'smit@gmail.com', 'password' => 'smit123', 'role' => 'Doctor', 'department' => 'Cardiology', 'specialty' => 'Senior Cardiologist', 'phone' => '+91 98980 12345'],
            ['doctor_id' => 'DOC-101', 'doc_id' => 'DOC-101', 'name' => 'Dr. Raj Patel', 'email' => 'doctor@medigo.com', 'password' => 'doctor123', 'role' => 'Doctor', 'department' => 'Cardiology', 'specialty' => 'Senior Cardiologist', 'phone' => '+91 98765 43210'],
            ['doctor_id' => 'DOC-102', 'doc_id' => 'DOC-102', 'name' => 'Dr. Jane Smith', 'email' => 'jane@medigo.com', 'password' => 'jane123', 'role' => 'Doctor', 'department' => 'Neurology', 'specialty' => 'Chief Neurologist', 'phone' => '+91 98456 33445'],
            ['doctor_id' => 'DOC-103', 'doc_id' => 'DOC-103', 'name' => 'Dr. Robert Chen', 'email' => 'robert@medigo.com', 'password' => 'robert123', 'role' => 'Doctor', 'department' => 'Pediatrics', 'specialty' => 'Child Specialist', 'phone' => '+91 98112 55667'],
            ['doctor_id' => 'DOC-104', 'doc_id' => 'DOC-104', 'name' => 'Dr. Marcus Vance', 'email' => 'marcus@medigo.com', 'password' => 'marcus123', 'role' => 'Doctor', 'department' => 'Emergency Medicine', 'specialty' => 'Trauma Surgeon', 'phone' => '+91 98776 99887']
        ];

        foreach ($default_doctors as $doc) {
            $e = mysqli_real_escape_string($conn, strtolower($doc['email']));
            $check = mysqli_query($conn, "SELECT `id` FROM `doctors` WHERE LOWER(`email`) = '$e'");
            if ($check && mysqli_num_rows($check) > 0) {
                $p = mysqli_real_escape_string($conn, $doc['password']);
                $n = mysqli_real_escape_string($conn, $doc['name']);
                mysqli_query($conn, "UPDATE `doctors` SET `password` = '$p', `name` = '$n' WHERE LOWER(`email`) = '$e'");
            } else {
                $did = mysqli_real_escape_string($conn, $doc['doctor_id']);
                $n = mysqli_real_escape_string($conn, $doc['name']);
                $p = mysqli_real_escape_string($conn, $doc['password']);
                $r = mysqli_real_escape_string($conn, $doc['role']);
                $dept = mysqli_real_escape_string($conn, $doc['department']);
                $s = mysqli_real_escape_string($conn, $doc['specialty']);
                $ph = mysqli_real_escape_string($conn, $doc['phone']);
                mysqli_query($conn, "INSERT INTO `doctors` (`doctor_id`, `doc_id`, `name`, `email`, `password`, `role`, `department`, `specialty`, `phone`) VALUES ('$did', '$did', '$n', '$e', '$p', '$r', '$dept', '$s', '$ph')");
            }
        }

        // Table 3: Patients
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `patients` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL UNIQUE,
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $ensure_columns($conn, 'patients', [
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

        mysqli_query($conn, "UPDATE `patients` SET `blood` = `blood_group` WHERE `blood` IS NULL OR `blood` = ''");
        mysqli_query($conn, "UPDATE `patients` SET `blood_group` = `blood` WHERE `blood_group` IS NULL OR `blood_group` = ''");

        // Seed default patients if empty
        $check_patients = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `patients`");
        if ($check_patients && mysqli_fetch_assoc($check_patients)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `patients` (`patient_id`, `name`, `email`, `password`, `dob`, `age`, `gender`, `blood_group`, `blood`, `phone`, `disease`, `status`, `allergies`, `contact_name`, `relationship`, `contact_phone`, `address`, `last_visit`) VALUES
                ('PAT-1001', 'Arjun Sharma', 'arjun.s@gmail.com', '123456', '1982-05-14', '45 Yrs', 'Male', 'O+', 'O+', '+91 98711 22334', 'Hypertension Stage 2', 'Admitted', 'Penicillin', 'Sunita Sharma', 'Spouse', '+91 98711 22339', 'Room 204, Ward B, Ahmedabad', 'Today'),
                ('PAT-1002', 'Priya Verma', 'priya.v@gmail.com', '123456', '1995-11-20', '28 Yrs', 'Female', 'B+', 'B+', '+91 98622 33445', 'Migraine Prophylaxis', 'Admitted', 'Sulfa Drugs', 'Ramesh Verma', 'Father', '+91 98622 33440', 'Room 105, Ward A, Ahmedabad', 'Today'),
                ('PAT-1003', 'Amit Shah', 'amit.shah@gmail.com', '123456', '1968-08-04', '56 Yrs', 'Male', 'B+', 'B+', '+91 97123 45678', 'Ischemic Heart Disease', 'Admitted', 'None', 'Geeta Shah', 'Spouse', '+91 97123 45670', 'Room 301, Cardiac Unit, Ahmedabad', 'Today'),
                ('PAT-1004', 'Rohan Gupta', 'rohan.g@gmail.com', '123456', '2001-03-12', '23 Yrs', 'Male', 'A+', 'A+', '+91 98533 44556', 'Seasonal Flu', 'Discharged', 'None', 'Kailash Gupta', 'Brother', '+91 98533 44550', 'Vastrapur, Ahmedabad', 'Yesterday'),
                ('PAT-1005', 'Ananya Iyer', 'ananya.iyer@gmail.com', '123456', '1990-09-25', '34 Yrs', 'Female', 'B-', 'B-', '+91 95501 23456', 'Hypothyroidism', 'Treatment', 'Ibuprofen', 'Karthik Iyer', 'Spouse', '+91 95501 23450', 'Prahlad Nagar, Ahmedabad', '10 Jun 2026')");
        }

        // Table 4: Appointments
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `appointments` (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

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

        mysqli_query($conn, "UPDATE `appointments` SET `apt_id` = `appointment_id` WHERE `apt_id` IS NULL OR `apt_id` = ''");
        mysqli_query($conn, "UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        mysqli_query($conn, "UPDATE `appointments` SET `apt_id` = CONCAT('APT-', 1000 + id) WHERE `apt_id` IS NULL OR `apt_id` = ''");
        mysqli_query($conn, "UPDATE `appointments` SET `appointment_id` = `apt_id` WHERE `appointment_id` IS NULL OR `appointment_id` = ''");
        mysqli_query($conn, "UPDATE `appointments` SET `patient_phone` = `phone` WHERE `patient_phone` IS NULL OR `patient_phone` = ''");
        mysqli_query($conn, "UPDATE `appointments` SET `phone` = `patient_phone` WHERE `phone` IS NULL OR `phone` = ''");

        // Seed default appointments
        $check_appts = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `appointments`");
        if ($check_appts && mysqli_fetch_assoc($check_appts)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `appointments` (`apt_id`, `appointment_id`, `doctor_id`, `doctor_name`, `patient_id`, `patient_name`, `phone`, `patient_phone`, `department`, `appointment_date`, `appointment_time`, `type`, `method`, `reason`, `symptoms`, `status`, `bp`, `hr`, `temp`) VALUES
                ('APT-1092', 'APT-1092', 'DOC-101', 'Dr. Raj Patel', 'PAT-1001', 'Arjun Sharma', '+91 98711 22334', '+91 98711 22334', 'Cardiology', CURRENT_DATE, '09:30 AM', 'Regular Checkup', 'Offline', 'Routine checkup', 'Monthly hypertension follow-up', 'Confirmed', '130/82', '76 bpm', '98.6 °F'),
                ('APT-4820', 'APT-4820', 'DOC-102', 'Dr. Jane Smith', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Neurology', CURRENT_DATE, '10:15 AM', 'Regular Checkup', 'Online', 'Migraine review', 'Migraine follow-up and prescription review', 'Confirmed', '115/76', '72 bpm', '98.4 °F'),
                ('APT-9931', 'APT-9931', 'DOC-101', 'Dr. Raj Patel', 'PAT-1003', 'Amit Shah', '+91 97123 45678', '+91 97123 45678', 'Cardiology', CURRENT_DATE, '11:00 AM', 'Emergency Consultation', 'Offline', 'Chest discomfort evaluation', 'Chest discomfort with palpitations', 'Confirmed', '155/95', '94 bpm', '99.1 °F'),
                ('APT-2248', 'APT-2248', 'DOC-103', 'Dr. Robert Chen', 'PAT-1004', 'Rohan Gupta', '+91 98533 44556', '+91 98533 44556', 'Pediatrics', CURRENT_DATE, '12:30 PM', 'Regular Checkup', 'Online', 'Post viral checkup', 'General post viral checkup', 'Pending', '118/75', '78 bpm', '98.6 °F'),
                ('APT-3011', 'APT-3011', 'DOC-101', 'Dr. Raj Patel', 'PAT-1005', 'Ananya Iyer', '+91 95501 23456', '+91 95501 23456', 'Cardiology', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), '10:00 AM', 'Cardiology Followup', 'Offline', 'Thyroid check', 'Thyroid & ECG follow-up', 'Confirmed', '122/80', '74 bpm', '98.5 °F'),
                ('APT-8821', 'APT-8821', 'DOC-104', 'Dr. Marcus Vance', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Emergency Medicine', CURRENT_DATE, '02:00 PM', 'General Checkup', 'Offline', 'Patient cancelled', 'Patient cancelled due to urgent travel', 'Cancelled', '120/80', '72 bpm', '98.6 °F')");
        }

        // Table 5: Prescriptions
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `prescriptions` (
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

        $ensure_columns($conn, 'prescriptions', [
            'doctor_id' => "VARCHAR(50) DEFAULT 'DOC-101'",
            'patient_age' => "VARCHAR(20) DEFAULT '40'",
            'patient_gender' => "VARCHAR(20) DEFAULT 'Male'",
            'status' => "VARCHAR(50) DEFAULT 'Active'"
        ]);

        $check_rx = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `prescriptions`");
        if ($check_rx && mysqli_fetch_assoc($check_rx)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `prescriptions` (`prescription_id`, `patient_id`, `patient_name`, `patient_age`, `patient_gender`, `doctor_name`, `doctor_id`, `diagnosis`, `medicines`, `instructions`, `prescription_date`, `status`) VALUES
                ('RX-8021', 'PAT-1001', 'Arjun Sharma', '45', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Hypertension Stage 2 & Dyslipidemia', 'Telmisartan 40mg (1-0-0), Atorvastatin 10mg (0-0-1), Amlodipine 5mg (0-0-1)', 'Take after meals. Low salt diet. Daily 30 min morning walk.', CURRENT_DATE, 'Active'),
                ('RX-8022', 'PAT-1002', 'Priya Verma', '28', 'Female', 'Dr. Jane Smith', 'DOC-102', 'Migraine Prophylaxis', 'Propranolol 20mg (1-0-1), Naproxen 250mg (SOS)', 'Hydrate well. Avoid screen exposure during attacks.', CURRENT_DATE, 'Active'),
                ('RX-8023', 'PAT-1003', 'Amit Shah', '56', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Ischemic Heart Disease Management', 'Clopidogrel 75mg (1-0-0), Rosuvastatin 20mg (0-0-1), Metoprolol 25mg (1-0-1)', 'Strict cardiac diet. Keep Sorbitrate 5mg accessible.', CURRENT_DATE, 'Active');");
        }

        // Table 6: Patient Reports
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `patient_reports` (
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

        $ensure_columns($conn, 'patient_reports', [
            'file_path' => "VARCHAR(255) DEFAULT NULL",
            'file_size' => "VARCHAR(50) DEFAULT '350 KB'",
            'status' => "VARCHAR(50) DEFAULT 'Finalized'"
        ]);

        $check_reports = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `patient_reports`");
        if ($check_reports && mysqli_fetch_assoc($check_reports)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `patient_reports` (`report_id`, `patient_id`, `patient_name`, `report_type`, `category`, `report_date`, `doctor_name`, `file_size`, `status`, `summary`, `results`) VALUES
                ('REP-5021', 'PAT-1001', 'Arjun Sharma', 'Echocardiogram (ECG)', 'Cardiology', CURRENT_DATE, 'Dr. Raj Patel', '450 KB', 'Finalized', 'Normal Sinus Rhythm with LVH signs', 'LVEF: 60%, Mild Concentric LVH, Normal Valvular function'),
                ('REP-5022', 'PAT-1002', 'Priya Verma', 'Brain MRI Scan', 'Neurology', CURRENT_DATE, 'Dr. Jane Smith', '1.2 MB', 'Finalized', 'No acute intracranial pathology detected', 'Normal cerebral parenchyma, ventricles clear'),
                ('REP-5023', 'PAT-1003', 'Amit Shah', 'Coronary Angiography', 'Cardiology', CURRENT_DATE, 'Dr. Raj Patel', '820 KB', 'Finalized', '70% stenosis in LAD mid segment', 'Referred for elective angioplasty evaluation');");
        }

        // Table 7: Patient Vitals
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `patient_vitals` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(100) NOT NULL,
            `heart_rate` INT DEFAULT 72,
            `bp` VARCHAR(20) DEFAULT '120/80',
            `blood_sugar` INT DEFAULT 98,
            `bmi` DECIMAL(5,2) DEFAULT 22.4,
            `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Table 8: Medication Refills / Requests
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `medication_refills` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `refill_id` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(100) NOT NULL,
            `medicine_id` VARCHAR(50) DEFAULT 'MED-01',
            `medicine_name` VARCHAR(150) NOT NULL,
            `dosage` VARCHAR(100) DEFAULT '1 Tablet Daily',
            `quantity` VARCHAR(50) DEFAULT '30 Tablets',
            `doctor_name` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
            `request_date` DATE DEFAULT (CURRENT_DATE),
            `reason` VARCHAR(255) DEFAULT 'Monthly chronic refill',
            `notes` TEXT DEFAULT NULL,
            `status` VARCHAR(50) DEFAULT 'Pending',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $ensure_columns($conn, 'medication_refills', [
            'dosage' => "VARCHAR(100) DEFAULT '1 Tablet Daily'",
            'quantity' => "VARCHAR(50) DEFAULT '30 Tablets'",
            'request_date' => "DATE DEFAULT (CURRENT_DATE)",
            'reason' => "VARCHAR(255) DEFAULT 'Regular medication refill'",
            'notes' => "TEXT DEFAULT NULL"
        ]);

        $check_refills = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `medication_refills`");
        if ($check_refills && mysqli_fetch_assoc($check_refills)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `medication_refills` (`refill_id`, `patient_id`, `patient_name`, `medicine_name`, `dosage`, `quantity`, `doctor_name`, `request_date`, `reason`, `status`) VALUES
                ('REQ-301', 'PAT-1001', 'Arjun Sharma', 'Telmisartan 40mg', '1 Tab Morning', '30 Tablets', 'Dr. Raj Patel', CURRENT_DATE, 'Blood pressure management refill', 'Pending'),
                ('REQ-302', 'PAT-1002', 'Priya Verma', 'Propranolol 20mg', '1 Tab BID', '60 Tablets', 'Dr. Jane Smith', CURRENT_DATE, 'Migraine prevention dosage', 'Approved'),
                ('REQ-303', 'PAT-1003', 'Amit Shah', 'Atorvastatin 20mg', '1 Tab Night', '30 Tablets', 'Dr. Raj Patel', CURRENT_DATE, 'Cholesterol maintenance', 'Pending'),
                ('REQ-304', 'PAT-1005', 'Ananya Iyer', 'Thyroxine 50mcg', '1 Tab Empty Stomach', '50 Tablets', 'Dr. Raj Patel', CURRENT_DATE, 'Thyroid hormone replacement', 'Pending')");
        }

        // Table 9: Patient Visits
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `patient_visits` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `visit_id` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(150) NOT NULL,
            `doctor_name` VARCHAR(150) NOT NULL DEFAULT 'Dr. Raj Patel',
            `doctor_id` VARCHAR(50) DEFAULT 'DOC-101',
            `visit_date` DATE NOT NULL,
            `visit_time` VARCHAR(50) DEFAULT '10:00 AM',
            `visit_type` VARCHAR(100) DEFAULT 'OPD Consultation',
            `department` VARCHAR(100) DEFAULT 'Cardiology',
            `diagnosis` VARCHAR(255) DEFAULT 'Routine Checkup',
            `bp` VARCHAR(20) DEFAULT '120/80',
            `pulse` VARCHAR(20) DEFAULT '72 bpm',
            `fee` DECIMAL(10,2) DEFAULT 500.00,
            `status` VARCHAR(50) DEFAULT 'Completed',
            `notes` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $check_visits = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `patient_visits`");
        if ($check_visits && mysqli_fetch_assoc($check_visits)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `patient_visits` (`visit_id`, `patient_id`, `patient_name`, `doctor_name`, `doctor_id`, `visit_date`, `visit_time`, `visit_type`, `department`, `diagnosis`, `bp`, `pulse`, `fee`, `status`, `notes`) VALUES
                ('VIS-901', 'PAT-1001', 'Arjun Sharma', 'Dr. Raj Patel', 'DOC-101', CURRENT_DATE, '09:30 AM', 'OPD Consultation', 'Cardiology', 'Hypertension Evaluation', '130/85', '76 bpm', 600.00, 'Completed', 'Vitals stable, updated Telmisartan dose'),
                ('VIS-902', 'PAT-1002', 'Priya Verma', 'Dr. Jane Smith', 'DOC-102', CURRENT_DATE, '10:15 AM', 'Follow-up Consultation', 'Neurology', 'Migraine with Aura', '118/76', '72 bpm', 500.00, 'Completed', 'Trigger diary reviewed, symptoms improving'),
                ('VIS-903', 'PAT-1003', 'Amit Shah', 'Dr. Raj Patel', 'DOC-101', CURRENT_DATE, '11:00 AM', 'Emergency Review', 'Cardiology', 'Angina Symptoms', '145/92', '88 bpm', 800.00, 'Completed', 'Advised rest and repeat ECG next week'),
                ('VIS-904', 'PAT-1004', 'Rohan Gupta', 'Dr. Robert Chen', 'DOC-103', CURRENT_DATE, '12:30 PM', 'OPD Consultation', 'Pediatrics', 'Viral Fever Post-check', '115/75', '80 bpm', 500.00, 'Completed', 'Fever subsided, prescribed multivitamins'),
                ('VIS-905', 'PAT-1005', 'Ananya Iyer', 'Dr. Raj Patel', 'DOC-101', DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY), '04:00 PM', 'Specialist Review', 'Cardiology', 'Palpitations & Thyroid', '125/80', '78 bpm', 600.00, 'Completed', 'TSH levels reviewed, dose maintained')");
        }

        // Table 10: Revenue Records
        mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `revenue_records` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `invoice_no` VARCHAR(50) NOT NULL UNIQUE,
            `patient_id` VARCHAR(50) NOT NULL,
            `patient_name` VARCHAR(150) NOT NULL,
            `doctor_name` VARCHAR(150) NOT NULL DEFAULT 'Dr. Raj Patel',
            `doctor_id` VARCHAR(50) DEFAULT 'DOC-101',
            `service_type` VARCHAR(150) DEFAULT 'OPD Consultation',
            `payment_method` VARCHAR(50) DEFAULT 'UPI',
            `amount` DECIMAL(10,2) DEFAULT 600.00,
            `discount` DECIMAL(10,2) DEFAULT 0.00,
            `tax` DECIMAL(10,2) DEFAULT 0.00,
            `net_amount` DECIMAL(10,2) DEFAULT 600.00,
            `payment_status` VARCHAR(50) DEFAULT 'Paid',
            `payment_date` DATE DEFAULT (CURRENT_DATE),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $check_rev = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `revenue_records`");
        if ($check_rev && mysqli_fetch_assoc($check_rev)['cnt'] == 0) {
            mysqli_query($conn, "INSERT INTO `revenue_records` (`invoice_no`, `patient_id`, `patient_name`, `doctor_name`, `doctor_id`, `service_type`, `payment_method`, `amount`, `discount`, `tax`, `net_amount`, `payment_status`, `payment_date`) VALUES
                ('INV-2026-001', 'PAT-1001', 'Arjun Sharma', 'Dr. Raj Patel', 'DOC-101', 'Cardiology OPD Consultation', 'UPI', 600.00, 0.00, 0.00, 600.00, 'Paid', CURRENT_DATE),
                ('INV-2026-002', 'PAT-1002', 'Priya Verma', 'Dr. Jane Smith', 'DOC-102', 'Neurology Specialist Consultation', 'Credit Card', 500.00, 0.00, 0.00, 500.00, 'Paid', CURRENT_DATE),
                ('INV-2026-003', 'PAT-1003', 'Amit Shah', 'Dr. Raj Patel', 'DOC-101', 'Cardiac Emergency Evaluation & ECG', 'Health Insurance', 1400.00, 100.00, 0.00, 1300.00, 'Paid', CURRENT_DATE),
                ('INV-2026-004', 'PAT-1004', 'Rohan Gupta', 'Dr. Robert Chen', 'DOC-103', 'Pediatric Checkup', 'Cash', 500.00, 50.00, 0.00, 450.00, 'Paid', CURRENT_DATE),
                ('INV-2026-005', 'PAT-1005', 'Ananya Iyer', 'Dr. Raj Patel', 'DOC-101', 'Comprehensive Cardiac Assessment', 'Debit Card', 900.00, 0.00, 0.00, 900.00, 'Paid', DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY))");
        }
    }
}
?>
