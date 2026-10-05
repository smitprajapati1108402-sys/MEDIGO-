<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - Patient Health History</title>
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
            --bg-color: #f4f7fc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
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
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--info-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* 2. Main Portal Wrapper */
        .wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }

        /* Page header info */
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .history-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .history-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Health Metrics tracker cards */
        .vitals-summary-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (max-width: 1024px) {
            .vitals-summary-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .vital-summary-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .vital-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .vital-icon.red { background-color: var(--danger-light); color: var(--danger); }
        .vital-icon.blue { background-color: var(--info-light); color: var(--info); }
        .vital-icon.green { background-color: var(--success-light); color: var(--success); }
        .vital-icon.orange { background-color: var(--warning-light); color: var(--warning); }

        .vital-details { display: flex; flex-direction: column; }
        .vital-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
        .vital-value { font-size: 1.15rem; font-weight: 800; color: var(--text-main); margin-top: 2px; }

        /* Split Workspace Columns */
        .workspace-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .workspace-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Generic Panel Cards */
        .portal-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .card-header {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header i { color: var(--primary); }

        /* Medical Vertical Timeline style */
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

        .timeline-item:last-child { margin-bottom: 0; }

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
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .timeline-doctor-tag {
            font-size: 0.7rem;
            font-weight: 700;
            background-color: var(--info-light);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 50px;
            display: inline-block;
        }

        /* Prescriptions list table */
        .table-responsive { width: 100%; overflow-x: auto; }
        .history-table { width: 100%; border-collapse: collapse; text-align: left; }

        .history-table th {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .history-table td {
            font-size: 0.85rem;
            padding: 14px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .history-table tr:last-child td { border-bottom: none; }

        .td-med-name { font-weight: 700; color: var(--text-main); }
        
        .badge-pill {
            font-size: 0.7rem; font-weight: 700; padding: 2px 8px;
            border-radius: 50px; display: inline-block;
        }
        .badge-pill.active { background-color: var(--success-light); color: var(--success); }
        .badge-pill.completed { background-color: #f1f5f9; color: var(--text-muted); }

        /* Patient Profile Details Card */
        .profile-summary-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
            margin-bottom: 24px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .profile-avatar-large {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background-color: var(--info-light);
            color: var(--info);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .profile-title h3 { font-size: 1.05rem; font-weight: 800; }
        .profile-title p { font-size: 0.78rem; color: var(--text-muted); }

        .metadata-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .metadata-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .metadata-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .metadata-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-main);
        }
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
            <li class="nav-item active">
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

    <!-- 2. Main Portal Body -->
    <div class="wrapper">

        <!-- History Title row -->
        <div class="history-header">
            <div>
                <h1>My Health Case Records</h1>
                <p>Access your lifetime secure clinical files, doctor checkup timeline, and prescription summaries.</p>
            </div>
        </div>

        <!-- Health Vitals summary cards tracker -->
        <div class="vitals-summary-row">
            <div class="vital-summary-card">
                <div class="vital-icon red"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="vital-details">
                    <span class="vital-label">Last Blood Pressure</span>
                    <span class="vital-value">130/80 mmHg</span>
                </div>
            </div>
            <div class="vital-summary-card">
                <div class="vital-icon blue"><i class="fa-solid fa-gauge-high"></i></div>
                <div class="vital-details">
                    <span class="vital-label">Average Pulse Rate</span>
                    <span class="vital-value">76 BPM</span>
                </div>
            </div>
            <div class="vital-summary-card">
                <div class="vital-icon green"><i class="fa-solid fa-flask-vial"></i></div>
                <div class="vital-details">
                    <span class="vital-label">Blood Glucose (HbA1c)</span>
                    <span class="vital-value">5.8% (Normal)</span>
                </div>
            </div>
            <div class="vital-summary-card">
                <div class="vital-icon orange"><i class="fa-solid fa-weight-scale"></i></div>
                <div class="vital-details">
                    <span class="vital-label">Body Mass Index (BMI)</span>
                    <span class="vital-value">25.2 (Overweight)</span>
                </div>
            </div>
        </div>

        <!-- Two Column Workspace Layout Grid -->
        <div class="workspace-grid">

            <!-- Left Side Column: Doctor Consultation Timeline -->
            <div class="portal-card">
                <div class="card-header">
                    <i class="fa-solid fa-file-waveform"></i> My Visit Consultation Case Files
                </div>

                <div class="timeline-container">
                    <!-- Timeline visit 1 -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-date">15 May 2026 &bull; Follow-up Visit</span>
                            <h4>Regular Cardiology Review Checkup</h4>
                            <p>Blood pressure stabilized under regular drug regime (Telmisartan). Heart rate is regular, and lungs are clear. Instructed to maintain morning low-sodium diet and daily walking sessions.</p>
                            <span class="timeline-doctor-tag"><i class="fa-solid fa-user-doctor"></i> Dr. Raj Patel</span>
                            <span style="font-size: 0.7rem; font-weight: 700; background-color: var(--primary-light); color: var(--primary); padding: 4px 10px; border-radius: 50px; display: inline-block; margin-left: 8px;"><i class="fa-solid fa-building"></i> Offline (In-Person)</span>
                        </div>
                    </div>

                    <!-- Timeline visit 2 (Emergency visit) -->
                    <div class="timeline-item emergency">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-date">10 Apr 2026 &bull; Emergency Intake</span>
                            <h4>Acute Hypertensive crisis & Migraine Spike</h4>
                            <p>Admitted to emergency care unit with blood pressure elevated to 160/95 and severe headache. Administered immediate Amlodipine tablet. BP successfully controlled within 4 hours. Discharged in stable condition.</p>
                            <span class="timeline-doctor-tag"><i class="fa-solid fa-user-doctor"></i> Dr. Raj Patel</span>
                            <span style="font-size: 0.7rem; font-weight: 700; background-color: var(--danger-light); color: var(--danger); padding: 4px 10px; border-radius: 50px; display: inline-block; margin-left: 8px;"><i class="fa-solid fa-building"></i> Offline (In-Person)</span>
                        </div>
                    </div>

                    <!-- Timeline visit 3 -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <span class="timeline-date">12 Mar 2026 &bull; Initial Visit</span>
                            <h4>Primary Cardiology Assessment</h4>
                            <p>Referred after continuous elevated blood pressure readings at home. Completed routine ECG which confirmed normal cardiac activity. Prescribed hypertensive prophylactic dose and strict dietary limits.</p>
                            <span class="timeline-doctor-tag"><i class="fa-solid fa-user-doctor"></i> Dr. Raj Patel</span>
                            <span style="font-size: 0.7rem; font-weight: 700; background-color: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 50px; display: inline-block; margin-left: 8px;"><i class="fa-solid fa-video"></i> Online (Video Call)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column Sidebar Info -->
            <div>
                <!-- Card 1: Patient Profile Credentials Info -->
                <div class="profile-summary-card">
                    <div class="profile-header">
                        <div class="profile-avatar-large" id="profileAvatarLarge">AS</div>
                        <div class="profile-title">
                            <h3 id="profileName">Arjun Sharma</h3>
                            <p>PATIENT ID: <strong style="color: var(--primary);" id="profileId">PAT-1001</strong></p>
                        </div>
                    </div>

                    <div class="metadata-grid">
                        <div class="metadata-item">
                            <span class="metadata-label">Age / Gender</span>
                            <span class="metadata-value" id="profileAgeGender">45 Years / Male</span>
                        </div>
                        <div class="metadata-item">
                            <span class="metadata-label">Blood Group</span>
                            <span class="metadata-value" id="profileBlood">O+ (Positive)</span>
                        </div>
                        <div class="metadata-item">
                            <span class="metadata-label">Allergies Info</span>
                            <span class="metadata-value" style="color: var(--danger); font-weight: 700;">Dust & Penicillin</span>
                        </div>
                        <div class="metadata-item">
                            <span class="metadata-label">Emergency Contact</span>
                            <span class="metadata-value">+91 98711 22334</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Prescriptions Active Medication Directory -->
                <div class="portal-card">
                    <div class="card-header">
                        <i class="fa-solid fa-prescription-bottle-medical"></i> Active Medication Directory
                    </div>

                    <div class="table-responsive">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Instructions</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="td-med-name">Telmisartan 40mg</td>
                                    <td>1 Tab &bull; Once Daily (Morning)</td>
                                    <td>3 Months</td>
                                    <td><span class="badge-pill active">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="td-med-name">Amlodipine 5mg</td>
                                    <td>1 Tab &bull; Once Daily (Night)</td>
                                    <td>1 Month</td>
                                    <td><span class="badge-pill active">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="td-med-name">Paracetamol 650mg</td>
                                    <td>1 Tab &bull; Once Daily (When needed)</td>
                                    <td>5 Days</td>
                                    <td><span class="badge-pill completed">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

            if (window.currentPatient) {
                const profileAvatar = document.getElementById('profileAvatarLarge');
                if (profileAvatar) {
                    const initials = window.currentPatient.name.split(' ').filter(Boolean).map(n => n[0]).join('').toUpperCase().substring(0, 2);
                    profileAvatar.textContent = initials || 'PT';
                }
                const profileName = document.getElementById('profileName');
                if (profileName) {
                    profileName.textContent = window.currentPatient.name;
                }
                const profileId = document.getElementById('profileId');
                if (profileId) {
                    profileId.textContent = patientId;
                }
                const profileAgeGender = document.getElementById('profileAgeGender');
                if (profileAgeGender) {
                    const age = window.currentPatient.age || '45 Yrs';
                    const gender = window.currentPatient.gender || 'Male';
                    profileAgeGender.textContent = `${age} / ${gender}`;
                }
                const profileBlood = document.getElementById('profileBlood');
                if (profileBlood) {
                    const blood = window.currentPatient.bloodType || window.currentPatient.blood_group || 'O+';
                    profileBlood.textContent = `${blood} (Positive)`;
                }
            }

            // 1. Fetch live vitals from MySQL
            try {
                const vRes = await fetch(`api.php?action=get_vitals&patient_id=${encodeURIComponent(patientId)}`);
                const vData = await vRes.json();
                if (vData.status === 'success' && vData.data) {
                    const vCards = document.querySelectorAll('.vital-summary-card .vital-value');
                    if (vCards.length >= 4) {
                        vCards[0].textContent = `${vData.data.bp || '120/80'} mmHg`;
                        vCards[1].textContent = `${vData.data.heart || 72} BPM`;
                        vCards[2].textContent = `${vData.data.sugar || 98} mg/dL (Normal)`;
                        vCards[3].textContent = `${vData.data.bmi || 22.4} (Healthy)`;
                    }
                }
            } catch (e) {
                console.warn('Vitals load:', e);
            }

            // 2. Fetch live appointments timeline from MySQL
            try {
                const aRes = await fetch(`api.php?action=get_appointments&patient_id=${encodeURIComponent(patientId)}&patient_name=${encodeURIComponent(patientName)}`);
                const aData = await aRes.json();
                if (aData.status === 'success' && Array.isArray(aData.data) && aData.data.length > 0) {
                    const timelineCont = document.querySelector('.timeline-container');
                    if (timelineCont) {
                        timelineCont.innerHTML = '';
                        aData.data.forEach((appt, idx) => {
                            const isEmerg = appt.reason && (appt.reason.toLowerCase().includes('emergency') || appt.reason.toLowerCase().includes('crisis'));
                            const dt = appt.datetime || (appt.appointment_date + ' • ' + appt.appointment_time);
                            const doc = appt.type || appt.doctor_name || 'Dr. Raj Patel';
                            const reason = appt.reason || appt.symptoms || 'Regular Medical Consultation and evaluation';
                            const method = appt.method || 'Offline';
                            const isOnline = method === 'Online';

                            const itemHtml = `
                                <div class="timeline-item ${isEmerg ? 'emergency' : ''}">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <span class="timeline-date">${dt}</span>
                                        <h4>${isEmerg ? 'Emergency Consultation' : 'Clinical Consultation Review'}</h4>
                                        <p>${reason}</p>
                                        <span class="timeline-doctor-tag"><i class="fa-solid fa-user-doctor"></i> ${doc}</span>
                                        <span style="font-size: 0.7rem; font-weight: 700; background-color: ${isOnline ? 'var(--success-light)' : 'var(--primary-light)'}; color: ${isOnline ? 'var(--success)' : 'var(--primary)'}; padding: 4px 10px; border-radius: 50px; display: inline-block; margin-left: 8px;">
                                            <i class="${isOnline ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> ${isOnline ? 'Online (Video Call)' : 'Offline (In-Person)'}
                                        </span>
                                    </div>
                                </div>
                            `;
                            timelineCont.insertAdjacentHTML('beforeend', itemHtml);
                        });
                    }
                }
            } catch (e) {
                console.warn('Timeline load:', e);
            }
        });
    </script>
</body>

</html>
