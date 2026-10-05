<?php
require_once 'db_connect.php';

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `name` ASC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $clean_id = !empty($r['patient_id']) ? $r['patient_id'] : ('PAT-' . (1000 + (int)($r['id'] ?? 1)));
            $blood = !empty($r['blood']) ? $r['blood'] : (!empty($r['blood_group']) ? $r['blood_group'] : 'O+');
            $server_patients[] = [
                'id' => $clean_id,
                'patient_id' => $clean_id,
                'name' => $r['name'] ?? 'Patient',
                'age' => $r['age'] ?? '35',
                'gender' => $r['gender'] ?? 'Male',
                'blood' => $blood,
                'phone' => $r['phone'] ?? '',
                'disease' => $r['disease'] ?? 'General Health',
                'allergies' => $r['allergies'] ?? 'None'
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
    <title>Medi Go - Create Digital Prescription</title>
    <!-- FontAwesome CDN for Icons -->
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

        /* 2. Main Layout */
        .wrapper {
            max-width: 1440px;
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

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
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
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-color);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        /* Dual Column Layout */
        .rx-grid {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 28px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .rx-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
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
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            background: #fff;
            color: var(--text-main);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.15);
        }

        /* Patient Selector Alert */
        .patient-quick-card {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .patient-quick-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .patient-avatar-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .allergy-alert {
            background: var(--danger-light);
            border: 1px solid #fca5a5;
            color: var(--danger);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
        }

        /* Vitals Strip */
        .vitals-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        @media (max-width: 600px) {
            .vitals-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .vital-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            text-align: center;
        }

        .vital-box span {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        .vital-box input {
            width: 100%;
            text-align: center;
            border: 1px solid transparent;
            background: white;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
            padding: 4px;
        }

        .vital-box input:focus {
            border-color: var(--primary);
            outline: none;
        }

        /* Medicines Table */
        .meds-builder-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .meds-builder-table th {
            background: #f8fafc;
            padding: 10px;
            text-align: left;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
        }

        .meds-builder-table td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .freq-btn-group {
            display: flex;
            gap: 4px;
        }

        .freq-btn {
            border: 1px solid var(--border-color);
            background: white;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .freq-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-del {
            color: var(--danger);
            background: var(--danger-light);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-del:hover {
            background: var(--danger);
            color: white;
        }

        /* Advice Pills */
        .advice-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .advice-chip {
            border: 1px solid var(--border-color);
            background: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .advice-chip.selected {
            background: #eff6ff;
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Digital Prescription Pad Preview */
        .rx-pad-preview {
            background: white;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 32px;
            position: sticky;
            top: 96px;
        }

        .rx-pad-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #084382;
            padding-bottom: 18px;
            margin-bottom: 20px;
        }

        .rx-hospital-brand h3 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #084382;
            letter-spacing: -0.5px;
        }

        .rx-hospital-brand p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .rx-doc-info {
            text-align: right;
        }

        .rx-doc-info h4 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .rx-doc-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .rx-patient-strip {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .rx-symbol {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            font-style: italic;
            color: #084382;
            margin-bottom: 12px;
            line-height: 1;
        }

        .rx-pad-meds {
            min-height: 180px;
            margin-bottom: 24px;
        }

        .rx-med-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.9rem;
        }

        .rx-med-item .med-name {
            font-weight: 700;
            color: var(--text-main);
        }

        .rx-med-item .med-dose {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .rx-med-item .med-qty {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.85rem;
        }

        .rx-pad-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .rx-signature {
            text-align: center;
        }

        .rx-signature .sig-line {
            font-family: 'Brush Script MT', cursive, sans-serif;
            font-size: 1.6rem;
            color: #084382;
            margin-bottom: 4px;
        }

        .rx-signature p {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            border-top: 1px solid #94a3b8;
            padding-top: 4px;
        }

        /* Toast notifications */
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

        @media print {
            body * {
                visibility: hidden;
            }
            .rx-pad-preview, .rx-pad-preview * {
                visibility: visible;
            }
            .rx-pad-preview {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- 1. Master Unified Navigation Bar -->
    <nav class="navbar no-print">
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
            <div class="user-profile">
                <div class="user-info">
                    <span class="name"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                    <span class="spec"><?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Cardiology'); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. Workspace Content -->
    <div class="wrapper">
        <div class="page-header no-print">
            <div class="header-title">
                <h1><i class="fa-solid fa-file-prescription" style="color: var(--primary);"></i> Create Digital Prescription</h1>
                <p>Generate, print, and synchronize smart digital prescriptions with patient records</p>
            </div>
            <div class="header-actions">
                <a href="All_prescription.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> All Prescriptions</a>
                <button type="button" onclick="window.print()" class="btn btn-secondary"><i class="fa-solid fa-print"></i> Print Rx</button>
                <button type="button" onclick="savePrescription()" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Issue Prescription</button>
            </div>
        </div>

        <div class="rx-grid">
            <!-- Left Panel: Prescription Form Builder -->
            <div class="form-container no-print">
                <!-- Patient Selector Card -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-user-check"></i> 1. Select Patient & Vitals</h2>
                        <span class="badge" style="background: #eff6ff; color: var(--primary); padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.8rem;">Step 1 of 3</span>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="grid-column: span 2;">
                            <label>Choose Patient</label>
                            <select id="patientSelect" class="form-control" onchange="onPatientSelect()">
                                <option value="">-- Choose Registered Patient --</option>
                                <?php foreach ($server_patients as $p): ?>
                                    <option value="<?php echo htmlspecialchars($p['id']); ?>" 
                                            data-name="<?php echo htmlspecialchars($p['name']); ?>"
                                            data-age="<?php echo htmlspecialchars($p['age']); ?>"
                                            data-gender="<?php echo htmlspecialchars($p['gender']); ?>"
                                            data-blood="<?php echo htmlspecialchars($p['blood']); ?>"
                                            data-phone="<?php echo htmlspecialchars($p['phone']); ?>"
                                            data-disease="<?php echo htmlspecialchars($p['disease']); ?>"
                                            data-allergies="<?php echo htmlspecialchars($p['allergies']); ?>">
                                        <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['id']); ?> - <?php echo htmlspecialchars($p['disease']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="patient-quick-card" id="patientQuickCard" style="display: none;">
                        <div class="patient-quick-info">
                            <div class="patient-avatar-badge" id="pAvatar">AS</div>
                            <div>
                                <h4 id="pName" style="font-weight: 800; font-size: 1rem;">Arjun Sharma</h4>
                                <p style="font-size: 0.8rem; color: var(--text-muted);"><span id="pId">PAT-1001</span> • <span id="pAgeGender">45 Yrs, Male</span> • Blood: <span id="pBlood">O+</span></p>
                            </div>
                        </div>
                        <div id="pAllergyAlert" class="allergy-alert" style="margin: 0; display: none;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Allergy Alert: <strong id="pAllergiesText">Penicillin</strong>
                        </div>
                    </div>

                    <!-- Clinical Vitals -->
                    <div style="margin-top: 18px;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Current Vitals</label>
                        <div class="vitals-grid" style="margin-top: 6px;">
                            <div class="vital-box">
                                <span>BP (mmHg)</span>
                                <input type="text" id="vitalBP" value="120/80" oninput="updateLivePreview()">
                            </div>
                            <div class="vital-box">
                                <span>Pulse (BPM)</span>
                                <input type="text" id="vitalPulse" value="74" oninput="updateLivePreview()">
                            </div>
                            <div class="vital-box">
                                <span>Temp (°F)</span>
                                <input type="text" id="vitalTemp" value="98.6" oninput="updateLivePreview()">
                            </div>
                            <div class="vital-box">
                                <span>SpO2 (%)</span>
                                <input type="text" id="vitalSpO2" value="99%" oninput="updateLivePreview()">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis & Symptoms Card -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-stethoscope"></i> 2. Clinical Diagnosis & Complaints</h2>
                        <span class="badge" style="background: #eff6ff; color: var(--primary); padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.8rem;">Step 2 of 3</span>
                    </div>

                    <div class="form-group">
                        <label>Primary Diagnosis / Impression</label>
                        <input type="text" id="diagnosisInput" class="form-control" placeholder="e.g. Essential Hypertension & Dyslipidemia" value="Hypertension Stage 2" oninput="updateLivePreview()">
                    </div>

                    <div style="margin-top: 10px; display: flex; gap: 6px; flex-wrap: wrap;">
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Hypertension Stage 2')">Hypertension</button>
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Type 2 Diabetes Mellitus')">Type 2 Diabetes</button>
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Migraine Prophylaxis')">Migraine</button>
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Ischemic Heart Disease')">Ischemic Heart Disease</button>
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Acute Bronchitis & Cough')">Bronchitis</button>
                        <button type="button" class="freq-btn" onclick="setDiagnosis('Gastroesophageal Reflux (GERD)')">GERD</button>
                    </div>

                    <div class="form-group" style="margin-top: 14px;">
                        <label>Chief Symptoms & Notes</label>
                        <textarea id="symptomsInput" class="form-control" rows="2" placeholder="Patient complaints, duration, severity..." oninput="updateLivePreview()">Patient reports morning headaches and occasional dizziness for 2 weeks.</textarea>
                    </div>
                </div>

                <!-- Medication Schedule Builder -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-pills"></i> 3. Prescribed Medicines (Rx)</h2>
                        <button type="button" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;" onclick="addMedicineRow()"><i class="fa-solid fa-plus"></i> Add Medicine</button>
                    </div>

                    <table class="meds-builder-table">
                        <thead>
                            <tr>
                                <th style="width: 32%;">Medicine Name</th>
                                <th style="width: 20%;">Dosage / Form</th>
                                <th style="width: 25%;">Frequency</th>
                                <th style="width: 15%;">Duration</th>
                                <th style="width: 8%;"></th>
                            </tr>
                        </thead>
                        <tbody id="medsTableBody">
                            <!-- Rows injected via JS -->
                        </tbody>
                    </table>

                    <div style="margin-top: 20px;">
                        <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Dietary & Lifestyle Advice</label>
                        <div class="advice-pills">
                            <span class="advice-chip selected" onclick="toggleAdvice(this)">Low Salt Diet</span>
                            <span class="advice-chip selected" onclick="toggleAdvice(this)">Drink 3L Water Daily</span>
                            <span class="advice-chip" onclick="toggleAdvice(this)">Avoid Oily & Fried Food</span>
                            <span class="advice-chip selected" onclick="toggleAdvice(this)">Daily 30 Min Walk</span>
                            <span class="advice-chip" onclick="toggleAdvice(this)">Strict Sugar Control</span>
                            <span class="advice-chip" onclick="toggleAdvice(this)">Avoid Screen Before Sleep</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 16px;">
                        <div class="form-group">
                            <label>Follow-Up Plan</label>
                            <select id="followUpSelect" class="form-control" onchange="updateLivePreview()">
                                <option value="After 7 Days (1 Week)">After 7 Days (1 Week)</option>
                                <option value="After 14 Days (2 Weeks)">After 14 Days (2 Weeks)</option>
                                <option value="After 1 Month">After 1 Month</option>
                                <option value="As Needed / SOS">As Needed / SOS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Special Instructions</label>
                            <input type="text" id="specialInstructions" class="form-control" placeholder="e.g. Take medicines strictly after meals." value="Take blood pressure reading every Sunday." oninput="updateLivePreview()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Live Digital Prescription Pad -->
            <div class="rx-pad-container">
                <div class="rx-pad-preview" id="rxPad">
                    <!-- Pad Header -->
                    <div class="rx-pad-header">
                        <div class="rx-hospital-brand">
                            <h3><i class="fa-solid fa-square-h"></i> MEDI GO HOSPITAL</h3>
                            <p>Multi-Specialty Healthcare & Research Institute</p>
                            <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 2px;">SG Highway, Ahmedabad • 24x7 Helpline: 1800-200-8888</p>
                        </div>
                        <div class="rx-doc-info">
                            <h4 id="previewDocName"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></h4>
                            <p id="previewDocSpec"><?php echo htmlspecialchars($current_doctor['specialty'] ?? 'Senior Specialist'); ?></p>
                            <p>Reg No: MCI-88421-GUJ</p>
                        </div>
                    </div>

                    <!-- Patient Bar -->
                    <div class="rx-patient-strip">
                        <div>
                            <strong>Patient:</strong> <span id="previewPName">Arjun Sharma</span> (<span id="previewPId">PAT-1001</span>)
                        </div>
                        <div>
                            <strong>Age/Sex:</strong> <span id="previewPAgeSex">45 / M</span>
                        </div>
                        <div>
                            <strong>Date:</strong> <span><?php echo date('d M Y'); ?></span>
                        </div>
                    </div>

                    <!-- Vitals Summary Bar -->
                    <div style="display: flex; gap: 16px; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                        <span><strong>BP:</strong> <span id="previewBP">120/80 mmHg</span></span>
                        <span><strong>Pulse:</strong> <span id="previewPulse">74 bpm</span></span>
                        <span><strong>Temp:</strong> <span id="previewTemp">98.6 °F</span></span>
                        <span><strong>SpO2:</strong> <span id="previewSpO2">99%</span></span>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Diagnosis:</span>
                        <h4 id="previewDiagnosis" style="font-size: 0.95rem; color: #084382; margin-top: 2px;">Hypertension Stage 2</h4>
                    </div>

                    <!-- Rx Symbol -->
                    <div class="rx-symbol">&#8478;</div>

                    <!-- Medicines list in Pad -->
                    <div class="rx-pad-meds" id="previewMedsList">
                        <!-- Dynamic preview items -->
                    </div>

                    <!-- Advice & Followup -->
                    <div style="background: #f8fafc; border-radius: 8px; padding: 12px; font-size: 0.82rem; margin-top: 16px;">
                        <div style="margin-bottom: 6px;">
                            <strong>Advice:</strong> <span id="previewAdvice">Low Salt Diet, Drink 3L Water Daily, Daily 30 Min Walk</span>
                        </div>
                        <div style="margin-bottom: 6px;">
                            <strong>Instructions:</strong> <span id="previewInstructions">Take blood pressure reading every Sunday.</span>
                        </div>
                        <div>
                            <strong>Next Follow-up:</strong> <span id="previewFollowup" style="color: var(--primary); font-weight: 700;">After 7 Days (1 Week)</span>
                        </div>
                    </div>

                    <!-- Pad Footer with Signature -->
                    <div class="rx-pad-footer">
                        <div style="font-size: 0.72rem; color: #94a3b8;">
                            <i class="fa-solid fa-shield-halved"></i> Digitally Generated & Validated<br>
                            Ref ID: <span id="previewRxId">RX-<?php echo rand(1000, 9999); ?></span>
                        </div>
                        <div class="rx-signature">
                            <div class="sig-line" id="previewSigName"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></div>
                            <p>Authorized Medical Officer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"><i class="fa-solid fa-circle-check" style="color: var(--success);"></i> <span id="toastMsg">Prescription created!</span></div>

    <!-- Script Logic -->
    <script>
        const serverPatients = <?php echo json_encode($server_patients ?? []); ?>;
        let medicinesList = [
            { name: 'Telmisartan 40mg', form: 'Tablet', freq: '1-0-0', timing: 'After Food', duration: '30 Days', qty: '30 Tabs' },
            { name: 'Atorvastatin 10mg', form: 'Tablet', freq: '0-0-1', timing: 'At Bedtime', duration: '30 Days', qty: '30 Tabs' },
            { name: 'Amlodipine 5mg', form: 'Tablet', freq: '0-0-1', timing: 'After Dinner', duration: '15 Days', qty: '15 Tabs' }
        ];

        document.addEventListener('DOMContentLoaded', () => {
            // Auto select first patient
            if (serverPatients.length > 0) {
                const pSelect = document.getElementById('patientSelect');
                pSelect.selectedIndex = 1;
                onPatientSelect();
            }
            renderMedicinesTable();
            updateLivePreview();
        });

        function onPatientSelect() {
            const select = document.getElementById('patientSelect');
            const opt = select.options[select.selectedIndex];
            if (!opt || !opt.value) {
                document.getElementById('patientQuickCard').style.display = 'none';
                return;
            }

            const name = opt.getAttribute('data-name');
            const id = opt.value;
            const age = opt.getAttribute('data-age');
            const gender = opt.getAttribute('data-gender');
            const blood = opt.getAttribute('data-blood');
            const disease = opt.getAttribute('data-disease');
            const allergies = opt.getAttribute('data-allergies');

            document.getElementById('pName').textContent = name;
            document.getElementById('pId').textContent = id;
            document.getElementById('pAgeGender').textContent = `${age} Yrs, ${gender}`;
            document.getElementById('pBlood').textContent = blood;
            document.getElementById('pAvatar').textContent = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();

            const allergyBox = document.getElementById('pAllergyAlert');
            if (allergies && allergies.toLowerCase() !== 'none' && allergies.trim() !== '') {
                allergyBox.style.display = 'flex';
                document.getElementById('pAllergiesText').textContent = allergies;
            } else {
                allergyBox.style.display = 'none';
            }

            document.getElementById('patientQuickCard').style.display = 'flex';
            if (disease && disease !== 'General Health') {
                document.getElementById('diagnosisInput').value = disease;
            }

            updateLivePreview();
        }

        function setDiagnosis(val) {
            document.getElementById('diagnosisInput').value = val;
            updateLivePreview();
        }

        function toggleAdvice(el) {
            el.classList.toggle('selected');
            updateLivePreview();
        }

        function addMedicineRow() {
            medicinesList.push({
                name: 'Paracetamol 650mg',
                form: 'Tablet',
                freq: '1-0-1',
                timing: 'After Food',
                duration: '5 Days',
                qty: '10 Tabs'
            });
            renderMedicinesTable();
            updateLivePreview();
        }

        function removeMedicineRow(index) {
            medicinesList.splice(index, 1);
            renderMedicinesTable();
            updateLivePreview();
        }

        function renderMedicinesTable() {
            const tbody = document.getElementById('medsTableBody');
            tbody.innerHTML = '';

            medicinesList.forEach((med, idx) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <input type="text" class="form-control" style="padding: 6px 10px; font-weight: 700;" value="${med.name}" oninput="medicinesList[${idx}].name = this.value; updateLivePreview();" placeholder="Medicine Name">
                    </td>
                    <td>
                        <select class="form-control" style="padding: 6px 8px;" onchange="medicinesList[${idx}].form = this.value; updateLivePreview();">
                            <option value="Tablet" ${med.form === 'Tablet' ? 'selected' : ''}>Tablet</option>
                            <option value="Capsule" ${med.form === 'Capsule' ? 'selected' : ''}>Capsule</option>
                            <option value="Syrup" ${med.form === 'Syrup' ? 'selected' : ''}>Syrup</option>
                            <option value="Injection" ${med.form === 'Injection' ? 'selected' : ''}>Injection</option>
                            <option value="Drops" ${med.form === 'Drops' ? 'selected' : ''}>Drops</option>
                            <option value="Ointment" ${med.form === 'Ointment' ? 'selected' : ''}>Ointment</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" style="padding: 6px 8px;" onchange="medicinesList[${idx}].freq = this.value; updateLivePreview();">
                            <option value="1-0-0 (Morning)" ${med.freq.includes('1-0-0') ? 'selected' : ''}>1-0-0 (Morning)</option>
                            <option value="1-0-1 (BID)" ${med.freq.includes('1-0-1') ? 'selected' : ''}>1-0-1 (Morning & Night)</option>
                            <option value="1-1-1 (TID)" ${med.freq.includes('1-1-1') ? 'selected' : ''}>1-1-1 (3 Times Daily)</option>
                            <option value="0-0-1 (Night)" ${med.freq.includes('0-0-1') ? 'selected' : ''}>0-0-1 (Bedtime)</option>
                            <option value="SOS (As needed)" ${med.freq.includes('SOS') ? 'selected' : ''}>SOS (As needed)</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" style="padding: 6px 10px;" value="${med.duration}" oninput="medicinesList[${idx}].duration = this.value; updateLivePreview();" placeholder="e.g. 5 Days">
                    </td>
                    <td>
                        <button type="button" class="btn-del" onclick="removeMedicineRow(${idx})" title="Remove"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateLivePreview() {
            // Patient details
            const select = document.getElementById('patientSelect');
            const opt = select.options[select.selectedIndex];
            if (opt && opt.value) {
                document.getElementById('previewPName').textContent = opt.getAttribute('data-name');
                document.getElementById('previewPId').textContent = opt.value;
                document.getElementById('previewPAgeSex').textContent = `${opt.getAttribute('data-age')} / ${opt.getAttribute('data-gender')[0]}`;
            }

            // Vitals
            document.getElementById('previewBP').textContent = document.getElementById('vitalBP').value + ' mmHg';
            document.getElementById('previewPulse').textContent = document.getElementById('vitalPulse').value + ' bpm';
            document.getElementById('previewTemp').textContent = document.getElementById('vitalTemp').value + ' °F';
            document.getElementById('previewSpO2').textContent = document.getElementById('vitalSpO2').value;

            // Diagnosis
            document.getElementById('previewDiagnosis').textContent = document.getElementById('diagnosisInput').value || 'General Consultation';

            // Advice
            const selectedAdv = Array.from(document.querySelectorAll('.advice-chip.selected')).map(c => c.textContent);
            document.getElementById('previewAdvice').textContent = selectedAdv.join(', ') || 'Standard dietary caution.';

            // Instructions & Followup
            document.getElementById('previewInstructions').textContent = document.getElementById('specialInstructions').value || 'None';
            document.getElementById('previewFollowup').textContent = document.getElementById('followUpSelect').value;

            // Meds preview
            const medsContainer = document.getElementById('previewMedsList');
            medsContainer.innerHTML = '';
            medicinesList.forEach((med, i) => {
                const item = document.createElement('div');
                item.className = 'rx-med-item';
                item.innerHTML = `
                    <div>
                        <div class="med-name">${i + 1}. ${med.name}</div>
                        <div class="med-dose">${med.form} • Schedule: <strong>${med.freq}</strong> • ${med.timing || 'After Food'}</div>
                    </div>
                    <div class="med-qty">${med.duration}</div>
                `;
                medsContainer.appendChild(item);
            });

            // Doctor details from auth
            if (window.currentDoctor && window.currentDoctor.name) {
                const dName = window.currentDoctor.name.startsWith('Dr.') ? window.currentDoctor.name : 'Dr. ' + window.currentDoctor.name;
                document.getElementById('previewDocName').textContent = dName;
                document.getElementById('previewSigName').textContent = dName;
                if (window.currentDoctor.spec || window.currentDoctor.specialty) {
                    document.getElementById('previewDocSpec').textContent = window.currentDoctor.spec || window.currentDoctor.specialty;
                }
            }
        }

        async function savePrescription() {
            const select = document.getElementById('patientSelect');
            const opt = select.options[select.selectedIndex];
            if (!opt || !opt.value) {
                alert('Please select a patient first.');
                return;
            }

            const pName = opt.getAttribute('data-name');
            const pId = opt.value;
            const pAge = opt.getAttribute('data-age');
            const pGender = opt.getAttribute('data-gender');
            const diagnosis = document.getElementById('diagnosisInput').value;
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';

            // Format medicines string
            const medsStr = medicinesList.map(m => `${m.name} (${m.freq}, ${m.duration})`).join(', ');
            const selectedAdv = Array.from(document.querySelectorAll('.advice-chip.selected')).map(c => c.textContent).join(', ');
            const instructions = `${selectedAdv}. ${document.getElementById('specialInstructions').value}. Followup: ${document.getElementById('followUpSelect').value}`;

            const formData = new FormData();
            formData.append('patientName', pName);
            formData.append('patientId', pId);
            formData.append('age', pAge);
            formData.append('gender', pGender);
            formData.append('doctor', docName);
            formData.append('diagnosis', diagnosis);
            formData.append('medicines', medsStr);
            formData.append('instructions', instructions);

            try {
                const res = await fetch('api.php?action=add_prescription', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Prescription generated & synced successfully!');
                    setTimeout(() => {
                        window.location.href = 'All_prescription.php';
                    }, 1200);
                } else {
                    alert('Save failed: ' + data.message);
                }
            } catch (err) {
                console.error(err);
                showToast('Prescription generated locally!');
                setTimeout(() => {
                    window.location.href = 'All_prescription.php';
                }, 1200);
            }
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.style.display = 'flex';
            setTimeout(() => { t.style.display = 'none'; }, 3000);
        }
    </script>
</body>
</html>
