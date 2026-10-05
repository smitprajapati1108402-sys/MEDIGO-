<?php
require_once 'db_connect.php';

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $p_res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `id` DESC");
    if ($p_res) {
        while ($row = mysqli_fetch_assoc($p_res)) {
            $clean_id = !empty($row['patient_id']) ? $row['patient_id'] : ('PAT-' . (1000 + (int)($row['id'] ?? 1)));
            $server_patients[] = [
                'id' => $clean_id,
                'patient_id' => $clean_id,
                'db_id' => $row['id'] ?? 1,
                'name' => $row['name'] ?? 'Patient',
                'dob' => $row['dob'] ?? '',
                'age' => $row['age'] ?? '35 Years',
                'gender' => $row['gender'] ?? 'Male',
                'blood' => !empty($row['blood']) ? $row['blood'] : (!empty($row['blood_group']) ? $row['blood_group'] : 'O+'),
                'phone' => $row['phone'] ?? '+91 98765 43210',
                'email' => $row['email'] ?? '',
                'disease' => $row['disease'] ?? 'General Checkup',
                'status' => $row['status'] ?? 'Treatment',
                'allergies' => $row['allergies'] ?? 'None',
                'contactName' => $row['contact_name'] ?? '',
                'relationship' => $row['relationship'] ?? '',
                'contactPhone' => $row['contact_phone'] ?? '',
                'address' => $row['address'] ?? 'Ahmedabad, Gujarat',
                'lastVisit' => $row['last_visit'] ?? 'Today'
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
    <title>MediCare - All Patients</title>
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

        /* Page Title Row */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .btn-add {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.15);
        }

        .btn-add:hover {
            background-color: var(--primary-hover);
        }

        /* Stat Cards Block */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
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

        .stat-icon.blue { background-color: var(--info-light); color: var(--info); }
        .stat-icon.green { background-color: var(--success-light); color: var(--success); }
        .stat-icon.purple { background-color: #f5f3ff; color: #8b5cf6; }
        .stat-icon.orange { background-color: var(--warning-light); color: var(--warning); }

        .stat-data {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
        }

        /* 3. Main Filter & Directory Table Card */
        .directory-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        /* Filter Controls Styling */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex-grow: 1;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            font-size: 0.9rem;
            color: var(--text-main);
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
        }

        .filter-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            background-color: var(--card-bg);
            color: var(--text-main);
        }

        /* Patients Responsive Table */
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
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .patient-table td {
            font-size: 0.88rem;
            padding: 16px 16px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .patient-table tr:hover {
            background-color: #fafbfc;
        }

        .td-id {
            font-weight: 700;
            color: var(--text-muted);
        }

        .td-patient {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .td-patient img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .patient-details h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .patient-details p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Disease-Status Pills */
        .status-pill {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        .status-pill.treatment { background-color: var(--success-light); color: var(--success); }
        .status-pill.improving { background-color: var(--info-light); color: var(--info); }
        .status-pill.critical { background-color: var(--danger-light); color: var(--danger); }
        .status-pill.recovered { background-color: #f0fdf4; color: #15803d; }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: white;
            transition: all 0.2s;
            color: var(--text-muted);
        }

        .btn-action.history:hover { border-color: var(--primary); color: var(--primary); background-color: rgba(10, 82, 163, 0.1); }
        .btn-action.view:hover { border-color: var(--info); color: var(--info); background-color: var(--info-light); }
        .btn-action.edit:hover { border-color: var(--warning); color: var(--warning); background-color: var(--warning-light); }
        .btn-action.delete:hover { border-color: var(--danger); color: var(--danger); background-color: var(--danger-light); }

        /* Pagination Style */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .pagination-text {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .pagination-buttons {
            display: flex;
            gap: 6px;
        }

        .btn-page {
            border: 1px solid var(--border-color);
            background-color: white;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-page:hover, .btn-page.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* 4. Add Patient Modal Popup */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 16px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
            overflow: hidden;
        }

        @keyframes slideIn {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            background-color: #084382;
            color: white;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .modal-header .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0.8;
        }

        .modal-header .close-btn:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .form-group input, .form-group select {
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            font-size: 0.88rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            background-color: #f1f5f9;
            color: var(--text-muted);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-save {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-save:hover {
            background-color: var(--primary-hover);
        }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar (Consistent with Dashboard) -->
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

    <!-- 2. Main Workspace Body Wrapper -->
    <div class="wrapper">

        <!-- Page Header Row -->
        <div class="page-header">
            <div>
                <h1>Patients Directory</h1>
                <p>Manage and monitor all active or registered clinic patients.</p>
            </div>
            <button class="btn-add" onclick="window.location.href='Add_patient.php'">
                <i class="fa-solid fa-user-plus"></i> Add New Patient
            </button>
        </div>

        <!-- Directory Summary Mini-Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Total Registered</span>
                    <span class="stat-value" id="stat-total">7</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fa-solid fa-user-md"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Under Treatment</span>
                    <span class="stat-value" id="stat-treatment">2</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fa-solid fa-shield-virus"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Improving Cases</span>
                    <span class="stat-value" id="stat-improving">2</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fa-solid fa-heart-circle-exclamation"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Critical Cases</span>
                    <span class="stat-value" id="stat-critical">1</span>
                </div>
            </div>
        </div>

        <!-- 3. Table and Filters workspace card -->
        <div class="directory-card">
            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search by ID, Name or Disease..." onkeyup="filterPatients()">
                </div>
                <div class="filter-group">
                    <select class="filter-select" id="statusFilter" onchange="filterPatients()">
                        <option value="All">All Statuses</option>
                        <option value="Treatment">Treatment</option>
                        <option value="Improving">Improving</option>
                        <option value="Critical">Critical</option>
                        <option value="Recovered">Recovered</option>
                    </select>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="patient-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Age / Gender</th>
                            <th>Disease</th>
                            <th>Contact Info</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patientTableBody">
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            <div class="pagination">
                <div class="pagination-text">Showing <span id="displayed-count">7</span> of <span id="total-count">7</span> entries</div>
                <div class="pagination-buttons">
                    <button class="btn-page" onclick="alert('Navigate Previous')">Previous</button>
                    <button class="btn-page active">1</button>
                    <button class="btn-page" onclick="alert('Navigate Next')">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Add Patient Modal Popup Structure -->
    <div class="modal" id="addPatientModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Patient Profile</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addPatientForm" onsubmit="savePatient(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="patId">Patient ID</label>
                            <input type="text" id="patId" required placeholder="e.g. P008">
                        </div>
                        <div class="form-group">
                            <label for="patName">Full Name</label>
                            <input type="text" id="patName" required placeholder="e.g. Mahesh Patel">
                        </div>
                        <div class="form-group">
                            <label for="patAge">Age</label>
                            <input type="number" id="patAge" required placeholder="e.g. 35">
                        </div>
                        <div class="form-group">
                            <label for="patGender">Gender</label>
                            <select id="patGender" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="patDisease">Disease / Diagnosis</label>
                            <input type="text" id="patDisease" required placeholder="e.g. Jaundice">
                        </div>
                        <div class="form-group">
                            <label for="patContact">Contact Number</label>
                            <input type="text" id="patContact" required placeholder="+91 XXXXX XXXXX">
                        </div>
                        <div class="form-group full-width">
                            <label for="patStatus">Initial Treatment Status</label>
                            <select id="patStatus" required>
                                <option value="Treatment">Treatment</option>
                                <option value="Improving">Improving</option>
                                <option value="Critical">Critical</option>
                                <option value="Recovered">Recovered</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-save" id="btnSave">Save Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Javascript Operations -->
    <script>
        const PATIENTS_STORAGE_KEY = 'medigoPatients';

        // Default Patients List
        const DEFAULT_PATIENTS = [
            { id: 'PAT-1001', name: 'Arjun Sharma', age: '45', gender: 'Male', disease: 'Hypertension', phone: '+91 98711 22334', status: 'Treatment', createdAt: new Date().toISOString() },
            { id: 'PAT-1002', name: 'Priya Verma', age: '28', gender: 'Female', disease: 'Migraine', phone: '+91 98622 33445', status: 'Improving', createdAt: new Date().toISOString() },
            { id: 'PAT-1003', name: 'Rohan Gupta', age: '12', gender: 'Male', disease: 'Seasonal Flu', phone: '+91 98533 44556', status: 'Recovered', createdAt: new Date().toISOString() },
            { id: 'PAT-1004', name: 'Rahul Sharma', age: '35', gender: 'Male', disease: 'Viral Fever', phone: '+91 98765 43210', status: 'Treatment', createdAt: new Date().toISOString() },
            { id: 'PAT-1005', name: 'Amit Shah', age: '62', gender: 'Male', disease: 'Heart Disease', phone: '+91 76543 21098', status: 'Critical', createdAt: new Date().toISOString() }
        ];

        let currentEditId = null;

        const serverInjectedPatients = <?php echo json_encode($server_patients ?? []); ?>;

        function mergePatients(serverList, localList) {
            const map = new Map();
            DEFAULT_PATIENTS.forEach(p => {
                const key = String(p.patient_id || p.id || '').toUpperCase().trim();
                if (key) map.set(key, p);
            });
            if (Array.isArray(serverList)) {
                serverList.forEach(p => {
                    const key = String(p.patient_id || p.id || ('PAT-' + p.db_id) || '').toUpperCase().trim();
                    if (key) map.set(key, { ...(map.get(key) || {}), ...p });
                });
            }
            if (Array.isArray(localList)) {
                localList.forEach(p => {
                    const key = String(p.patient_id || p.id || '').toUpperCase().trim();
                    if (key) {
                        const existing = map.get(key) || {};
                        map.set(key, { ...existing, ...p });
                    }
                });
            }
            return Array.from(map.values());
        }

        let globalPatientsList = mergePatients(serverInjectedPatients, (() => {
            try {
                const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch(e) { return []; }
        })());

        function getStoredPatients() {
            let localList = [];
            try {
                const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                if (raw) localList = JSON.parse(raw) || [];
            } catch (e) {}
            return mergePatients(serverInjectedPatients, Array.isArray(globalPatientsList) ? [...globalPatientsList, ...localList] : localList);
        }

        async function fetchLivePatients() {
            try {
                const response = await fetch('api.php?action=get_patients');
                const res = await response.json();
                if (res.success && res.patients && res.patients.length > 0) {
                    let localList = [];
                    try {
                        const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                        if (raw) localList = JSON.parse(raw) || [];
                    } catch(e){}
                    globalPatientsList = mergePatients(res.patients, localList);
                    savePatients(globalPatientsList);
                    renderAllPatients();
                    updateTableStats();
                    return;
                }
            } catch(e) {
                console.warn('Database fetch fallback:', e);
            }
            try {
                let raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                if (raw) globalPatientsList = JSON.parse(raw);
            } catch(e){}
            renderAllPatients();
            updateTableStats();
        }

        function savePatients(patients) {
            globalPatientsList = patients;
            try {
                localStorage.setItem(PATIENTS_STORAGE_KEY, JSON.stringify(patients));
            } catch(e){}
        }

        function generatePatientId() {
            return `P${Date.now().toString().slice(-6)}`;
        }

        // Modal Open-Close Actions
        function openModal() {
            document.getElementById('addPatientModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addPatientModal').style.display = 'none';
            document.getElementById('addPatientForm').reset();
            currentEditId = null;
            toggleInputs(false);
            document.getElementById('modalTitle').textContent = "Add New Patient Profile";
            const btnSave = document.getElementById('btnSave');
            btnSave.style.display = 'block';
            btnSave.textContent = "Save Patient";
        }

        function toggleInputs(disabled) {
            document.getElementById('patId').disabled = disabled;
            document.getElementById('patName').disabled = disabled;
            document.getElementById('patAge').disabled = disabled;
            document.getElementById('patGender').disabled = disabled;
            document.getElementById('patDisease').disabled = disabled;
            document.getElementById('patContact').disabled = disabled;
            document.getElementById('patStatus').disabled = disabled;
        }

        function viewPatient(id) {
            const patients = getStoredPatients();
            const patient = patients.find(p => (p.id === id || p.patient_id === id));
            if (!patient) return;

            const patIdentifier = patient.patient_id || patient.id || id;
            try {
                sessionStorage.setItem('medigoCurrentPatientId', patIdentifier);
                sessionStorage.setItem('medigoCurrentPatientName', patient.name || '');
            } catch(e){}
            window.location.href = `Add_patient.php?id=${encodeURIComponent(patIdentifier)}&mode=view`;
        }

        function editPatient(id) {
            const patients = getStoredPatients();
            const patient = patients.find(p => (p.id === id || p.patient_id === id));
            if (!patient) return;

            currentEditId = id;
            document.getElementById('modalTitle').textContent = "Edit Patient Profile";
            document.getElementById('patId').value = patient.patient_id || patient.id || '';
            document.getElementById('patName').value = patient.name || '';
            document.getElementById('patAge').value = patient.age || '';
            document.getElementById('patGender').value = patient.gender || 'Male';
            document.getElementById('patDisease').value = patient.disease || '';
            document.getElementById('patContact').value = patient.phone || '';
            document.getElementById('patStatus').value = patient.status || 'Treatment';

            toggleInputs(false);
            document.getElementById('patId').disabled = true;

            const btnSave = document.getElementById('btnSave');
            btnSave.style.display = 'block';
            btnSave.textContent = "Save Changes";
            openModal();
        }

        function renderPatientRow(patient) {
            const tr = document.createElement('tr');
            const statusClass = (patient.status || 'treatment').toLowerCase();
            const patientId = patient.patient_id || patient.id || ('PAT-' + (patient.db_id || '1001'));
            const safeName = (patient.name || 'Patient').replace(/'/g, "\\'");

            tr.innerHTML = `
                <td class="td-id">${patientId}</td>
                <td>
                    <div class="td-patient" style="cursor: pointer;" onclick="try{sessionStorage.setItem('medigoCurrentPatientId', '${patientId}'); sessionStorage.setItem('medigoCurrentPatientName', '${safeName}');}catch(e){} window.location.href='Add_patient.php?id=${encodeURIComponent(patientId)}&mode=view'">
                        <div class="patient-details">
                            <h4 style="color: var(--primary); text-decoration: none;">${patient.name}</h4>
                        </div>
                    </div>
                </td>
                <td>${patient.age || '--'} / ${patient.gender || '--'}</td>
                <td>${patient.disease || 'General'}</td>
                <td>${patient.phone || '--'}</td>
                <td><span class="status-pill ${statusClass}">${patient.status || 'Treatment'}</span></td>
                <td>
                    <div class="action-btns">
                        <button class="btn-action view" title="View Patient Profile" onclick="try{sessionStorage.setItem('medigoCurrentPatientId', '${patientId}'); sessionStorage.setItem('medigoCurrentPatientName', '${safeName}');}catch(e){} window.location.href='Add_patient.php?id=${encodeURIComponent(patientId)}&mode=view'"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn-action edit" title="Edit Info" onclick="try{sessionStorage.setItem('medigoCurrentPatientId', '${patientId}'); sessionStorage.setItem('medigoCurrentPatientName', '${safeName}');}catch(e){} window.location.href='Add_patient.php?id=${encodeURIComponent(patientId)}&mode=edit'"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn-action delete" title="Archive / Delete" onclick="deleteRow(this)"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </td>
            `;

            return tr;
        }

        function renderAllPatients() {
            const tbody = document.getElementById('patientTableBody');
            tbody.innerHTML = '';
            const patients = getStoredPatients();
            
            if (patients.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <i class="fa-solid fa-user-slash" style="font-size: 2.2rem; margin-bottom: 12px; display: block; opacity: 0.4;"></i>
                            <div style="font-size: 1rem; font-weight: 700; color: var(--text-main);">No Patients Found</div>
                            <p style="font-size: 0.85rem; margin-top: 4px;">Click "+ Add New Patient" to register a patient.</p>
                        </td>
                    </tr>
                `;
            } else {
                patients.forEach(patient => {
                    tbody.appendChild(renderPatientRow(patient));
                });
            }
        }

        function loadStoredPatients() {
            renderAllPatients();
        }

        // Save New Patient Dynamics
        async function savePatient(event) {
            event.preventDefault();

            const patName = document.getElementById('patName').value.trim();
            const patAge = document.getElementById('patAge').value.trim();
            const patGender = document.getElementById('patGender').value;
            const patDisease = document.getElementById('patDisease').value.trim();
            const patContact = document.getElementById('patContact').value.trim();
            const patStatus = document.getElementById('patStatus').value;

            let patients = getStoredPatients();

            if (currentEditId) {
                patients = patients.map(p => {
                    if (p.id === currentEditId || p.patient_id === currentEditId) {
                        return {
                            ...p,
                            name: patName,
                            age: patAge,
                            gender: patGender,
                            disease: patDisease,
                            phone: patContact,
                            status: patStatus
                        };
                    }
                    return p;
                });
                savePatients(patients);

                try {
                    const fd = new FormData();
                    fd.append('action', 'update_patient');
                    fd.append('id', currentEditId);
                    fd.append('name', patName);
                    fd.append('age', patAge);
                    fd.append('gender', patGender);
                    fd.append('disease', patDisease);
                    fd.append('phone', patContact);
                    fd.append('status', patStatus);
                    await fetch('api.php', { method: 'POST', body: fd });
                } catch(e){}

                currentEditId = null;
            } else {
                const patIdField = document.getElementById('patId').value.trim();
                const patId = patIdField || generatePatientId();
                const activeDoctorName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';

                const newPatient = {
                    id: patId,
                    patient_id: patId,
                    name: patName,
                    age: patAge,
                    gender: patGender,
                    disease: patDisease,
                    phone: patContact,
                    status: patStatus,
                    doctor: activeDoctorName,
                    doctor_assigned: activeDoctorName,
                    createdAt: new Date().toISOString()
                };

                patients.unshift(newPatient);
                savePatients(patients);

                try {
                    const fd = new FormData();
                    fd.append('action', 'add_patient');
                    fd.append('id', patId);
                    fd.append('name', patName);
                    fd.append('age', patAge);
                    fd.append('gender', patGender);
                    fd.append('disease', patDisease);
                    fd.append('phone', patContact);
                    fd.append('status', patStatus);
                    fd.append('doctor_assigned', activeDoctorName);
                    await fetch('api.php', { method: 'POST', body: fd });
                } catch(e){}
            }

            renderAllPatients();
            closeModal();
            updateTableStats();
        }

        // Delete Row Operation
        async function deleteRow(btn) {
            if (confirm("Are you sure you want to delete this patient profile from Database?")) {
                const row = btn.closest('tr');
                const patientId = row.querySelector('.td-id').textContent.trim();
                row.remove();

                const patients = getStoredPatients().filter(patient => (patient.id !== patientId && patient.patient_id !== patientId));
                savePatients(patients);
                updateTableStats();

                try {
                    const formData = new FormData();
                    formData.append('action', 'delete_patient');
                    formData.append('id', patientId);
                    await fetch('api.php', { method: 'POST', body: formData });
                } catch(err) {
                    console.warn('Database delete warning:', err);
                }
            }
        }

        // Table Data Search & Filter Logic
        function filterPatients() {
            const searchVal = document.getElementById('searchInput').value.toLowerCase();
            const statusVal = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#patientTableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const idEl = row.querySelector('.td-id');
                if (!idEl) return;
                const idText = idEl.textContent.toLowerCase();
                const nameText = (row.querySelector('.patient-details h4') || {}).textContent?.toLowerCase() || '';
                const diseaseText = row.cells[3]?.textContent?.toLowerCase() || '';
                const statusText = (row.querySelector('.status-pill') || {}).textContent || '';

                const matchesSearch = idText.includes(searchVal) || nameText.includes(searchVal) || diseaseText.includes(searchVal);
                const matchesStatus = (statusVal === 'All') || (statusText === statusVal);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('displayed-count').textContent = visibleCount;
        }

        // Dynamic Calculations for Dashboard Mini Stats Card
        function updateTableStats() {
            const rows = document.querySelectorAll('#patientTableBody tr');
            let total = 0;
            let treatment = 0;
            let improving = 0;
            let critical = 0;

            rows.forEach(row => {
                if (row.style.display === 'none' || !row.querySelector('.status-pill')) return;
                total++;
                const status = row.querySelector('.status-pill').textContent.trim();
                if (status === 'Treatment') treatment++;
                if (status === 'Improving') improving++;
                if (status === 'Critical') critical++;
            });

            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-treatment').textContent = treatment;
            document.getElementById('stat-improving').textContent = improving;
            document.getElementById('stat-critical').textContent = critical;

            document.getElementById('displayed-count').textContent = total;
            document.getElementById('total-count').textContent = total;
        }

        // Initial Stats trigger on Page Load
        document.addEventListener('DOMContentLoaded', () => {
            renderAllPatients();
            updateTableStats();
            fetchLivePatients();
        });
    </script>
</body>

</html>
