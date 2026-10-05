<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - My Prescriptions</title>
    <?php include 'patient_auth.php'; ?>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --primary-light: #f0f9ff;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-light: #ecfdf5;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --info: #0284c7;
            --info-light: #f0f9ff;
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

        .doc-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* 2. Portal Workspace Wrapper */
        .wrapper {
            max-width: 1440px; margin: 0 auto; padding: 32px;
        }

        .rx-header { margin-bottom: 24px; }
        .rx-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
        .rx-header p { color: var(--text-muted); font-size: 0.95rem; }

        /* Workspace Grid layout */
        .workspace-grid {
            display: grid; grid-template-columns: 1.3fr 1fr; gap: 32px;
        }

        @media (max-width: 1024px) {
            .workspace-grid { grid-template-columns: 1fr; }
        }

        /* Generic portal cards */
        .portal-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .card-header {
            font-size: 1.05rem; font-weight: 800; color: var(--text-main);
            border-bottom: 1px solid var(--border-color); padding-bottom: 14px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }
        .card-header i { color: var(--primary); }

        /* Interactive Pill Schedule Helper */
        .pill-schedule-row {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px;
        }
        .schedule-tab {
            border: 1px solid var(--border-color); background-color: #fafbfc;
            padding: 16px 12px; border-radius: 12px; text-align: center; cursor: pointer;
            transition: all 0.2s;
        }
        .schedule-tab:hover { border-color: var(--primary); background-color: var(--info-light); }
        .schedule-tab.active { background-color: var(--primary); border-color: var(--primary); color: white; }
        .schedule-tab i { font-size: 1.3rem; margin-bottom: 6px; display: block; }
        .schedule-tab.active i { color: white; }
        .schedule-tab .tab-name { font-size: 0.85rem; font-weight: 800; }
        .schedule-tab .tab-time { font-size: 0.72rem; opacity: 0.85; margin-top: 2px; display: block; }

        /* Highlighted Pills list box */
        .pills-focus-container {
            background-color: #fafbeb; border: 1px solid #fef08a;
            border-radius: 12px; padding: 18px; margin-bottom: 24px;
        }
        .pills-focus-container h4 { font-size: 0.82rem; font-weight: 800; color: #854d0e; margin-bottom: 8px; }
        .pills-focus-list { list-style: none; font-size: 0.88rem; color: #713f12; line-height: 1.5; }
        .pills-focus-list li { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
        .pills-focus-list li i { color: var(--warning); }

        /* Prescription Directory Table */
        .table-responsive { width: 100%; overflow-x: auto; }
        .rx-table { width: 100%; border-collapse: collapse; text-align: left; }
        .rx-table th {
            color: var(--text-muted); font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; padding: 12px; border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }
        .rx-table td { font-size: 0.85rem; padding: 16px 12px; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
        .rx-table tr:last-child td { border-bottom: none; }

        .td-med-title { font-weight: 700; color: var(--text-main); }
        .td-schedule { font-size: 0.82rem; color: var(--text-muted); }

        .btn-refill {
            background-color: transparent; color: var(--primary); border: 1px solid var(--primary);
            padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-refill:hover { background-color: var(--primary); color: white; }
        .btn-refill.requested {
            background-color: #f1f5f9; color: var(--text-muted); border-color: #cbd5e1;
            cursor: not-allowed; text-decoration: none;
        }

        /* Digital Prescription Slip (Right column sticky) */
        .slip-sticky { position: sticky; top: 100px; }

        .digital-rx-slip {
            border: 1px solid var(--border-color); border-radius: 16px;
            padding: 24px; background-color: #fafbfc; position: relative;
        }
        .rx-watermark {
            position: absolute; right: 20px; top: 80px; font-size: 6rem;
            color: rgba(10, 82, 163, 0.04); font-weight: 900; user-select: none; pointer-events: none;
        }

        .slip-header-hospital {
            border-bottom: 2px solid var(--primary); padding-bottom: 12px; margin-bottom: 16px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .slip-hospital-title { font-size: 1rem; font-weight: 800; color: var(--primary); }
        .slip-doctor-meta { text-align: right; }
        .slip-doctor-meta strong { font-size: 0.85rem; color: var(--text-main); display: block; }
        .slip-doctor-meta span { font-size: 0.72rem; color: var(--text-muted); }

        .slip-patient-bar {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
            margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;
        }
        .patient-meta-item { display: flex; flex-direction: column; gap: 2px; }
        .patient-meta-item span { font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
        .patient-meta-item strong { font-size: 0.82rem; color: var(--text-main); }

        /* Rx Drug Table inside Slip */
        .slip-drug-list { list-style: none; margin-bottom: 24px; }
        .slip-drug-item {
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .slip-drug-item:last-child { border-bottom: none; }
        .drug-slip-name { font-weight: 700; font-size: 0.88rem; color: var(--text-main); }
        .drug-slip-dosage { font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; }
        .drug-slip-qty { font-size: 0.82rem; font-weight: 700; color: var(--primary); }

        .slip-instructions-box {
            background-color: var(--info-light); border-left: 4px solid var(--info);
            border-radius: 4px; padding: 12px; margin-bottom: 20px;
        }
        .slip-instructions-box h5 { font-size: 0.75rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 4px; }
        .slip-instructions-box p { font-size: 0.8rem; color: var(--text-main); line-height: 1.4; }

        .slip-footer {
            border-top: 1px solid var(--border-color); padding-top: 14px;
            display: flex; justify-content: space-between; align-items: center;
        }

        /* Success Toast Popup */
        .toast {
            position: fixed; bottom: 30px; right: 30px; background-color: var(--success); color: white;
            padding: 16px 28px; border-radius: 12px; font-weight: 700; transform: translateY(100px);
            opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2000;
            display: flex; align-items: center; gap: 12px;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
    </style>
</head>

<body>

    <!-- 1. Header Navigation Bar -->
    <nav class="navbar">
        <a href="Patient_dashboard.php" class="nav-brand">
            <i class="fa-solid fa-house-medical"></i> MediGo<span>Portal</span>
        </a>
        <ul class="nav-menu">
            <li class="nav-item"><a href="Patient_dashboard.php">Dashboard</a></li>
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
            <li class="nav-item active">
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
                <div class="doc-avatar" style="width: 38px; height: 38px; font-size: 0.9rem; margin-right: 4px;" id="navAvatar">AS</div>
                <div class="patient-meta">
                    <h4 id="navPatientName">Arjun Sharma <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></h4>
                    <p id="navPatientId">Patient ID: PAT-1001</p>
                </div>
                <ul class="dropdown" style="right: 0; left: auto;">
                    <li><a href="#" onclick="alert('Profile section under development')"><i class="fa-solid fa-user"></i> My Profile</a></li>
                    <li><a href="#" onclick="alert('Settings section under development')"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="patient_login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. Portal Workspace Wrapper -->
    <div class="wrapper">

        <div class="rx-header">
            <h1>My Active Medications</h1>
            <p>Monitor your active daily prescriptions, tablet schedules, and request clinical drug refills [INDEX].</p>
        </div>

        <!-- Split columns layout grid -->
        <div class="workspace-grid">

            <!-- Left Column: Medications Directory & Timetable Selector -->
            <div>
                <!-- Card 1: Pill Schedule Helper -->
                <div class="portal-card">
                    <div class="card-header">
                        <i class="fa-solid fa-clock"></i> Interactive Daily Pill Timetable
                    </div>

                    <div class="pill-schedule-row">
                        <div class="schedule-tab active" onclick="switchSchedule('morning', this)">
                            <i class="fa-solid fa-sun" style="color: var(--warning);"></i>
                            <span class="tab-name">Morning Dose</span>
                            <span class="tab-time">08:00 AM (After Food)</span>
                        </div>
                        <div class="schedule-tab" onclick="switchSchedule('afternoon', this)">
                            <i class="fa-solid fa-cloud-sun"></i>
                            <span class="tab-name">Afternoon Dose</span>
                            <span class="tab-time">02:00 PM (Lunch SOS)</span>
                        </div>
                        <div class="schedule-tab" onclick="switchSchedule('night', this)">
                            <i class="fa-solid fa-moon" style="color: #8b5cf6;"></i>
                            <span class="tab-name">Night Dose</span>
                            <span class="tab-time">09:00 PM (Before Bed)</span>
                        </div>
                    </div>

                    <!-- Focus Schedule Details Box -->
                    <div class="pills-focus-container">
                        <h4 id="focusScheduleTitle">Morning Medication Queue</h4>
                        <ul class="pills-focus-list" id="focusScheduleList">
                            <!-- Loaded Dynamically based on active timetable tab -->
                        </ul>
                    </div>
                </div>

                <!-- Card 2: Active Prescription Medications Directory -->
                <div class="portal-card">
                    <div class="card-header">
                        <i class="fa-solid fa-prescription-bottle-medical"></i> Active Medication Directory
                    </div>

                    <div class="table-responsive">
                        <table class="rx-table">
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Refills Left</th>
                                    <th>Dosage Instructions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rxDirectoryTableBody">
                                <!-- Loaded dynamically via Database -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Digital Rx Prescription Slip (Sticky) -->
            <div class="slip-sticky">
                <div class="portal-card">
                    <div class="card-header">
                        <i class="fa-solid fa-receipt"></i> Digital Consultation Rx Slip
                    </div>

                    <!-- Digital Letterhead slip -->
                    <div class="digital-rx-slip">
                        <div class="rx-watermark">Rx</div>
                        
                        <div class="slip-header-hospital">
                            <span class="slip-hospital-title"><i class="fa-solid fa-square-h"></i> Medi Go Clinic</span>
                            <div class="slip-doctor-meta">
                                <strong>Dr. Raj Patel</strong>
                                <span>Senior Cardiologist</span>
                            </div>
                        </div>

                        <!-- Patient bar inside slip -->
                        <div class="slip-patient-bar">
                            <div class="patient-meta-item">
                                <span>Patient Name</span>
                                <strong id="slipPatientName">Arjun Sharma (PAT-1001)</strong>
                            </div>
                            <div class="patient-meta-item" style="text-align: right;">
                                <span>Rx Date / Ref ID</span>
                                <strong>15 May 2026 &bull; RX-2024-001</strong>
                            </div>
                        </div>

                        <!-- Drug items list -->
                        <ul class="slip-drug-list">
                            <li class="slip-drug-item">
                                <div>
                                    <span class="drug-slip-name">Telmisartan 40mg (Hypertensive)</span>
                                    <p class="drug-slip-dosage">Oral &bull; 1 Tablet &bull; Once daily (Morning, after breakfast)</p>
                                </div>
                                <span class="drug-slip-qty">Qty: 90 Tabs</span>
                            </li>
                            <li class="slip-drug-item">
                                <div>
                                    <span class="drug-slip-name">Amlodipine 5mg (Vasodilator)</span>
                                    <p class="drug-slip-dosage">Oral &bull; 1 Tablet &bull; Once daily (Night, before sleeping)</p>
                                </div>
                                <span class="drug-slip-qty">Qty: 30 Tabs</span>
                            </li>
                            <li class="slip-drug-item">
                                <div>
                                    <span class="drug-slip-name">Atorvastatin 10mg (Lipid Control)</span>
                                    <p class="drug-slip-dosage">Oral &bull; 1 Tablet &bull; Once daily (Night, before sleeping)</p>
                                </div>
                                <span class="drug-slip-qty">Qty: 90 Tabs</span>
                            </li>
                        </ul>

                        <!-- Doctor's specialized note instructions -->
                        <div class="slip-instructions-box">
                            <h5>Doctor's Dietary Advice</h5>
                            <p>Maintain a strict low-sodium (low salt) diet pattern. Engage in at least 30 minutes of mild walking daily. Monitor and record blood pressure readings at home twice weekly.</p>
                        </div>

                        <div class="slip-footer">
                            <button class="btn-refill" style="padding: 10px 20px;" onclick="window.print()">
                                <i class="fa-solid fa-print"></i> Print Rx Copy
                            </button>
                            <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700;">DIGITALLY SECURED</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Live success Toast message -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span id="toastMsg">Drug refill requested successfully! pending clinical review.</span>
    </div>

    <!-- Live JS Prescription Engine -->
    <script>
        let currentMeds = [
            { id: "MED-90", name: "Telmisartan 40mg", refills: 2, instructions: "1 Tablet • Once Daily (Morning, after food)", morning: true, afternoon: false, night: false },
            { id: "MED-41", name: "Amlodipine 5mg", refills: 1, instructions: "1 Tablet • Once Daily (Night, before bed)", morning: false, afternoon: false, night: true },
            { id: "MED-23", name: "Atorvastatin 10mg", refills: 3, instructions: "1 Tablet • Once Daily (Night, before bed)", morning: false, afternoon: false, night: true },
            { id: "MED-08", name: "Multivitamin", refills: 0, instructions: "1 Capsule • SOS (Only during high fatigue)", morning: false, afternoon: true, night: false }
        ];

        let requestedMeds = [];

        // Fetch Prescriptions & Refill Status from MySQL Database
        async function renderMedications() {
            const tbody = document.getElementById('rxDirectoryTableBody');
            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';

            try {
                const res = await fetch(`api.php?action=get_prescriptions&patient_id=${encodeURIComponent(patientId)}`);
                const result = await res.json();

                if (result.status === 'success' && result.data) {
                    if (Array.isArray(result.data.refills)) {
                        requestedMeds = result.data.refills.map(r => r.medicine_id);
                    }
                    if (Array.isArray(result.data.prescriptions) && result.data.prescriptions.length > 0) {
                        const rx = result.data.prescriptions[0];
                        // Update prescription summary details on page if present
                        const diagEl = document.querySelector('.rx-card-details strong');
                        if (diagEl && rx.diagnosis) {
                            diagEl.textContent = rx.diagnosis;
                        }
                    }
                }
            } catch (err) {
                console.warn('Error fetching prescription from database:', err);
            }

            tbody.innerHTML = '';

            currentMeds.forEach(med => {
                const isRequested = requestedMeds.includes(med.id);
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <div class="td-med-title">${med.name}</div>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Rx ID: ${med.id}</span>
                    </td>
                    <td><strong style="color: ${med.refills > 0 ? 'var(--text-main)' : 'var(--danger)'};">${med.refills} refills left</strong></td>
                    <td class="td-schedule">${med.instructions}</td>
                    <td>
                        <button class="btn-refill ${isRequested ? 'requested' : ''}" 
                                onclick="requestRefill('${med.id}', '${med.name}')" 
                                ${isRequested ? 'disabled' : ''}>
                            ${isRequested ? 'Refill Pending' : 'Request Refill'}
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Switch Schedule Time Helper tabs dynamically
        function switchSchedule(timeSlot, element) {
            document.querySelectorAll('.schedule-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            element.classList.add('active');

            const titleEl = document.getElementById('focusScheduleTitle');
            const listEl = document.getElementById('focusScheduleList');

            listEl.innerHTML = '';

            if (timeSlot === 'morning') {
                titleEl.textContent = 'Morning Medication Queue (08:00 AM)';
                const morningMeds = currentMeds.filter(m => m.morning);
                morningMeds.forEach(m => {
                    listEl.innerHTML += `<li><i class="fa-solid fa-pills"></i> <strong>${m.name}</strong> - ${m.instructions.split('•')[1] || m.instructions}</li>`;
                });
            } else if (timeSlot === 'afternoon') {
                titleEl.textContent = 'Afternoon Medication Queue (02:00 PM)';
                const afternoonMeds = currentMeds.filter(m => m.afternoon);
                afternoonMeds.forEach(m => {
                    listEl.innerHTML += `<li><i class="fa-solid fa-pills"></i> <strong>${m.name}</strong> - ${m.instructions.split('•')[1] || m.instructions}</li>`;
                });
            } else {
                titleEl.textContent = 'Night Medication Queue (09:00 PM)';
                const nightMeds = currentMeds.filter(m => m.night);
                nightMeds.forEach(m => {
                    listEl.innerHTML += `<li><i class="fa-solid fa-moon" style="color:var(--primary); margin-right:8px;"></i><strong>${m.name}</strong> - ${m.instructions.split('•')[1] || m.instructions}</li>`;
                });
            }
        }

        function loadDefaultSchedule() {
            const listEl = document.getElementById('focusScheduleList');
            if (listEl) {
                listEl.innerHTML = `
                    <li><i class="fa-solid fa-pills"></i> <strong>Telmisartan 40mg</strong> - 1 Tablet (Once Daily after Breakfast)</li>
                `;
            }
        }

        // Live Refill Request: Saves to MySQL database
        async function requestRefill(id, name) {
            if (confirm(`Send a digital refill request to Dr. Raj Patel for ${name}?`)) {
                const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
                const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

                const fd = new FormData();
                fd.append('patient_id', patientId);
                fd.append('patient_name', patientName);
                fd.append('medicine_id', id);
                fd.append('medicine_name', name);
                fd.append('doctor_name', 'Dr. Raj Patel');
                fd.append('action', 'request_refill');

                try {
                    const res = await fetch('api.php?action=request_refill', {
                        method: 'POST',
                        body: fd
                    });
                    const data = await res.json();
                    
                    if (!requestedMeds.includes(id)) {
                        requestedMeds.push(id);
                    }
                    renderMedications();

                    const toast = document.getElementById('successToast');
                    document.getElementById('toastMsg').textContent = data.message || `Refill requested successfully for ${name}!`;
                    toast.classList.add('show');
                    setTimeout(() => { toast.classList.remove('show'); }, 3000);

                } catch (err) {
                    console.error('Refill request error:', err);
                    if (!requestedMeds.includes(id)) requestedMeds.push(id);
                    renderMedications();
                }
            }
        }

        // Initial setup on ready
        document.addEventListener('DOMContentLoaded', () => {
            if (window.currentPatient) {
                const navName = document.getElementById('navPatientName');
                const navId = document.getElementById('navPatientId');
                const navAv = document.getElementById('navAvatar');
                const slipPatientName = document.getElementById('slipPatientName');
                if (navName) navName.innerHTML = `${window.currentPatient.name} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i>`;
                if (navId) navId.textContent = `Patient ID: ${window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001'}`;
                if (navAv) {
                    const initials = window.currentPatient.name.split(' ').filter(Boolean).map(n=>n[0]).join('').toUpperCase().substring(0, 2);
                    navAv.textContent = initials || 'AS';
                }
                if (slipPatientName) {
                    slipPatientName.textContent = `${window.currentPatient.name} (${window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001'})`;
                }
            }
            renderMedications();
            loadDefaultSchedule();
        });
    </script>
</body>

</html>
