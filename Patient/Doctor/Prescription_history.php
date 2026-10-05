<?php
require_once 'db_connect.php';

$server_prescriptions = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `prescriptions` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_prescriptions[] = [
                'id' => $r['prescription_id'] ?: ('RX-' . $r['id']),
                'prescription_id' => $r['prescription_id'] ?: ('RX-' . $r['id']),
                'patient_id' => $r['patient_id'] ?? 'PAT-1001',
                'patient_name' => $r['patient_name'] ?? 'Patient',
                'age' => $r['patient_age'] ?? '40',
                'gender' => $r['patient_gender'] ?? 'Male',
                'doctor_name' => $r['doctor_name'] ?? ($current_doc_name ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'),
                'diagnosis' => $r['diagnosis'] ?? 'Clinical Diagnosis',
                'medicines' => $r['medicines'] ?? '',
                'instructions' => $r['instructions'] ?? 'Follow dosage schedule.',
                'date' => $r['prescription_date'] ?? date('Y-m-d'),
                'status' => $r['status'] ?? 'Active'
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
    <title>Medi Go - Prescription History & Clinical Archive</title>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    
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
            padding-bottom: 50px;
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
            padding: 8px 14px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .nav-item:hover>a,
        .nav-item.active>a {
            color: white;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 220px;
            display: none;
            flex-direction: column;
            padding: 8px 0;
            z-index: 100;
            border: 1px solid var(--border-color);
        }

        .nav-item:hover .dropdown {
            display: flex;
        }

        .dropdown li {
            list-style: none;
        }

        .dropdown a {
            color: var(--text-main);
            padding: 10px 18px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .dropdown a:hover {
            background-color: var(--bg-color);
            color: var(--primary);
            padding-left: 22px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .user-info .name {
            font-size: 0.9rem;
            font-weight: 700;
            color: white;
        }

        .user-info .spec {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.75);
        }

        /* 2. Main Content */
        .wrapper {
            max-width: 1440px;
            margin: 28px auto;
            padding: 0 24px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.25);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-color);
        }

        /* 3. Stat KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
        }

        .kpi-info h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .kpi-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        .kpi-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .kpi-icon.blue { background: var(--info-light); color: var(--primary); }
        .kpi-icon.green { background: var(--success-light); color: var(--success); }
        .kpi-icon.amber { background: var(--warning-light); color: var(--warning); }
        .kpi-icon.purple { background: #f3e8ff; color: #7e22ce; }

        /* 4. Filter Bar */
        .filter-bar {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 14px;
            flex: 1;
            min-width: 260px;
        }

        .search-box input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .filter-group {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            outline: none;
            background: white;
            color: var(--text-main);
            cursor: pointer;
        }

        /* 5. Data Table */
        .table-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            padding: 14px 18px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.88rem;
            vertical-align: middle;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .rx-badge {
            background: #eff6ff;
            color: var(--primary);
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.82rem;
            border: 1px solid #bfdbfe;
            display: inline-block;
        }

        .patient-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #084382;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
        }

        .diagnosis-tag {
            background: #f1f5f9;
            color: #334155;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill.active { background: var(--success-light); color: var(--success); }
        .status-pill.completed { background: var(--info-light); color: var(--primary); }
        .status-pill.expired { background: #f1f5f9; color: var(--text-muted); }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* 6. Rx Details Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-card {
            background: white;
            border-radius: 14px;
            max-width: 680px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 32px;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <!-- 1. Master Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="doctor_dashboard.php" class="brand">
                <i class="fa-solid fa-square-h"></i> Medi Go
            </a>
            <ul class="nav-menu">
                <li class="nav-item">
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
                <li class="nav-item active">
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

    <!-- 2. Workspace Body -->
    <div class="wrapper">
        <div class="page-header">
            <div class="header-title">
                <h1><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Prescription History & Archives</h1>
                <p>Complete clinical log of issued digital prescriptions, refills, and medication chronologies</p>
            </div>
            <div>
                <a href="Add_prescription.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Prescription</a>
            </div>
        </div>

        <!-- Stat KPIs -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statTotal"><?php echo count($server_prescriptions); ?></h3>
                    <p>Total Prescriptions Issued</p>
                </div>
                <div class="kpi-icon blue"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statActive"><?php echo count(array_filter($server_prescriptions, fn($r) => strtolower($r['status'] ?? '') === 'active')); ?></h3>
                    <p>Active Therapies</p>
                </div>
                <div class="kpi-icon green"><i class="fa-solid fa-heart-pulse"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statPatients"><?php echo count(array_unique(array_column($server_prescriptions, 'patient_id'))); ?></h3>
                    <p>Unique Patients Treated</p>
                </div>
                <div class="kpi-icon purple"><i class="fa-solid fa-user-injured"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statRefills">4</h3>
                    <p>Monthly Refill Renewals</p>
                </div>
                <div class="kpi-icon amber"><i class="fa-solid fa-arrows-rotate"></i></div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" id="searchInput" placeholder="Search by patient, ID, Rx number, medicine..." onkeyup="filterHistory()">
            </div>
            <div class="filter-group">
                <select id="statusFilter" class="filter-select" onchange="filterHistory()">
                    <option value="All">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Completed">Completed</option>
                    <option value="Expired">Expired</option>
                </select>
                <select id="periodFilter" class="filter-select" onchange="filterHistory()">
                    <option value="All">All Time</option>
                    <option value="Today">Today</option>
                    <option value="This Month">This Month</option>
                </select>
                <button type="button" class="btn btn-secondary" style="padding: 8px 14px;" onclick="exportCSV()"><i class="fa-solid fa-file-excel"></i> Export</button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Rx ID</th>
                            <th>Patient Information</th>
                            <th>Clinical Diagnosis</th>
                            <th>Prescribed Medication</th>
                            <th>Date Issued</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <?php if (empty($server_prescriptions)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No prescription history recorded yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($server_prescriptions as $rx): ?>
                                <tr data-rx='<?php echo htmlspecialchars(json_encode($rx), ENT_QUOTES, 'UTF-8'); ?>'>
                                    <td><span class="rx-badge"><?php echo htmlspecialchars($rx['id']); ?></span></td>
                                    <td>
                                        <div class="patient-cell">
                                            <div class="patient-avatar"><?php echo strtoupper(substr($rx['patient_name'], 0, 2)); ?></div>
                                            <div>
                                                <strong style="color: var(--text-main); font-size: 0.92rem;"><?php echo htmlspecialchars($rx['patient_name']); ?></strong>
                                                <div style="font-size: 0.78rem; color: var(--text-muted);"><?php echo htmlspecialchars($rx['patient_id']); ?> • <?php echo htmlspecialchars($rx['age']); ?> Yrs (<?php echo htmlspecialchars($rx['gender']); ?>)</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="diagnosis-tag"><?php echo htmlspecialchars($rx['diagnosis']); ?></span></td>
                                    <td style="max-width: 280px; font-size: 0.84rem; color: #334155;"><?php echo htmlspecialchars($rx['medicines']); ?></td>
                                    <td><strong><?php echo date('d M Y', strtotime($rx['date'])); ?></strong></td>
                                    <td>
                                        <span class="status-pill <?php echo strtolower($rx['status']) === 'active' ? 'active' : 'completed'; ?>">
                                            <i class="fa-solid fa-circle" style="font-size: 0.45rem;"></i> <?php echo htmlspecialchars($rx['status']); ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="action-btns" style="justify-content: flex-end;">
                                            <button type="button" class="btn-action" title="View Full Rx Pad" onclick="viewRxModal(this)"><i class="fa-solid fa-eye"></i></button>
                                            <button type="button" class="btn-action" title="Print Prescription" onclick="printSingleRx(this)"><i class="fa-solid fa-print"></i></button>
                                            <a href="Add_prescription.php?repeat=<?php echo urlencode($rx['id']); ?>" class="btn-action" title="Repeat / Refill"><i class="fa-solid fa-repeat"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Full Rx Pad Modal -->
    <div class="modal-overlay" id="rxModal">
        <div class="modal-card">
            <button class="modal-close" onclick="closeRxModal()"><i class="fa-solid fa-xmark"></i></button>
            <div id="modalPadContent">
                <!-- Injected via JavaScript -->
            </div>
            <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn btn-secondary" onclick="closeRxModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Prescription</button>
            </div>
        </div>
    </div>

    <!-- Script Logic -->
    <script>
        const serverPrescriptions = <?php echo json_encode($server_prescriptions ?? []); ?>;

        function filterHistory() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#historyTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowData = row.getAttribute('data-rx') ? JSON.parse(row.getAttribute('data-rx')) : null;
                const status = rowData ? (rowData.status || '').toLowerCase() : '';

                const matchesQuery = text.includes(query);
                const matchesStatus = (statusFilter === 'all' || status === statusFilter);

                if (matchesQuery && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function viewRxModal(btn) {
            const tr = btn.closest('tr');
            const data = JSON.parse(tr.getAttribute('data-rx'));
            
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : data.doctor_name || 'Dr. PRAJAPATI SMIT MANOJKUMAR';

            const modalHtml = `
                <div style="border-bottom: 2px solid #084382; padding-bottom: 14px; margin-bottom: 18px; display: flex; justify-content: space-between;">
                    <div>
                        <h3 style="color: #084382; font-weight: 800; font-size: 1.3rem;"><i class="fa-solid fa-square-h"></i> MEDI GO HOSPITAL</h3>
                        <p style="font-size: 0.8rem; color: #64748b;">Multi-Specialty Healthcare & Research Institute • Ahmedabad</p>
                    </div>
                    <div style="text-align: right;">
                        <h4 style="font-weight: 800;">${docName}</h4>
                        <p style="font-size: 0.8rem; color: #64748b;">Cardiology Specialist • Reg: MCI-88421-GUJ</p>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px 16px; display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 16px;">
                    <div><strong>Patient:</strong> ${data.patient_name} (${data.patient_id})</div>
                    <div><strong>Age/Sex:</strong> ${data.age} / ${data.gender}</div>
                    <div><strong>Date:</strong> ${data.date}</div>
                </div>

                <div style="margin-bottom: 12px;">
                    <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Diagnosis:</span>
                    <h4 style="font-size: 0.95rem; color: #084382;">${data.diagnosis}</h4>
                </div>

                <div style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #084382; font-style: italic; margin-bottom: 10px;">&#8478;</div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; min-height: 120px; font-size: 0.9rem; line-height: 1.6;">
                    ${data.medicines.split(',').map((m, i) => `<div style="padding: 6px 0; border-bottom: 1px dashed #e2e8f0;"><strong>${i+1}.</strong> ${m.trim()}</div>`).join('')}
                </div>

                <div style="background: #f8fafc; border-radius: 8px; padding: 12px; margin-top: 14px; font-size: 0.82rem;">
                    <strong>Instructions:</strong> ${data.instructions || 'Take medications strictly as advised.'}
                </div>

                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
                    <div style="font-size: 0.72rem; color: #94a3b8;">
                        <i class="fa-solid fa-shield-halved"></i> Digitally Signed Prescription<br>
                        Ref: ${data.id}
                    </div>
                    <div style="text-align: center;">
                        <div style="font-family: 'Brush Script MT', cursive; font-size: 1.5rem; color: #084382;">${docName}</div>
                        <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; border-top: 1px solid #94a3b8; padding-top: 4px;">Authorized Medical Specialist</p>
                    </div>
                </div>
            `;

            document.getElementById('modalPadContent').innerHTML = modalHtml;
            document.getElementById('rxModal').style.display = 'flex';
        }

        function closeRxModal() {
            document.getElementById('rxModal').style.display = 'none';
        }

        function printSingleRx(btn) {
            viewRxModal(btn);
            setTimeout(() => {
                window.print();
            }, 300);
        }

        function exportCSV() {
            let csv = 'Rx ID,Patient Name,Patient ID,Age,Gender,Diagnosis,Medicines,Date,Status\n';
            serverPrescriptions.forEach(r => {
                csv += `"${r.id}","${r.patient_name}","${r.patient_id}","${r.age}","${r.gender}","${r.diagnosis}","${r.medicines}","${r.date}","${r.status}"\n`;
            });
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('href', url);
            a.setAttribute('download', 'medigo_prescriptions_history.csv');
            a.click();
        }
    </script>
</body>
</html>
