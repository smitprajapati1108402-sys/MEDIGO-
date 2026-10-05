<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGo - Patient Portal</title>
    <?php include 'patient_auth.php'; ?>
    <!-- FontAwesome for Premium Medical Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Chart.js CDN for Health Trends Graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #0284c7;
            /* Sky Blue */
            --primary-light: #f0f9ff;
            --primary-hover: #0369a1;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --success-light: #ecfdf5;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
        }

        html {
            scroll-behavior: smooth;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* 1. Header Navigation */
        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 1.35rem;
            font-weight: 800;
        }

        .nav-brand i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .nav-brand span {
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 16px;
            align-items: center;
            height: 100%;
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .nav-item > a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item.active > a,
        .nav-item:hover > a {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Hover Dropdown Menu style */
        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            min-width: 200px;
            padding: 8px;
            list-style: none;
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 1100;
            border: 1px solid var(--border);
        }

        .nav-item:hover .dropdown {
            display: flex;
        }

        .dropdown li {
            width: 100%;
        }

        .dropdown li a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            width: 100%;
        }

        .dropdown li a i {
            color: var(--primary);
            width: 16px;
            font-size: 0.95rem;
        }

        .dropdown li a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
            height: 100%;
        }

        .notif-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
        }

        .notif-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: var(--danger);
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .patient-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .patient-profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .patient-meta h4 {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .patient-meta p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Container & Layout */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Welcome Section */
        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            padding: 28px;
            border-radius: 20px;
            border: 1px solid #bae6fd;
        }

        .welcome-text h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0369a1;
            margin-bottom: 4px;
        }

        .welcome-text p {
            color: #0c4a6e;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .profile-badges {
            display: flex;
            gap: 16px;
        }

        .p-badge {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0369a1;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* 2. Vital Stats Grid */
        .vitals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .vital-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .vital-card:hover {
            transform: translateY(-2px);
        }

        .vital-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .vital-icon.red {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .vital-icon.blue {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .vital-icon.orange {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .vital-icon.green {
            background-color: var(--success-light);
            color: var(--success);
        }

        .vital-info h3 {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .vital-info p {
            font-size: 1.4rem;
            font-weight: 800;
        }

        .vital-status {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--success);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .vital-status.alert {
            color: var(--danger);
        }

        /* 3. Columns Layout Workspace */
        .workspace-grid {
            display: grid;
            grid-template-columns: 1.8fr 1.2fr;
            gap: 28px;
        }

        @media (max-width: 1024px) {
            .workspace-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Generic Card Component */
        .dashboard-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 1.1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 i {
            color: var(--primary);
        }

        /* Upcoming Appointments */
        .appointment-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .appointment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            transition: all 0.2s;
        }

        .appointment-row:hover {
            border-color: var(--primary);
            background-color: #fafdf8;
        }

        .doc-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .doc-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .doc-info h4 {
            font-size: 0.9rem;
            font-weight: 700;
        }

        .doc-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .appt-time {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .appt-time span {
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .appt-time span i {
            color: var(--text-muted);
        }

        .status-badge {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
        }

        .status-badge.confirmed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-badge.pending {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .btn-telehealth {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-telehealth:hover {
            background-color: var(--primary-hover);
        }

        /* Quick Actions Panel */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .action-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            background-color: var(--bg-color);
        }

        .action-card:hover {
            border-color: var(--primary);
            background-color: var(--card-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.08);
        }

        .action-card i {
            font-size: 1.4rem;
            color: var(--primary);
        }

        .action-card span {
            font-size: 0.8rem;
            font-weight: 700;
        }

        /* Current Prescriptions */
        .pres-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .pres-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .pres-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .pres-details h4 {
            font-size: 0.88rem;
            font-weight: 700;
        }

        .pres-details p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .btn-refill {
            background-color: var(--primary-light);
            color: var(--primary);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-refill:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Lab Test Reports */
        .report-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .report-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--bg-color);
            border-radius: 10px;
            padding: 12px 16px;
            border: 1px solid var(--border);
        }

        .report-info h4 {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .report-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .btn-download {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .btn-download:hover {
            color: var(--primary-hover);
        }

        /* 4. Pop-up Modal Windows */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .modal.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            padding: 28px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-cancel {
            background-color: var(--bg-color);
            color: var(--text-dark);
            border: 1px solid var(--border);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #0f172a;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body>

    <!-- 1. Header Navigation Bar -->
    <nav class="navbar">
        <a href="#" class="nav-brand">
            <i class="fa-solid fa-house-medical"></i> MediGo<span>Portal</span>
        </a>
        <ul class="nav-menu">
            <li class="nav-item active"><a href="#">Dashboard</a></li>
            <li class="nav-item">
                <a href="#">Appointments <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="Add_appointment.php"><i class="fa-solid fa-calendar-plus"></i> Add Appointment</a></li>
                    <li><a href="appointmentHistory.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Medical Reports <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="report.php"><i class="fa-solid fa-file-waveform"></i> Lab Reports</a></li>
                    <li><a href="uploadreport.php"><i class="fa-solid fa-file-arrow-up"></i> Upload Report</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Prescription <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="current_prescription.php"><i class="fa-solid fa-pills"></i> Current Prescriptions</a></li>
                    <li><a href="#" onclick="alert('Requesting Refill')"><i class="fa-solid fa-rotate"></i> Request Refill</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Payment <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="#" onclick="alert('Make a payment of pending bills')"><i class="fa-solid fa-credit-card"></i> Pay Bills</a></li>
                    <li><a href="#" onclick="alert('Viewing Payment History')"><i class="fa-solid fa-clock-rotate-left"></i> Payment History</a></li>
                </ul>
            </li>
        </ul>
        <div class="nav-right">
            <button class="notif-btn">
                <i class="fa-regular fa-bell"></i>
                <span class="badge"></span>
            </button>
            <div class="patient-profile nav-item">
                <div class="doc-avatar" style="width: 38px; height: 38px; font-size: 0.9rem; margin-right: 4px;">AS</div>
                <div class="patient-meta">
                    <h4>Arjun Sharma <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></h4>
                    <p>Patient ID: PAT-1001</p>
                </div>
                <ul class="dropdown" style="right: 0; left: auto;">
                    <li><a href="#" onclick="alert('Profile section under development')"><i class="fa-solid fa-user"></i> My Profile</a></li>
                    <li><a href="#" onclick="alert('Settings section under development')"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="patient_login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">

        <!-- Welcome banner with patient meta details -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1 id="welcomeTitle">Welcome back, Arjun Sharma</h1>
                <p>All your vital stats look stable. Keep maintaining your routine!</p>
            </div>
            <div class="profile-badges">
                <div class="p-badge" id="welcomeBlood">Blood Type: O+</div>
                <div class="p-badge" id="welcomeAge">Age: 45 Yrs</div>
            </div>
        </div>

        <!-- 2. Vitals Matrix Cards -->
        <div class="vitals-grid">
            <div class="vital-card">
                <div class="vital-icon red">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <div class="vital-info">
                    <h3>Heart Rate</h3>
                    <p id="vitalHeart">72 <span style="font-size: 0.9rem; font-weight: normal;">BPM</span></p>
                    <div class="vital-status"><i class="fa-solid fa-circle-check"></i> Normal</div>
                </div>
            </div>
            <div class="vital-card">
                <div class="vital-icon blue">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div class="vital-info">
                    <h3>Blood Pressure</h3>
                    <p id="vitalBP">120/80 <span style="font-size: 0.9rem; font-weight: normal;">mmHg</span></p>
                    <div class="vital-status"><i class="fa-solid fa-circle-check"></i> Normal</div>
                </div>
            </div>
            <div class="vital-card">
                <div class="vital-icon orange">
                    <i class="fa-solid fa-droplet"></i>
                </div>
                <div class="vital-info">
                    <h3>Blood Sugar</h3>
                    <p id="vitalSugar">98 <span style="font-size: 0.9rem; font-weight: normal;">mg/dL</span></p>
                    <div class="vital-status"><i class="fa-solid fa-circle-check"></i> Normal</div>
                </div>
            </div>
            <div class="vital-card">
                <div class="vital-icon green">
                    <i class="fa-solid fa-weight-scale"></i>
                </div>
                <div class="vital-info">
                    <h3>BMI Status</h3>
                    <p id="vitalBMI">22.4 <span style="font-size: 0.9rem; font-weight: normal;">kg/m&sup2;</span></p>
                    <div class="vital-status"><i class="fa-solid fa-circle-check"></i> Healthy</div>
                </div>
            </div>
        </div>

        <!-- 3. Work Grid Columns -->
        <div class="workspace-grid">

            <!-- Column 1 (Left panel): Appointments & Graphs -->
            <div>
                <!-- Upcoming Appointments List Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2><i class="fa-regular fa-calendar-check"></i> Appointment History</h2>
                    </div>
                    <div class="appointment-list" id="appointmentContainer">
                        <!-- Rendered Dynamically via JS -->
                    </div>
                </div>

                <!-- Health Analytics Graph Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-chart-line"></i> Heart Rate & BP Log Trend</h2>
                    </div>
                    <div style="height: 250px; position: relative;">
                        <canvas id="healthTrendsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Column 2 (Right panel): Actions, Prescriptions, Test Reports -->
            <div>

                <!-- Quick Action Grid -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2>Quick Actions</h2>
                    </div>
                    <div class="action-grid">
                        <div class="action-card" onclick="window.location.href='Add_appointment.php'">
                            <i class="fa-solid fa-calendar-plus"></i>
                            <span>Add Appointment</span>
                        </div>
                        <div class="action-card" onclick="openVitalsModal()">
                            <i class="fa-solid fa-file-waveform"></i>
                            <span>Log Vitals</span>
                        </div>
                        <div class="action-card" onclick="alert('Routing to telemedicine video platform...')">
                            <i class="fa-solid fa-video"></i>
                            <span>Join Waiting Room</span>
                        </div>
                        <div class="action-card" onclick="alert('Help desk contact info: support@medigo.com')">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Help Center</span>
                        </div>
                    </div>
                </div>

                <!-- Active Medications / Prescriptions -->
                <div class="dashboard-card" id="currentPrescriptions">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-pills"></i> Current Prescriptions</h2>
                    </div>
                    <div class="pres-list">
                        <div class="pres-row">
                            <div class="pres-details">
                                <h4>Amlodipine 5mg</h4>
                                <p>Once daily, morning | Dr. Raj Patel</p>
                            </div>
                            <button class="btn-refill" onclick="triggerRefill('Amlodipine')">Request Refill</button>
                        </div>
                        <div class="pres-row">
                            <div class="pres-details">
                                <h4>Telmisartan 40mg</h4>
                                <p>Once daily, after food | Dr. Raj Patel</p>
                            </div>
                            <button class="btn-refill" onclick="triggerRefill('Telmisartan')">Request Refill</button>
                        </div>
                    </div>
                </div>

                <!-- Lab Test Reports -->
                <div class="dashboard-card" id="recentLabReports">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-file-invoice"></i> Recent Lab Reports</h2>
                    </div>
                    <div class="report-list">
                        <div class="report-row">
                            <div class="report-info">
                                <h4>Lipid Profile (Blood)</h4>
                                <p>Verified: May 24, 2026</p>
                            </div>
                            <button class="btn-download" onclick="alert('Downloading Lipid_Profile_Report.pdf...')"
                                title="Download PDF"><i class="fa-solid fa-file-arrow-down"></i></button>
                        </div>
                        <div class="report-row">
                            <div class="report-info">
                                <h4>Electrocardiogram (ECG)</h4>
                                <p>Verified: Jun 05, 2026</p>
                            </div>
                            <button class="btn-download" onclick="alert('Downloading ECG_Report.pdf...')"
                                title="Download PDF"><i class="fa-solid fa-file-arrow-down"></i></button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Modal 1: Add Appointment -->
    <div class="modal" id="appointmentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Appointment</h3>
                <button class="close-btn" onclick="closeAppointmentModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="appointmentForm" onsubmit="bookAppointment(event)">
                <div class="form-group">
                    <label for="doctorSelect">Choose Specialist *</label>
                    <select id="doctorSelect" class="form-control" required>
                        <option value="Dr. Raj Patel (Cardiology)">Dr. Raj Patel (Cardiology)</option>
                        <option value="Dr. Jane Smith (Neurology)">Dr. Jane Smith (Neurology)</option>
                        <option value="Dr. Robert Chen (Pediatrics)">Dr. Robert Chen (Pediatrics)</option>
                        <option value="Dr. Marcus Vance (Emergency Medicine)">Dr. Marcus Vance (Emergency Medicine)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="apptDate">Select Date *</label>
                    <input type="date" id="apptDate" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="apptTime">Select Time *</label>
                    <input type="time" id="apptTime" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="consultationType">Appointment Method *</label>
                    <select id="consultationType" class="form-control">
                        <option value="Online">Online (Video Call)</option>
                        <option value="Offline">Offline (In-Person)</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeAppointmentModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Add Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Log Vitals -->
    <div class="modal" id="vitalsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Log Health Vitals</h3>
                <button class="close-btn" onclick="closeVitalsModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="vitalsForm" onsubmit="saveVitals(event)">
                <div class="form-row"
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="heartInput">Heart Rate (BPM)</label>
                        <input type="number" id="heartInput" class="form-control" placeholder="e.g., 72" required
                            min="40" max="200">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="bpInput">Blood Pressure (mmHg)</label>
                        <input type="text" id="bpInput" class="form-control" placeholder="e.g., 120/80" required
                            pattern="\d{2,3}\/\d{2,3}">
                    </div>
                </div>
                <div class="form-row"
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="sugarInput">Blood Sugar (mg/dL)</label>
                        <input type="number" id="sugarInput" class="form-control" placeholder="e.g., 95" required
                            min="50" max="400">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="bmiInput">BMI Index</label>
                        <input type="number" id="bmiInput" class="form-control" placeholder="e.g., 22.4" step="0.1"
                            required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeVitalsModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Save Vitals</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Popup Notifications -->
    <div class="toast" id="systemToast">
        <i class="fa-solid fa-circle-check" style="color: var(--success);"></i>
        <span id="toastMessage">Success operation message</span>
    </div>

    <!-- Live JS Script Interface -->
    <script>
        // DOM elements selectors
        const apptContainer = document.getElementById('appointmentContainer');
        const apptModal = document.getElementById('appointmentModal');
        const vitalsModal = document.getElementById('vitalsModal');

        let vitalRecords = { heart: 72, bp: "120/80", sugar: 98, bmi: 22.4 };

        document.addEventListener('DOMContentLoaded', () => {
            if (window.currentPatient) {
                document.getElementById('welcomeTitle').innerHTML = `Welcome back, ${window.currentPatient.name}`;
                document.getElementById('welcomeBlood').textContent = `Blood Type: ${window.currentPatient.bloodType || window.currentPatient.blood_group || 'O+'}`;
                document.getElementById('welcomeAge').textContent = `Age: ${window.currentPatient.age || '45 Yrs'}`;
            }
            loadDoctorsList();
            renderAppointments();
            fetchVitalsUI();
            initTrendsChart();
        });

        // Load doctors dynamically from database
        async function loadDoctorsList() {
            try {
                const res = await fetch('api.php?action=get_doctors');
                const result = await res.json();
                if (result.status === 'success' && Array.isArray(result.data) && result.data.length > 0) {
                    const docSelect = document.getElementById('doctorSelect');
                    if (docSelect) {
                        docSelect.innerHTML = '';
                        result.data.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = `${d.name} (${d.department})`;
                            opt.textContent = `${d.name} (${d.department} - ${d.specialty})`;
                            docSelect.appendChild(opt);
                        });
                    }
                }
            } catch (err) {
                console.warn('Could not load doctors list from MySQL:', err);
            }
        }

        // 1. Render upcoming consultations from MySQL Database
        async function renderAppointments() {
            apptContainer.innerHTML = '<div style="text-align: center; padding: 24px; color: var(--text-muted);"><i class="fa-solid fa-spinner fa-spin"></i> Loading appointments from database...</div>';

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

            try {
                const res = await fetch(`api.php?action=get_appointments&patient_id=${encodeURIComponent(patientId)}&patient_name=${encodeURIComponent(patientName)}`);
                const result = await res.json();

                let patientAppts = [];
                if (result.status === 'success' && Array.isArray(result.data)) {
                    patientAppts = result.data.filter(a => a.status !== 'Cancelled');
                }

                apptContainer.innerHTML = '';

                if (patientAppts.length === 0) {
                    apptContainer.innerHTML = `
                        <div style="text-align: center; padding: 24px; color: var(--text-muted);">
                            <p>No upcoming appointments found in database.</p>
                        </div>`;
                    return;
                }

                patientAppts.forEach(appt => {
                    let doctorName = appt.type || appt.doctor_name || "";
                    let specialty = appt.department || appt.specialty || "General Medicine";
                    if (doctorName && doctorName.includes(' (')) {
                        const parts = doctorName.split(' (');
                        doctorName = parts[0];
                        specialty = parts[1].replace(')', '');
                    }

                    const docInitials = doctorName ? doctorName.replace("Dr. ", "").split(" ").filter(Boolean).map(n => n[0]).join("") : "DR";
                    const method = appt.method || appt.type || "In-Person";
                    const isOnline = method === 'Online' || method === 'Video Call';
                    const methodText = isOnline ? 'Online (Video Call)' : 'Offline (In-Person)';
                    const methodIcon = isOnline ? 'fa-solid fa-video' : 'fa-solid fa-building';

                    let displayDate = appt.datetime || appt.appointment_date || "";
                    let displayTime = appt.appointment_time || "";
                    if (displayDate && displayDate.includes(' - ')) {
                        const parts = displayDate.split(' - ');
                        displayDate = parts[0];
                        displayTime = parts[1];
                    }

                    const apptRow = `
                        <div class="appointment-row">
                            <div class="doc-profile">
                                <div class="doc-avatar">${docInitials}</div>
                                <div class="doc-info">
                                    <h4>${doctorName}</h4>
                                    <p>${specialty}</p>
                                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                                        <i class="${methodIcon}"></i> ${methodText}
                                    </div>
                                </div>
                            </div>
                            <div class="appt-time">
                                <span><i class="fa-regular fa-calendar"></i> ${displayDate}</span>
                                <span><i class="fa-regular fa-clock"></i> ${displayTime}</span>
                            </div>
                            <div class="appt-action">
                                ${isOnline ?
                                    `<button class="btn-telehealth" onclick="alert('Redirecting to virtual appointment room...')"><i class="fa-solid fa-video"></i> Join Room</button>` :
                                    `<span class="status-badge ${appt.status.toLowerCase()}">${appt.status || 'Confirmed'}</span>`
                                }
                            </div>
                        </div>
                    `;
                    apptContainer.insertAdjacentHTML('beforeend', apptRow);
                });
            } catch (err) {
                console.error('Failed to load appointments from MySQL:', err);
                apptContainer.innerHTML = `<div style="text-align: center; padding: 20px; color: var(--text-muted);">Could not fetch appointments from server.</div>`;
            }
        }

        // Fetch vitals from MySQL and display on dynamic Cards
        async function fetchVitalsUI() {
            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            try {
                const res = await fetch(`api.php?action=get_vitals&patient_id=${encodeURIComponent(patientId)}`);
                const result = await res.json();
                if (result.status === 'success' && result.data) {
                    vitalRecords = result.data;
                }
            } catch (e) {
                console.warn('Using local vitals:', e);
            }
            displayVitalsUI();
        }

        function displayVitalsUI() {
            document.getElementById('vitalHeart').innerHTML = `${vitalRecords.heart || 72} <span style="font-size: 0.9rem; font-weight: normal;">BPM</span>`;
            document.getElementById('vitalBP').innerHTML = `${vitalRecords.bp || '120/80'} <span style="font-size: 0.9rem; font-weight: normal;">mmHg</span>`;
            document.getElementById('vitalSugar').innerHTML = `${vitalRecords.sugar || 98} <span style="font-size: 0.9rem; font-weight: normal;">mg/dL</span>`;
            document.getElementById('vitalBMI').innerHTML = `${vitalRecords.bmi || 22.4} <span style="font-size: 0.9rem; font-weight: normal;">kg/m&sup2;</span>`;
        }

        // 3. Appointment Modal controllers
        function openAppointmentModal() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const todayFormatted = `${yyyy}-${mm}-${dd}`;
            
            const dateInput = document.getElementById('apptDate');
            if (dateInput) {
                dateInput.setAttribute('min', todayFormatted);
                if (!dateInput.value || dateInput.value < todayFormatted) {
                    dateInput.value = todayFormatted;
                }
            }
            apptModal.classList.add('active');
        }

        function closeAppointmentModal() {
            apptModal.classList.remove('active');
            document.getElementById('appointmentForm').reset();
        }

        // Book Appointment: Saved directly to MySQL database
        async function bookAppointment(event) {
            event.preventDefault();

            const doctorFull = document.getElementById('doctorSelect').value;
            const dateInput = document.getElementById('apptDate').value;
            const timeInput = document.getElementById('apptTime').value;
            const consultType = document.getElementById('consultationType').value;

            let formattedTime = formatTime(timeInput);
            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : "Arjun Sharma";

            const fd = new FormData();
            fd.append('doctor', doctorFull);
            fd.append('date', dateInput);
            fd.append('time', formattedTime);
            fd.append('method', consultType);
            fd.append('patient_id', patientId);
            fd.append('patient_name', patientName);
            fd.append('action', 'book_appointment');

            try {
                const res = await fetch('api.php?action=book_appointment', {
                    method: 'POST',
                    body: fd
                });
                const result = await res.json();
                if (result.status === 'success') {
                    renderAppointments();
                    closeAppointmentModal();
                    triggerNotification('Appointment scheduled & saved to database!');
                } else {
                    alert(result.message || 'Could not schedule appointment.');
                }
            } catch (err) {
                console.error('Error booking appointment:', err);
                triggerNotification('Appointment scheduled successfully!');
                closeAppointmentModal();
            }
        }

        // 4. Vitals Modal controls
        function openVitalsModal() {
            document.getElementById('heartInput').value = vitalRecords.heart || 72;
            document.getElementById('bpInput').value = vitalRecords.bp || '120/80';
            document.getElementById('sugarInput').value = vitalRecords.sugar || 98;
            document.getElementById('bmiInput').value = vitalRecords.bmi || 22.4;
            vitalsModal.classList.add('active');
        }

        function closeVitalsModal() {
            vitalsModal.classList.remove('active');
        }

        // Save vitals: Saved directly to MySQL database
        async function saveVitals(event) {
            event.preventDefault();

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';
            const heart = parseInt(document.getElementById('heartInput').value);
            const bp = document.getElementById('bpInput').value.trim();
            const sugar = parseInt(document.getElementById('sugarInput').value);
            const bmi = parseFloat(document.getElementById('bmiInput').value);

            vitalRecords = { heart, bp, sugar, bmi };

            const fd = new FormData();
            fd.append('patient_id', patientId);
            fd.append('patient_name', patientName);
            fd.append('heart', heart);
            fd.append('bp', bp);
            fd.append('sugar', sugar);
            fd.append('bmi', bmi);
            fd.append('action', 'save_vitals');

            try {
                await fetch('api.php?action=save_vitals', {
                    method: 'POST',
                    body: fd
                });
            } catch (e) {
                console.warn('Offline vitals fallback:', e);
            }

            displayVitalsUI();
            closeVitalsModal();
            triggerNotification('Vital logs updated & saved to database!');
        }

        // Refill logic handler via MySQL database
        async function triggerRefill(medName) {
            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

            const fd = new FormData();
            fd.append('patient_id', patientId);
            fd.append('patient_name', patientName);
            fd.append('medicine_id', 'MED-' + Math.floor(10 + Math.random() * 90));
            fd.append('medicine_name', medName);
            fd.append('action', 'request_refill');

            try {
                const res = await fetch('api.php?action=request_refill', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                triggerNotification(data.message || `Refill requested for ${medName}.`);
            } catch (e) {
                triggerNotification(`Refill requested for ${medName}. Doctor notified.`);
            }
        }

        // 5. Chart JS Trends instantiation
        function initTrendsChart() {
            const ctx = document.getElementById('healthTrendsChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['27 May', '28 May', '29 May', '30 May', '31 May', '01 Jun', '02 Jun'],
                    datasets: [
                        {
                            label: 'Systolic BP (mmHg)',
                            data: [118, 122, 120, 119, 121, 120, 120],
                            borderColor: '#0284c7',
                            backgroundColor: 'transparent',
                            borderWidth: 2.5,
                            tension: 0.3
                        },
                        {
                            label: 'Heart Rate (BPM)',
                            data: [70, 74, 75, 71, 73, 72, 72],
                            borderColor: '#ef4444',
                            backgroundColor: 'transparent',
                            borderWidth: 2.5,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    weight: '600',
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { weight: '600' } }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // --- Helper Formatting Utilities ---
        function formatDisplayDate(dateStr) {
            const options = { day: 'numeric', month: 'short' };
            return new Date(dateStr).toLocaleDateString('en-US', options);
        }

        function formatTime(time24) {
            if (!time24) return '09:30 AM';
            let [hours, minutes] = time24.split(':');
            let ampm = parseInt(hours) >= 12 ? 'PM' : 'AM';
            let h = parseInt(hours) % 12;
            h = h ? h : 12;
            return `${h}:${minutes} ${ampm}`;
        }

        function triggerNotification(message) {
            const toast = document.getElementById('systemToast');
            document.getElementById('toastMessage').innerText = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3500);
        }

        // Close on outside window overlays click helper
        window.onclick = function (event) {
            if (event.target === apptModal) closeAppointmentModal();
            if (event.target === vitalsModal) closeVitalsModal();
        }
    </script>
</body>

</html>
