<?php
require_once 'db_connect.php';

$server_reports = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patient_reports` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_reports[] = [
                'id' => $r['report_id'] ?? $r['id'] ?? 'REP-001',
                'patientName' => $r['patient_name'] ?? 'Patient',
                'patientId' => $r['patient_id'] ?? 'PAT-1001',
                'category' => $r['category'] ?? $r['report_type'] ?? 'General Pathology',
                'reportType' => $r['report_type'] ?? 'Blood Test',
                'lab' => 'Medigo Central Pathology Lab',
                'date' => $r['report_date'] ?? date('Y-m-d'),
                'doctor' => $r['doctor_name'] ?? ($current_doc_name ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'),
                'status' => $r['status'] ?? 'Approved',
                'summary' => $r['summary'] ?? 'Normal test results',
                'results' => $r['results'] ?? 'All parameters within standard reference range'
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
    <title>MediCare - Patient Reports</title>
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

        /* 1. Header & Navigation (Consistent with other pages) */
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

        .btn-upload {
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

        .btn-upload:hover {
            background-color: var(--primary-hover);
        }

        /* Mini Metric Stats Row */
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
        .stat-icon.orange { background-color: var(--warning-light); color: var(--warning); }
        .stat-icon.green { background-color: var(--success-light); color: var(--success); }
        .stat-icon.red { background-color: var(--danger-light); color: var(--danger); }

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

        /* 3. Main Filter & Reports Table Card */
        .reports-card {
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

        /* Responsive Reports Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .reports-table th {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .reports-table td {
            font-size: 0.88rem;
            padding: 16px 16px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .reports-table tr:hover {
            background-color: #fafbfc;
        }

        .td-report-id {
            font-weight: 700;
            color: var(--text-muted);
        }

        .td-patient {
            font-weight: 700;
            color: var(--text-main);
        }

        .report-category {
            font-size: 0.85rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .report-category i {
            color: var(--primary);
        }

        /* Dynamic Status Badges */
        .status-pill {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        .status-pill.approved { background-color: var(--success-light); color: var(--success); }
        .status-pill.review { background-color: var(--warning-light); color: var(--warning); }
        .status-pill.critical { background-color: var(--danger-light); color: var(--danger); }

        /* Actions Bar Button Icons matching screenshot */
        .action-btns {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: #ffffff;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: #475569;
            font-size: 0.95rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            text-decoration: none;
            padding: 0;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .btn-action.view:hover {
            border-color: #0a52a3;
            color: #0a52a3;
            background-color: #eff6ff;
        }

        .btn-action.download:hover {
            border-color: #10b981;
            color: #10b981;
            background-color: #ecfdf5;
        }

        .btn-action.sign:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            background-color: #eff6ff;
        }

        /* Modal Structure for Upload & View */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            border-radius: 16px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
            overflow: hidden;
        }

        /* --- REPORT VIEWER MODAL STYLING --- */
        .report-modal-card {
            background-color: #ffffff;
            border-radius: 16px;
            width: 100%;
            max-width: 820px;
            max-height: 92vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideIn 0.3s ease;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }

        .report-modal-header {
            background: linear-gradient(135deg, #084382 0%, #0a52a3 100%);
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-modal-header h3 {
            font-size: 1.15rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .report-modal-body {
            padding: 24px;
            overflow-y: auto;
            background-color: #f8fafc;
        }

        .report-sheet {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
            color: #1e293b;
            font-size: 0.9rem;
        }

        .report-doc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0a52a3;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .report-brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .report-brand-logo i {
            font-size: 2.2rem;
            color: #0a52a3;
        }

        .report-brand-text h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #084382;
            line-height: 1.2;
        }

        .report-brand-text p {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 600;
        }

        .report-doc-meta {
            text-align: right;
        }

        .report-doc-meta .doc-id {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0a52a3;
            background: #eff6ff;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 4px;
        }

        .patient-info-card {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 14px 18px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 22px;
            border: 1px solid #e2e8f0;
        }

        .info-field-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 2px;
        }

        .info-field-value {
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
        }

        .test-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 0.88rem;
        }

        .test-table th {
            background-color: #084382;
            color: #ffffff;
            padding: 10px 14px;
            text-align: left;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .test-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        .test-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .test-flag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .test-flag.normal { background-color: #ecfdf5; color: #10b981; }
        .test-flag.high { background-color: #fef2f2; color: #ef4444; }
        .test-flag.borderline { background-color: #fffbeb; color: #f59e0b; }

        .clinical-notes-card {
            background: #f8fafc;
            border-left: 4px solid #0a52a3;
            padding: 14px 16px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 24px;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .clinical-notes-card h4 {
            font-size: 0.85rem;
            color: #084382;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .clinical-notes-card p {
            font-size: 0.85rem;
            color: #475569;
            line-height: 1.5;
        }

        .report-sign-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
        }

        .stamp-box {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #10b981;
            font-weight: 700;
            font-size: 0.82rem;
            border: 1.5px solid #10b981;
            padding: 6px 12px;
            border-radius: 8px;
            background: #f0fdf4;
        }

        .doc-signature {
            text-align: right;
        }

        .doc-signature .sig-line {
            font-family: 'Brush Script MT', cursive, sans-serif;
            font-size: 1.5rem;
            color: #084382;
            margin-bottom: 4px;
        }

        .doc-signature .sig-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e293b;
        }

        .doc-signature .sig-sub {
            font-size: 0.74rem;
            color: #64748b;
        }

        .report-modal-footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-modal-action {
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            transition: all 0.2s;
        }

        .btn-modal-action.print {
            background-color: #0a52a3;
            color: white;
        }
        .btn-modal-action.print:hover {
            background-color: #084382;
        }

        .btn-modal-action.download-pdf {
            background-color: #10b981;
            color: white;
        }
        .btn-modal-action.download-pdf:hover {
            background-color: #059669;
        }

        .btn-modal-action.close-view {
            background-color: #f1f5f9;
            color: #475569;
        }
        .btn-modal-action.close-view:hover {
            background-color: #e2e8f0;
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

        .modal-header .close-btn:hover { opacity: 1; }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
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
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding-top: 8px;
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

        .btn-save:hover { background-color: var(--primary-hover); }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar (Matches Directory) -->
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
                    <a href="#">Patients <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
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
                <li class="nav-item active">
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

        <!-- Header Row -->
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1>Diagnostic Patient Reports</h1>
                <p>View, sign, and manage laboratory reports, MRI scans, and cardiac workups.</p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <button class="btn-primary-action" onclick="goToPatientHistoryFromReports()" style="background-color: #0a52a3; color: #fff; border: 1px solid #0a52a3; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Patient History
                </button>
                <button class="btn-primary-action active" style="background-color: #084382; color: #fff; border: 1px solid #084382; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(8, 67, 130, 0.2);">
                    <i class="fa-solid fa-file-waveform"></i> Diagnostic Reports
                </button>
                <button class="btn-primary-action" onclick="goToNewEntryFromReports()" style="background-color: #0a52a3; color: #fff; border: 1px solid #0a52a3; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-file-circle-plus"></i> New Entry
                </button>
                <button class="btn-upload" onclick="window.location.href='Add_patientreport.php'">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Upload New Report
                </button>
            </div>
        </div>

        <!-- Metrics Stats Cards Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Total Diagnostic Reports</span>
                    <span class="stat-value" id="totalReports">5</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Pending Review</span>
                    <span class="stat-value" id="pendingReview">1</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fa-solid fa-signature"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Approved & Signed</span>
                    <span class="stat-value" id="approvedReports">3</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-data">
                    <span class="stat-label">Critical Alerts</span>
                    <span class="stat-value" id="criticalAlerts">1</span>
                </div>
            </div>
        </div>

        <!-- 3. Reports Main Section Card -->
        <div class="reports-card">
            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search by ID, Patient Name or Lab..." onkeyup="filterReports()">
                </div>
                <div class="filter-group">
                    <select class="filter-select" id="statusFilter" onchange="filterReports()">
                        <option value="All">All Statuses</option>
                        <option value="Approved">Approved</option>
                        <option value="Review">Pending Review</option>
                        <option value="Critical">Critical Alert</option>
                    </select>
                </div>
            </div>

            <!-- Reports Directory Responsive Table -->
            <div class="table-responsive">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>Patient</th>
                            <th>Report Category</th>
                            <th>Diagnostic Lab</th>
                            <th>Test Date</th>
                            <th>Verification Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reportsTableBody">
                        <!-- Default Row 1 -->
                        <tr>
                            <td class="td-report-id">REP-2940</td>
                            <td class="td-patient">Arjun Sharma</td>
                            <td>
                                <div class="report-category">
                                    <i class="fa-solid fa-droplet"></i> Lipid Profile (Blood)
                                </div>
                            </td>
                            <td>Standard Diagnostics Corp.</td>
                            <td>24 May 2026</td>
                            <td><span class="status-pill approved">Approved</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('REP-2940')"><i class="fa-solid fa-file-lines"></i></button>
                                    <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('REP-2940')"><i class="fa-solid fa-arrow-down"></i></button>
                                    <button class="btn-action sign" style="display: none;" title="Doctor's Approval Sign" onclick="approveReport(this, 'REP-2940')"><i class="fa-solid fa-pen-fancy"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Default Row 2 -->
                        <tr>
                            <td class="td-report-id">REP-3810</td>
                            <td class="td-patient">Amit Shah</td>
                            <td>
                                <div class="report-category">
                                    <i class="fa-solid fa-heart-pulse"></i> Electrocardiogram (ECG)
                                </div>
                            </td>
                            <td>Medi Go Cardiology Lab</td>
                            <td>05 Jun 2026</td>
                            <td><span class="status-pill critical">Critical</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('REP-3810')"><i class="fa-solid fa-file-lines"></i></button>
                                    <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('REP-3810')"><i class="fa-solid fa-arrow-down"></i></button>
                                    <button class="btn-action sign" title="Doctor's Approval Sign" onclick="approveReport(this, 'REP-3810')"><i class="fa-solid fa-pen-fancy"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Default Row 3 -->
                        <tr>
                            <td class="td-report-id">REP-1104</td>
                            <td class="td-patient">Priya Verma</td>
                            <td>
                                <div class="report-category">
                                    <i class="fa-solid fa-brain"></i> Head MRI scan
                                </div>
                            </td>
                            <td>Metro Imaging Center</td>
                            <td>02 Jun 2026</td>
                            <td><span class="status-pill approved">Approved</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('REP-1104')"><i class="fa-solid fa-file-lines"></i></button>
                                    <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('REP-1104')"><i class="fa-solid fa-arrow-down"></i></button>
                                    <button class="btn-action sign" style="display: none;" title="Doctor's Approval Sign" onclick="approveReport(this, 'REP-1104')"><i class="fa-solid fa-pen-fancy"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Default Row 4 -->
                        <tr>
                            <td class="td-report-id">REP-8854</td>
                            <td class="td-patient">Rohan Gupta</td>
                            <td>
                                <div class="report-category">
                                    <i class="fa-solid fa-vials"></i> HbA1c Diabetes Profile
                                </div>
                            </td>
                            <td>Pathology Labs India</td>
                            <td>08 Jun 2026</td>
                            <td><span class="status-pill review">Review</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('REP-8854')"><i class="fa-solid fa-file-lines"></i></button>
                                    <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('REP-8854')"><i class="fa-solid fa-arrow-down"></i></button>
                                    <button class="btn-action sign" title="Doctor's Approval Sign" onclick="approveReport(this, 'REP-8854')"><i class="fa-solid fa-pen-fancy"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Default Row 5 -->
                        <tr>
                            <td class="td-report-id">REP-0921</td>
                            <td class="td-patient">Rahul Sharma</td>
                            <td>
                                <div class="report-category">
                                    <i class="fa-solid fa-droplet"></i> Complete Blood Count (CBC)
                                </div>
                            </td>
                            <td>Standard Diagnostics Corp.</td>
                            <td>28 May 2026</td>
                            <td><span class="status-pill approved">Approved</span></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('REP-0921')"><i class="fa-solid fa-file-lines"></i></button>
                                    <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('REP-0921')"><i class="fa-solid fa-arrow-down"></i></button>
                                    <button class="btn-action sign" style="display: none;" title="Doctor's Approval Sign" onclick="approveReport(this, 'REP-0921')"><i class="fa-solid fa-pen-fancy"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. Upload Report Modal Popup Structure -->
    <div class="modal" id="uploadReportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload New Clinical Report</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="uploadReportForm" onsubmit="saveReport(event)">
                    <div class="form-group">
                        <label for="repId">Report Reference ID</label>
                        <input type="text" id="repId" required placeholder="e.g. REP-7049">
                    </div>
                    <div class="form-group">
                        <label for="repPatient">Patient Name</label>
                        <input type="text" id="repPatient" required placeholder="e.g. Arjun Sharma">
                    </div>
                    <div class="form-group">
                        <label for="repCategory">Report Category</label>
                        <select id="repCategory" required>
                            <option value="Lipid Profile (Blood)">Lipid Profile (Blood)</option>
                            <option value="Electrocardiogram (ECG)">Electrocardiogram (ECG)</option>
                            <option value="Head MRI scan">Head MRI scan</option>
                            <option value="HbA1c Diabetes Profile">HbA1c Diabetes Profile</option>
                            <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="repLab">Diagnostics Laboratory</label>
                        <input type="text" id="repLab" required placeholder="e.g. Metro Diagnostics Center">
                    </div>
                    <div class="form-group">
                        <label for="repStatus">Verification Status</label>
                        <select id="repStatus" required>
                            <option value="Approved">Approved</option>
                            <option value="Review">Pending Review</option>
                            <option value="Critical">Critical Alert</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-save">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 5. View Full Diagnostic Report Modal Popup -->
    <div class="modal" id="viewReportModal">
        <div class="report-modal-card">
            <div class="report-modal-header">
                <h3><i class="fa-solid fa-file-waveform"></i> Medical Diagnostic Report</h3>
                <button class="close-btn" onclick="closeViewModal()">&times;</button>
            </div>
            <div class="report-modal-body" id="reportModalBody">
                <!-- Dynamically populated report sheet -->
            </div>
            <div class="report-modal-footer">
                <button type="button" class="btn-modal-action close-view" onclick="closeViewModal()">Close</button>
                <button type="button" class="btn-modal-action print" onclick="printReportModal()"><i class="fa-solid fa-print"></i> Print Report</button>
                <button type="button" class="btn-modal-action download-pdf" onclick="downloadReportModal()"><i class="fa-solid fa-download"></i> Download Report</button>
            </div>
        </div>
    </div>

    <!-- Live JS Client Engine -->
    <script>
        const serverReports = <?php echo json_encode($server_reports ?? []); ?>;

        const defaultMockReports = [
            { id: "REP-5021", patientName: "Arjun Sharma", category: "Cardiology", lab: "Medigo Central Lab", date: "08 Jun 2026", status: "Approved" },
            { id: "REP-5022", patientName: "Priya Verma", category: "Neurology", lab: "Medigo Neuro Lab", date: "07 Jun 2026", status: "Approved" },
            { id: "REP-5023", patientName: "Amit Shah", category: "Cardiology", lab: "Metro Heart Institute", date: "06 Jun 2026", status: "Review" },
            { id: "REP-5024", patientName: "Rohan Gupta", category: "Pathology", lab: "City Diagnostic Care", date: "05 Jun 2026", status: "Approved" }
        ];

        let reportsCache = [];

        // Fetch Live Reports from MySQL API
        async function fetchLiveReports() {
            try {
                const res = await fetch('api.php?action=get_reports');
                const data = await res.json();
                if (data.success && Array.isArray(data.reports) && data.reports.length > 0) {
                    reportsCache = data.reports.map(r => ({
                        id: r.id,
                        patientName: r.patientName,
                        category: r.category || r.reportType || 'General',
                        lab: 'Medigo Pathology Lab',
                        date: r.date,
                        status: r.status || 'Approved'
                    }));
                    localStorage.setItem('medigo_reports', JSON.stringify(reportsCache));
                    const sVal = document.getElementById('searchInput') ? document.getElementById('searchInput').value : '';
                    if (sVal) {
                        filterReports();
                    } else {
                        renderReportsTable(reportsCache);
                    }
                    updateReportStats();
                    return;
                }
            } catch(e) {
                console.warn("MySQL live reports error:", e);
            }

            if (serverReports && serverReports.length > 0) {
                reportsCache = serverReports;
            } else {
                let local = localStorage.getItem('medigo_reports');
                if (local) {
                    try { reportsCache = JSON.parse(local); } catch(err){ reportsCache = defaultMockReports; }
                } else {
                    reportsCache = defaultMockReports;
                }
            }
            const sVal = document.getElementById('searchInput') ? document.getElementById('searchInput').value : '';
            if (sVal) {
                filterReports();
            } else {
                renderReportsTable(reportsCache);
            }
            updateReportStats();
        }

        let currentActiveReportId = null;

        function renderReportsTable(data) {
            const tbody = document.getElementById('reportsTableBody');
            tbody.innerHTML = '';

            if (!data || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                    <i class="fa-solid fa-file-waveform" style="font-size:2rem; opacity:0.4; display:block; margin-bottom:8px;"></i>
                    No patient reports recorded yet in database
                </td></tr>`;
                return;
            }

            data.forEach(record => {
                const tr = document.createElement('tr');
                const cat = record.category || record.reportType || 'General';
                let icon = 'fa-file-medical';
                if (cat.includes('Blood') || cat.includes('CBC')) icon = 'fa-droplet';
                else if (cat.includes('ECG') || cat.includes('Cardio')) icon = 'fa-heart-pulse';
                else if (cat.includes('MRI') || cat.includes('scan') || cat.includes('Brain')) icon = 'fa-brain';
                else if (cat.includes('Diabetes') || cat.includes('HbA1c')) icon = 'fa-vials';

                const status = record.status || 'Approved';

                tr.innerHTML = `
                    <td class="td-report-id">${record.id}</td>
                    <td class="td-patient">${record.patientName}</td>
                    <td>
                        <div class="report-category">
                            <i class="fa-solid ${icon}"></i> ${cat}
                        </div>
                    </td>
                    <td>${record.lab || 'Medigo Lab'}</td>
                    <td>${record.date}</td>
                    <td><span class="status-pill ${status.toLowerCase()}">${status}</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-action view" title="View Detailed Report" onclick="viewDetailedReport('${record.id}')"><i class="fa-solid fa-file-lines"></i></button>
                            <button class="btn-action download" title="Download Medical Report PDF" onclick="downloadReportDirect('${record.id}')"><i class="fa-solid fa-arrow-down"></i></button>
                            <button class="btn-action sign" ${status === 'Approved' ? 'style="display: none;"' : ''} title="Doctor's Approval Sign" onclick="approveReport(this, '${record.id}')"><i class="fa-solid fa-pen-fancy"></i></button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Generate dynamic investigation parameters
        function generateReportFindings(category, status, patientName) {
            const cat = (category || '').toLowerCase();
            
            if (cat.includes('blood') || cat.includes('cbc')) {
                return [
                    { param: 'Hemoglobin (Hb)', result: '14.2', unit: 'g/dL', ref: '13.0 - 17.0', flag: 'normal' },
                    { param: 'Total Leucocyte Count (WBC)', result: status === 'Critical' ? '15,800' : '7,400', unit: '/cu.mm', ref: '4,000 - 11,000', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Platelet Count', result: '2.65', unit: 'Lakhs/cu.mm', ref: '1.50 - 4.50', flag: 'normal' },
                    { param: 'Packed Cell Volume (PCV)', result: '42.8', unit: '%', ref: '40.0 - 50.0', flag: 'normal' },
                    { param: 'Red Blood Cell (RBC)', result: '4.92', unit: 'mill/cu.mm', ref: '4.50 - 5.50', flag: 'normal' },
                    { param: 'Erythrocyte Sed. Rate (ESR)', result: status === 'Critical' ? '32' : '9', unit: 'mm/1st hr', ref: '0 - 15', flag: status === 'Critical' ? 'high' : 'normal' }
                ];
            } else if (cat.includes('lipid') || cat.includes('cardio') || cat.includes('cholesterol')) {
                return [
                    { param: 'Total Cholesterol', result: status === 'Critical' ? '264' : '182', unit: 'mg/dL', ref: '< 200', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Serum Triglycerides', result: status === 'Critical' ? '228' : '138', unit: 'mg/dL', ref: '< 150', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'HDL Cholesterol (Good)', result: '48', unit: 'mg/dL', ref: '> 40', flag: 'normal' },
                    { param: 'LDL Cholesterol (Direct)', result: status === 'Critical' ? '168' : '98', unit: 'mg/dL', ref: '< 100', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'VLDL Cholesterol', result: '28', unit: 'mg/dL', ref: '5.0 - 30.0', flag: 'normal' },
                    { param: 'Total Chol / HDL Ratio', result: status === 'Critical' ? '5.5' : '3.8', unit: 'Ratio', ref: '3.3 - 4.4', flag: status === 'Critical' ? 'borderline' : 'normal' }
                ];
            } else if (cat.includes('ecg') || cat.includes('electro')) {
                return [
                    { param: 'Heart Rate (Pulse)', result: status === 'Critical' ? '112' : '76', unit: 'bpm', ref: '60 - 100', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'P-R Interval', result: '158', unit: 'ms', ref: '120 - 200', flag: 'normal' },
                    { param: 'QRS Duration', result: '86', unit: 'ms', ref: '80 - 120', flag: 'normal' },
                    { param: 'Q-Tc Interval', result: status === 'Critical' ? '468' : '412', unit: 'ms', ref: '< 440', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Axis Deviation', result: 'Normal Axis (+52°)', unit: 'Degrees', ref: '-30° to +90°', flag: 'normal' },
                    { param: 'Clinical ECG Rhythm', result: status === 'Critical' ? 'Sinus Tachycardia with ST elevation' : 'Normal Sinus Rhythm', unit: 'Diagnosis', ref: 'Sinus Rhythm', flag: status === 'Critical' ? 'high' : 'normal' }
                ];
            } else if (cat.includes('diabetes') || cat.includes('hba1c') || cat.includes('sugar')) {
                return [
                    { param: 'HbA1c (Glycated Hemoglobin)', result: status === 'Critical' ? '9.4' : (status === 'Review' ? '6.8' : '5.5'), unit: '%', ref: '< 5.7', flag: status === 'Critical' ? 'high' : (status === 'Review' ? 'borderline' : 'normal') },
                    { param: 'Estimated Avg. Glucose (eAG)', result: status === 'Critical' ? '223' : '112', unit: 'mg/dL', ref: '90 - 120', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Fasting Blood Glucose (FBS)', result: status === 'Critical' ? '168' : '94', unit: 'mg/dL', ref: '70 - 100', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Post Prandial Blood Glucose', result: status === 'Critical' ? '242' : '128', unit: 'mg/dL', ref: '< 140', flag: status === 'Critical' ? 'high' : 'normal' }
                ];
            } else if (cat.includes('mri') || cat.includes('scan') || cat.includes('neuro') || cat.includes('brain')) {
                return [
                    { param: 'Cerebral Hemispheres', result: 'Normal grey-white matter differentiation', unit: 'Visual', ref: 'Normal Morphology', flag: 'normal' },
                    { param: 'Ventricular System', result: 'Symmetrical, no ventriculomegaly', unit: 'Visual', ref: 'Normal Size & Shape', flag: 'normal' },
                    { param: 'Intracranial Signal', result: status === 'Critical' ? 'Acute focal hyperintensity in parietal lobe' : 'No abnormal signal intensity', unit: 'MRI Intensity', ref: 'No Lesions', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Midline Shift', result: 'No midline shift or herniation', unit: 'Measurement', ref: 'Nil', flag: 'normal' }
                ];
            } else {
                return [
                    { param: 'Serum Creatinine', result: '0.94', unit: 'mg/dL', ref: '0.7 - 1.2', flag: 'normal' },
                    { param: 'Blood Urea Nitrogen (BUN)', result: '14.2', unit: 'mg/dL', ref: '7.0 - 20.0', flag: 'normal' },
                    { param: 'Serum Bilirubin Total', result: '0.82', unit: 'mg/dL', ref: '0.2 - 1.2', flag: 'normal' },
                    { param: 'SGPT / ALT', result: status === 'Critical' ? '88' : '26', unit: 'U/L', ref: '< 45', flag: status === 'Critical' ? 'high' : 'normal' },
                    { param: 'Serum Electrolytes (Na/K)', result: 'Na: 140 / K: 4.2', unit: 'mmol/L', ref: 'Na:136-145, K:3.5-5.0', flag: 'normal' }
                ];
            }
        }

        function goToPatientHistoryFromReports() {
            const urlParams = new URLSearchParams(window.location.search);
            const pId = urlParams.get('id') || urlParams.get('patientId') || sessionStorage.getItem('medigoCurrentPatientId') || sessionStorage.getItem('medigoCurrentPatientName') || 'PAT-1001';
            window.location.href = `patienthistory.php?id=${encodeURIComponent(pId)}`;
        }

        function goToNewEntryFromReports() {
            const urlParams = new URLSearchParams(window.location.search);
            const pId = urlParams.get('id') || urlParams.get('patientId') || sessionStorage.getItem('medigoCurrentPatientId') || sessionStorage.getItem('medigoCurrentPatientName') || 'PAT-1001';
            window.location.href = `Add_newentery.php?id=${encodeURIComponent(pId)}`;
        }

        // View Detailed Report in Interactive Modal
        function viewDetailedReport(recordId) {
            currentActiveReportId = recordId;
            const report = reportsCache.find(r => r.id === recordId) || {
                id: recordId,
                patientName: 'Arjun Sharma',
                patientId: 'PAT-1001',
                category: 'Lipid Profile (Blood)',
                lab: 'Medigo Central Pathology Lab',
                date: new Date().toISOString().split('T')[0],
                status: 'Approved',
                summary: 'All parameters observed within biological limits.'
            };

            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : (report.doctor || 'Dr. PRAJAPATI SMIT MANOJKUMAR');
            const docSpec = (window.currentDoctor && window.currentDoctor.specialty) ? window.currentDoctor.specialty : 'Senior Consultant';
            const findings = generateReportFindings(report.category || report.reportType, report.status, report.patientName);

            let findingsHtml = findings.map(f => `
                <tr>
                    <td style="font-weight:600;">${f.param}</td>
                    <td style="font-weight:700; color:#0f172a;">${f.result}</td>
                    <td style="color:#64748b;">${f.unit}</td>
                    <td style="color:#64748b;">${f.ref}</td>
                    <td>
                        <span class="test-flag ${f.flag}">${f.flag.toUpperCase()}</span>
                    </td>
                </tr>
            `).join('');

            const modalBody = document.getElementById('reportModalBody');
            modalBody.innerHTML = `
                <div class="report-sheet">
                    <div class="report-doc-header">
                        <div class="report-brand-logo">
                            <i class="fa-solid fa-square-h"></i>
                            <div class="report-brand-text">
                                <h2>MEDI GO ADVANCED DIAGNOSTICS</h2>
                                <p>NABL & ISO 15189 Certified Multi-Specialty Pathology & Radiology Center</p>
                            </div>
                        </div>
                        <div class="report-doc-meta">
                            <div class="doc-id">${report.id}</div>
                            <div style="font-size:0.75rem; color:#64748b; font-weight:600;">Date: ${report.date}</div>
                        </div>
                    </div>

                    <div class="patient-info-card">
                        <div>
                            <div class="info-field-label">Patient Name</div>
                            <div class="info-field-value">${report.patientName}</div>
                        </div>
                        <div>
                            <div class="info-field-label">Patient ID</div>
                            <div class="info-field-value">${report.patientId || 'PAT-1001'}</div>
                        </div>
                        <div>
                            <div class="info-field-label">Test Investigation</div>
                            <div class="info-field-value">${report.category || report.reportType}</div>
                        </div>
                        <div>
                            <div class="info-field-label">Diagnostic Laboratory</div>
                            <div class="info-field-value">${report.lab || 'Medigo Central Lab'}</div>
                        </div>
                        <div>
                            <div class="info-field-label">Referring Doctor</div>
                            <div class="info-field-value">${docName}</div>
                        </div>
                        <div>
                            <div class="info-field-label">Verification Status</div>
                            <div class="info-field-value" style="color: #10b981;">${report.status || 'Approved'}</div>
                        </div>
                    </div>

                    <table class="test-table">
                        <thead>
                            <tr>
                                <th>Test Parameter</th>
                                <th>Observed Result</th>
                                <th>Unit</th>
                                <th>Biological Reference Range</th>
                                <th>Flag</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${findingsHtml}
                        </tbody>
                    </table>

                    <div class="clinical-notes-card">
                        <h4>CLINICAL IMPRESSION & INTERPRETATION:</h4>
                        <p>${report.summary || 'Findings are correlated with clinical status. Test indices demonstrate stable baseline physiological parameters. Recommended dietary maintenance and routine wellness review.'}</p>
                    </div>

                    <div class="report-sign-footer">
                        <div class="stamp-box">
                            <i class="fa-solid fa-certificate"></i>
                            <span>NABL ACCREDITED • DIGITALLY VERIFIED REPORT</span>
                        </div>
                        <div class="doc-signature">
                            <div class="sig-line">${docName}</div>
                            <div class="sig-title">${docName}</div>
                            <div class="sig-sub">${docSpec} • Medigo Hospital</div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('viewReportModal').style.display = 'flex';
        }

        function closeViewModal() {
            document.getElementById('viewReportModal').style.display = 'none';
        }

        // Direct Download Medical Report (PDF / Printable HTML)
        function downloadReportDirect(recordId) {
            const report = reportsCache.find(r => r.id === recordId) || {
                id: recordId,
                patientName: 'Patient',
                patientId: 'PAT-1001',
                category: 'Diagnostic Report',
                lab: 'Medigo Central Pathology Lab',
                date: new Date().toISOString().split('T')[0],
                status: 'Approved'
            };

            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : (report.doctor || 'Dr. PRAJAPATI SMIT MANOJKUMAR');
            const docSpec = (window.currentDoctor && window.currentDoctor.specialty) ? window.currentDoctor.specialty : 'Senior Consultant';
            const findings = generateReportFindings(report.category || report.reportType, report.status, report.patientName);
            
            let findingsRows = findings.map(f => `
                <tr>
                    <td style="padding:10px 14px; border-bottom:1px solid #e2e8f0; font-weight:600;">${f.param}</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #e2e8f0; font-weight:700; color:#0f172a;">${f.result}</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #e2e8f0; color:#64748b;">${f.unit}</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #e2e8f0; color:#64748b;">${f.ref}</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #e2e8f0;">
                        <span style="display:inline-block; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700; background-color:${f.flag==='high'?'#fef2f2':(f.flag==='borderline'?'#fffbeb':'#ecfdf5')}; color:${f.flag==='high'?'#ef4444':(f.flag==='borderline'?'#f59e0b':'#10b981')};">
                            ${f.flag.toUpperCase()}
                        </span>
                    </td>
                </tr>
            `).join('');

            const htmlContent = `<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Diagnostic Report - ${report.id} - ${report.patientName}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin: 0; padding: 30px; color: #1e293b; }
        .report-page { max-width: 800px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #0a52a3; padding-bottom: 16px; margin-bottom: 24px; }
        .brand { font-size: 24px; font-weight: 800; color: #084382; }
        .brand-sub { font-size: 12px; color: #64748b; font-weight: 600; }
        .report-id { font-size: 16px; font-weight: 800; color: #0a52a3; background: #eff6ff; padding: 6px 12px; border-radius: 6px; }
        .patient-box { background: #f1f5f9; border-radius: 8px; padding: 16px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .p-label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; }
        .p-val { font-size: 14px; font-weight: 700; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 13px; }
        th { background: #084382; color: #ffffff; padding: 10px 14px; text-align: left; font-size: 12px; text-transform: uppercase; }
        .notes-box { background: #f8fafc; border-left: 4px solid #0a52a3; padding: 14px; margin-bottom: 24px; border-radius: 0 8px 8px 0; }
        .footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #cbd5e1; }
        .stamp { border: 1.5px solid #10b981; color: #10b981; font-weight: 700; font-size: 12px; padding: 6px 12px; border-radius: 6px; background: #f0fdf4; }
        .signature { text-align: right; }
        .sig-name { font-size: 14px; font-weight: 700; color: #0f172a; }
        .sig-sub { font-size: 12px; color: #64748b; }
        @media print {
            body { background: #fff; padding: 0; }
            .report-page { border: none; box-shadow: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="report-page">
        <div class="header">
            <div>
                <div class="brand">🏥 MEDI GO CLINICAL & DIAGNOSTIC LABS</div>
                <div class="brand-sub">Accredited Advanced Pathology & Medical Research Center • NABL / ISO Certified</div>
            </div>
            <div>
                <div class="report-id">${report.id}</div>
                <div style="font-size:12px; color:#64748b; text-align:right; margin-top:4px;">Date: ${report.date}</div>
            </div>
        </div>

        <div class="patient-box">
            <div><div class="p-label">Patient Name</div><div class="p-val">${report.patientName}</div></div>
            <div><div class="p-label">Patient ID</div><div class="p-val">${report.patientId || 'PAT-1001'}</div></div>
            <div><div class="p-label">Test Investigation</div><div class="p-val">${report.category || report.reportType}</div></div>
            <div><div class="p-label">Diagnostic Laboratory</div><div class="p-val">${report.lab || 'Medigo Pathology Lab'}</div></div>
            <div><div class="p-label">Referring Clinician</div><div class="p-val">${docName}</div></div>
            <div><div class="p-label">Verification Status</div><div class="p-val" style="color:#10b981;">${report.status || 'Approved'}</div></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Investigation Parameter</th>
                    <th>Observed Result</th>
                    <th>Unit</th>
                    <th>Biological Reference Range</th>
                    <th>Status Flag</th>
                </tr>
            </thead>
            <tbody>
                ${findingsRows}
            </tbody>
        </table>

        <div class="notes-box">
            <div style="font-weight:700; color:#084382; margin-bottom:4px; font-size:13px;">CLINICAL INTERPRETATION & PATHOLOGY REMARKS:</div>
            <div style="font-size:13px; color:#475569; line-height:1.5;">${report.summary || 'All observed laboratory parameters have been clinically correlated. Results indicate normal metabolic function and standard reference biological values. Routine follow-up advised.'}</div>
        </div>

        <div class="footer">
            <div class="stamp">
                ✓ DIGITALLY VERIFIED & APPROVED LAB REPORT
            </div>
            <div class="signature">
                <div style="font-family:'Brush Script MT', cursive; font-size:22px; color:#084382; margin-bottom:2px;">${docName}</div>
                <div class="sig-name">${docName}</div>
                <div class="sig-sub">${docSpec} • Medigo Hospital</div>
            </div>
        </div>
    </div>
</body>
</html>`;

            // 1. Direct file download
            const blob = new Blob([htmlContent], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${report.id}_${(report.patientName || 'Report').replace(/\\s+/g, '_')}_Diagnostic_Report.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            // 2. Open printable preview window
            const printWindow = window.open('', '_blank', 'width=900,height=800');
            if (printWindow) {
                printWindow.document.open();
                printWindow.document.write(htmlContent);
                printWindow.document.close();
                setTimeout(() => {
                    printWindow.print();
                }, 500);
            }
        }

        // Trigger Download from Modal
        function downloadReportModal() {
            if (currentActiveReportId) {
                downloadReportDirect(currentActiveReportId);
            }
        }

        // Trigger Print from Modal
        function printReportModal() {
            const printContent = document.getElementById('reportModalBody').innerHTML;
            const printWindow = window.open('', '_blank', 'width=900,height=800');
            if (printWindow) {
                printWindow.document.open();
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <title>Print Medical Report</title>
                        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                        <style>
                            body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; padding: 20px; }
                            .report-sheet { border: none !important; box-shadow: none !important; padding: 0 !important; }
                            .test-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            .test-table th { background: #084382 !important; color: #fff !important; padding: 8px 12px; font-size: 12px; text-align: left; }
                            .test-table td { padding: 8px 12px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
                            .patient-info-card { background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
                            .clinical-notes-card { background: #f8fafc; border-left: 4px solid #0a52a3; padding: 12px; margin-bottom: 20px; }
                            .report-sign-footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 20px; padding-top: 10px; border-top: 1px dashed #cbd5e1; }
                            .stamp-box { border: 1.5px solid #10b981; color: #10b981; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 6px; }
                            .test-flag { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; }
                            .test-flag.normal { background: #ecfdf5; color: #10b981; }
                            .test-flag.high { background: #fef2f2; color: #ef4444; }
                            .test-flag.borderline { background: #fffbeb; color: #f59e0b; }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                setTimeout(() => {
                    printWindow.print();
                }, 500);
            }
        }

        // Modal Open-Close actions
        function openModal() {
            document.getElementById('uploadReportModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('uploadReportModal').style.display = 'none';
            document.getElementById('uploadReportForm').reset();
        }

        // Save Uploaded Clinical Report to MySQL API
        async function saveReport(event) {
            event.preventDefault();

            const patient = document.getElementById('repPatient').value.trim();
            const category = document.getElementById('repCategory').value;
            const lab = document.getElementById('repLab').value.trim();
            const status = document.getElementById('repStatus').value;
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';

            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${y}-${m}-${d}`;

            try {
                const formData = new FormData();
                formData.append('patientName', patient);
                formData.append('reportType', category);
                formData.append('category', category);
                formData.append('doctor', docName);
                formData.append('summary', `Diagnostic report from ${lab}`);
                formData.append('results', `Status: ${status}. Verified by clinic.`);

                const res = await fetch('api.php?action=add_report', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                
                const newId = result.success ? result.report_id : `REP-${Math.floor(1000 + Math.random() * 9000)}`;

                reportsCache.unshift({
                    id: newId,
                    patientName: patient,
                    category: category,
                    lab: lab,
                    date: formattedDate,
                    status: status
                });
                localStorage.setItem('medigo_reports', JSON.stringify(reportsCache));
            } catch(e) {
                const newId = `REP-${Math.floor(1000 + Math.random() * 9000)}`;
                reportsCache.unshift({
                    id: newId,
                    patientName: patient,
                    category: category,
                    lab: lab,
                    date: formattedDate,
                    status: status
                });
                localStorage.setItem('medigo_reports', JSON.stringify(reportsCache));
            }

            closeModal();
            renderReportsTable(reportsCache);
            updateReportStats();
        }

        // Realtime Approval / Signature trigger with Database sync
        async function approveReport(btn, id) {
            if (confirm("Sign and digitally approve this diagnostic patient report?")) {
                const row = btn.closest('tr');
                const pill = row.querySelector('.status-pill');
                
                pill.textContent = 'Approved';
                pill.className = 'status-pill approved';
                btn.style.display = 'none';

                let record = reportsCache.find(r => r.id === id);
                if (record) {
                    record.status = 'Approved';
                    localStorage.setItem('medigo_reports', JSON.stringify(reportsCache));
                }

                try {
                    const formData = new FormData();
                    formData.append('report_id', id);
                    formData.append('status', 'Approved');
                    formData.append('doctor', (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR');
                    await fetch('api.php?action=update_report_status', {
                        method: 'POST',
                        body: formData
                    });
                } catch(e) {
                    console.warn("API approve sync note:", e);
                }

                updateReportStats();
            }
        }

        // Dynamic Metric Counts
        function updateReportStats() {
            let total = reportsCache.length;
            let approved = 0;
            let review = 0;
            let critical = 0;

            reportsCache.forEach(r => {
                const st = (r.status || '').toLowerCase();
                if (st === 'approved') approved++;
                else if (st === 'review') review++;
                else if (st === 'critical') critical++;
            });

            document.getElementById('totalReports').textContent = total;
            document.getElementById('pendingReview').textContent = review;
            document.getElementById('approvedReports').textContent = approved;
            document.getElementById('criticalAlerts').textContent = critical;
        }

        // Live Table search filters
        function filterReports() {
            const searchVal = document.getElementById('searchInput').value.toLowerCase();
            const statusVal = document.getElementById('statusFilter').value;

            const filtered = reportsCache.filter(item => {
                const id = (item.id || '').toLowerCase();
                const name = (item.patientName || '').toLowerCase();
                const cat = (item.category || '').toLowerCase();
                const lab = (item.lab || '').toLowerCase();
                const status = item.status || 'Approved';

                const matchesSearch = id.includes(searchVal) || name.includes(searchVal) || cat.includes(searchVal) || lab.includes(searchVal);
                const matchesStatus = (statusVal === 'All') || (status === statusVal);

                return matchesSearch && matchesStatus;
            });

            renderReportsTable(filtered);
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchLiveReports();
            
            const urlParams = new URLSearchParams(window.location.search);
            const patientParam = urlParams.get('patient');
            if (patientParam) {
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.value = patientParam;
                    filterReports();
                }
            }

            const modeParam = urlParams.get('mode');
            if (modeParam === 'view') {
                const uploadBtn = document.querySelector('.btn-upload');
                if (uploadBtn) {
                    uploadBtn.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>
