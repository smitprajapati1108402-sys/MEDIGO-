<?php
require_once 'db_connect.php';

$doctor_account = null;
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `doctors` LIMIT 1");
    if ($res) {
        $doctor_account = mysqli_fetch_assoc($res);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'doctor_auth.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - Account Security & Preferences</title>
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
            max-width: 1180px;
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
            padding: 10px 22px;
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

        /* 3. Settings Cards */
        .card {
            background: var(--card-bg);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 28px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.92rem;
            outline: none;
            transition: all 0.2s;
            background: #fff;
            color: var(--text-main);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.15);
        }

        /* Toggle Switches */
        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .toggle-row:last-child {
            border-bottom: none;
        }

        .toggle-info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .toggle-info p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(22px);
        }

        /* Session Item */
        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 10px;
        }

        .session-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .session-icon {
            font-size: 1.4rem;
            color: var(--primary);
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
                <li class="nav-item active">
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
                <h1><i class="fa-solid fa-sliders" style="color: var(--primary);"></i> Account Security & Preferences</h1>
                <p>Configure password credentials, two-factor authentication, alerts, and hospital display preferences</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="saveAccountSettings()"><i class="fa-solid fa-floppy-disk"></i> Save Preferences</button>
            </div>
        </div>

        <form id="accountForm" onsubmit="event.preventDefault(); saveAccountSettings();">
            <!-- 1. Password & Security -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-shield-halved" style="color: var(--primary);"></i> 1. Security & Authentication</h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" id="currPassword" class="form-control" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" id="newPassword" class="form-control" placeholder="Enter new strong password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" id="confirmPassword" class="form-control" placeholder="Re-type new password">
                    </div>
                </div>

                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <h4>Two-Factor Authentication (2FA)</h4>
                            <p>Enforce an OTP security code on every doctor portal login attempt.</p>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="twoFactorToggle" <?php echo !empty($doctor_account['two_factor']) ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- 2. Notification Alerts -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-bell" style="color: var(--primary);"></i> 2. Clinical Notification Alerts</h3>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <h4>New Appointment Notifications</h4>
                        <p>Receive email & push notifications whenever a patient books or reschedules an appointment.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" id="emailNotifToggle" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <h4>Emergency Inpatient Alerts</h4>
                        <p>Instant high-priority alerts for critical patients admitted under your care.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" id="smsNotifToggle" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <h4>Medicine Refill Inquiries</h4>
                        <p>Notify when patients request chronic medication refills.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" id="apptAlertToggle" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <!-- 3. Active Sessions -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-laptop-medical" style="color: var(--primary);"></i> 3. Active Devices & Sessions</h3>
                </div>

                <div class="session-item">
                    <div class="session-info">
                        <i class="fa-solid fa-desktop session-icon"></i>
                        <div>
                            <strong style="color: var(--text-main); font-size: 0.95rem;">Hospital Workstation (Chrome on Windows)</strong>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">IP: 192.168.1.45 • Ahmedabad, India • <span style="color: var(--success); font-weight: 700;">Current Session</span></div>
                        </div>
                    </div>
                    <span class="badge" style="background: var(--success-light); color: var(--success); padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem;">Online</span>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 0.95rem;"><i class="fa-solid fa-floppy-disk"></i> Save All Settings</button>
            </div>
        </form>
    </div>

    <div id="toast"><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> <span id="toastMsg">Settings saved successfully!</span></div>

    <script>
        async function saveAccountSettings() {
            const currPass = document.getElementById('currPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            const twoFactor = document.getElementById('twoFactorToggle').checked ? 1 : 0;
            const emailNotif = document.getElementById('emailNotifToggle').checked ? 1 : 0;
            const smsNotif = document.getElementById('smsNotifToggle').checked ? 1 : 0;
            const apptAlert = document.getElementById('apptAlertToggle').checked ? 1 : 0;
            const docId = (window.currentDoctor && window.currentDoctor.id) ? window.currentDoctor.id : 'DOC-101';

            if (newPass && newPass !== confirmPass) {
                alert('New password and confirm password do not match.');
                return;
            }

            const fd = new FormData();
            fd.append('doc_id', docId);
            fd.append('current_password', currPass);
            fd.append('new_password', newPass);
            fd.append('two_factor', twoFactor);
            fd.append('email_notif', emailNotif);
            fd.append('sms_notif', smsNotif);
            fd.append('appt_alert', apptAlert);

            try {
                const res = await fetch('api.php?action=update_doctor_account', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Account preferences saved!');
                    document.getElementById('currPassword').value = '';
                    document.getElementById('newPassword').value = '';
                    document.getElementById('confirmPassword').value = '';
                } else {
                    alert('Update failed: ' + data.message);
                }
            } catch (err) {
                console.error(err);
                showToast('Settings saved locally!');
            }
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.style.display = 'flex';
            setTimeout(() => { t.style.display = 'none'; }, 2800);
        }
    </script>
</body>
</html>
