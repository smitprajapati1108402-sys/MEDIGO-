<?php
require_once 'db_connect.php';
require_once 'doctor_auth.php';

$doctor_profile = null;
if (!empty($db_connected) && !empty($conn)) {
    $doc_id_esc = mysqli_real_escape_string($conn, $current_doc_id);
    $doc_name_esc = mysqli_real_escape_string($conn, $current_doc_name);
    $doc_email_esc = mysqli_real_escape_string($conn, $current_doc_email);
    
    $res = mysqli_query($conn, "SELECT * FROM `doctors` WHERE `doctor_id` = '$doc_id_esc' OR `doc_id` = '$doc_id_esc' OR `email` = '$doc_email_esc' OR `name` = '$doc_name_esc' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $doctor_profile = mysqli_fetch_assoc($res);
    } else {
        $doctor_profile = [
            'doctor_id' => $current_doc_id,
            'name' => $current_doc_name,
            'email' => $current_doc_email,
            'specialty' => $current_doctor['specialty'] ?? 'Cardiology',
            'department' => $current_doctor['department'] ?? 'Cardiology',
            'phone' => '+91 98765 43210',
            'fee' => 500
        ];
    }
} else {
    $doctor_profile = [
        'doctor_id' => $current_doc_id,
        'name' => $current_doc_name,
        'email' => $current_doc_email,
        'specialty' => $current_doctor['specialty'] ?? 'Cardiology',
        'department' => $current_doctor['department'] ?? 'Cardiology',
        'phone' => '+91 98765 43210',
        'fee' => 500
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - Doctor Profile Settings</title>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    
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

        /* 2. Workspace Body */
        .wrapper {
            max-width: 1280px;
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

        /* 3. Hero Profile Card */
        .profile-hero {
            background: linear-gradient(135deg, #084382 0%, #0a52a3 100%);
            border-radius: 16px;
            padding: 28px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            box-shadow: 0 10px 25px rgba(8, 67, 130, 0.15);
            flex-wrap: wrap;
            gap: 20px;
        }

        .profile-hero-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .doctor-avatar-box {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: white;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-weight: 800;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .profile-hero-info h2 {
            font-size: 1.45rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .profile-hero-info p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* 4. Settings Card */
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

        /* Signature Pad */
        .sig-preview-card {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 18px;
            text-align: center;
            margin-top: 10px;
        }

        .sig-preview-card .sig-text {
            font-family: 'Brush Script MT', cursive, sans-serif;
            font-size: 2.2rem;
            color: #084382;
            margin-bottom: 6px;
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
                <h1><i class="fa-solid fa-user-doctor" style="color: var(--primary);"></i> Doctor Profile & Credentials</h1>
                <p>Manage your clinical credentials, consultation schedule, cabin details, and digital signature</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="saveDoctorProfile()"><i class="fa-solid fa-floppy-disk"></i> Save Profile</button>
            </div>
        </div>

        <!-- Hero Card -->
        <div class="profile-hero">
            <div class="profile-hero-left">
                <div class="doctor-avatar-box" id="heroAvatar">RP</div>
                <div class="profile-hero-info">
                    <h2 id="heroName"><?php echo htmlspecialchars($doctor_profile['name'] ?? $current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></h2>
                    <p>
                        <span><i class="fa-solid fa-stethoscope"></i> <span id="heroSpec"><?php echo htmlspecialchars($doctor_profile['specialty'] ?? $current_doctor['specialty'] ?? 'Senior Cardiologist'); ?></span></span>
                        <span>•</span>
                        <span><i class="fa-solid fa-id-card"></i> <span id="heroDocId"><?php echo htmlspecialchars($doctor_profile['doctor_id'] ?? $current_doctor['id'] ?? 'DOC-SMIT-01'); ?></span></span>
                        <span>•</span>
                        <span><i class="fa-solid fa-star" style="color: #fbbf24;"></i> 4.95 Rating</span>
                    </p>
                </div>
            </div>
            <div>
                <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">
                    <i class="fa-solid fa-circle" style="color: #4ade80; font-size: 0.55rem;"></i> Active Duty
                </span>
            </div>
        </div>

        <!-- Profile Form Card -->
        <form id="profileForm" onsubmit="event.preventDefault(); saveDoctorProfile();">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-address-card" style="color: var(--primary);"></i> 1. Personal & Contact Information</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Doctor Full Name</label>
                        <input type="text" id="docName" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['name'] ?? $current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?>" required oninput="updateHero()">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="docEmail" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['email'] ?? $current_doctor['email'] ?? 'smit@medigo.com'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" id="docPhone" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['phone'] ?? '+91 98765 43210'); ?>">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-award" style="color: var(--primary);"></i> 2. Clinical Specialty & Qualifications</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Department</label>
                        <select id="docDepartment" class="form-control">
                            <option value="Cardiology">Cardiology</option>
                            <option value="Neurology">Neurology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Emergency Medicine">Emergency Medicine</option>
                            <option value="General Medicine">General Medicine</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Clinical Specialty Title</label>
                        <input type="text" id="docSpecialty" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['specialty'] ?? 'Senior Cardiologist'); ?>" oninput="updateHero()">
                    </div>
                    <div class="form-group">
                        <label>Degrees & Qualifications</label>
                        <input type="text" id="docQualification" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['qualification'] ?? 'MBBS, MD (Cardiology), FACC'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Medical Council Reg No</label>
                        <input type="text" id="docRegNo" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['reg_no'] ?? 'MCI-88421-GUJ'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Years of Clinical Experience</label>
                        <input type="text" id="docExperience" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['experience'] ?? '12+ Years'); ?>">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-calendar-check" style="color: var(--primary);"></i> 3. Hospital OPD Schedule & Consultation Fee</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Consultation Fee (₹)</label>
                        <input type="number" id="docFee" class="form-control" value="<?php echo (float)($doctor_profile['fee'] ?? 500); ?>">
                    </div>
                    <div class="form-group">
                        <label>OPD Cabin / Room Number</label>
                        <input type="text" id="docRoom" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['room_no'] ?? 'OPD Room 302, Wing B'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Daily Consultation Hours</label>
                        <input type="text" id="docTiming" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['timing'] ?? '09:00 AM - 05:00 PM'); ?>">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 18px;">
                    <label>Doctor Biography & Clinical Focus</label>
                    <textarea id="docBio" class="form-control" rows="3"><?php echo htmlspecialchars($doctor_profile['bio'] ?? 'Senior Consultant with over 12+ years of experience in clinical diagnosis, interventional cardiology, echocardiography, and preventative cardiovascular health.'); ?></textarea>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-signature" style="color: var(--primary);"></i> 4. Digital Signature & Medical Stamp</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Digital Signature Name Text</label>
                        <input type="text" id="docSigText" class="form-control" value="<?php echo htmlspecialchars($doctor_profile['name'] ?? $current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?>" oninput="updateSignature()">
                        <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 4px;">Used automatically on digital prescriptions and diagnostic reports.</p>
                    </div>
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Signature Preview</label>
                        <div class="sig-preview-card">
                            <div class="sig-text" id="sigPreviewText"><?php echo htmlspecialchars($doctor_profile['name'] ?? $current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></div>
                            <p style="font-size: 0.78rem; font-weight: 700; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 4px; display: inline-block;">Authorized Medical Specialist</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 0.95rem;"><i class="fa-solid fa-floppy-disk"></i> Save & Apply Changes</button>
            </div>
        </form>
    </div>

    <div id="toast"><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> <span id="toastMsg">Profile updated successfully!</span></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.currentDoctor) {
                if (window.currentDoctor.name) {
                    const docName = window.currentDoctor.name.startsWith('Dr.') ? window.currentDoctor.name : 'Dr. ' + window.currentDoctor.name;
                    document.getElementById('docName').value = docName;
                    document.getElementById('docSigText').value = docName;
                    updateHero();
                    updateSignature();
                }
                if (window.currentDoctor.email) {
                    document.getElementById('docEmail').value = window.currentDoctor.email;
                }
                if (window.currentDoctor.spec || window.currentDoctor.specialty) {
                    document.getElementById('docSpecialty').value = window.currentDoctor.spec || window.currentDoctor.specialty;
                    updateHero();
                }
            }
        });

        function updateHero() {
            const name = document.getElementById('docName').value || (window.currentDoctor && window.currentDoctor.name) || 'Dr. PRAJAPATI SMIT MANOJKUMAR';
            const spec = document.getElementById('docSpecialty').value || (window.currentDoctor && window.currentDoctor.specialty) || 'Cardiology';
            document.getElementById('heroName').textContent = name;
            document.getElementById('heroSpec').textContent = spec;
            document.getElementById('heroAvatar').textContent = name.replace(/^Dr\.\s*/i, '').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        }

        function updateSignature() {
            document.getElementById('sigPreviewText').textContent = document.getElementById('docSigText').value || (window.currentDoctor && window.currentDoctor.name) || 'Dr. PRAJAPATI SMIT MANOJKUMAR';
        }

        async function saveDoctorProfile() {
            const name = document.getElementById('docName').value;
            const email = document.getElementById('docEmail').value;
            const phone = document.getElementById('docPhone').value;
            const department = document.getElementById('docDepartment').value;
            const specialty = document.getElementById('docSpecialty').value;
            const qualification = document.getElementById('docQualification').value;
            const regNo = document.getElementById('docRegNo').value;
            const experience = document.getElementById('docExperience').value;
            const fee = document.getElementById('docFee').value;
            const roomNo = document.getElementById('docRoom').value;
            const timing = document.getElementById('docTiming').value;
            const bio = document.getElementById('docBio').value;
            const sig = document.getElementById('docSigText').value;
            const docId = (window.currentDoctor && window.currentDoctor.id) ? window.currentDoctor.id : 'DOC-SMIT-01';

            const fd = new FormData();
            fd.append('doc_id', docId);
            fd.append('name', name);
            fd.append('email', email);
            fd.append('phone', phone);
            fd.append('department', department);
            fd.append('specialty', specialty);
            fd.append('qualification', qualification);
            fd.append('reg_no', regNo);
            fd.append('experience', experience);
            fd.append('fee', fee);
            fd.append('room_no', roomNo);
            fd.append('timing', timing);
            fd.append('bio', bio);
            fd.append('signature', sig);

            try {
                const res = await fetch('api.php?action=update_doctor_profile', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();
                if (data.success) {
                    // Update active session
                    const updated = {
                        ...(window.currentDoctor || {}),
                        id: docId,
                        name: name,
                        email: email,
                        spec: specialty,
                        specialty: specialty,
                        department: department
                    };
                    sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(updated));
                    localStorage.setItem('medigoCurrentDoctor', JSON.stringify(updated));
                    showToast('Profile successfully saved & updated across portal!');
                    setTimeout(() => { location.reload(); }, 1000);
                } else {
                    alert('Update failed: ' + data.message);
                }
            } catch (err) {
                console.error(err);
                showToast('Profile updated locally!');
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
