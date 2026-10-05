-- ==============================================================================
-- MediGo Smart Hospital System - Master Unified SQL Database Dump
-- Fully connecting Admin, Doctor & Patient Modules (MySQL / MariaDB)
-- Host: localhost | Database: medigo
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS `medigo` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `medigo`;

-- ------------------------------------------------------------------------------
-- Table 1: `admins`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'Admin',
  `security_key` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'System Administrator', 'admin@medigo.com', 'admin123', 'Admin'),
(2, 'Admin User', 'admin', 'admin123', 'Admin')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ------------------------------------------------------------------------------
-- Table 2: `doctors`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `doctor_id` VARCHAR(50) NOT NULL UNIQUE,
  `doc_id` VARCHAR(50) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `doctors` (`id`, `doctor_id`, `doc_id`, `name`, `department`, `specialty`, `experience`, `email`, `password`, `phone`, `timing`, `fee`, `status`) VALUES
(1, 'DOC-SMIT-01', 'DOC-SMIT-01', 'Dr. PRAJAPATI SMIT MANOJKUMAR', 'Cardiology', 'Senior Cardiologist', '10+ Years', 'smit@gmail.com', 'smit123', '+91 98980 12345', '09:00 AM - 05:00 PM', 800.00, 'Available'),
(2, 'DOC-101', 'DOC-101', 'Dr. Raj Patel', 'Cardiology', 'Senior Cardiologist', '12+ Years', 'raj.patel@medigo.com', 'doctor123', '+91 98234 11223', '09:00 AM - 02:00 PM', 800.00, 'Available'),
(3, 'DOC-102', 'DOC-102', 'Dr. Jane Smith', 'Neurology', 'Chief Neurologist', '15+ Years', 'jane.smith@medigo.com', 'jane123', '+91 98456 33445', '10:00 AM - 04:00 PM', 1000.00, 'Available'),
(4, 'DOC-103', 'DOC-103', 'Dr. Robert Chen', 'Pediatrics', 'Child Specialist', '8+ Years', 'robert.chen@medigo.com', 'robert123', '+91 98112 55667', '02:00 PM - 08:00 PM', 600.00, 'Available'),
(5, 'DOC-104', 'DOC-104', 'Dr. Marcus Vance', 'Emergency Medicine', 'Trauma Surgeon', '10+ Years', 'marcus.v@medigo.com', 'marcus123', '+91 98776 99887', '24/7 On-Call', 900.00, 'Available')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `password`=VALUES(`password`);

