<?php
require_once 'db_connect.php';

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $clean_id = !empty($r['patient_id']) ? $r['patient_id'] : ('PAT-' . (1000 + (int)($r['id'] ?? 1)));
            $server_patients[] = [
                'id' => $clean_id,
                'patient_id' => $clean_id,
                'db_id' => $r['id'] ?? '',
                'name' => $r['name'] ?? 'Patient',
                'age' => $r['age'] ?? '35 Years',
                'gender' => $r['gender'] ?? 'Male',
                'blood' => !empty($r['blood']) ? $r['blood'] : (!empty($r['blood_group']) ? $r['blood_group'] : 'O+'),
                'phone' => $r['phone'] ?? '+91 98765 43210',
                'disease' => $r['disease'] ?? 'Hypertension',
                'status' => $r['status'] ?? 'Treatment',
                'allergies' => $r['allergies'] ?? 'None'
            ];
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
    <title>MediCare - Patient Medical History</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Chart.js for Vitals Trend -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .notif-bell {
            position: relative;
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
        }

        .notif-bell .badge {
            position: absolute;
            top: -4px;
            right: -6px;
            background-color: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Header selector row */
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .history-title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .history-title p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .patient-selector-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .patient-selector-box label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .patient-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 0.88rem;
            font-weight: 700;
            outline: none;
            cursor: pointer;
            background-color: #fafbfc;
            color: var(--primary);
        }

        /* Workspace 2-Column Grid Layout */
        .history-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 28px;
        }

        @media (max-width: 1024px) {
            .history-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Dashboard-like Cards */
        .history-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header h2 i {
            color: var(--primary);
        }

        /* Patient Info Card Profile Grid */
        .patient-profile-block {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .patient-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: var(--info-light);
            color: var(--info);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .patient-meta-details h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .patient-meta-details p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .vitals-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .vital-box {
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px;
            text-align: center;
        }

        .vital-box span {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        .vital-box strong {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        /* Medical History Timeline (Right Column) */
        .timeline-container {
            position: relative;
            padding-left: 24px;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 4px;
            bottom: 4px;
            width: 2px;
            background-color: var(--border-color);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -23px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: white;
            border: 3px solid var(--primary);
        }

        .timeline-item.emergency .timeline-dot {
            border-color: var(--danger);
        }

        .timeline-content {
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
        }

        .timeline-date {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
            display: block;
        }

        .timeline-item.emergency .timeline-date {
            color: var(--danger);
        }

        .timeline-content h4 {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .timeline-content p {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .timeline-tag {
            font-size: 0.68rem;
            font-weight: 700;
            background-color: #e2e8f0;
            color: var(--text-main);
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        /* Generic Table Component inside Cards */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .history-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .history-table td {
            font-size: 0.82rem;
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .history-table tr:last-child td {
            border-bottom: none;
        }

        .badge-status {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 50px;
        }

        .badge-status.success {
            background-color: var(--success-light);
            color: var(--success);
        }

        .badge-status.pending {
            background-color: var(--warning-light);
            color: var(--warning);
        }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar (Consistent across systems) -->
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
                    <a href="Allpatient.php">Patients <i class="fa-solid fa-chevron-down"
                            style="font-size: 0.7rem;"></i></a>
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
            <div class="notif-bell">
                <i class="fa-regular fa-bell"></i>
                <span class="badge">1</span>
            </div>
            <div class="user-profile">
                <div class="user-info">
                    <span class="name"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                    <span class="spec"><?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. Main Body Workspace Wrapper -->
    <div class="wrapper">

        <!-- Header Selector Bar -->
        <div class="history-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div class="history-title">
                <h1>Patient History Dashboard</h1>
                <p>Track clinical progress, past prescriptions, and patient vitals chronology.</p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <button class="btn-primary-action active" style="background-color: #084382; color: #fff; border: 1px solid #084382; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(8, 67, 130, 0.2);">
                    <i class="fa-solid fa-clock-rotate-left"></i> Patient History
                </button>
                <button class="btn-primary-action" id="btnHeaderReports" onclick="goToActivePatientReports()" style="background-color: #0a52a3; color: #fff; border: 1px solid #0a52a3; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-file-waveform"></i> Diagnostic Reports
                </button>
                <button class="btn-primary-action" id="btnHeaderNewEntry" onclick="goToActivePatientNewEntry()" style="background-color: #0a52a3; color: #fff; border: 1px solid #0a52a3; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-file-circle-plus"></i> New Entry
                </button>
            </div>
            <div class="patient-selector-box">
                <label for="pSelector">ACTIVE PATIENT:</label>
                <select class="patient-select" id="pSelector" onchange="loadPatientData()">
                    <option value="PAT-1001">Arjun Sharma (PAT-1001)</option>
                    <option value="PAT-1002">Priya Verma (PAT-1002)</option>
                </select>
            </div>
        </div>

        <!-- Two Column Main Workspace Grid -->
        <div class="history-grid">

            <!-- Left Column: Patient Profile Details, Vitals Line Charts, and Diagnostics logs -->
            <div>
                <!-- Card 1: Patient Profile Summary -->
                <div class="history-card">
                    <div class="patient-profile-block">
                        <div class="patient-avatar" id="patAvatar">AS</div>
                        <div class="patient-meta-details">
                            <h3 id="patName">Arjun Sharma</h3>
                            <p>Allergies: <span id="patAllergies" style="color: var(--danger); font-weight: 700;">Penicillin</span></p>
                        </div>
                    </div>

                    <div class="vitals-summary-grid">
                        <div class="vital-box">
                            <span>Blood Group</span>
                            <strong id="patBlood">O+</strong>
                        </div>
                        <div class="vital-box">
                            <span>Age / Gender</span>
                            <strong id="patAgeGender">45 / Male</strong>
                        </div>
                        <div class="vital-box">
                            <span>Height</span>
                            <strong id="patHeight">178 cm</strong>
                        </div>
                        <div class="vital-box">
                            <span>Weight</span>
                            <strong id="patWeight">75 kg</strong>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Vitals Tracker Dynamic Charts -->
                <div class="history-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-heart-pulse"></i> Vitals Trend Line</h2>
                    </div>
                    <!-- Chart canvas target container -->
                    <div style="height: 180px; position: relative;">
                        <canvas id="vitalsChart"></canvas>
                    </div>
                </div>

                <!-- Card 3: Active Prescription Log -->
                <div class="history-card" style="margin-bottom: 0;">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-prescription-bottle-medical"></i> Active Medication Log</h2>
                    </div>
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody id="medicationTableBody">
                            <!-- Dynamic Content -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Medical Visit timeline (Chronological Case File) -->
            <div>
                <div class="history-card" style="height: 100%; margin-bottom: 0;">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-file-medical"></i> Timeline Case History</h2>
                    </div>

                    <div class="timeline-container" id="timelineContainer">
                        <!-- Dynamic Chronology List -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Live JS Core Control System -->
    <script>
        const serverPatients = <?php echo json_encode($server_patients ?? []); ?>;

        const PATIENTS_STORAGE_KEY = 'medigoPatients';
        const DEFAULT_PATIENTS = [
            { id: "PAT-1001", name: "Arjun Sharma", age: "42", gender: "Male", blood: "O+", allergies: "Penicillin", disease: "Hypertension Stage 2", status: "Treatment" },
            { id: "PAT-1002", name: "Priya Verma", age: "29", gender: "Female", blood: "A+", allergies: "Sulfa Drugs", disease: "Chronic Migraine", status: "Improving" },
            { id: "PAT-1003", name: "Amit Shah", age: "56", gender: "Male", blood: "B+", allergies: "None", disease: "Ischemic Heart Disease", status: "Critical" },
            { id: "PAT-1004", name: "Rohan Gupta", age: "23", gender: "Male", blood: "AB+", allergies: "None", disease: "Post Viral Fatigue", status: "Recovered" },
            { id: "PAT-1005", name: "Ananya Iyer", age: "34", gender: "Female", blood: "B-", allergies: "Ibuprofen", disease: "Hypothyroidism", status: "Treatment" }
        ];

        let vitalsChartInstance = null;
        let loadedPatientsList = (Array.isArray(serverPatients) && serverPatients.length > 0) ? serverPatients : DEFAULT_PATIENTS;
        let livePrescriptions = [];
        let liveReports = [];
        let liveAppointments = [];

        function getStoredPatients() {
            return loadedPatientsList;
        }

        async function fetchLiveHistoryData() {
            try {
                // 1. Fetch Patients from MySQL
                const pRes = await fetch('api.php?action=get_patients');
                const pData = await pRes.json();
                if (pData.success && Array.isArray(pData.patients) && pData.patients.length > 0) {
                    loadedPatientsList = pData.patients;
                }
            } catch(e){}

            try {
                // 2. Fetch Prescriptions
                const rxRes = await fetch('api.php?action=get_prescriptions');
                const rxData = await rxRes.json();
                if (rxData.success && Array.isArray(rxData.prescriptions)) {
                    livePrescriptions = rxData.prescriptions;
                }
            } catch(e){}

            try {
                // 3. Fetch Reports
                const repRes = await fetch('api.php?action=get_reports');
                const repData = await repRes.json();
                if (repData.success && Array.isArray(repData.reports)) {
                    liveReports = repData.reports;
                }
            } catch(e){}

            try {
                // 4. Fetch Appointments for Patient History Timeline
                const aptRes = await fetch('api.php?action=get_appointments');
                const aptData = await aptRes.json();
                if (aptData.success && Array.isArray(aptData.appointments)) {
                    liveAppointments = aptData.appointments;
                }
            } catch(e){}

            populateSelector();

            // Check query param or active session for auto-selecting patient
            const urlParams = new URLSearchParams(window.location.search);
            const queryTarget = urlParams.get('id') || urlParams.get('patient') || urlParams.get('patientId') || urlParams.get('patient_id') || urlParams.get('name') || sessionStorage.getItem('medigoCurrentPatientId') || sessionStorage.getItem('medigoCurrentPatientName');

            let matchedPatient = null;
            if (queryTarget) {
                const targetStr = String(queryTarget).toLowerCase().trim();
                matchedPatient = loadedPatientsList.find(p => {
                    const pid = String(p.patient_id || p.id || '').toLowerCase().trim();
                    const pname = String(p.name || '').toLowerCase().trim();
                    const pdbid = String(p.db_id || '').toLowerCase().trim();
                    return pid === targetStr || pname === targetStr || pname.includes(targetStr) || targetStr.includes(pname) || (pdbid && pdbid === targetStr);
                });
            }

            loadPatientData(matchedPatient);
        }

        function populateSelector() {
            const select = document.getElementById('pSelector');
            select.innerHTML = '';
            
            loadedPatientsList.forEach((p, idx) => {
                const opt = document.createElement('option');
                const pId = p.patient_id || p.id || ('PAT-' + (p.db_id || (idx + 1001)));
                opt.value = pId;
                opt.textContent = `${p.name} (${pId})`;
                select.appendChild(opt);
            });
        }

        function goToActivePatientReports() {
            const select = document.getElementById('pSelector');
            const pId = select.value;
            const pObj = loadedPatientsList.find(p => (p.patient_id || p.id) === pId) || {};
            window.location.href = `PatientReports.php?patient=${encodeURIComponent(pObj.name || '')}&id=${encodeURIComponent(pId)}&mode=view`;
        }

        function goToActivePatientNewEntry() {
            const select = document.getElementById('pSelector');
            const pId = select.value;
            window.location.href = `Add_newentery.php?id=${encodeURIComponent(pId)}`;
        }

        function getPatientHistoryData(patient) {
            const pId = String(patient.patient_id || patient.id || '').toUpperCase().trim();
            const pName = String(patient.name || 'Patient').trim();
            const avatar = pName.split(' ').filter(Boolean).map(n => n[0]).join('').toUpperCase().slice(0, 2) || 'PT';

            let systolic = [120, 125, 122, 118, 120];
            let diastolic = [80, 82, 80, 78, 80];
            let heartRate = [72, 75, 74, 71, 72];

            if (pId.includes('1001') || (patient.disease || '').toLowerCase().includes('hypertension')) {
                systolic = [145, 140, 138, 142, 130];
                diastolic = [92, 90, 88, 90, 82];
                heartRate = [82, 80, 78, 84, 76];
            } else if (patient.status === 'Critical') {
                systolic = [140, 148, 155, 145, 150];
                diastolic = [90, 95, 98, 92, 94];
                heartRate = [88, 92, 96, 90, 94];
            } else if (patient.status === 'Recovered') {
                systolic = [128, 124, 120, 118, 116];
                diastolic = [82, 80, 78, 76, 75];
                heartRate = [76, 74, 72, 70, 68];
            }

            // Load medications from livePrescriptions
            let medications = [];
            const patientRx = livePrescriptions.filter(rx => {
                const rxPid = String(rx.patientId || rx.id || '').toUpperCase().trim();
                const rxName = String(rx.patientName || rx.name || '').toLowerCase().trim();
                const curName = pName.toLowerCase();
                return (pId && rxPid === pId) || (rxName && (rxName === curName || rxName.includes(curName) || curName.includes(rxName)));
            });

            if (patientRx.length > 0) {
                patientRx.forEach(rx => {
                    const medList = (rx.medicines || rx.meds || '').split(',');
                    medList.forEach(m => {
                        if (m.trim()) {
                            medications.push({
                                name: m.trim(),
                                dosage: "Standard Dose",
                                freq: rx.instructions || "As directed",
                                duration: "Ongoing"
                            });
                        }
                    });
                });
            }

            if (medications.length === 0) {
                const dis = (patient.disease || '').toLowerCase();
                if (dis.includes('hypertension')) {
                    medications = [
                        { name: "Telmisartan 40mg", dosage: "1 Tablet", freq: "Once daily (Morning)", duration: "3 Months" },
                        { name: "Amlodipine 5mg", dosage: "1 Tablet", freq: "Once daily (Night)", duration: "1 Month" }
                    ];
                } else if (dis.includes('migraine')) {
                    medications = [
                        { name: "Propranolol 40mg", dosage: "1/2 Tablet", freq: "Twice daily", duration: "1 Month" },
                        { name: "Naproxen 500mg", dosage: "1 Tablet", freq: "SOS (In severe pain)", duration: "10 Days" }
                    ];
                } else {
                    medications = [
                        { name: "Multivitamin", dosage: "1 Capsule", freq: "Once daily", duration: "15 Days" },
                        { name: "Pantoprazole 40mg", dosage: "1 Tablet", freq: "Once daily (Before food)", duration: "10 Days" }
                    ];
                }
            }

            // Build Timeline visits
            let visits = [];

            // 1. Add appointments as timeline events
            const patientAppts = liveAppointments.filter(apt => {
                const aptPid = String(apt.patientId || apt.patient_id || apt.id || '').toUpperCase().trim();
                const aptName = String(apt.patient || apt.patientName || '').toLowerCase().trim();
                const curName = pName.toLowerCase();
                return (pId && aptPid === pId) || (aptName && (aptName === curName || aptName.includes(curName) || curName.includes(aptName)));
            });

            patientAppts.forEach(apt => {
                const isEmerg = (apt.type && apt.type.toLowerCase().includes('emergency')) || (apt.status === 'Critical');
                visits.push({
                    date: apt.datetime || (apt.date + ' ' + (apt.time || '')) || 'Scheduled',
                    type: isEmerg ? 'Emergency Consultation' : (apt.type || 'Appointment'),
                    title: `${apt.type || 'Clinical Checkup'} (${apt.status || 'Confirmed'})`,
                    desc: `Symptoms: ${apt.symptoms || 'General follow-up consultation'}. Recorded Vitals: BP ${apt.bp || '120/80'}, Heart Rate ${apt.hr || '72 bpm'}.`,
                    tag: apt.method ? `${apt.method} Visit` : 'OPD Visit',
                    isEmergency: isEmerg
                });
            });

            // 2. Add clinical reports as timeline events
            const patientReps = liveReports.filter(rep => {
                const repPid = String(rep.patientId || rep.id || '').toUpperCase().trim();
                const repName = String(rep.patientName || rep.name || '').toLowerCase().trim();
                const curName = pName.toLowerCase();
                return (pId && repPid === pId) || (repName && (repName === curName || repName.includes(curName) || curName.includes(repName)));
            });

            patientReps.forEach(r => {
                visits.push({
                    date: r.date || 'Recent',
                    type: 'Diagnostic Report',
                    title: r.reportType || r.category || 'Diagnostic Assessment',
                    desc: r.summary || r.results || 'Diagnostic lab report verified and approved by medical team.',
                    tag: r.category || 'Laboratory',
                    isEmergency: false
                });
            });

            // 3. Add standard intake visit
            visits.push({
                date: patient.lastVisit || "Today",
                type: patient.status === 'Critical' ? 'Emergency' : 'Routine Checkup',
                title: `${patient.disease || 'General Health'} Consultation`,
                desc: `${patient.name} registered medical profile. Current status: ${patient.status || 'Treatment'}. Allergies: ${patient.allergies || 'None'}.`,
                tag: patient.disease || 'Checkup',
                isEmergency: patient.status === 'Critical'
            });

            // Append custom visits from localStorage
            let customVisits = JSON.parse(localStorage.getItem('medigo_custom_visits')) || [];
            let patientCustomVisits = customVisits.filter(v => (v.patientId || '').toUpperCase() === pId);
            if (patientCustomVisits.length > 0) {
                visits = [...patientCustomVisits, ...visits];
            }

            return {
                name: patient.name,
                avatar: avatar,
                allergies: patient.allergies || "None reported",
                bloodGroup: patient.blood || "O+",
                ageGender: `${patient.age || '40'} / ${patient.gender || 'Male'}`,
                height: "174 cm",
                weight: "72 kg",
                vitalsLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                systolic: systolic,
                diastolic: diastolic,
                heartRate: heartRate,
                medications: medications,
                visits: visits
            };
        }

        // Master function to render to UI components
        function loadPatientData(explicitPatient = null) {
            let storedPatient = explicitPatient;

            if (!storedPatient) {
                const select = document.getElementById('pSelector');
                const selectedVal = (select ? select.value : '').toLowerCase().trim();
                const selectedIndex = select ? select.selectedIndex : -1;

                if (selectedVal) {
                    storedPatient = loadedPatientsList.find(p => {
                        const pid = String(p.patient_id || p.id || '').toLowerCase().trim();
                        const pdb = String(p.db_id || '').toLowerCase().trim();
                        const pname = String(p.name || '').toLowerCase().trim();
                        return pid === selectedVal || pdb === selectedVal || pname === selectedVal || selectedVal.includes(pname);
                    });
                }

                if (!storedPatient && selectedIndex >= 0 && loadedPatientsList[selectedIndex]) {
                    storedPatient = loadedPatientsList[selectedIndex];
                }
            }

            if (!storedPatient) {
                storedPatient = loadedPatientsList[0];
            }

            if (!storedPatient) return;

            const targetPId = storedPatient.patient_id || storedPatient.id || ('PAT-' + (storedPatient.db_id || '1001'));

            // Sync select element to match selected patient
            const select = document.getElementById('pSelector');
            if (select) {
                for (let i = 0; i < select.options.length; i++) {
                    const optVal = select.options[i].value;
                    const optText = select.options[i].textContent.toLowerCase();
                    if (optVal === targetPId || optText.includes(String(storedPatient.name || '').toLowerCase())) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            }

            // Save active patient to session storage
            try {
                sessionStorage.setItem('medigoCurrentPatientId', targetPId);
                sessionStorage.setItem('medigoCurrentPatientName', storedPatient.name || '');
            } catch(e){}

            const patient = getPatientHistoryData(storedPatient);

            // Render Profile Card
            document.getElementById('patName').textContent = patient.name;
            document.getElementById('patAvatar').textContent = patient.avatar;
            document.getElementById('patAllergies').textContent = patient.allergies;
            document.getElementById('patBlood').textContent = patient.bloodGroup;
            document.getElementById('patAgeGender').textContent = patient.ageGender;
            document.getElementById('patHeight').textContent = patient.height;
            document.getElementById('patWeight').textContent = patient.weight;

            // Render Medication Table
            const medBody = document.getElementById('medicationTableBody');
            medBody.innerHTML = "";
            patient.medications.forEach(med => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${med.name}</strong></td>
                    <td>${med.dosage}</td>
                    <td>${med.freq}</td>
                    <td>${med.duration}</td>
                `;
                medBody.appendChild(tr);
            });

            // Render Case Timeline History
            const timeline = document.getElementById('timelineContainer');
            timeline.innerHTML = "";
            patient.visits.forEach(visit => {
                const div = document.createElement('div');
                div.className = `timeline-item ${visit.isEmergency ? 'emergency' : ''}`;
                div.innerHTML = `
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">${visit.date} &bull; ${visit.type}</span>
                        <h4>${visit.title}</h4>
                        <p>${visit.desc}</p>
                        <span class="timeline-tag">${visit.tag}</span>
                    </div>
                `;
                timeline.appendChild(div);
            });

            // Render Vitals Chart
            renderVitalsChart(patient);
        }

        // Render Vitals Double Line Chart
        function renderVitalsChart(patient) {
            const ctx = document.getElementById('vitalsChart').getContext('2d');

            if (vitalsChartInstance) {
                vitalsChartInstance.destroy();
            }

            vitalsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: patient.vitalsLabels,
                    datasets: [
                        {
                            label: 'Systolic BP (mmHg)',
                            data: patient.systolic,
                            borderColor: '#ef4444',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 3,
                            fill: false
                        },
                        {
                            label: 'Diastolic BP (mmHg)',
                            data: patient.diastolic,
                            borderColor: '#3b82f6',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 3,
                            fill: false
                        },
                        {
                            label: 'Heart Rate (BPM)',
                            data: patient.heartRate,
                            borderColor: '#10b981',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 10,
                                font: { size: 9, weight: '700' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 60,
                            max: 180,
                            ticks: {
                                font: { size: 9, weight: '600' }
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 9, weight: '600' }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', fetchLiveHistoryData);
    </script>
</body>

</html>
