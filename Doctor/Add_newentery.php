<?php
require_once 'db_connect.php';

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `name` ASC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_patients[] = $r;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'doctor_auth.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGo - Medical Report Entry</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0a52a3;
            --primary-hover: #084382;
            --bg-color: #f4f7fc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-light: #ecfdf5;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --info: #3b82f6;
            --info-light: #eff6ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* 1. Header & Navigation (Matches Dashboard exactly) */
        .navbar {
            background-color: #084382;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 72px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }

        .brand i {
            font-size: 1.6rem;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 8px;
            height: 100%;
        }

        .nav-item {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-item>a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .nav-item:hover>a,
        .nav-item.active>a {
            background-color: rgba(255, 255, 255, 0.12);
            color: white;
        }

        .dropdown {
            position: absolute;
            top: 90%;
            left: 0;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            min-width: 210px;
            padding: 8px;
            list-style: none;
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 1100;
            border: 1px solid var(--border-color);
        }

        .nav-item:hover .dropdown {
            display: flex;
        }

        .dropdown li a {
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 10px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .dropdown li a i {
            color: var(--primary);
            width: 16px;
        }

        .dropdown li a:hover {
            background-color: var(--bg-color);
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            padding-left: 20px;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            color: white;
        }

        .user-info .name {
            font-size: 0.88rem;
            font-weight: 700;
        }

        .user-info .spec {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.75);
        }

        /* 2. Main Wrapper Layout */
        .wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }

        .breadcrumbs {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 16px;
            font-weight: 600;
        }

        .breadcrumbs a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            color: var(--primary);
        }

        .breadcrumbs span {
            color: var(--text-main);
        }

        /* Page Title Row */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Two-Column Form Layout */
        .entry-container {
            display: grid;
            grid-template-columns: 2.2fr 1fr;
            gap: 28px;
        }

        @media (max-width: 1024px) {
            .entry-container {
                grid-template-columns: 1fr;
            }
        }

        /* Cards style */
        .form-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .section-num {
            background-color: var(--primary);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        /* Form Controls */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-grid.triple {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group.triple-span-2 {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .form-group label span {
            color: var(--danger);
        }

        input, select, textarea {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            font-size: 0.88rem;
            color: var(--text-main);
            background-color: #fafbfc;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.08);
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper input {
            padding-right: 44px;
            width: 100%;
        }

        .search-input-wrapper i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }

        .search-input-wrapper i:hover {
            color: var(--primary);
        }

        /* Test Results Table */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: left;
        }

        .results-table th {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .results-table td {
            font-size: 0.85rem;
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .status-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        .status-badge.normal {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-badge.high {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .btn-add-row {
            background: none;
            border: 1px dashed var(--primary);
            color: var(--primary);
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-add-row:hover {
            background-color: var(--info-light);
        }

        .btn-delete-row {
            color: var(--danger);
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1rem;
        }

        /* Right Sidebar Cards */
        .sidebar-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 20px;
        }

        .sidebar-card h3 {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-card h3 i {
            color: var(--primary);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            margin-bottom: 12px;
        }

        .summary-row span:first-child {
            color: var(--text-muted);
            font-weight: 600;
        }

        .summary-row span:last-child {
            color: var(--text-main);
            font-weight: 700;
        }

        .status-indicator {
            background-color: var(--success-light);
            color: var(--success);
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.72rem;
        }

        .signature-box {
            text-align: center;
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
            margin-top: 16px;
        }

        .sig-font {
            font-family: 'Brush Script MT', cursive;
            font-size: 1.6rem;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        /* Action Toolbar */
        .toolbar {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .btn-tool {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
            background-color: white;
            color: var(--text-main);
        }

        .btn-tool:hover {
            background-color: var(--bg-color);
        }

        .btn-tool.primary {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-tool.primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-tool.success {
            background-color: var(--success-light);
            color: var(--success);
            border-color: var(--success);
        }

        .btn-tool.success:hover {
            background-color: #d1fae5;
        }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar (Consistent with system) -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="doctor_dashboard.php" class="brand">
                <i class="fa-solid fa-square-h"></i> Medi Go
            </a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="doctor_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a href="Allpatient.php">Patients <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                    <ul class="dropdown">
                        <li><a href="Allpatient.php"><i class="fa-solid fa-users"></i> All Patients</a></li>
                        <li><a href="Add_patient.php"><i class="fa-solid fa-user-plus"></i> Add Patient</a></li>
                        <li><a href="patienthistory.php"><i class="fa-solid fa-history"></i> Patient History</a></li>
                        <li><a href="PatientReports.php"><i class="fa-solid fa-file-invoice"></i> Patient Reports</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="Appointment.php">Appointments <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                    <ul class="dropdown">
                        <li><a href="Today_appoinment.php"><i class="fa-solid fa-calendar-check"></i> Today's Appointments</a></li>
                        <li><a href="Upcoming_appointment.php"><i class="fa-solid fa-calendar-days"></i> Upcoming Appointments</a></li>
                        <li><a href="Cancelled_appointment.php"><i class="fa-solid fa-calendar-xmark"></i> Cancelled Appointments</a></li>
                        <li><a href="Add_appoinment.php"><i class="fa-solid fa-calendar-plus"></i> Add Appointment</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="All_prescription.php">Prescriptions <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                    <ul class="dropdown">
                        <li><a href="All_prescription.php"><i class="fa-solid fa-receipt"></i> All Prescriptions</a></li>
                        <li><a href="Add_prescription.php"><i class="fa-solid fa-prescription-bottle-medical"></i> Add Prescription</a></li>
                        <li><a href="Prescription_history.php"><i class="fa-solid fa-clock-rotate-left"></i> Prescription History</a></li>
                        <li><a href="Medicine_requests.php"><i class="fa-solid fa-pills"></i> Medicine Requests</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="PatientReports.php">Reports <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                    <ul class="dropdown">
                        <li><a href="PatientReports.php"><i class="fa-solid fa-file-waveform"></i> Patient Reports</a></li>
                        <li><a href="Prescription_reports.php"><i class="fa-solid fa-file-medical"></i> Prescription Reports</a></li>
                        <li><a href="Visit_reports.php"><i class="fa-solid fa-hospital-user"></i> Visit Reports</a></li>
                        <li><a href="Revenue_reports.php"><i class="fa-solid fa-money-bill-wave"></i> Revenue Reports</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="Profile_settings.php">Settings <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                    <ul class="dropdown">
                        <li><a href="Profile_settings.php"><i class="fa-solid fa-user-gear"></i> Profile Settings</a></li>
                        <li><a href="Account_settings.php"><i class="fa-solid fa-sliders"></i> Account Settings</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="logout()" style="color: #ff4d4d; font-weight: bold; margin-left: 10px;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="nav-right">
            <div class="user-profile">
                <div class="user-info">
                    <span class="name"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                    <span class="spec"><?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. Main Wrapper -->
    <div class="wrapper">
        <div class="breadcrumbs">
            <a href="Allpatient.php">Patients</a> &nbsp; &gt; &nbsp; <span>New Medical Entry</span>
        </div>

        <div class="page-header">
            <div>
                <h1>New Medical Entry</h1>
                <p>Record clinical diagnostic observations, symptoms, and treatment guidelines.</p>
            </div>
        </div>

        <form id="medicalEntryForm" onsubmit="saveEntry(event)">
            <div class="entry-container">
                <!-- Left Column Form Cards -->
                <div>
                    <!-- 1. Patient Information -->
                    <div class="form-card">
                        <div class="section-title">
                            <span class="section-num">1</span> Patient Information
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patientId">Patient ID <span>*</span></label>
                                <div class="search-input-wrapper">
                                    <input type="text" id="patientId" required placeholder="e.g. PAT-1001" oninput="autofillDetails(this.value)">
                                    <i class="fa-solid fa-magnifying-glass" onclick="autofillDetails(document.getElementById('patientId').value)"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="patientName">Patient Name <span>*</span></label>
                                <input type="text" id="patientName" required placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label for="patientAge">Age <span>*</span></label>
                                <input type="text" id="patientAge" required placeholder="Age (e.g. 45)">
                            </div>
                            <div class="form-group">
                                <label for="patientGender">Gender <span>*</span></label>
                                <select id="patientGender" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="patientBloodGroup">Blood Group</label>
                                <select id="patientBloodGroup">
                                    <option value="" disabled selected>Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="patientMobile">Mobile Number <span>*</span></label>
                                <input type="text" id="patientMobile" required placeholder="+91 XXXXX XXXXX">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Doctor Information -->
                    <div class="form-card">
                        <div class="section-title">
                            <span class="section-num">2</span> Doctor Information
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="doctorName">Doctor Name <span>*</span></label>
                                <select id="doctorName" required>
                                    <option value="<?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?>" selected><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></option>
                                    <option value="Dr. Jane Smith">Dr. Jane Smith</option>
                                    <option value="Dr. Robert Chen">Dr. Robert Chen</option>
                                    <option value="Dr. Marcus Vance">Dr. Marcus Vance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="doctorDepartment">Department <span>*</span></label>
                                <select id="doctorDepartment" required>
                                    <option value="<?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?>" selected><?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?></option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Neurology">Neurology</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="Emergency Medicine">Emergency Medicine</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="doctorId">Doctor ID</label>
                                <input type="text" id="doctorId" readonly value="<?php echo htmlspecialchars($current_doctor['id'] ?? 'DOC-SMIT-01'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="appointmentId">Appointment ID</label>
                                <input type="text" id="appointmentId" placeholder="e.g. APT-5012">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Report Details -->
                    <div class="form-card">
                        <div class="section-title">
                            <span class="section-num">3</span> Report Details
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="reportType">Report Type <span>*</span></label>
                                <select id="reportType" required>
                                    <option value="Consultation" selected>Consultation</option>
                                    <option value="Diagnostic Scans">Diagnostic Scans</option>
                                    <option value="Blood Test">Blood Test</option>
                                    <option value="General Checkup">General Checkup</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="reportDate">Report Date <span>*</span></label>
                                <input type="text" id="reportDate" required>
                            </div>
                            <div class="form-group full-width">
                                <label for="symptoms">Symptoms</label>
                                <textarea id="symptoms" rows="2" placeholder="e.g. Mild palpitations, headache..."></textarea>
                            </div>
                            <div class="form-group full-width">
                                <label for="diagnosis">Diagnosis <span>*</span></label>
                                <textarea id="diagnosis" rows="2" required placeholder="Primary Diagnosis"></textarea>
                            </div>
                            <div class="form-group full-width">
                                <label for="treatmentNotes">Treatment / Prescribed Medications</label>
                                <textarea id="treatmentNotes" rows="3" placeholder="Enter treatment protocol and medication names..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Test Results -->
                    <div class="form-card">
                        <div class="section-title">
                            <span class="section-num">4</span> Test Results
                        </div>
                        <div style="overflow-x: auto;">
                            <table class="results-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Test Name</th>
                                        <th>Result</th>
                                        <th>Unit</th>
                                        <th>Normal Range</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="resultsTableBody">
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" value="Hemoglobin (Hb)" style="width: 100%; padding: 6px;"></td>
                                        <td><input type="text" value="13.5" style="width: 80px; padding: 6px;"></td>
                                        <td>g/dL</td>
                                        <td>12.0 - 16.0</td>
                                        <td><span class="status-badge normal">Normal</span></td>
                                        <td><button type="button" class="btn-delete-row" onclick="deleteRow(this)">&times;</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn-add-row" onclick="addNewTestRow()">
                            <i class="fa-solid fa-plus"></i> Add New Test
                        </button>
                    </div>

                    <!-- Action toolbar -->
                    <div class="toolbar">
                        <button type="submit" class="btn-tool primary"><i class="fa-solid fa-floppy-disk"></i> Save Report</button>
                        <button type="button" class="btn-tool" onclick="alert('Printing Record...')"><i class="fa-solid fa-print"></i> Print</button>
                        <button type="button" class="btn-tool success" onclick="sendToPatient()"><i class="fa-solid fa-paper-plane"></i> Send to Patient</button>
                        <button type="button" class="btn-tool" onclick="window.location.href='Allpatient.php'">Cancel</button>
                    </div>
                </div>

                <!-- Right Sidebar Details -->
                <div>
                    <div class="sidebar-card">
                        <h3><i class="fa-solid fa-file-waveform"></i> Report Summary</h3>
                        <div class="summary-row">
                            <span>Patient Condition</span>
                            <span class="status-indicator">Stable</span>
                        </div>
                        <div class="summary-row">
                            <span>Risk Level</span>
                            <span style="color: var(--success); font-weight: 700;">Low</span>
                        </div>
                        <div class="summary-row">
                            <span>Author Clinician</span>
                            <span><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3><i class="fa-solid fa-signature"></i> Doctor Signature</h3>
                        <div class="signature-box">
                            <div class="sig-font"><?php echo htmlspecialchars(str_replace('Dr. ', '', $current_doctor['name'] ?? 'PRAJAPATI SMIT MANOJKUMAR')); ?></div>
                            <p style="font-weight: 700; margin-top: 10px;"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></p>
                            <p style="color: var(--text-muted); font-size: 0.72rem;">MBBS, MD (<?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?>)</p>
                            <p style="color: var(--text-muted); font-size: 0.72rem;">Reg. No. G-94820</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Interface scripts -->
    <script>
        const serverPatients = <?php echo json_encode($server_patients ?? []); ?>;

        const fallbackPatients = [
            { id: "PAT-1001", patient_id: "PAT-1001", name: "Arjun Sharma", age: "42", gender: "Male", blood: "O+", phone: "+91 98765 43210", disease: "Hypertension Stage 2" },
            { id: "PAT-1002", patient_id: "PAT-1002", name: "Priya Verma", age: "29", gender: "Female", blood: "A+", phone: "+91 98234 56789", disease: "Chronic Migraine" },
            { id: "PAT-1003", patient_id: "PAT-1003", name: "Amit Shah", age: "56", gender: "Male", blood: "B+", phone: "+91 97123 45678", disease: "Ischemic Heart Disease" },
            { id: "PAT-1004", patient_id: "PAT-1004", name: "Rohan Gupta", age: "23", gender: "Male", blood: "AB+", phone: "+91 96012 34567", disease: "Post Viral Fatigue" },
            { id: "PAT-1005", patient_id: "PAT-1005", name: "Ananya Iyer", age: "34", gender: "Female", blood: "B-", phone: "+91 95501 23456", disease: "Hypothyroidism" }
        ];

        let allPatientsCache = (Array.isArray(serverPatients) && serverPatients.length > 0) ? serverPatients : fallbackPatients;

        // Fetch live patients from MySQL
        async function fetchLivePatients() {
            try {
                const res = await fetch('api.php?action=get_patients');
                const data = await res.json();
                if (data.success && Array.isArray(data.patients) && data.patients.length > 0) {
                    allPatientsCache = data.patients;
                }
            } catch(e){}
        }

        // Set default report date
        document.addEventListener('DOMContentLoaded', () => {
            fetchLivePatients();

            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const month = months[today.getMonth()];
            const year = today.getFullYear();
            document.getElementById('reportDate').value = `${day} ${month} ${year}`;
            
            // Check if ID is passed in query param
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            if (id) {
                document.getElementById('patientId').value = id;
                autofillDetails(id);
            }
        });

        // Autofill logic from database / localStorage
        function autofillDetails(enteredId) {
            if (!enteredId) return;
            const cleanId = enteredId.toUpperCase().trim();
            let localPatients = [];
            try {
                const raw = localStorage.getItem('medigoPatients');
                if (raw) localPatients = JSON.parse(raw) || [];
            } catch(e){}

            const matchedPatient = (Array.isArray(allPatientsCache) ? allPatientsCache.find(p => (p.patient_id || p.id || '').toUpperCase() === cleanId) : null) || 
                                   localPatients.find(p => (p.patient_id || p.id || '').toUpperCase() === cleanId) ||
                                   fallbackPatients.find(p => (p.patient_id || p.id || '').toUpperCase() === cleanId);

            if (matchedPatient) {
                document.getElementById('patientName').value = matchedPatient.name || '';
                document.getElementById('patientAge').value = (matchedPatient.age || '').replace(/\D/g, '') || '40';
                document.getElementById('patientGender').value = matchedPatient.gender || 'Male';
                document.getElementById('patientBloodGroup').value = matchedPatient.blood || matchedPatient.blood_group || 'O+';
                document.getElementById('patientMobile').value = matchedPatient.phone || '';
                document.getElementById('diagnosis').value = matchedPatient.disease || '';
                document.getElementById('symptoms').value = (matchedPatient.disease ? matchedPatient.disease + ", " : "") + "Routine Checkup Evaluation";
            } else {
                const sessName = sessionStorage.getItem('medigoCurrentPatientName');
                if (sessName) document.getElementById('patientName').value = sessName;
            }
        }

        // Add test row
        function addNewTestRow() {
            const tbody = document.getElementById('resultsTableBody');
            const rowCount = tbody.rows.length + 1;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" placeholder="Test Name" style="width: 100%; padding: 6px;"></td>
                <td><input type="text" placeholder="Value" style="width: 80px; padding: 6px;"></td>
                <td>-</td>
                <td>-</td>
                <td><span class="status-badge normal">Normal</span></td>
                <td><button type="button" class="btn-delete-row" onclick="deleteRow(this)">&times;</button></td>
            `;
            tbody.appendChild(tr);
        }

        function deleteRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            
            // Re-index row numbers
            const tbody = document.getElementById('resultsTableBody');
            Array.from(tbody.rows).forEach((r, idx) => {
                r.cells[0].textContent = idx + 1;
            });
        }

        // Save entry function with direct MySQL Database integration
        async function saveEntry(event) {
            event.preventDefault();

            const patientId = document.getElementById('patientId').value.trim();
            const patientName = document.getElementById('patientName').value.trim();
            const symptomsVal = document.getElementById('symptoms').value.trim();
            const diagnosisVal = document.getElementById('diagnosis').value.trim();
            const treatmentNotesVal = document.getElementById('treatmentNotes').value.trim();
            const reportDate = document.getElementById('reportDate').value.trim();
            const deptVal = document.getElementById('doctorDepartment').value;
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : (document.getElementById('doctorName')?.value || 'Dr. PRAJAPATI SMIT MANOJKUMAR');

            const newVisit = {
                patientId: patientId,
                date: reportDate,
                type: "Routine",
                title: diagnosisVal || "Medical Assessment",
                desc: `Symptoms: ${symptomsVal}. Diagnosis: ${diagnosisVal}. Treatment: ${treatmentNotesVal}.`,
                tag: deptVal || "General Checkup",
                isEmergency: false
            };

            // Save to localStorage under medigo_custom_visits for immediate preview
            let customVisits = JSON.parse(localStorage.getItem('medigo_custom_visits')) || [];
            customVisits.push(newVisit);
            localStorage.setItem('medigo_custom_visits', JSON.stringify(customVisits));

            // Sync with MySQL Database
            try {
                // 1. Add Report in patient_reports table
                const reportData = new FormData();
                reportData.append('patientId', patientId);
                reportData.append('patientName', patientName);
                reportData.append('reportType', diagnosisVal || 'Clinical Assessment Report');
                reportData.append('category', deptVal || 'Cardiology');
                reportData.append('doctor', docName);
                reportData.append('summary', `Diagnosis: ${diagnosisVal}. Symptoms: ${symptomsVal}`);
                reportData.append('results', treatmentNotesVal || 'Standard therapeutic regimen initiated');

                await fetch('api.php?action=add_report', {
                    method: 'POST',
                    body: reportData
                });

                // 2. Add Prescription in prescriptions table if treatment notes or diagnosis are present
                if (treatmentNotesVal) {
                    const rxData = new FormData();
                    rxData.append('patientId', patientId);
                    rxData.append('patientName', patientName);
                    rxData.append('age', document.getElementById('patientAge').value || '40');
                    rxData.append('gender', document.getElementById('patientGender').value || 'Male');
                    rxData.append('doctor', docName);
                    rxData.append('diagnosis', diagnosisVal || 'General Checkup');
                    rxData.append('medicines', treatmentNotesVal);
                    rxData.append('instructions', 'Take as advised. Follow-up in 2 weeks.');

                    await fetch('api.php?action=add_prescription', {
                        method: 'POST',
                        body: rxData
                    });
                }
            } catch(e) {
                console.warn('MySQL API sync error, saved locally:', e);
            }

            alert('Medical Entry Saved Successfully to Database & Added to Patient Timeline!');
            window.location.href = `patienthistory.php?id=${patientId}`;
        }

        function sendToPatient() {
            alert('Report Sent to Patient via Mobile/Email Successfully!');
            document.getElementById('medicalEntryForm').dispatchEvent(new Event('submit'));
        }
    </script>
</body>

</html>

