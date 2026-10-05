<?php
require_once 'db_connect.php';

$server_upcoming = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `appointments` WHERE `status` != 'Cancelled' ORDER BY `appointment_date` ASC, `appointment_time` ASC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_upcoming[] = [
                'id' => $r['apt_id'] ?? $r['id'] ?? 'APT-001',
                'patientName' => $r['patient_name'] ?? 'Patient',
                'phone' => $r['patient_phone'] ?? '+91 98765 43210',
                'datetime' => ($r['appointment_date'] ?? date('Y-m-d')) . ' - ' . ($r['appointment_time'] ?? '09:30 AM'),
                'type' => $r['type'] ?? $r['appointment_type'] ?? 'Regular Checkup',
                'method' => $r['method'] ?? 'Offline',
                'status' => $r['status'] ?? 'Confirmed'
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
    <title>MediCare - Upcoming Appointments</title>
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

        .brand i { font-size: 1.6rem; }

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

        .nav-item:hover .dropdown { display: flex; }

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

        .dropdown li a i { color: var(--primary); width: 16px; }

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

        .user-info .name { font-size: 0.88rem; font-weight: 700; }
        .user-info .spec { font-size: 0.78rem; color: rgba(255, 255, 255, 0.75); }

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

        /* Stats Blocks Row */
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
        .stat-icon.orange { background-color: var(--warning-light); color: var(--warning); }
        .stat-icon.red { background-color: var(--danger-light); color: var(--danger); }

        .stat-data { display: flex; flex-direction: column; }
        .stat-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
        .stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-main); }

        /* 3. Main Filter & Table Card */
        .appointments-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

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
        }

        .search-box i {
            position: absolute; left: 15px; top: 50%;
            transform: translateY(-50%); color: var(--text-muted);
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            background-color: var(--card-bg);
            cursor: pointer;
        }

        /* Appointments Table styling */
        .table-responsive { width: 100%; overflow-x: auto; }
        .appt-table { width: 100%; border-collapse: collapse; text-align: left; }

        .appt-table th {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .appt-table td {
            font-size: 0.88rem;
            padding: 16px 16px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .appt-table tr:hover { background-color: #fafbfc; }

        .td-appt-id { font-weight: 700; color: var(--text-muted); }
        .td-patient { font-weight: 700; color: var(--text-main); }
        .td-time { font-weight: 700; color: var(--primary); }

        /* Dynamic Status Pills */
        .status-pill {
            font-size: 0.72rem; font-weight: 700; padding: 4px 10px;
            border-radius: 50px; display: inline-block;
        }
        .status-pill.confirmed { background-color: var(--success-light); color: var(--success); }
        .status-pill.pending { background-color: var(--warning-light); color: var(--warning); }
        .status-pill.cancelled { background-color: var(--danger-light); color: var(--danger); }

        /* Actions Buttons */
        .action-btns { display: flex; gap: 8px; }

        .btn-action {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            background-color: white;
            transition: all 0.2s;
        }
        .btn-action.confirm { border-color: var(--success); color: var(--success); }
        .btn-action.confirm:hover { background-color: var(--success); color: white; }
        .btn-action.cancel { border-color: var(--danger); color: var(--danger); }
        .btn-action.cancel:hover { background-color: var(--danger); color: white; }
        .btn-action.reschedule { border-color: var(--warning); color: var(--warning); }
        .btn-action.reschedule:hover { background-color: var(--warning); color: white; }

        /* Toast */
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

    <!-- 1. Navbar -->
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
                <li class="nav-item active">
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

    <!-- 2. Main Wrapper -->
    <div class="wrapper">
        <div class="page-header">
            <div>
                <h1>Upcoming Appointments</h1>
                <p>View and manage your future clinical consultations.</p>
            </div>
        </div>

        <!-- Metrics Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Total Appointments</span>
                    <span class="stat-value" id="stat-total">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Confirmed Bookings</span>
                    <span class="stat-value" id="stat-confirmed">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fa-solid fa-spinner"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Pending Reviews</span>
                    <span class="stat-value" id="stat-pending">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i class="fa-solid fa-calendar-xmark"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Cancelled Slots</span>
                    <span class="stat-value" id="stat-cancelled">0</span>
                </div>
            </div>
        </div>

        <!-- Main Card Section -->
        <div class="appointments-card">
            <!-- Filter Options -->
            <div class="filter-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search by Appt ID, Patient, Diagnosis..." onkeyup="filterAppts()">
                </div>
                <select class="filter-select" id="statusFilter" onchange="filterAppts()">
                    <option value="All">All Statuses</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Table Responsive -->
            <div class="table-responsive">
                <table class="appt-table">
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Date & Time</th>
                            <th>Type of Visit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="apptTableBody">
                        <!-- Loaded dynamically via LocalStorage database -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toast Notification Success Popup -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span id="toastMsg">Appointment successfully booked!</span>
    </div>

    <script>
        // Server pre-rendered upcoming appointments from MySQL
        const serverUpcomingAppts = <?php echo json_encode($server_upcoming ?? []); ?>;

        const defaultAppts = [
            { id: "APT-1092", patientName: "Arjun Sharma", datetime: "09 Jun 2026 - 09:30 AM", type: "Regular Checkup", method: "Offline", status: "Confirmed" },
            { id: "APT-4820", patientName: "Priya Verma", datetime: "09 Jun 2026 - 10:15 AM", type: "Follow-up", method: "Online", status: "Confirmed" },
            { id: "APT-9931", patientName: "Amit Shah", datetime: "09 Jun 2026 - 11:00 AM", type: "Emergency Consultation", method: "Offline", status: "Confirmed" },
            { id: "APT-2248", patientName: "Rohan Gupta", datetime: "10 Jun 2026 - 12:30 PM", type: "Regular Checkup", method: "Offline", status: "Pending" },
            { id: "APT-5012", patientName: "Rahul Sharma", datetime: "10 Jun 2026 - 02:00 PM", type: "Viral Fever Checkup", method: "Offline", status: "Pending" }
        ];

        let localApptsCache = [];

        // Fetch Live Appointments from MySQL via api.php
        async function fetchLiveAppointments() {
            try {
                const response = await fetch('api.php?action=get_appointments&filter=upcoming');
                const result = await response.json();
                if (result.success && Array.isArray(result.appointments) && result.appointments.length > 0) {
                    localApptsCache = result.appointments;
                    localStorage.setItem('medigo_appts', JSON.stringify(localApptsCache));
                    renderAppointments();
                    return;
                }
            } catch (err) {
                console.warn("MySQL live fetch error, using local/server dataset:", err);
            }

            if (serverUpcomingAppts && serverUpcomingAppts.length > 0) {
                localApptsCache = serverUpcomingAppts;
            } else {
                let db = localStorage.getItem('medigo_appts');
                if (db) {
                    localApptsCache = JSON.parse(db);
                } else {
                    localApptsCache = defaultAppts;
                }
            }
            renderAppointments();
        }

        // Render Database Records to HTML
        function renderAppointments() {
            const tbody = document.getElementById('apptTableBody');
            tbody.innerHTML = '';

            const searchVal = document.getElementById('searchInput').value.toLowerCase();
            const statusVal = document.getElementById('statusFilter').value;

            let displayedAppts = localApptsCache.filter(appt => {
                const name = (appt.patientName || appt.patient || '').toLowerCase();
                const id = (appt.id || appt.apt_id || '').toLowerCase();
                const dt = (appt.datetime || '').toLowerCase();
                const type = (appt.type || '').toLowerCase();

                const matchesSearch = id.includes(searchVal) || name.includes(searchVal) || dt.includes(searchVal) || type.includes(searchVal);
                const matchesStatus = (statusVal === 'All') || (appt.status === statusVal);
                return matchesSearch && matchesStatus;
            });

            if (displayedAppts.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding:32px; color:var(--text-muted);">
                    <i class="fa-solid fa-calendar-xmark" style="font-size:2rem; margin-bottom:8px; display:block; opacity:0.5;"></i>
                    No upcoming appointments found matching your filters.
                </td></tr>`;
                updateStats(localApptsCache);
                return;
            }

            displayedAppts.forEach((appt, idx) => {
                const tr = document.createElement('tr');
                const apptId = appt.id || appt.apt_id;
                const pName = appt.patientName || appt.patient;
                const pTime = appt.datetime || (appt.date + ' - ' + appt.time);

                tr.innerHTML = `
                    <td class="td-appt-id">${apptId}</td>
                    <td class="td-patient">${pName}</td>
                    <td class="td-time">${pTime}</td>
                    <td>
                        <div>${appt.type || 'General Checkup'}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                            <i class="${appt.method === 'Online' ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> ${appt.method || 'Offline'}
                        </div>
                    </td>
                    <td><span class="status-pill ${(appt.status || '').toLowerCase()}">${appt.status}</span></td>
                    <td>
                        <div class="action-btns">
                            ${appt.status === 'Pending' ? `<button class="btn-action confirm" onclick="changeStatus('${apptId}', 'Confirmed')"><i class="fa-solid fa-check"></i> Confirm</button>` : ''}
                            ${appt.status !== 'Cancelled' ? `<button class="btn-action cancel" onclick="changeStatus('${apptId}', 'Cancelled')"><i class="fa-solid fa-xmark"></i> Cancel</button>` : ''}
                            <button class="btn-action reschedule" onclick="rescheduleAppt('${apptId}')"><i class="fa-regular fa-clock"></i> Reschedule</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updateStats(localApptsCache);
        }

        // Update Stat counter values
        function updateStats(appts) {
            let total = appts.length;
            let confirmed = 0;
            let pending = 0;
            let cancelled = 0;

            appts.forEach(appt => {
                if (appt.status === 'Confirmed') confirmed++;
                else if (appt.status === 'Pending') pending++;
                else if (appt.status === 'Cancelled') cancelled++;
            });

            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-confirmed').textContent = confirmed;
            document.getElementById('stat-pending').textContent = pending;
            document.getElementById('stat-cancelled').textContent = cancelled;
        }

        // Modify Status Transitions (Confirm / Cancel) with MySQL API
        async function changeStatus(aptId, newStatus) {
            // Update local memory and localStorage
            const target = localApptsCache.find(a => (a.id || a.apt_id) === aptId);
            if (target) {
                target.status = newStatus;
                localStorage.setItem('medigo_appts', JSON.stringify(localApptsCache));
                renderAppointments();
            }

            // Sync with MySQL Database
            try {
                const formData = new FormData();
                formData.append('apt_id', aptId);
                formData.append('status', newStatus);

                const res = await fetch('api.php?action=update_appointment_status', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
                if (result.success) {
                    triggerToast(`Appointment ${aptId} marked as ${newStatus} in Database!`);
                } else {
                    triggerToast(`Updated locally: ${result.message}`);
                }
            } catch (e) {
                triggerToast(`Status changed to ${newStatus} (Saved locally)`);
            }
        }

        // Reschedule Option (Sync with MySQL Database)
        async function rescheduleAppt(aptId) {
            const target = localApptsCache.find(a => (a.id || a.apt_id) === aptId);
            const currentDt = target ? (target.datetime || '') : '';
            const newDate = prompt("Enter new Date (YYYY-MM-DD or DD Mon YYYY):", currentDt.split(' - ')[0] || "2026-06-15");
            const newTime = prompt("Enter new Time Slot (e.g., 03:30 PM):", currentDt.split(' - ')[1] || "03:30 PM");

            if (newDate && newTime) {
                const newDtStr = `${newDate} - ${newTime}`;
                if (target) {
                    target.datetime = newDtStr;
                    target.status = 'Pending';
                    localStorage.setItem('medigo_appts', JSON.stringify(localApptsCache));
                    renderAppointments();
                }

                // Sync with MySQL Database
                try {
                    const formData = new FormData();
                    formData.append('apt_id', aptId);
                    formData.append('status', 'Pending');
                    formData.append('datetime', newDtStr);

                    const res = await fetch('api.php?action=update_appointment_status', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await res.json();
                    if (result.success) {
                        triggerToast(`Appointment rescheduled to ${newDtStr} in MySQL!`);
                    } else {
                        triggerToast("Rescheduled locally");
                    }
                } catch (e) {
                    triggerToast("Rescheduled locally");
                }
            }
        }

        // Trigger Toast notifications
        function triggerToast(message) {
            const toast = document.getElementById('successToast');
            document.getElementById('toastMsg').textContent = message;
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 2500);
        }

        // Dynamic Filtering on input keys
        function filterAppts() {
            renderAppointments();
        }

        // Initial setup trigger
        document.addEventListener('DOMContentLoaded', fetchLiveAppointments);
    </script>
</body>

</html>
