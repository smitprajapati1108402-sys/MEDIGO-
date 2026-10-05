<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGo - My Lab Reports</title>
    <?php include 'patient_auth.php'; ?>
    <!-- FontAwesome for Premium Medical Icons -->
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
            --success: #10b981;
            --success-light: #ecfdf5;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
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

        /* Container & Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, #0a52a3 0%, #063162 100%);
            color: white;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 10px 20px rgba(10, 82, 163, 0.1);
        }

        .welcome-section h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .welcome-section p {
            font-size: 0.95rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.5;
        }

        /* Search & Filter Section */
        .filter-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 280px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            font-size: 0.9rem;
            background-color: #fafbfd;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            background-color: white;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .filter-select {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            background-color: var(--card-bg);
            cursor: pointer;
            outline: none;
            min-width: 180px;
        }

        /* Report Grid System */
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 20px;
        }

        .report-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s;
        }

        .report-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
            border-color: var(--primary);
        }

        .report-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .report-icon-container {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .report-icon-container.blood { background-color: var(--danger-light); color: var(--danger); }
        .report-icon-container.lipid { background-color: var(--warning-light); color: var(--warning); }
        .report-icon-container.cardio { background-color: var(--primary-light); color: var(--primary); }

        .report-status {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            background-color: var(--success-light);
            color: var(--success);
            text-transform: uppercase;
        }

        .report-body h3 {
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: var(--text-dark);
        }

        .report-body p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .report-meta-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            padding-top: 16px;
        }

        .btn-view-report {
            background-color: var(--primary-light);
            color: var(--primary);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-view-report:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Modal Overlay & Card styling */
        .modal {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(15, 23, 42, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
            padding: 16px;
        }

        .modal.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            padding: 28px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: scale(0.9);
            transition: transform 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 14px;
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        /* Clinical Report Table Inside Modal */
        .lab-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: left;
        }

        .lab-table th {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            padding: 10px 8px;
            border-bottom: 1px solid var(--border);
        }

        .lab-table td {
            font-size: 0.85rem;
            padding: 12px 8px;
            border-bottom: 1px solid var(--border);
        }

        .lab-table tr:last-child td {
            border-bottom: none;
        }

        .val-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .val-indicator.normal { background-color: var(--success); }
        .val-indicator.high { background-color: var(--danger); }
        .val-indicator.low { background-color: var(--warning); }

        .btn-download-pdf {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-download-pdf:hover {
            background-color: var(--primary-hover);
        }

        /* Success Toast */
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
            <li class="nav-item active">
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

    <!-- 2. Body -->
    <div class="container">
        <div class="welcome-section">
            <h1>My Medical Lab Reports</h1>
            <p>View and manage all verified blood, lipid, and other diagnostic laboratory reports prepared by your specialist doctors.</p>
        </div>

        <!-- Filter Card -->
        <div class="filter-card">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search report name or test parameters..." onkeyup="filterReports()">
            </div>
            <select class="filter-select" id="deptFilter" onchange="filterReports()">
                <option value="All">All Departments</option>
                <option value="Hematology">Hematology</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Biochemistry">Biochemistry</option>
            </select>
        </div>

        <!-- Grid of Reports -->
        <div class="report-grid" id="reportGrid">
            <!-- Report Card 1 -->
            <div class="report-card" data-name="Complete Blood Count (CBC) Hematology" data-dept="Hematology">
                <div>
                    <div class="report-header">
                        <div class="report-icon-container blood"><i class="fa-solid fa-droplet"></i></div>
                        <span class="report-status">Verified</span>
                    </div>
                    <div class="report-body">
                        <h3>Complete Blood Count (CBC)</h3>
                        <p>Measures red blood cells, white blood cells, platelets, and hemoglobin levels.</p>
                    </div>
                </div>
                <div class="report-meta-info">
                    <span>Verified: May 15, 2026</span>
                    <button class="btn-view-report" onclick="openReportModal('cbc')">View Detail</button>
                </div>
            </div>

            <!-- Report Card 2 -->
            <div class="report-card" data-name="Lipid Profile Panel Biochemistry Cholesterol" data-dept="Biochemistry">
                <div>
                    <div class="report-header">
                        <div class="report-icon-container lipid"><i class="fa-solid fa-flask-vial"></i></div>
                        <span class="report-status">Verified</span>
                    </div>
                    <div class="report-body">
                        <h3>Lipid Profile Panel</h3>
                        <p>Total Cholesterol, HDL, LDL, and Triglycerides levels checker.</p>
                    </div>
                </div>
                <div class="report-meta-info">
                    <span>Verified: Apr 22, 2026</span>
                    <button class="btn-view-report" onclick="openReportModal('lipid')">View Detail</button>
                </div>
            </div>

            <!-- Report Card 3 -->
            <div class="report-card" data-name="ECG Cardiac Test Cardiology Heart" data-dept="Cardiology">
                <div>
                    <div class="report-header">
                        <div class="report-icon-container cardio"><i class="fa-solid fa-heart-pulse"></i></div>
                        <span class="report-status">Verified</span>
                    </div>
                    <div class="report-body">
                        <h3>Electrocardiogram (ECG) Report</h3>
                        <p>Records the electrical signals in your heart to check for different cardiac conditions.</p>
                    </div>
                </div>
                <div class="report-meta-info">
                    <span>Verified: Mar 10, 2026</span>
                    <button class="btn-view-report" onclick="openReportModal('ecg')">View Detail</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Report Modal -->
    <div class="modal" id="reportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Report Details</h3>
                <button class="close-btn" onclick="closeReportModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div style="font-size: 0.85rem; display: flex; flex-direction: column; gap: 4px; margin-bottom: 20px; color: var(--text-muted);">
                <div><strong>Patient Name:</strong> <span id="modalPatientName">Arjun Sharma</span></div>
                <div><strong>Patient ID:</strong> <span id="modalPatientId">PAT-1001</span></div>
                <div id="modalDate"><strong>Date Verified:</strong> --</div>
                <div id="modalDept"><strong>Department:</strong> --</div>
            </div>

            <div id="modalReportContent">
                <!-- Dynamically populated report tables -->
            </div>

            <button class="btn-download-pdf" onclick="downloadPDF()"><i class="fa-solid fa-file-arrow-down"></i> Download PDF Report</button>
        </div>
    </div>

    <!-- Success Toast Notification -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>PDF report downloaded successfully!</span>
    </div>

    <script>
        const reportData = {
            cbc: {
                title: "Complete Blood Count (CBC)",
                date: "May 15, 2026",
                dept: "Hematology",
                tests: [
                    { name: "Hemoglobin", value: "14.2 g/dL", range: "13.5 - 17.5 g/dL", status: "normal" },
                    { name: "White Blood Cell (WBC)", value: "6.5 x10^3/uL", range: "4.5 - 11.0 x10^3/uL", status: "normal" },
                    { name: "Red Blood Cell (RBC)", value: "4.8 x10^6/uL", range: "4.3 - 5.9 x10^6/uL", status: "normal" },
                    { name: "Platelets", value: "245 x10^3/uL", range: "150 - 450 x10^3/uL", status: "normal" }
                ]
            },
            lipid: {
                title: "Lipid Profile Panel",
                date: "Apr 22, 2026",
                dept: "Biochemistry",
                tests: [
                    { name: "Total Cholesterol", value: "210 mg/dL", range: "< 200 mg/dL", status: "high" },
                    { name: "HDL Cholesterol", value: "48 mg/dL", range: "> 40 mg/dL", status: "normal" },
                    { name: "LDL Cholesterol", value: "135 mg/dL", range: "< 100 mg/dL", status: "high" },
                    { name: "Triglycerides", value: "145 mg/dL", range: "< 150 mg/dL", status: "normal" }
                ]
            },
            ecg: {
                title: "Electrocardiogram (ECG) Report",
                date: "Mar 10, 2026",
                dept: "Cardiology",
                tests: [
                    { name: "Heart Rate", value: "72 BPM", range: "60 - 100 BPM", status: "normal" },
                    { name: "PR Interval", value: "160 ms", range: "120 - 200 ms", status: "normal" },
                    { name: "QRS Duration", value: "95 ms", range: "80 - 120 ms", status: "normal" },
                    { name: "ECG Finding Summary", value: "Normal Sinus Rhythm", range: "Normal signals", status: "normal" }
                ]
            }
        };

        function filterReports() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const dept = document.getElementById('deptFilter').value;

            document.querySelectorAll('.report-card').forEach(card => {
                const cardName = card.getAttribute('data-name').toLowerCase();
                const cardDept = card.getAttribute('data-dept');

                const matchesQuery = cardName.includes(query);
                const matchesDept = (dept === 'All' || cardDept === dept);

                if (matchesQuery && matchesDept) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function openReportModal(key) {
            const data = reportData[key];
            if (!data) return;

            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalDate').innerHTML = `<strong>Date Verified:</strong> ${data.date}`;
            document.getElementById('modalDept').innerHTML = `<strong>Department:</strong> ${data.dept}`;

            if (window.currentPatient) {
                document.getElementById('modalPatientName').textContent = window.currentPatient.name;
                document.getElementById('modalPatientId').textContent = window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001';
            }

            let contentHtml = `
                <table class="lab-table">
                    <thead>
                        <tr>
                            <th>Test Parameter</th>
                            <th>Observed Value</th>
                            <th>Reference Range</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.tests.forEach(test => {
                contentHtml += `
                    <tr>
                        <td><strong>${test.name}</strong></td>
                        <td>${test.value}</td>
                        <td>${test.range}</td>
                        <td>
                            <span class="val-indicator ${test.status}"></span>
                            <span style="font-weight: 700; text-transform: capitalize; color: var(--${test.status === 'normal' ? 'success' : test.status === 'high' ? 'danger' : 'warning'});">
                                ${test.status}
                            </span>
                        </td>
                    </tr>
                `;
            });

            contentHtml += `
                    </tbody>
                </table>
            `;

            document.getElementById('modalReportContent').innerHTML = contentHtml;
            document.getElementById('reportModal').classList.add('active');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.remove('active');
        }

        function downloadPDF() {
            const toast = document.getElementById('successToast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        window.onclick = function (event) {
            const modal = document.getElementById('reportModal');
            if (event.target === modal) {
                closeReportModal();
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            if (window.currentPatient) {
                const navName = document.getElementById('navPatientName');
                const navId = document.getElementById('navPatientId');
                const navAv = document.getElementById('navAvatar');
                const modalPatientName = document.getElementById('modalPatientName');
                const modalPatientId = document.getElementById('modalPatientId');
                if (navName) navName.innerHTML = `${window.currentPatient.name} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i>`;
                if (navId) navId.textContent = `Patient ID: ${window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001'}`;
                if (navAv) {
                    const initials = window.currentPatient.name.split(' ').filter(Boolean).map(n=>n[0]).join('').toUpperCase().substring(0, 2);
                    navAv.textContent = initials || 'AS';
                }
                if (modalPatientName) modalPatientName.textContent = window.currentPatient.name;
                if (modalPatientId) modalPatientId.textContent = window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001';
            }
        });
    </script>
</body>

</html>
