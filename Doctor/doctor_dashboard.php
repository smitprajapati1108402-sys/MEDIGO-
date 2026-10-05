<?php
require_once 'db_connect.php';

// Server-side metrics computation from MySQL
$total_patients = 5;
$today_appts_count = 4;
$pending_reports_count = 3;
$today_appts_list = [];
$recent_patients_list = [];

if (!empty($db_connected) && !empty($conn)) {
    $p_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `patients`");
    if ($p_res) $total_patients = (int)mysqli_fetch_assoc($p_res)['cnt'];

    $a_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `appointments` WHERE `appointment_date` = CURRENT_DATE");
    if ($a_res) $today_appts_count = (int)mysqli_fetch_assoc($a_res)['cnt'];

    $r_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM `patient_reports`");
    if ($r_res) $pending_reports_count = (int)mysqli_fetch_assoc($r_res)['cnt'];

    $t_res = mysqli_query($conn, "SELECT * FROM `appointments` WHERE `appointment_date` = CURRENT_DATE ORDER BY `id` ASC LIMIT 5");
    if (!$t_res || mysqli_num_rows($t_res) === 0) {
        $t_res = mysqli_query($conn, "SELECT * FROM `appointments` ORDER BY `id` ASC LIMIT 5");
    }
    if ($t_res) {
        while ($row = mysqli_fetch_assoc($t_res)) {
            $today_appts_list[] = $row;
        }
    }

    $rp_res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `id` DESC LIMIT 5");
    if ($rp_res) {
        while ($row = mysqli_fetch_assoc($rp_res)) {
            $recent_patients_list[] = $row;
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
    <title>MediCare - Doctor Dashboard</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Chart.js for Beautiful Analytics Chart -->
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

        /* 1. Header & Navigation */
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

        /* Nav Dropdowns styling matches the image */
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

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            object-fit: cover;
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
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* 2. Main Wrapper Layout */
        .wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }

        /* Welcome Section */
        .welcome-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .welcome-left h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .welcome-left p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .date-box {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 12px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .date-box i {
            font-size: 1.3rem;
            color: var(--text-muted);
        }

        .date-box-text .date {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .date-box-text .day {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Stat Cards Matrix */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (max-width: 1024px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-icon.blue {
            background-color: var(--info-light);
            color: var(--info);
        }

        .stat-icon.green {
            background-color: var(--success-light);
            color: var(--success);
        }

        .stat-icon.purple {
            background-color: #f5f3ff;
            color: #8b5cf6;
        }

        .stat-icon.orange {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .stat-data {
            flex-grow: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .stat-trend {
            font-size: 0.78rem;
            font-weight: 700;
        }

        .stat-trend.up {
            color: var(--success);
        }

        .stat-trend.down {
            color: var(--danger);
        }

        /* 3. Columns Grid Workspace */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.1fr;
            gap: 24px;
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Generic Card Components */
        .dashboard-card {
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
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .card-link {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        /* Column 1 Elements (Appointments & Weekly Schedule) */
        .appointment-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 20px;
        }

        .appointment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .appointment-row:last-child {
            border-bottom: none;
        }

        .time-col {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            width: 75px;
        }

        .pat-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-grow: 1;
        }

        .pat-profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .pat-info h4 {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .pat-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Badge Pills */
        .badge-pill {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
        }

        .badge-pill.confirmed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .badge-pill.emergency {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .badge-pill.pending {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .btn-view {
            background-color: var(--info-light);
            color: var(--info);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background-color: var(--info);
            color: white;
        }

        .btn-primary-wide {
            background-color: var(--primary);
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-primary-wide:hover {
            background-color: var(--primary-hover);
        }

        /* Weekly Calendar Scheduler CSS */
        .calendar-week-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-top: 14px;
        }

        .day-card {
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 10px 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .day-card.active {
            background-color: var(--info-light);
            border-color: var(--info);
        }

        .day-card .day-name {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .day-card.active .day-name {
            color: var(--info);
        }

        .day-card .day-date {
            font-size: 0.85rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .day-card .day-appt {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Column 2 Elements (Recent Patients Table) */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .patient-table th {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .patient-table td {
            font-size: 0.85rem;
            padding: 16px 14px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .patient-table tr:last-child td {
            border-bottom: none;
        }

        .td-id {
            font-weight: 700;
            color: var(--text-muted);
        }

        .td-name {
            font-weight: 700;
        }

        /* Custom Disease-Status Pills */
        .status-pill {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        .status-pill.treatment {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-pill.improving {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-pill.critical {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .status-pill.recovered {
            background-color: #f0fdf4;
            color: #15803d;
        }

        /* Column 3 Elements (Actions & Notifications) */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .action-card {
            border: 1px solid var(--border-color);
            background-color: var(--bg-color);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .action-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
            background-color: var(--card-bg);
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.08);
        }

        .action-card i {
            font-size: 1.4rem;
            color: var(--primary);
        }

        .action-card span {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Notifications Panel */
        .notif-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .notif-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .notif-icon.blue {
            background-color: var(--info-light);
            color: var(--info);
        }

        .notif-icon.calendar {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .notif-icon.purple {
            background-color: #f5f3ff;
            color: #8b5cf6;
        }

        .notif-content h4 {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .notif-content p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Chart Filter Config Dropdown */
        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 700;
            outline: none;
            cursor: pointer;
            background-color: var(--card-bg);
        }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="doctor_dashboard.php" class="brand">
                <i class="fa-solid fa-square-h"></i> Medi Go
            </a>
            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="doctor_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                </li>
                <li class="nav-item">
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

    <!-- 2. Workspace Body Wrapper -->
    <div class="wrapper">

        <!-- Welcome Hero Line -->
        <div class="welcome-row">
            <div class="welcome-left">
                <h1>Welcome Back, <span id="welcomeDoctorName"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span></h1>
                <p>Here's what's happening with your clinic today.</p>
            </div>
            <div class="date-box">
                <i class="fa-regular fa-calendar-days"></i>
                <div class="date-box-text">
                    <div class="date" id="currentDate">27 May 2025</div>
                    <div class="day"><span id="currentDay">Tuesday</span> &bull; <span id="currentTime" style="font-weight: 600; color: var(--primary);">12:00 PM</span></div>
                </div>
            </div>
        </div>

        <!-- 4 Stat Card Blocks -->
        <div class="stats-row">
            <div class="stat-card" onclick="window.location.href='Allpatient.php'" style="cursor: pointer;">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-user-injured"></i>
                </div>
                <div class="stat-data">
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value" id="dashTotalPatients"><?php echo $total_patients; ?></div>
                    <div class="stat-trend up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 12% <span
                            style="color: var(--text-muted); font-weight: normal;">Live from Database</span>
                    </div>
                </div>
            </div>
            <div class="stat-card" onclick="window.location.href='Today_appoinment.php'" style="cursor: pointer;">
                <div class="stat-icon green">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="stat-data">
                    <div class="stat-label">Today's Appointments</div>
                    <div class="stat-value"><?php echo $today_appts_count; ?></div>
                    <div class="stat-trend up">
                        <i class="fa-solid fa-arrow-trend-up"></i> Live <span
                            style="color: var(--text-muted); font-weight: normal;">Queue active</span>
                    </div>
                </div>
            </div>
            <div class="stat-card" onclick="window.location.href='PatientReports.php'" style="cursor: pointer;">
                <div class="stat-icon purple">
                    <i class="fa-solid fa-file-medical-alt"></i>
                </div>
                <div class="stat-data">
                    <div class="stat-label">Diagnostic Reports</div>
                    <div class="stat-value"><?php echo $pending_reports_count; ?></div>
                    <div class="stat-trend down">
                        <i class="fa-solid fa-file-circle-check"></i> <span
                            style="color: var(--text-muted); font-weight: normal;">verified in database</span>
                    </div>
                </div>
            </div>
            <div class="stat-card" onclick="window.location.href='Today_appoinment.php'" style="cursor: pointer;">
                <div class="stat-icon orange">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <div class="stat-data">
                    <div class="stat-label">Today's Revenue</div>
                    <div class="stat-value">&#8377;<?php echo number_format($today_appts_count * 1500); ?></div>
                    <div class="stat-trend up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 15% <span
                            style="color: var(--text-muted); font-weight: normal;">consultation billings</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Dashboard Structure Grid Worksite -->
        <div class="dashboard-grid">

            <!-- Column 1: Today's Appointments -->
            <div>
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Today's Appointments</h2>
                        <a href="Today_appoinment.php" class="card-link">View All</a>
                    </div>
                    <div class="appointment-list">
                        <?php if (!empty($today_appts_list)): ?>
                            <?php foreach ($today_appts_list as $t_appt): 
                                $appt_status = $t_appt['status'] ?? 'Confirmed';
                                $appt_type = $t_appt['type'] ?? $t_appt['appointment_type'] ?? 'Regular Checkup';
                                $appt_time = $t_appt['appointment_time'] ?? $t_appt['time'] ?? '09:00 AM';
                                $pat_name = $t_appt['patient_name'] ?? $t_appt['name'] ?? 'Patient';
                                $status_class = strtolower($appt_status);
                                if (stripos($appt_type, 'Emergency') !== false) {
                                    $status_class = 'emergency';
                                }
                            ?>
                            <div class="appointment-row" onclick="window.location.href='Today_appoinment.php'" style="cursor: pointer;">
                                <span class="time-col"><?php echo htmlspecialchars($appt_time); ?></span>
                                <div class="pat-profile">
                                    <div class="pat-info">
                                        <h4><?php echo htmlspecialchars($pat_name); ?></h4>
                                        <p><?php echo htmlspecialchars($appt_type); ?></p>
                                    </div>
                                </div>
                                <span class="badge-pill <?php echo $status_class; ?>"><?php echo htmlspecialchars($appt_status); ?></span>
                                <button class="btn-view" onclick="event.stopPropagation(); window.location.href='Today_appoinment.php'">Review</button>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 20px; text-align: center; color: var(--text-muted);">No appointments scheduled for today.</div>
                        <?php endif; ?>
                    </div>
                    <button class="btn-primary-wide" onclick="window.location.href='Appointment.php'">View Full
                        Schedule</button>
                </div>

                <!-- Upcoming Weekly Calendar Section -->
                <div class="dashboard-card" style="margin-bottom: 0;">
                    <div class="card-header" style="margin-bottom: 8px;">
                        <h2>Upcoming Schedule</h2>
                        <a href="Upcoming_appointment.php" class="card-link">View All</a>
                    </div>
                    <div class="calendar-week-row">
                        <div class="day-card active" onclick="selectDay(this)">
                            <div class="day-name">Mon</div>
                            <div class="day-date">27 May</div>
                            <div class="day-appt">12 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)">
                            <div class="day-name">Tue</div>
                            <div class="day-date">28 May</div>
                            <div class="day-appt">14 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)">
                            <div class="day-name">Wed</div>
                            <div class="day-date">29 May</div>
                            <div class="day-appt">10 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)">
                            <div class="day-name">Thu</div>
                            <div class="day-date">30 May</div>
                            <div class="day-appt">16 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)">
                            <div class="day-name">Fri</div>
                            <div class="day-date">31 May</div>
                            <div class="day-appt">11 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)">
                            <div class="day-name">Sat</div>
                            <div class="day-date">01 Jun</div>
                            <div class="day-appt">8 Appt</div>
                        </div>
                        <div class="day-card" onclick="selectDay(this)"
                            style="background-color: #fafafa; border-color: #eee;">
                            <div class="day-name" style="color: var(--danger);">Sun</div>
                            <div class="day-date">02 Jun</div>
                            <div class="day-appt" style="color: var(--text-muted);">Day Off</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: Recent Patients List -->
            <div>
                <div class="dashboard-card" style="height: 100%;">
                    <div class="card-header">
                        <h2>Recent Patients</h2>
                        <a href="Allpatient.php" class="card-link">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="patient-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Disease</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentPatientsBody">
                                <!-- Rendered dynamically via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Column 3: Appointments Analytics, Actions & Notifications -->
            <div>
                <!-- Appointments Line Chart Container -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Appointments Overview <span
                                style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">(This
                                Month)</span></h2>
                        <select class="filter-select">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <!-- Target canvas for Chart JS rendering -->
                    <div style="height: 180px; position: relative;">
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>

                <!-- Prescription Quick Actions -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Prescription Quick Actions</h2>
                    </div>
                    <div class="action-grid">
                        <div class="action-card" onclick="window.location.href='Add_prescription.php'">
                            <i class="fa-solid fa-file-medical"></i>
                            <span>Add Prescription</span>
                        </div>
                        <div class="action-card" onclick="const pId = sessionStorage.getItem('medigoCurrentPatientId') || sessionStorage.getItem('medigoCurrentPatientName'); window.location.href = pId ? ('patienthistory.php?id=' + encodeURIComponent(pId)) : 'patienthistory.php';">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>View Patient History</span>
                        </div>
                        <div class="action-card" onclick="window.location.href='Prescription_reports.php'">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span>Prescription Reports</span>
                        </div>
                        <div class="action-card" onclick="window.location.href='Medicine_requests.php'">
                            <i class="fa-solid fa-pills"></i>
                            <span>Medicine Requests</span>
                        </div>
                    </div>
                </div>

                <!-- Notifications Panel -->
                <div class="dashboard-card" style="margin-bottom: 0;">
                    <div class="card-header">
                        <h2>Notifications</h2>
                        <a href="#" class="card-link">View All</a>
                    </div>
                    <div class="notif-list">
                        <div class="notif-row">
                            <div class="notif-icon blue">
                                <i class="fa-regular fa-bell"></i>
                            </div>
                            <div class="notif-content">
                                <h4>New lab report available for Arjun Sharma</h4>
                                <p>10 minutes ago</p>
                            </div>
                        </div>
                        <div class="notif-row">
                            <div class="notif-icon calendar">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <div class="notif-content">
                                <h4>You have 5 appointments today</h4>
                                <p>30 minutes ago</p>
                            </div>
                        </div>
                        <div class="notif-row">
                            <div class="notif-icon purple">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <div class="notif-content">
                                <h4>Report verified: Amit Shah</h4>
                                <p>1 hour ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
    </div>

    <!-- Live Javascript Logic -->
    <script>

        // Custom interactive script to handle calendar day selections
        function selectDay(element) {
            // Remove active classes from other schedule cards
            document.querySelectorAll('.day-card').forEach(card => {
                card.classList.remove('active');
            });
            // Apply focus border to current day card
            element.classList.add('active');
        }

        // Beautiful Live Analytics line chart matching original mockup
        document.addEventListener('DOMContentLoaded', () => {
            // Update real-life date and time dynamically
            const updateDateTime = () => {
                const now = new Date();
                
                // Format date: "27 May 2025"
                const day = now.getDate();
                const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const formattedDate = `${day} ${month} ${year}`;
                
                // Format day: "Tuesday"
                const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const formattedDay = weekdays[now.getDay()];
                
                // Format time: "12:00 PM"
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                const formattedTime = `${hours}:${minutes} ${ampm}`;
                
                const dateEl = document.getElementById('currentDate');
                const dayEl = document.getElementById('currentDay');
                const timeEl = document.getElementById('currentTime');
                
                if (dateEl) dateEl.textContent = formattedDate;
                if (dayEl) dayEl.textContent = formattedDay;
                if (timeEl) timeEl.textContent = formattedTime;
            };
            
            updateDateTime();
            // Keep the time updated every second
            setInterval(updateDateTime, 1000);

            const ctx = document.getElementById('appointmentsChart').getContext('2d');

            // Subtle blue gradient underneath chart vector path
            const gradient = ctx.createLinearGradient(0, 0, 0, 160);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1 May', '6 May', '11 May', '16 May', '21 May', '26 May', '31 May'],
                    datasets: [{
                        label: 'Appointments',
                        data: [40, 75, 110, 85, 135, 115, 145],
                        borderColor: '#2563eb', // Rich indigo-blue outline
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4, // Smooth curved dynamic waves
                        fill: true,
                        backgroundColor: gradient
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide labels for minimal dashboard design
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return `Appointments: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                display: true,
                                color: '#f1f5f9'
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 10,
                                    weight: '600'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 10,
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });

            // Render Recent Patients dynamically from MySQL Database
            const renderDashboardPatients = async () => {
                const serverPatients = <?php echo json_encode($recent_patients_list); ?>;
                let patients = serverPatients && serverPatients.length > 0 ? serverPatients : [];

                try {
                    const response = await fetch('api.php?action=get_patients');
                    const res = await response.json();
                    if (res.success && res.patients && res.patients.length > 0) {
                        patients = res.patients;
                    }
                } catch(e) {
                    console.warn('API get_patients fallback:', e);
                }

                if (patients.length === 0) {
                    try {
                        let raw = localStorage.getItem('medigoPatients');
                        if (raw) patients = JSON.parse(raw);
                    } catch(err){}
                }

                // Update Total Patients metric
                const totalPatientsEl = document.getElementById('dashTotalPatients');
                if (totalPatientsEl && patients.length > 0) {
                    totalPatientsEl.textContent = patients.length;
                }

                // Render top 5 recent patients into table
                const tbody = document.getElementById('recentPatientsBody');
                if (tbody) {
                    tbody.innerHTML = '';
                    const recent5 = patients.slice(0, 5);
                    recent5.forEach(p => {
                        const tr = document.createElement('tr');
                        tr.style.cursor = 'pointer';
                        const pId = p.patient_id || p.id || ('PAT-' + (p.db_id || '1001'));
                        tr.onclick = () => {
                            try {
                                sessionStorage.setItem('medigoCurrentPatientId', pId);
                                sessionStorage.setItem('medigoCurrentPatientName', p.name || '');
                            } catch(e){}
                            window.location.href = `Add_patient.php?id=${encodeURIComponent(pId)}&mode=view`;
                        };
                        const statusClass = (p.status || 'treatment').toLowerCase();
                        tr.innerHTML = `
                            <td class="td-id">${pId}</td>
                            <td class="td-name">${p.name}</td>
                            <td>${p.disease || 'General Checkup'}</td>
                            <td><span class="status-pill ${statusClass}">${p.status || 'Treatment'}</span></td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            };

            renderDashboardPatients();
        });
    </script>
</body>

</html>
