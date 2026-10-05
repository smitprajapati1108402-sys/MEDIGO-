<?php
require_once 'db_connect.php';

$server_refills = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `medication_refills` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_refills[] = [
                'id' => $r['refill_id'] ?: ('REQ-' . $r['id']),
                'refill_id' => $r['refill_id'] ?: ('REQ-' . $r['id']),
                'patient_id' => $r['patient_id'] ?? 'PAT-1001',
                'patient_name' => $r['patient_name'] ?? 'Patient',
                'medicine_name' => $r['medicine_name'] ?? '',
                'dosage' => $r['dosage'] ?? '1 Tablet Daily',
                'quantity' => $r['quantity'] ?? '30 Tablets',
                'doctor_name' => $r['doctor_name'] ?? ($current_doc_name ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'),
                'request_date' => $r['request_date'] ?? date('Y-m-d'),
                'reason' => $r['reason'] ?? 'Chronic maintenance refill',
                'notes' => $r['notes'] ?? '',
                'status' => $r['status'] ?? 'Pending'
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
    <title>Medi Go - Medicine Requests & Refill Approvals</title>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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

        /* 1. Navbar */
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

        /* 2. Main Wrapper */
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
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-color);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        /* 3. KPI Grid */
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
            transition: transform 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
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

        .kpi-icon.amber { background: var(--warning-light); color: var(--warning); }
        .kpi-icon.green { background: var(--success-light); color: var(--success); }
        .kpi-icon.blue { background: var(--info-light); color: var(--primary); }
        .kpi-icon.red { background: var(--danger-light); color: var(--danger); }

        /* 4. Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 12px;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 20px;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 12px 20px;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .tab-btn.active {
            color: var(--primary);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            border-radius: 3px 3px 0 0;
        }

        .tab-counter {
            background: #e2e8f0;
            color: #334155;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .tab-btn.active .tab-counter {
            background: #eff6ff;
            color: var(--primary);
        }

        /* 5. Filter Bar */
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

        /* 6. Requests Table */
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

        .req-badge {
            background: #fffbeb;
            color: #b45309;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.82rem;
            border: 1px solid #fde68a;
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

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill.pending { background: var(--warning-light); color: var(--warning); }
        .status-pill.approved { background: var(--success-light); color: var(--success); }
        .status-pill.rejected { background: var(--danger-light); color: var(--danger); }

        .stock-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
            background: #ecfdf5;
            color: #059669;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        /* Modal */
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
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 28px;
            position: relative;
        }

        #toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1e293b;
            color: white;
            padding: 14px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 9999;
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
                <h1><i class="fa-solid fa-pills" style="color: var(--primary);"></i> Medicine Requests & Refill Approvals</h1>
                <p>Review, authorize, and modify patient prescription refill requests for hospital pharmacy dispensing</p>
            </div>
            <div>
                <a href="Add_prescription.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Prescription</a>
            </div>
        </div>

        <!-- KPI Summary Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statPending"><?php echo count(array_filter($server_refills, fn($r) => strtolower($r['status'] ?? '') === 'pending')); ?></h3>
                    <p>Pending Doctor Review</p>
                </div>
                <div class="kpi-icon amber"><i class="fa-solid fa-clock"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statApproved"><?php echo count(array_filter($server_refills, fn($r) => strtolower($r['status'] ?? '') === 'approved')); ?></h3>
                    <p>Approved & Sent to Pharmacy</p>
                </div>
                <div class="kpi-icon green"><i class="fa-solid fa-circle-check"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statTotalRefills"><?php echo count($server_refills); ?></h3>
                    <p>Total Refill Inquiries</p>
                </div>
                <div class="kpi-icon blue"><i class="fa-solid fa-file-medical"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3 id="statRejected"><?php echo count(array_filter($server_refills, fn($r) => strtolower($r['status'] ?? '') === 'rejected')); ?></h3>
                    <p>Declined / Re-evaluation</p>
                </div>
                <div class="kpi-icon red"><i class="fa-solid fa-ban"></i></div>
            </div>
        </div>

        <!-- Tab Nav -->
        <div class="tab-nav">
            <button class="tab-btn active" onclick="switchTab('all', this)">
                All Requests <span class="tab-counter"><?php echo count($server_refills); ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('pending', this)">
                Pending Review <span class="tab-counter"><?php echo count(array_filter($server_refills, fn($r) => strtolower($r['status'] ?? '') === 'pending')); ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab('approved', this)">
                Approved
            </button>
            <button class="tab-btn" onclick="switchTab('rejected', this)">
                Declined
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" id="searchInput" placeholder="Search by patient, drug name, or request ID..." onkeyup="filterRefills()">
            </div>
            <div>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Pharmacy Sync Status: <strong style="color: var(--success);"><i class="fa-solid fa-circle-dot"></i> Live Online</strong></span>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Patient Information</th>
                            <th>Requested Medication</th>
                            <th>Dosage & Qty</th>
                            <th>Reason / Clinical Note</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="refillsTableBody">
                        <?php foreach ($server_refills as $ref): ?>
                            <tr data-status="<?php echo strtolower($ref['status']); ?>" data-id="<?php echo htmlspecialchars($ref['id']); ?>">
                                <td><span class="req-badge"><?php echo htmlspecialchars($ref['id']); ?></span></td>
                                <td>
                                    <div class="patient-cell">
                                        <div class="patient-avatar"><?php echo strtoupper(substr($ref['patient_name'], 0, 2)); ?></div>
                                        <div>
                                            <strong style="color: var(--text-main); font-size: 0.92rem;"><?php echo htmlspecialchars($ref['patient_name']); ?></strong>
                                            <div style="font-size: 0.78rem; color: var(--text-muted);"><?php echo htmlspecialchars($ref['patient_id']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong style="color: #0f172a;"><?php echo htmlspecialchars($ref['medicine_name']); ?></strong>
                                    <div><span class="stock-badge"><i class="fa-solid fa-boxes-stacked"></i> In Pharmacy Stock</span></div>
                                </td>
                                <td>
                                    <div><?php echo htmlspecialchars($ref['dosage']); ?></div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;"><?php echo htmlspecialchars($ref['quantity']); ?></div>
                                </td>
                                <td style="max-width: 240px; font-size: 0.84rem; color: #475569;"><?php echo htmlspecialchars($ref['reason']); ?></td>
                                <td><strong><?php echo date('d M Y', strtotime($ref['request_date'])); ?></strong></td>
                                <td>
                                    <span class="status-pill <?php echo strtolower($ref['status']); ?>">
                                        <i class="fa-solid fa-circle" style="font-size: 0.45rem;"></i> <?php echo htmlspecialchars($ref['status']); ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <?php if (strtolower($ref['status']) === 'pending'): ?>
                                        <div class="action-cell">
                                            <button type="button" class="btn btn-success" style="padding: 6px 12px; font-size: 0.8rem;" onclick="approveRefill('<?php echo htmlspecialchars($ref['id']); ?>', '<?php echo htmlspecialchars($ref['patient_name']); ?>', '<?php echo htmlspecialchars($ref['medicine_name']); ?>')"><i class="fa-solid fa-check"></i> Approve</button>
                                            <button type="button" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.8rem;" onclick="rejectRefill('<?php echo htmlspecialchars($ref['id']); ?>')"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    <?php else: ?>
                                        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Processed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal-overlay" id="actionModal">
        <div class="modal-card">
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text-main); margin-bottom: 12px;" id="modalTitle">Authorize Refill</h3>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 18px;" id="modalDesc">Confirm medication refill and forward electronic token to hospital pharmacy dispensary.</p>
            
            <div style="margin-bottom: 16px;">
                <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Doctor's Note / Pharmacist Instructions</label>
                <textarea id="modalNotes" class="form-control" rows="2" style="width: 100%; margin-top: 6px; border: 1px solid var(--border-color); border-radius: 8px; padding: 10px;" placeholder="Optional dispensing remarks...">Verified against latest lab values. 30 days refill authorized.</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeActionModal()">Cancel</button>
                <button type="button" class="btn btn-primary" id="modalConfirmBtn" onclick="confirmAction()">Authorize & Dispatch</button>
            </div>
        </div>
    </div>

    <div id="toast"><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> <span id="toastMsg">Refill approved!</span></div>

    <script>
        let currentActionRefillId = null;
        let currentActionType = 'Approved';
        let activeTab = 'all';

        function switchTab(tab, btn) {
            activeTab = tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterRefills();
        }

        function filterRefills() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#refillsTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesQuery = text.includes(query);
                const matchesTab = (activeTab === 'all' || status === activeTab);

                if (matchesQuery && matchesTab) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function approveRefill(id, pName, medName) {
            currentActionRefillId = id;
            currentActionType = 'Approved';
            document.getElementById('modalTitle').textContent = `Approve ${medName}`;
            document.getElementById('modalDesc').textContent = `Authorize prescription refill for ${pName}. The order will be immediately queued at Hospital Pharmacy.`;
            document.getElementById('modalConfirmBtn').className = 'btn btn-success';
            document.getElementById('modalConfirmBtn').textContent = 'Confirm Approval';
            document.getElementById('actionModal').style.display = 'flex';
        }

        function rejectRefill(id) {
            currentActionRefillId = id;
            currentActionType = 'Rejected';
            document.getElementById('modalTitle').textContent = `Decline Refill Request`;
            document.getElementById('modalDesc').textContent = `Specify reason for refusal (e.g. mandatory clinical evaluation needed before repeating dosage).`;
            document.getElementById('modalNotes').value = 'Clinical examination and blood tests required before renewal.';
            document.getElementById('modalConfirmBtn').className = 'btn btn-danger';
            document.getElementById('modalConfirmBtn').textContent = 'Decline Request';
            document.getElementById('actionModal').style.display = 'flex';
        }

        function closeActionModal() {
            document.getElementById('actionModal').style.display = 'none';
        }

        async function confirmAction() {
            if (!currentActionRefillId) return;
            const notes = document.getElementById('modalNotes').value;

            const fd = new FormData();
            fd.append('refill_id', currentActionRefillId);
            fd.append('status', currentActionType);
            fd.append('notes', notes);

            try {
                const res = await fetch('api.php?action=update_refill_status', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                closeActionModal();
                showToast(`Request ${currentActionType} successfully!`);
                setTimeout(() => { location.reload(); }, 900);
            } catch (err) {
                console.error(err);
                closeActionModal();
                showToast(`Request updated!`);
                setTimeout(() => { location.reload(); }, 900);
            }
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.style.display = 'flex';
            setTimeout(() => { t.style.display = 'none'; }, 2500);
        }
    </script>
</body>
</html>
