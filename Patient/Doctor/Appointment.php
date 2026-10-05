<?php
require_once 'db_connect.php';

$server_appts = [];
if (!empty($db_connected) && !empty($conn)) {
    $a_res = mysqli_query($conn, "SELECT * FROM `appointments` ORDER BY `appointment_date` ASC, `appointment_time` ASC");
    if ($a_res) {
        while ($row = mysqli_fetch_assoc($a_res)) {
            $p_name = $row['patient_name'] ?? 'Patient';
            $server_appts[] = [
                'id' => $row['apt_id'] ?? $row['id'] ?? 'APT-001',
                'db_id' => $row['id'] ?? 1,
                'patient' => $p_name,
                'patientName' => $p_name,
                'phone' => $row['patient_phone'] ?? '+91 98765 43210',
                'datetime' => ($row['appointment_date'] ?? date('Y-m-d')) . ' - ' . ($row['appointment_time'] ?? '09:30 AM'),
                'date' => $row['appointment_date'] ?? date('Y-m-d'),
                'time' => $row['appointment_time'] ?? '09:30 AM',
                'type' => $row['type'] ?? $row['appointment_type'] ?? 'Regular Checkup',
                'method' => $row['method'] ?? 'Offline',
                'status' => $row['status'] ?? 'Confirmed'
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
    <title>MediCare - Appointments Dashboard</title>
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

        /* 1. Header & Navigation (Consistent style) */
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

        .btn-schedule {
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

        .btn-schedule:hover { background-color: var(--primary-hover); }

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

        /* Modal Structure */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
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
            max-width: 500px;
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

        .modal-header h3 { font-size: 1.15rem; font-weight: 700; }
        .modal-header .close-btn {
            background: none; border: none; color: white;
            font-size: 1.25rem; cursor: pointer; opacity: 0.8;
        }
        .modal-header .close-btn:hover { opacity: 1; }

        .modal-body { padding: 24px; }

        .form-group {
            display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px;
        }

        .form-group label { font-size: 0.8rem; font-weight: 700; color: var(--text-main); }
        .form-group input, .form-group select {
            padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 8px;
            outline: none; font-size: 0.88rem;
        }
        .form-group input:focus, .form-group select:focus { border-color: var(--primary); }

        .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding-top: 8px; }
        .btn-modal-cancel { background-color: #f1f5f9; color: var(--text-muted); border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .btn-modal-save { background-color: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; }

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
                <h1>Appointments Directory</h1>
                <p>Manage, schedule, and configure clinical consultations and daily bookings.</p>
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

    <!-- 4. Schedule New Appointment Modal -->
    <div class="modal" id="scheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Schedule New Appointment</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm" onsubmit="saveAppointment(event)">
                    <div class="form-group">
                        <label for="patSelector">Select Patient Name *</label>
                        <input type="text" id="patSelector" required placeholder="Type patient name or select..." list="patList" autocomplete="off">
                        <datalist id="patList">
                            <option value="Arjun Sharma">Arjun Sharma</option>
                            <option value="Priya Verma">Priya Verma</option>
                            <option value="Rohan Gupta">Rohan Gupta</option>
                            <option value="Rahul Sharma">Rahul Sharma</option>
                            <option value="Amit Shah">Amit Shah</option>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="apptDate">Appointment Date *</label>
                        <input type="date" id="apptDate" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" onchange="onDateChange()">
                    </div>
                    <div class="form-group">
                        <label for="apptTime">Time Slot *</label>
                        <select id="apptTime" required>
                            <option value="09:30 AM">09:30 AM</option>
                            <option value="10:15 AM">10:15 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:30 PM">12:30 PM</option>
                            <option value="02:00 PM">02:00 PM</option>
                            <option value="03:30 PM">03:30 PM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="visitType">Type of Visit *</label>
                        <select id="visitType" required>
                            <option value="Regular Checkup">Regular Checkup</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Emergency Consultation">Emergency Consultation</option>
                            <option value="ECG Test Diagnostics">ECG Test Diagnostics</option>
                            <option value="Chronic Case Review">Chronic Case Review</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="meetingType">Consultation Mode *</label>
                        <select id="meetingType" class="form-control" required>
                            <option value="Online">Online (Video Call)</option>
                            <option value="Offline" selected>Offline (In-Person)</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-modal-save">Book Slot</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification Success Popup -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span id="toastMsg">Appointment successfully booked!</span>
    </div>

    <script>
        // Default Mock Data for initialization
        const defaultAppts = [
            { id: "APT-1092", patientName: "Arjun Sharma", datetime: "09 Jun 2026 - 09:30 AM", type: "Regular Checkup", method: "Offline", status: "Confirmed" },
            { id: "APT-4820", patientName: "Priya Verma", datetime: "09 Jun 2026 - 10:15 AM", type: "Follow-up", method: "Online", status: "Confirmed" },
            { id: "APT-9931", patientName: "Amit Shah", datetime: "09 Jun 2026 - 11:00 AM", type: "Emergency Consultation", method: "Offline", status: "Confirmed" },
            { id: "APT-2248", patientName: "Rohan Gupta", datetime: "10 Jun 2026 - 12:30 PM", type: "Regular Checkup", method: "Offline", status: "Pending" },
            { id: "APT-5012", patientName: "Rahul Sharma", datetime: "10 Jun 2026 - 02:00 PM", type: "Viral Fever Checkup", method: "Offline", status: "Pending" }
        ];

        const serverInjectedAppts = <?php echo json_encode($server_appts); ?>;
        let globalAppts = (serverInjectedAppts && serverInjectedAppts.length > 0) ? serverInjectedAppts : defaultAppts;

        // Retrieve or Initialize LocalStorage Database
        function getDatabase() {
            return globalAppts;
        }

        async function fetchLiveAppointments() {
            try {
                const response = await fetch('api.php?action=get_appointments');
                const res = await response.json();
                if (res.success && res.appointments && res.appointments.length > 0) {
                    globalAppts = res.appointments;
                    localStorage.setItem('medigo_appts', JSON.stringify(globalAppts));
                    renderAppointments();
                    return;
                }
            } catch(e) {
                console.warn('API get_appointments fallback:', e);
            }
            try {
                let db = localStorage.getItem('medigo_appts');
                if (db) globalAppts = JSON.parse(db);
            } catch(e){}
            renderAppointments();
        }

        // Render Database Records to HTML
        function renderAppointments() {
            const appts = getDatabase();
            const tbody = document.getElementById('apptTableBody');
            tbody.innerHTML = '';

            const urlParams = new URLSearchParams(window.location.search);
            const filterParam = urlParams.get('filter'); // 'today', 'upcoming', 'cancelled'

            const pageTitleEl = document.querySelector('.page-header h1');
            const pageSubEl = document.querySelector('.page-header p');

            if (filterParam === 'today') {
                if (pageTitleEl) pageTitleEl.textContent = "Today's Appointments";
                if (pageSubEl) pageSubEl.textContent = "View and manage appointments scheduled for today.";
            } else if (filterParam === 'upcoming') {
                if (pageTitleEl) pageTitleEl.textContent = "Upcoming Appointments";
                if (pageSubEl) pageSubEl.textContent = "View and manage your future clinical consultations.";
            } else if (filterParam === 'cancelled') {
                if (pageTitleEl) pageTitleEl.textContent = "Cancelled Appointments";
                if (pageSubEl) pageSubEl.textContent = "Review cancelled clinical slots and historical bookings.";
            }

            let filteredAppts = appts;
            const today = new Date();
            today.setHours(0,0,0,0);

            if (filterParam === 'today') {
                filteredAppts = appts.filter(appt => {
                    if (appt.status === 'Cancelled') return false;
                    const datePart = appt.datetime.split(" - ")[0];
                    const apptDate = new Date(datePart);
                    apptDate.setHours(0,0,0,0);
                    return apptDate.getTime() === today.getTime();
                });
            } else if (filterParam === 'upcoming') {
                filteredAppts = appts.filter(appt => {
                    if (appt.status === 'Cancelled') return false;
                    const datePart = appt.datetime.split(" - ")[0];
                    const apptDate = new Date(datePart);
                    apptDate.setHours(0,0,0,0);
                    return apptDate.getTime() > today.getTime();
                });
            } else if (filterParam === 'cancelled') {
                filteredAppts = appts.filter(appt => appt.status === 'Cancelled');
            }

            filteredAppts.forEach((appt) => {
                const originalIndex = appts.findIndex(a => a.id === appt.id);
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="td-appt-id">${appt.id}</td>
                    <td class="td-patient">${appt.patientName}</td>
                    <td class="td-time">${appt.datetime}</td>
                    <td>
                        <div>${appt.type}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                            <i class="${appt.method === 'Online' ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> ${appt.method || 'Offline'}
                        </div>
                    </td>
                    <td><span class="status-pill ${appt.status.toLowerCase()}">${appt.status}</span></td>
                    <td>
                        <div class="action-btns">
                            ${appt.status === 'Pending' ? `<button class="btn-action confirm" onclick="changeStatus(${originalIndex}, 'Confirmed')">Confirm</button>` : ''}
                            ${appt.status !== 'Cancelled' ? `<button class="btn-action cancel" onclick="changeStatus(${originalIndex}, 'Cancelled')">Cancel</button>` : ''}
                            <button class="btn-action reschedule" onclick="rescheduleAppt(${originalIndex})">Reschedule</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updateStats(appts);
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

        function onDateChange() {
            const dateInput = document.getElementById('apptDate');
            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayStr = `${y}-${m}-${d}`;

            if (dateInput.value && dateInput.value < todayStr) {
                alert("Pichle din ya mahine ki date select nahi kar sakte. Kripya aaj ki ya aage ki date select karein.");
                dateInput.value = todayStr;
            }
        }

        // Toggle Modal Displays
        function openModal() {
            document.getElementById('scheduleModal').style.display = 'flex';
            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayStr = `${y}-${m}-${d}`;
            const dateInput = document.getElementById('apptDate');
            if (dateInput) {
                dateInput.min = todayStr;
                dateInput.value = todayStr;
            }
        }

        function closeModal() {
            document.getElementById('scheduleModal').style.display = 'none';
            document.getElementById('scheduleForm').reset();
        }

        // Schedule / Save New Appointment Dynamically
        function saveAppointment(event) {
            event.preventDefault();

            const patientName = document.getElementById('patSelector').value;
            const dateValue = document.getElementById('apptDate').value;
            const timeValue = document.getElementById('apptTime').value;
            const visitType = document.getElementById('visitType').value;

            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayFormatted = `${y}-${m}-${d}`;

            if (dateValue < todayFormatted) {
                alert("Pichli date par appointment book nahi kar sakte. Kripya aaj ki ya aage ki date chunein.");
                return;
            }

            // Formulating formatted date string (e.g. 09 Jun 2026)
            const dateObj = new Date(dateValue);
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const formattedDate = `${String(dateObj.getDate()).padStart(2, '0')} ${months[dateObj.getMonth()]} ${dateObj.getFullYear()}`;

            const newId = `APT-${Math.floor(1000 + Math.random() * 9000)}`;

            const meetingType = document.getElementById('meetingType').value;
            const newAppt = {
                id: newId,
                patientName: patientName,
                datetime: `${formattedDate} - ${timeValue}`,
                type: visitType,
                method: meetingType,
                status: "Pending" // Initial status set to review
            };

            let db = getDatabase();
            db.unshift(newAppt);
            localStorage.setItem('medigo_appts', JSON.stringify(db));

            // Sync with MySQL Database
            try {
                const fd = new FormData();
                fd.append('action', 'add_appointment');
                fd.append('patient', patientName);
                fd.append('date', dateValue);
                fd.append('time', timeValue);
                fd.append('type', visitType);
                fd.append('method', meetingType);
                fd.append('status', 'Pending');
                fetch('api.php', { method: 'POST', body: fd });
            } catch(err){
                console.warn('MySQL save appointment error:', err);
            }

            closeModal();
            renderAppointments();
            triggerToast("Appointment scheduled and saved to Database!");
        }

        // Modify Status Transitions (Confirm / Cancel)
        async function changeStatus(index, newStatus) {
            let db = getDatabase();
            const appt = db[index];
            if (!appt) return;

            appt.status = newStatus;
            localStorage.setItem('medigo_appts', JSON.stringify(db));
            renderAppointments();
            triggerToast(`Appointment status updated to ${newStatus}!`);

            try {
                const fd = new FormData();
                fd.append('action', 'update_appointment_status');
                fd.append('id', appt.id);
                fd.append('status', newStatus);
                await fetch('api.php', { method: 'POST', body: fd });
            } catch(e){}
        }

        // Reschedule Option (Modal-like Date/Time Slot Swap)
        async function rescheduleAppt(index) {
            let db = getDatabase();
            const appt = db[index];
            if (!appt) return;

            const newDate = prompt("Enter new Date (e.g., 2026-06-12):", "2026-06-12");
            const newTime = prompt("Enter new Time Slot (e.g., 03:30 PM):", "03:30 PM");

            if (newDate && newTime) {
                appt.datetime = `${newDate} - ${newTime}`;
                appt.status = 'Pending';
                localStorage.setItem('medigo_appts', JSON.stringify(db));
                renderAppointments();
                triggerToast("Appointment rescheduled successfully in Database!");

                try {
                    const fd = new FormData();
                    fd.append('action', 'update_appointment_status');
                    fd.append('id', appt.id);
                    fd.append('status', 'Pending');
                    fd.append('datetime', `${newDate} - ${newTime}`);
                    await fetch('api.php', { method: 'POST', body: fd });
                } catch(e){}
            }
        }

        // Trigger Toast notifications
        function triggerToast(message) {
            const toast = document.getElementById('successToast');
            if (toast) {
                document.getElementById('toastMsg').textContent = message;
                toast.classList.add('show');
                setTimeout(() => { toast.classList.remove('show'); }, 2000);
            }
        }

        // Dynamic Filtering on input keys
        function filterAppts() {
            const searchVal = document.getElementById('searchInput').value.toLowerCase();
            const statusVal = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#apptTableBody tr');

            rows.forEach(row => {
                const idEl = row.querySelector('.td-appt-id');
                if (!idEl) return;
                const idText = idEl.textContent.toLowerCase();
                const patientText = (row.querySelector('.td-patient') || {}).textContent?.toLowerCase() || '';
                const timeText = (row.querySelector('.td-time') || {}).textContent?.toLowerCase() || '';
                const statusText = (row.querySelector('.status-pill') || {}).textContent || '';

                const matchesSearch = idText.includes(searchVal) || patientText.includes(searchVal) || timeText.includes(searchVal);
                const matchesStatus = (statusVal === 'All') || (statusText === statusVal);

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        // Initial setup trigger
        document.addEventListener('DOMContentLoaded', () => {
            renderAppointments();
            fetchLiveAppointments();
        });
    </script>
</body>

</html>
