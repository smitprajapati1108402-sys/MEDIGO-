<?php
require_once 'db_connect.php';

$server_prescriptions = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `prescriptions` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_prescriptions[] = [
                'id' => $r['prescription_id'] ?? $r['id'] ?? 'RX-001',
                'name' => $r['patient_name'] ?? 'Patient',
                'patientId' => $r['patient_id'] ?? 'PAT-1001',
                'date' => $r['prescription_date'] ?? date('Y-m-d'),
                'meds' => $r['medicines'] ?? 'Standard Medication',
                'instructions' => $r['instructions'] ?? 'Take after meals as directed.',
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
    <title>Medi Go - Prescriptions Dashboard</title>
    <!-- FontAwesome CDN for Icons matching the design -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
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

        /* --- DASHBOARD MAIN CONTAINER --- */
        .dashboard-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .dashboard-title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .dashboard-title p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* Stats Cards Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 6px;
            font-weight: 600;
        }

        .stat-info p {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
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

        .stat-icon.total { background: var(--info-light); color: var(--info); }
        .stat-icon.active { background: var(--success-light); color: var(--success); }
        .stat-icon.completed { background: #f5f3ff; color: #8b5cf6; }

        /* Filter Controls */
        .table-controls {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px 16px 0 0;
            border: 1px solid var(--border-color);
            border-bottom: none;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
            justify-content: space-between;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 38px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            background-color: var(--bg-color);
        }

        .search-box input:focus {
            border-color: var(--primary);
            background-color: var(--card-bg);
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .filter-select {
            padding: 10px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--card-bg);
            font-size: 0.9rem;
            font-weight: 700;
            outline: none;
            cursor: pointer;
        }

        /* Prescription Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: 0 0 16px 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        th {
            background-color: #f8fafc;
            color: var(--text-muted);
            padding: 14px 20px;
            font-weight: 700;
            border-bottom: 1px solid var(--border-color);
            text-transform: uppercase;
            font-size: 0.78rem;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #fcfdfe;
        }

        /* Badges styling */
        .badge-status {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-status.active {
            background-color: var(--success-light);
            color: var(--success);
        }

        .badge-status.completed {
            background-color: var(--info-light);
            color: var(--info);
        }

        .badge-status.cancelled {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        /* Actions styling */
        .action-btns {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .action-btn.view:hover { color: var(--primary); }
        .action-btn.report:hover { color: #0284c7; }
        .action-btn.delete:hover { color: var(--danger); }

        /* --- POPUP MODAL (Add / View Prescription) --- */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-content {
            background: var(--card-bg);
            width: 90%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 24px;
            animation: fadeIn 0.3s ease;
            border: 1px solid var(--border-color);
        }

        @keyframes fadeIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
        }

        .modal-header h2 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: var(--danger);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            background-color: var(--bg-color);
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            background-color: var(--card-bg);
            box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: var(--text-main);
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
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

    <!-- --- MAIN CONTENT: DASHBOARD --- -->
    <main class="dashboard-container">
        
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>All Prescriptions</h1>
                <p>Manage and track all patient medical prescriptions</p>
            </div>
            <a href="Add_prescription.php" class="btn-primary" style="text-decoration: none;">
                <i class="fa-solid fa-plus"></i> New Prescription
            </a>
        </div>

        <!-- Metric Counter Cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Prescriptions</h3>
                    <p id="count-total">0</p>
                </div>
                <div class="stat-icon total">
                    <i class="fa-solid fa-file-medical"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Active Courses</h3>
                    <p id="count-active">0</p>
                </div>
                <div class="stat-icon active">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Completed</h3>
                    <p id="count-completed">0</p>
                </div>
                <div class="stat-icon completed">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </section>

        <!-- Search and Filter Panel -->
        <div class="table-controls">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search by patient name, medication or ID..." onkeyup="filterPrescriptions()">
            </div>
            <select class="filter-select" id="statusFilter" onchange="filterPrescriptions()">
                <option value="all">All Status</option>
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <!-- Prescription List Table -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Medication details</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="prescriptionTableBody">
                    <!-- Dynamic Rows Rendered by JS -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- --- ADD PRESCRIPTION MODAL --- -->
    <div id="prescriptionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Create New Prescription</h2>
                <button class="close-btn" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="prescriptionForm" onsubmit="savePrescription(event)">
                <input type="hidden" id="editIndex" value="">
                
                <div class="form-group">
                    <label for="patientName">Patient Name</label>
                    <input type="text" id="patientName" class="form-control" required placeholder="e.g. Arjun Sharma">
                </div>
                
                <div class="form-group">
                    <label for="prescriptionDate">Date</label>
                    <input type="date" id="prescriptionDate" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="medications">Medications & Dosage</label>
                    <textarea id="medications" class="form-control" rows="3" required placeholder="e.g. Paracetamol 500mg (1-0-1), Atorvastatin 10mg (0-0-1)"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="prescriptionStatus">Status</label>
                    <select id="prescriptionStatus" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary">Save Prescription</button>
                </div>
            </form>
        </div>
    </div>

    <!-- --- JAVASCRIPT LOGIC --- -->
    <script>
        // Server pre-rendered prescriptions from MySQL
        const serverPrescriptions = <?php echo json_encode($server_prescriptions ?? []); ?>;

        const PRESCRIPTIONS_STORAGE_KEY = 'medigo_prescriptions';
        const DEFAULT_PRESCRIPTIONS = [
            { id: "RX-8021", name: "Arjun Sharma", patientId: "PAT-1001", date: "2026-06-08", meds: "Telmisartan 40mg (1-0-0), Atorvastatin 10mg (0-0-1), Amlodipine 5mg (0-0-1)", status: "Active" },
            { id: "RX-8022", name: "Priya Verma", patientId: "PAT-1002", date: "2026-06-08", meds: "Propranolol 20mg (1-0-1), Naproxen 250mg (SOS)", status: "Active" },
            { id: "RX-8023", name: "Amit Shah", patientId: "PAT-1003", date: "2026-06-08", meds: "Clopidogrel 75mg (1-0-0), Rosuvastatin 20mg (0-0-1), Metoprolol 25mg (1-0-1)", status: "Active" }
        ];

        let prescriptions = [];

        async function fetchLivePrescriptions() {
            try {
                const res = await fetch('api.php?action=get_prescriptions');
                const data = await res.json();
                if (data.success && Array.isArray(data.prescriptions) && data.prescriptions.length > 0) {
                    prescriptions = data.prescriptions.map(p => ({
                        id: p.id,
                        name: p.patientName,
                        patientId: p.patientId,
                        date: p.date,
                        meds: p.medicines,
                        status: p.status || 'Active'
                    }));
                    localStorage.setItem(PRESCRIPTIONS_STORAGE_KEY, JSON.stringify(prescriptions));
                    renderTable(prescriptions);
                    updateStats();
                    return;
                }
            } catch (err) {
                console.warn("MySQL live prescriptions error:", err);
            }

            if (serverPrescriptions && serverPrescriptions.length > 0) {
                prescriptions = serverPrescriptions;
            } else {
                let local = localStorage.getItem(PRESCRIPTIONS_STORAGE_KEY);
                if (local) {
                    try { prescriptions = JSON.parse(local); } catch(e){ prescriptions = DEFAULT_PRESCRIPTIONS; }
                } else {
                    prescriptions = DEFAULT_PRESCRIPTIONS;
                }
            }
            renderTable(prescriptions);
            updateStats();
        }

        // Initialization
        window.onload = function() {
            const dateInput = document.getElementById('prescriptionDate');
            if (dateInput) {
                dateInput.value = new Date().toISOString().split('T')[0];
            }
            fetchLivePrescriptions();

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('action') === 'add') {
                window.location.href = 'Add_prescription.php';
            }
        };

        // Render Table Rows Dynamically
        function renderTable(data) {
            const tableBody = document.getElementById('prescriptionTableBody');
            tableBody.innerHTML = "";

            if (!data || data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                    <i class="fa-solid fa-receipt" style="font-size:2rem; opacity:0.4; display:block; margin-bottom:8px;"></i>
                    No prescriptions found in database
                </td></tr>`;
                return;
            }

            data.forEach((item, index) => {
                let statusClass = (item.status || 'active').toLowerCase();
                
                const row = `
                    <tr>
                        <td><strong>${item.id}</strong></td>
                        <td>${item.name || item.patientName}</td>
                        <td>${item.date}</td>
                        <td style="max-width: 320px; word-wrap: break-word;">${item.meds || item.medicines}</td>
                        <td><span class="badge-status ${statusClass}">${item.status}</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="action-btn view" title="Edit Prescription" onclick="editPrescription(${index})">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="action-btn report" title="View Patient Report" onclick="openPatientReport('${(item.name || item.patientName || '').replace(/'/g, "\\'")}', '${item.patientId || ''}', '${item.id || ''}')">
                                    <i class="fa-solid fa-file-waveform"></i>
                                </button>
                                <button class="action-btn delete" title="Delete record" onclick="deletePrescription(${index})">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Search & Status Filters
        function filterPrescriptions() {
            const searchVal = document.getElementById('searchInput').value.toLowerCase();
            const statusVal = document.getElementById('statusFilter').value;

            const filtered = prescriptions.filter(item => {
                const name = (item.name || item.patientName || '').toLowerCase();
                const meds = (item.meds || item.medicines || '').toLowerCase();
                const id = (item.id || '').toLowerCase();
                
                const matchesSearch = name.includes(searchVal) || meds.includes(searchVal) || id.includes(searchVal);
                const matchesStatus = (statusVal === "all") || (item.status === statusVal);

                return matchesSearch && matchesStatus;
            });

            renderTable(filtered);
        }

        // Stats Counters update
        function updateStats() {
            const total = prescriptions.length;
            const active = prescriptions.filter(p => (p.status || '').toLowerCase() === "active").length;
            const completed = prescriptions.filter(p => (p.status || '').toLowerCase() === "completed").length;

            document.getElementById('count-total').textContent = total;
            document.getElementById('count-active').textContent = active;
            document.getElementById('count-completed').textContent = completed;
        }

        // Open Modal to Add
        function openAddModal() {
            document.getElementById('modalTitle').textContent = "Create New Prescription";
            document.getElementById('prescriptionForm').reset();
            document.getElementById('prescriptionDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('editIndex').value = "";
            document.getElementById('prescriptionModal').style.display = 'flex';
        }

        // Close Modal
        function closeModal() {
            document.getElementById('prescriptionModal').style.display = 'none';
        }

        // Save Prescription (both Add new and Edit) with MySQL API
        async function savePrescription(e) {
            e.preventDefault();
            const patientName = document.getElementById('patientName').value.trim();
            const pDate = document.getElementById('prescriptionDate').value;
            const meds = document.getElementById('medications').value.trim();
            const status = document.getElementById('prescriptionStatus').value;
            const editIndex = document.getElementById('editIndex').value;

            if (editIndex === "") {
                // Add New Mode via MySQL API
                try {
                    const formData = new FormData();
                    formData.append('patientName', patientName);
                    formData.append('medicines', meds);
                    formData.append('instructions', 'Take as directed by doctor');
                    formData.append('diagnosis', 'Clinical Prescription');
                    formData.append('doctor', (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR');

                    const response = await fetch('api.php?action=add_prescription', {
                        method: 'POST',
                        body: formData
                    });
                    const res = await response.json();
                    
                    const newId = res.success ? res.prescription_id : `RX-${Math.floor(1000 + Math.random() * 9000)}`;
                    prescriptions.unshift({ id: newId, name: patientName, date: pDate, meds: meds, status: status });
                } catch(err) {
                    const newId = `RX-${Math.floor(1000 + Math.random() * 9000)}`;
                    prescriptions.unshift({ id: newId, name: patientName, date: pDate, meds: meds, status: status });
                }
            } else {
                // Edit Mode
                const index = parseInt(editIndex);
                if (prescriptions[index]) {
                    prescriptions[index].name = patientName;
                    prescriptions[index].date = pDate;
                    prescriptions[index].meds = meds;
                    prescriptions[index].status = status;
                }
            }

            localStorage.setItem(PRESCRIPTIONS_STORAGE_KEY, JSON.stringify(prescriptions));
            closeModal();
            filterPrescriptions();
            updateStats();
        }

        // Edit button click
        function editPrescription(index) {
            const item = prescriptions[index];
            if (!item) return;
            document.getElementById('modalTitle').textContent = "Edit Prescription";
            document.getElementById('patientName').value = item.name || item.patientName;
            document.getElementById('prescriptionDate').value = item.date;
            document.getElementById('medications').value = item.meds || item.medicines;
            document.getElementById('prescriptionStatus').value = item.status || 'Active';
            document.getElementById('editIndex').value = index;
            document.getElementById('prescriptionModal').style.display = 'flex';
        }

        // Delete record
        function deletePrescription(index) {
            if (confirm("Are you sure you want to delete this prescription?")) {
                prescriptions.splice(index, 1);
                localStorage.setItem(PRESCRIPTIONS_STORAGE_KEY, JSON.stringify(prescriptions));
                filterPrescriptions();
                updateStats();
            }
        }

        // Open Direct Patient Report
        function openPatientReport(patientName, patientId, rxId) {
            if (patientName) {
                sessionStorage.setItem('medigoCurrentPatientName', patientName);
                if (patientId) sessionStorage.setItem('medigoCurrentPatientId', patientId);
                window.location.href = 'PatientReports.php?patient=' + encodeURIComponent(patientName);
            } else {
                window.location.href = 'PatientReports.php';
            }
        }
    </script>
</body>
</html>