-- ------------------------------------------------------------------------------
-- Table 3: `patients`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patients` (
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
  `doctor_assigned` VARCHAR(150) DEFAULT 'Dr. Raj Patel',
  `disease` VARCHAR(200) DEFAULT 'General Health',
  `allergies` VARCHAR(255) DEFAULT 'None',
  `contact_name` VARCHAR(100) DEFAULT '',
  `relationship` VARCHAR(50) DEFAULT '',
  `contact_phone` VARCHAR(50) DEFAULT '',
  `admission_date` DATE DEFAULT NULL,
  `last_visit` VARCHAR(50) DEFAULT 'Today',
  `status` VARCHAR(50) DEFAULT 'Admitted',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `patients` (`id`, `patient_id`, `name`, `email`, `password`, `dob`, `age`, `gender`, `blood_group`, `blood`, `phone`, `address`, `doctor_assigned`, `disease`, `allergies`, `contact_name`, `relationship`, `contact_phone`, `admission_date`, `last_visit`, `status`) VALUES
(1, 'PAT-1001', 'Arjun Sharma', 'arjun.s@gmail.com', '123456', '1982-05-14', '45 Yrs', 'Male', 'O+', 'O+', '+91 98711 22334', 'Room 204, Ward B, Ahmedabad', 'Dr. Raj Patel', 'Hypertension Stage 2', 'Penicillin', 'Sunita Sharma', 'Spouse', '+91 98711 22339', CURDATE(), 'Today', 'Admitted'),
(2, 'PAT-1002', 'Priya Verma', 'priya.v@gmail.com', '123456', '1995-11-20', '28 Yrs', 'Female', 'B+', 'B+', '+91 98622 33445', 'Room 105, Ward A, Ahmedabad', 'Dr. Jane Smith', 'Migraine Prophylaxis', 'Sulfa Drugs', 'Ramesh Verma', 'Father', '+91 98622 33440', CURDATE(), 'Today', 'Admitted'),
(3, 'PAT-1003', 'Amit Shah', 'amit.shah@gmail.com', '123456', '1968-08-04', '56 Yrs', 'Male', 'B+', 'B+', '+91 97123 45678', 'Room 301, Cardiac Unit, Ahmedabad', 'Dr. Raj Patel', 'Ischemic Heart Disease', 'None', 'Geeta Shah', 'Spouse', '+91 97123 45670', CURDATE(), 'Today', 'Admitted'),
(4, 'PAT-1004', 'Rohan Gupta', 'rohan.g@gmail.com', '123456', '2001-03-12', '23 Yrs', 'Male', 'A+', 'A+', '+91 98533 44556', 'Vastrapur, Ahmedabad', 'Dr. Robert Chen', 'Seasonal Flu', 'None', 'Kailash Gupta', 'Brother', '+91 98533 44550', CURDATE(), 'Yesterday', 'Discharged'),
(5, 'PAT-1005', 'Ananya Iyer', 'ananya.iyer@gmail.com', '123456', '1990-09-25', '34 Yrs', 'Female', 'B-', 'B-', '+91 95501 23456', 'Prahlad Nagar, Ahmedabad', 'Dr. Raj Patel', 'Hypothyroidism', 'Ibuprofen', 'Karthik Iyer', 'Spouse', '+91 95501 23450', CURDATE(), '10 Jun 2026', 'Treatment')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ------------------------------------------------------------------------------
-- Table 4: `appointments`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `apt_id` VARCHAR(50) DEFAULT NULL,
  `appointment_id` VARCHAR(50) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `appointments` (`id`, `apt_id`, `appointment_id`, `doctor_id`, `doctor_name`, `patient_id`, `patient_name`, `phone`, `patient_phone`, `department`, `appointment_date`, `appointment_time`, `type`, `method`, `reason`, `symptoms`, `status`, `bp`, `hr`, `temp`) VALUES
(1, 'APT-1092', 'APT-1092', 'DOC-101', 'Dr. Raj Patel', 'PAT-1001', 'Arjun Sharma', '+91 98711 22334', '+91 98711 22334', 'Cardiology', CURDATE(), '09:30 AM', 'Regular Checkup', 'Offline', 'Routine checkup', 'Monthly hypertension follow-up', 'Confirmed', '130/82', '76 bpm', '98.6 °F'),
(2, 'APT-4820', 'APT-4820', 'DOC-102', 'Dr. Jane Smith', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Neurology', CURDATE(), '10:15 AM', 'Regular Checkup', 'Online', 'Migraine review', 'Migraine follow-up and prescription review', 'Confirmed', '115/76', '72 bpm', '98.4 °F'),
(3, 'APT-9931', 'APT-9931', 'DOC-101', 'Dr. Raj Patel', 'PAT-1003', 'Amit Shah', '+91 97123 45678', '+91 97123 45678', 'Cardiology', CURDATE(), '11:00 AM', 'Emergency Consultation', 'Offline', 'Chest discomfort evaluation', 'Chest discomfort with palpitations', 'Confirmed', '155/95', '94 bpm', '99.1 °F'),
(4, 'APT-2248', 'APT-2248', 'DOC-103', 'Dr. Robert Chen', 'PAT-1004', 'Rohan Gupta', '+91 98533 44556', '+91 98533 44556', 'Pediatrics', CURDATE(), '12:30 PM', 'Regular Checkup', 'Online', 'Post viral checkup', 'General post viral checkup', 'Pending', '118/75', '78 bpm', '98.6 °F'),
(5, 'APT-3011', 'APT-3011', 'DOC-101', 'Dr. Raj Patel', 'PAT-1005', 'Ananya Iyer', '+91 95501 23456', '+91 95501 23456', 'Cardiology', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), '10:00 AM', 'Cardiology Followup', 'Offline', 'Thyroid check', 'Thyroid & ECG follow-up', 'Confirmed', '122/80', '74 bpm', '98.5 °F'),
(6, 'APT-8821', 'APT-8821', 'DOC-104', 'Dr. Marcus Vance', 'PAT-1002', 'Priya Verma', '+91 98622 33445', '+91 98622 33445', 'Emergency Medicine', CURDATE(), '02:00 PM', 'General Checkup', 'Offline', 'Patient cancelled', 'Patient cancelled due to urgent travel', 'Cancelled', '120/80', '72 bpm', '98.6 °F')
ON DUPLICATE KEY UPDATE `patient_name`=VALUES(`patient_name`);

-- ------------------------------------------------------------------------------
-- Table 5: `prescriptions`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prescriptions` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `prescriptions` (`id`, `prescription_id`, `patient_id`, `patient_name`, `patient_age`, `patient_gender`, `doctor_name`, `doctor_id`, `diagnosis`, `medicines`, `instructions`, `prescription_date`, `status`) VALUES
(1, 'RX-8021', 'PAT-1001', 'Arjun Sharma', '45', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Hypertension Stage 2 & Dyslipidemia', 'Telmisartan 40mg (1-0-0), Atorvastatin 10mg (0-0-1), Amlodipine 5mg (0-0-1)', 'Take after meals. Low salt diet. Daily 30 min morning walk.', CURRENT_DATE, 'Active'),
(2, 'RX-8022', 'PAT-1002', 'Priya Verma', '28', 'Female', 'Dr. Jane Smith', 'DOC-102', 'Migraine Prophylaxis', 'Propranolol 20mg (1-0-1), Naproxen 250mg (SOS)', 'Hydrate well. Avoid screen exposure during attacks.', CURRENT_DATE, 'Active'),
(3, 'RX-8023', 'PAT-1003', 'Amit Shah', '56', 'Male', 'Dr. Raj Patel', 'DOC-101', 'Ischemic Heart Disease Management', 'Clopidogrel 75mg (1-0-0), Rosuvastatin 20mg (0-0-1), Metoprolol 25mg (1-0-1)', 'Strict cardiac diet. Keep Sorbitrate 5mg accessible.', CURRENT_DATE, 'Active')
ON DUPLICATE KEY UPDATE `patient_name`=VALUES(`patient_name`);

-- ------------------------------------------------------------------------------
-- Table 6: `patient_reports`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patient_reports` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `patient_reports` (`id`, `report_id`, `patient_id`, `patient_name`, `report_type`, `category`, `doctor_name`, `file_size`, `report_date`, `status`, `summary`, `results`) VALUES
(1, 'REP-5021', 'PAT-1001', 'Arjun Sharma', 'Echocardiogram (ECG)', 'Cardiology', 'Dr. Raj Patel', '450 KB', CURRENT_DATE, 'Finalized', 'Normal Sinus Rhythm with LVH signs', 'LVEF: 60%, Mild Concentric LVH, Normal Valvular function'),
(2, 'REP-5022', 'PAT-1002', 'Priya Verma', 'Brain MRI Scan', 'Neurology', 'Dr. Jane Smith', '1.2 MB', CURRENT_DATE, 'Finalized', 'No acute intracranial pathology detected', 'Normal cerebral parenchyma, ventricles clear'),
(3, 'REP-5023', 'PAT-1003', 'Amit Shah', 'Coronary Angiography', 'Cardiology', 'Dr. Raj Patel', '820 KB', CURRENT_DATE, 'Finalized', '70% stenosis in LAD mid segment', 'Referred for elective angioplasty evaluation')
ON DUPLICATE KEY UPDATE `patient_name`=VALUES(`patient_name`);

-- ------------------------------------------------------------------------------
-- Table 7: `patient_vitals`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `patient_vitals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `patient_id` VARCHAR(50) NOT NULL,
  `patient_name` VARCHAR(100) NOT NULL,
  `heart_rate` INT DEFAULT 72,
  `bp` VARCHAR(20) DEFAULT '120/80',
  `blood_sugar` INT DEFAULT 98,
  `bmi` DECIMAL(5,2) DEFAULT 22.4,
  `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------------------------
-- Table 8: `medication_refills`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `medication_refills` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `refill_id` VARCHAR(50) NOT NULL UNIQUE,
  `patient_id` VARCHAR(50) NOT NULL,
  `patient_name` VARCHAR(100) NOT NULL,
  `medicine_id` VARCHAR(50) NOT NULL,
  `medicine_name` VARCHAR(150) NOT NULL,
  `doctor_name` VARCHAR(100) DEFAULT 'Dr. Raj Patel',
  `status` VARCHAR(50) DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------------------------
-- Table 9: `blood_bank`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blood_bank` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `blood_group` VARCHAR(10) NOT NULL UNIQUE,
  `bags_available` INT DEFAULT 0,
  `status` VARCHAR(50) DEFAULT 'Sufficient',
  `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blood_bank` (`blood_group`, `bags_available`, `status`) VALUES
('A+', 24, 'Sufficient'),
('A-', 8, 'Low Stock'),
('B+', 32, 'Sufficient'),
('B-', 6, 'Critical'),
('AB+', 14, 'Moderate'),
('AB-', 4, 'Critical'),
('O+', 45, 'Sufficient'),
('O-', 5, 'Critical')
ON DUPLICATE KEY UPDATE `bags_available`=VALUES(`bags_available`);

-- ------------------------------------------------------------------------------
-- Table 10: `blood_transactions`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blood_transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `donor_patient_name` VARCHAR(150) NOT NULL,
  `blood_group` VARCHAR(10) NOT NULL,
  `bags` INT NOT NULL DEFAULT 1,
  `type` VARCHAR(50) NOT NULL DEFAULT 'Donation',
  `contact` VARCHAR(50) DEFAULT NULL,
  `date` DATE NOT NULL,
  `status` VARCHAR(50) DEFAULT 'Completed',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------------------------
-- Table 11: `pharmacy`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pharmacy` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pharmacy` (`medicine_name`, `generic_name`, `category`, `batch_no`, `quantity`, `price`, `expiry_date`, `supplier`, `status`) VALUES
('Paracetamol 500mg', 'Acetaminophen', 'Tablets', 'BAT-901', 450, 15.00, '2027-12-31', 'MediGo Pharma', 'In Stock'),
('Amoxicillin 250mg', 'Amoxicillin Trihydrate', 'Capsules', 'BAT-902', 200, 45.00, '2027-08-15', 'Apex Health', 'In Stock'),
('Azithromycin 500mg', 'Azithromycin', 'Tablets', 'BAT-903', 120, 85.00, '2027-06-30', 'Sun Pharma', 'In Stock'),
('Cough Syrup 100ml', 'Dextromethorphan', 'Syrup', 'BAT-904', 80, 75.00, '2026-11-20', 'Cipla Ltd', 'Low Stock')
ON DUPLICATE KEY UPDATE `medicine_name`=VALUES(`medicine_name`);

-- ------------------------------------------------------------------------------
-- Table 12: `hospital_info`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hospital_info` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `hospital_info` (`id`, `hospital_name`, `tagline`, `address`, `phone`, `emergency_contact`, `email`, `total_beds`, `icu_beds`, `ambulances`) VALUES
(1, 'MediGo Shield Hospital', 'Smart Hospital System & Medical Center', 'Opposite Medigo Park, Civil Lines', '+91 98765 43210', '108 / 102', 'contact@medigo.com', 450, 50, 8)
ON DUPLICATE KEY UPDATE `hospital_name`=VALUES(`hospital_name`);

-- ------------------------------------------------------------------------------
-- Table 13: `departments`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `departments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `extension` VARCHAR(50) NOT NULL,
  `lead` VARCHAR(150) NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `departments` (`name`, `extension`, `lead`, `location`, `status`) VALUES
('Emergency Department', 'Ext 4911', 'Dr. Marcus Vance', 'Wing A, Floor 1', 'Active'),
('Cardiology', 'Ext 4022', 'Dr. Raj Patel', 'Wing B, Floor 3', 'Active'),
('Radiology & Imaging', 'Ext 4310', 'Dr. Julian Kovic', 'Wing A, Floor 1', 'Active'),
('Pediatrics Clinic', 'Ext 4150', 'Dr. Robert Chen', 'Wing C, Floor 2', 'Active'),
('Intensive Care Unit (ICU)', 'Ext 4800', 'Dr. Katherine Vance', 'Wing B, Floor 2', 'Active'),
('Neurology', 'Ext 4490', 'Dr. Jane Smith', 'Wing D, Floor 4', 'Active'),
('Pharmacy Services', 'Ext 4210', 'PharmD. Rita Glass', 'Lobby Level, Wing B', 'Active')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- ------------------------------------------------------------------------------
-- Table 14: `broadcasts`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `broadcasts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `priority` VARCHAR(50) DEFAULT 'info',
  `message` TEXT NOT NULL,
  `time` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `broadcasts` (`priority`, `message`, `time`) VALUES
('critical', 'Emergency protocol active in Wing B due to facility electrical testing.', '10:00 AM'),
('warning', 'Scheduled network infrastructure maintenance tonight at 11:00 PM.', '09:30 AM'),
('info', 'Weekly all-hands medical staff briefing tomorrow at 08:30 AM in Conference Hall A.', '08:45 AM');

-- ------------------------------------------------------------------------------
-- Table 15: `contacts`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `subject` VARCHAR(200) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` VARCHAR(50) DEFAULT 'New',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
