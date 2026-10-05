<?php 
require_once 'db_connect.php'; 

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $clean_id = !empty($r['patient_id']) ? $r['patient_id'] : ('PAT-' . (1000 + (int)($r['id'] ?? 1)));
            $server_patients[] = [
                'id' => $clean_id,
                'patient_id' => $clean_id,
                'db_id' => $r['id'] ?? '',
                'name' => $r['name'] ?? 'Patient',
                'dob' => $r['dob'] ?? '',
                'age' => $r['age'] ?? '35',
                'gender' => $r['gender'] ?? 'Male',
                'blood' => !empty($r['blood']) ? $r['blood'] : (!empty($r['blood_group']) ? $r['blood_group'] : 'O+'),
                'phone' => $r['phone'] ?? '',
                'email' => $r['email'] ?? '',
                'disease' => $r['disease'] ?? 'General Health',
                'status' => $r['status'] ?? 'Treatment',
                'allergies' => $r['allergies'] ?? 'None',
                'contactName' => $r['contact_name'] ?? '',
                'relationship' => $r['relationship'] ?? '',
                'contactPhone' => $r['contact_phone'] ?? ''
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
    <title>MediCare - Add New Patient</title>
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

        /* 1. Header & Navigation (Matches Dashboard and Directory) */
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
        }

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
            margin-bottom: 28px;
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

        .btn-back {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary-action {
            background-color: #0a52a3;
            color: #ffffff !important;
            border: 1px solid #0a52a3;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(10, 82, 163, 0.25);
            text-decoration: none;
            letter-spacing: 0.2px;
        }

        .btn-primary-action:hover {
            background-color: #084382;
            border-color: #084382;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(8, 67, 130, 0.35);
            color: #ffffff !important;
        }

        .btn-primary-action i {
            font-size: 1rem;
        }

        .page-header.view-header-layout {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 20px;
            flex-wrap: wrap;
        }

        @media (max-width: 992px) {
            .page-header.view-header-layout {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }
            .page-header.view-header-layout > div {
                display: flex;
                justify-content: center !important;
                text-align: center;
            }
        }

        /* Forms Layout Grid */
        .form-grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .form-grid-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Card Form Components */
        .form-section-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* Form Controls Structure */
        .inputs-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 18px;
        }

        .inputs-row.triple {
            grid-template-columns: repeat(3, 1fr);
        }

        .inputs-row.full {
            grid-template-columns: 1fr;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .input-group input, 
        .input-group select, 
        .input-group textarea {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            font-size: 0.9rem;
            color: var(--text-main);
            background-color: #fafbfd;
            transition: all 0.2s;
        }

        .input-group input:focus, 
        .input-group select:focus, 
        .input-group textarea:focus {
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.08);
        }

        /* Actions Bar at bottom */
        .form-actions-bar {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 12px;
        }

        .btn-cancel {
            background-color: #e2e8f0;
            color: var(--text-main);
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-cancel:hover {
            background-color: #cbd5e1;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.2s;
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.2);
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        /* 3. Live Preview Card (Right Column) */
        .preview-sticky {
            position: sticky;
            top: 100px;
        }

        .preview-card {
            background: linear-gradient(135deg, #0a52a3 0%, #084382 100%);
            color: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(8, 67, 130, 0.15);
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .preview-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .preview-logo {
            font-size: 1.1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-status {
            font-size: 0.75rem;
            font-weight: 700;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .preview-user-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .preview-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .preview-name {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 4px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .preview-id {
            font-size: 0.8rem;
            opacity: 0.85;
            font-weight: 600;
        }

        .preview-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 20px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .meta-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            opacity: 0.75;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Success Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--success);
            color: white;
            padding: 16px 28px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            z-index: 2000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar (Matches Directory) -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="doctor_dashboard.php" class="brand">
                <i class="fa-solid fa-square-h"></i> Medi Go
            </a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="doctor_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                </li>
                <li class="nav-item active">
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

    <!-- 2. Main Workspace Body Wrapper -->
    <div class="wrapper">

        <!-- Page Header Row -->
        <div class="page-header">
            <div>
                <h1>New Patient Registration</h1>
                <p>Register a new patient and initialize their clinical intake profile.</p>
            </div>
            <div class="header-actions" style="display: flex; gap: 12px; align-items: center;">
                <button class="btn-back" onclick="window.location.href='Allpatient.php'">
                    <i class="fa-solid fa-arrow-left"></i> Back to Directory
                </button>
            </div>
        </div>

        <!-- Forms & Live Preview Column Grid -->
        <form id="patientRegistrationForm" onsubmit="submitForm(event)">
            <div class="form-grid-layout">
                
                <!-- Left Column: Input Fields Section -->
                <div>
                    <!-- Section 1: Personal Details -->
                    <div class="form-section-card">
                        <div class="section-title">
                            <i class="fa-solid fa-user"></i> Personal Information
                        </div>
                        
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="formName">Full Patient Name *</label>
                                <input type="text" id="formName" required placeholder="First, Middle, Surname" oninput="updatePreview()">
                            </div>
                            <div class="input-group">
                                <label for="formDOB">Date of Birth *</label>
                                <input type="date" id="formDOB" required onchange="calculateAge()">
                            </div>
                        </div>

                        <div class="inputs-row triple">
                            <div class="input-group">
                                <label for="formAge">Calculated Age</label>
                                <input type="text" id="formAge" readonly placeholder="Calculated automatically">
                            </div>
                            <div class="input-group">
                                <label for="formGender">Gender *</label>
                                <select id="formGender" required onchange="updatePreview()">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="formBloodGroup">Blood Group *</label>
                                <select id="formBloodGroup" required onchange="updatePreview()">
                                    <option value="" disabled selected>Select Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>

                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="formPhone">Mobile Number *</label>
                                <input type="tel" id="formPhone" required placeholder="+91 9XXXX XXXXX">
                            </div>
                            <div class="input-group">
                                <label for="formEmail">Email Address</label>
                                <input type="email" id="formEmail" placeholder="example@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Clinical Intake & Medical Context -->
                    <div class="form-section-card">
                        <div class="section-title">
                            <i class="fa-solid fa-stethoscope"></i> Clinical Assessment
                        </div>

                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="formDisease">Primary Symptom / Diagnosis *</label>
                                <input type="text" id="formDisease" required placeholder="e.g. Chest Pain, Chronic Migraine" oninput="updatePreview()">
                            </div>
                            <div class="input-group">
                                <label for="formStatus">Initial Care Status *</label>
                                <select id="formStatus" required onchange="updatePreview()">
                                    <option value="Treatment">Treatment</option>
                                    <option value="Improving">Improving</option>
                                    <option value="Critical">Critical</option>
                                    <option value="Recovered">Recovered</option>
                                </select>
                            </div>
                        </div>

                        <div class="inputs-row full">
                            <div class="input-group">
                                <label for="formAllergies">Medical History / Allergies</label>
                                <textarea id="formAllergies" rows="3" placeholder="List any known allergies (Penicillin, Nuts, Dust) or past diagnoses (Hypertension, Asthma)..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Emergency Contact Info -->
                    <div class="form-section-card">
                        <div class="section-title">
                            <i class="fa-solid fa-truck-medical"></i> Emergency Contact
                        </div>

                        <div class="inputs-row triple">
                            <div class="input-group">
                                <label for="formContactName">Contact Person Name *</label>
                                <input type="text" id="formContactName" required placeholder="Relation contact name">
                            </div>
                            <div class="input-group">
                                <label for="formRelationship">Relationship *</label>
                                <select id="formRelationship" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Parent">Parent</option>
                                    <option value="Child">Child</option>
                                    <option value="Sibling">Sibling</option>
                                    <option value="Friend">Friend</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="formContactPhone">Emergency Contact Phone *</label>
                                <input type="tel" id="formContactPhone" required placeholder="+91 XXXXX XXXXX">
                            </div>
                        </div>
                    </div>

                    <!-- Actions Form Buttons -->
                    <div class="form-actions-bar">
                        <button type="button" class="btn-cancel" onclick="resetForm()">Reset Profile</button>
                        <button type="submit" class="btn-submit">Register Patient</button>
                    </div>
                </div>

                <!-- Right Column: Live Dynamic Card Preview -->
                <div class="preview-sticky">
                    <div class="preview-card">
                        <div class="preview-header">
                            <span class="preview-logo"><i class="fa-solid fa-square-h"></i> Medi Go Profile</span>
                            <span class="preview-status" id="preStatus">Treatment</span>
                        </div>

                        <div class="preview-user-row">
                            <div class="preview-avatar" id="preAvatarIcon">
                                <i class="fa-solid fa-user-injured"></i>
                            </div>
                            <div>
                                <h3 class="preview-name" id="preName">John Doe</h3>
                                <span class="preview-id" id="preId">REGISTRATION ID: <strong style="color: #f59e0b;">PENDING</strong></span>
                            </div>
                        </div>

                        <div class="preview-meta-grid">
                            <div class="meta-item">
                                <span class="meta-label">Age / Gender</span>
                                <span class="meta-value" id="preAgeGender">--</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Blood Group</span>
                                <span class="meta-value" id="preBlood">--</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Primary Diagnosis</span>
                                <span class="meta-value" id="preDisease" style="color: #fffbdf;">Not specified</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Assigned Doctor</span>
                                <span class="meta-value" id="preAssignedDoctor"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; line-height: 1.4;">
                        <i class="fa-solid fa-circle-info"></i> Complete the left-side forms to automatically generate and save the patient's record to the global database.
                    </p>
                </div>

            </div>
        </form>
    </div>

    <!-- Live Toast Notification Container -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>Patient registered successfully in Medi Go!</span>
    </div>

    <!-- Dynamic JavaScript Engine -->
    <script>
        const PATIENTS_STORAGE_KEY = 'medigoPatients';
        const GOOGLE_SHEET_URL = 'https://script.google.com/macros/s/AKfycbyPTuQ1MfBGRqpmm4slxsh8AqhuWI-mFA2cPG0clSJVx9bXsDddMpcQC7ZIFJWJOHTx/exec';

        const serverInjectedPatients = <?php echo json_encode($server_patients ?? []); ?>;
        const DEFAULT_PATIENTS = [
            { id: 'PAT-1001', name: 'Arjun Sharma', age: '45', gender: 'Male', disease: 'Hypertension', phone: '+91 98711 22334', status: 'Treatment', createdAt: new Date().toISOString() },
            { id: 'PAT-1002', name: 'Priya Verma', age: '28', gender: 'Female', disease: 'Migraine', phone: '+91 98622 33445', status: 'Improving', createdAt: new Date().toISOString() },
            { id: 'PAT-1003', name: 'Rohan Gupta', age: '12', gender: 'Male', disease: 'Seasonal Flu', phone: '+91 98533 44556', status: 'Recovered', createdAt: new Date().toISOString() },
            { id: 'PAT-1004', name: 'Rahul Sharma', age: '35', gender: 'Male', disease: 'Viral Fever', phone: '+91 98765 43210', status: 'Treatment', createdAt: new Date().toISOString() },
            { id: 'PAT-1005', name: 'Amit Shah', age: '62', gender: 'Male', disease: 'Heart Disease', phone: '+91 76543 21098', status: 'Critical', createdAt: new Date().toISOString() }
        ];

        function mergePatients(serverList, localList) {
            const map = new Map();
            DEFAULT_PATIENTS.forEach(p => {
                const key = String(p.patient_id || p.id || '').toUpperCase().trim();
                if (key) map.set(key, p);
            });
            if (Array.isArray(serverList)) {
                serverList.forEach(p => {
                    const key = String(p.patient_id || p.id || ('PAT-' + p.db_id) || '').toUpperCase().trim();
                    if (key) map.set(key, { ...(map.get(key) || {}), ...p });
                });
            }
            if (Array.isArray(localList)) {
                localList.forEach(p => {
                    const key = String(p.patient_id || p.id || '').toUpperCase().trim();
                    if (key) {
                        const existing = map.get(key) || {};
                        map.set(key, { ...existing, ...p });
                    }
                });
            }
            return Array.from(map.values());
        }

        let globalPatientsList = mergePatients(serverInjectedPatients, (() => {
            try {
                const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch(e) { return []; }
        })());

        let currentEditId = null;
        let isViewMode = false;

        function getStoredPatients() {
            let localList = [];
            try {
                const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                if (raw) localList = JSON.parse(raw) || [];
            } catch (e) {}
            return mergePatients(serverInjectedPatients, Array.isArray(globalPatientsList) ? [...globalPatientsList, ...localList] : localList);
        }

        function savePatients(patients) {
            globalPatientsList = patients;
            try {
                localStorage.setItem(PATIENTS_STORAGE_KEY, JSON.stringify(patients));
            } catch(e){}
        }

        function generatePatientId() {
            return `P${Date.now().toString().slice(-6)}`;
        }

        async function sendPatientToGoogleSheet(patient) {
            try {
                const activeDoctorName = (window.currentDoctor && window.currentDoctor.name) 
                    ? window.currentDoctor.name 
                    : (patient.doctor || patient.assigned_doctor || 'Dr. PRAJAPATI SMIT MANOJKUMAR');

                const sheetData = {
                    patient_name: patient.name,
                    diagnosis: patient.disease,
                    assigned_doctor: activeDoctorName,
                    condition: patient.status,
                    contact: patient.phone,
                    room_ward: ""
                };

                await fetch(GOOGLE_SHEET_URL, {
                    method: "POST",
                    mode: "no-cors",
                    headers: {
                        "Content-Type": "text/plain;charset=utf-8"
                    },
                    body: JSON.stringify(sheetData)
                });

                console.log("Patient sent to Google Sheet for doctor:", activeDoctorName);
                return true;

            } catch (error) {
                console.error("Google Sheet Error:", error);
                return false;
            }
        }

        // Calculate Age dynamically from Date of Birth
        function calculateAge() {
            const dobValue = document.getElementById('formDOB').value;
            if (!dobValue) return;

            const dob = new Date(dobValue);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            // Display calculated age
            document.getElementById('formAge').value = age + " Years";
            updatePreview();
        }

        // Live Preview Sync Engine
        function updatePreview() {
            const name = document.getElementById('formName').value.trim();
            const gender = document.getElementById('formGender').value;
            const ageVal = document.getElementById('formAge').value.trim();
            const blood = document.getElementById('formBloodGroup').value;
            const disease = document.getElementById('formDisease').value.trim();
            const status = document.getElementById('formStatus').value;

            document.getElementById('preName').textContent = name ? name : "John Doe";
            document.getElementById('preBlood').textContent = blood ? blood : "--";
            document.getElementById('preDisease').textContent = disease ? disease : "Not specified";

            const displayAge = ageVal ? ageVal.split(' ')[0] : "--";
            const displayGender = gender ? gender : "--";
            document.getElementById('preAgeGender').textContent = `${displayAge} / ${displayGender}`;

            const avatarBox = document.getElementById('preAvatarIcon');
            if (gender === 'Male') {
                avatarBox.innerHTML = '<i class="fa-solid fa-user-tie"></i>';
            } else if (gender === 'Female') {
                avatarBox.innerHTML = '<i class="fa-solid fa-user-nurse"></i>';
            } else {
                avatarBox.innerHTML = '<i class="fa-solid fa-user-injured"></i>';
            }

            const statusPill = document.getElementById('preStatus');
            statusPill.textContent = status;
            statusPill.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
            if (status === 'Critical') {
                statusPill.style.backgroundColor = 'var(--danger)';
            } else if (status === 'Recovered') {
                statusPill.style.backgroundColor = 'var(--success)';
            } else if (status === 'Improving') {
                statusPill.style.backgroundColor = 'var(--info)';
            }
        }

        function populateForm(patient) {
            document.getElementById('formName').value = patient.name || '';
            document.getElementById('formDOB').value = patient.dob || '';
            document.getElementById('formAge').value = patient.age || '';
            document.getElementById('formGender').value = patient.gender || '';
            document.getElementById('formBloodGroup').value = patient.blood || patient.blood_group || '';
            document.getElementById('formPhone').value = patient.phone || '';
            document.getElementById('formEmail').value = patient.email || '';
            document.getElementById('formDisease').value = patient.disease || '';
            document.getElementById('formStatus').value = patient.status || 'Treatment';
            document.getElementById('formAllergies').value = patient.allergies || '';
            document.getElementById('formContactName').value = patient.contactName || patient.contact_name || '';
            document.getElementById('formRelationship').value = patient.relationship || '';
            document.getElementById('formContactPhone').value = patient.contactPhone || patient.contact_phone || '';

            // Update registration ID in the preview card
            const patId = patient.patient_id || patient.id || 'PENDING';
            document.getElementById('preId').innerHTML = `REGISTRATION ID: <strong style="color: #10b981;">${patId}</strong>`;
        }

        function disableForm() {
            document.getElementById('formName').disabled = true;
            document.getElementById('formDOB').disabled = true;
            document.getElementById('formAge').disabled = true;
            document.getElementById('formGender').disabled = true;
            document.getElementById('formBloodGroup').disabled = true;
            document.getElementById('formPhone').disabled = true;
            document.getElementById('formEmail').disabled = true;
            document.getElementById('formDisease').disabled = true;
            document.getElementById('formStatus').disabled = true;
            document.getElementById('formAllergies').disabled = true;
            document.getElementById('formContactName').disabled = true;
            document.getElementById('formRelationship').disabled = true;
            document.getElementById('formContactPhone').disabled = true;
        }

        // Submit Action
        async function submitForm(event) {
            event.preventDefault();

            if (isViewMode) return;

            const name = document.getElementById('formName').value.trim();
            const dob = document.getElementById('formDOB').value;
            const ageVal = document.getElementById('formAge').value.trim();
            const gender = document.getElementById('formGender').value;
            const blood = document.getElementById('formBloodGroup').value;
            const disease = document.getElementById('formDisease').value.trim();
            const status = document.getElementById('formStatus').value;
            const phone = document.getElementById('formPhone').value.trim();
            const email = document.getElementById('formEmail').value.trim();
            const allergies = document.getElementById('formAllergies').value.trim();
            const contactName = document.getElementById('formContactName').value.trim();
            const relationship = document.getElementById('formRelationship').value;
            const contactPhone = document.getElementById('formContactPhone').value.trim();

            let patients = getStoredPatients();
            let registrationId;

            if (currentEditId) {
                registrationId = currentEditId;
                patients = patients.map(p => {
                    if (p.id === currentEditId || p.patient_id === currentEditId) {
                        return {
                            ...p,
                            name,
                            dob,
                            age: ageVal,
                            gender,
                            blood,
                            disease,
                            status,
                            phone,
                            email,
                            allergies,
                            contactName,
                            relationship,
                            contactPhone
                        };
                    }
                    return p;
                });
                savePatients(patients);

                try {
                    const fd = new FormData();
                    fd.append('action', 'update_patient');
                    fd.append('id', currentEditId);
                    fd.append('name', name);
                    fd.append('dob', dob);
                    fd.append('age', ageVal);
                    fd.append('gender', gender);
                    fd.append('blood', blood);
                    fd.append('disease', disease);
                    fd.append('status', status);
                    fd.append('phone', phone);
                    fd.append('email', email);
                    fd.append('allergies', allergies);
                    fd.append('contactName', contactName);
                    fd.append('relationship', relationship);
                    fd.append('contactPhone', contactPhone);
                    await fetch('api.php', { method: 'POST', body: fd });
                } catch(e){}
            } else {
                registrationId = generatePatientId();

                const activeDoctorName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';
                const activeDoctorId = (window.currentDoctor && window.currentDoctor.id) ? window.currentDoctor.id : 'DOC-SMIT-01';

                const newPatient = {
                    id: registrationId,
                    patient_id: registrationId,
                    name,
                    dob,
                    age: ageVal,
                    gender,
                    blood,
                    disease,
                    status,
                    phone,
                    email,
                    allergies,
                    contactName,
                    relationship,
                    contactPhone,
                    doctor: activeDoctorName,
                    assigned_doctor: activeDoctorName,
                    doctor_assigned: activeDoctorName,
                    doctor_id: activeDoctorId,
                    createdAt: new Date().toISOString()
                };

                // Prepend new patient into local storage immediately
                patients.unshift(newPatient);
                savePatients(patients);

                // Send patient to MySQL Database
                try {
                    const fd = new FormData();
                    fd.append('action', 'add_patient');
                    fd.append('id', registrationId);
                    fd.append('name', name);
                    fd.append('dob', dob);
                    fd.append('age', ageVal);
                    fd.append('gender', gender);
                    fd.append('blood', blood);
                    fd.append('disease', disease);
                    fd.append('status', status);
                    fd.append('phone', phone);
                    fd.append('email', email);
                    fd.append('allergies', allergies);
                    fd.append('contactName', contactName);
                    fd.append('relationship', relationship);
                    fd.append('contactPhone', contactPhone);
                    fd.append('assigned_doctor', activeDoctorName);
                    fd.append('doctor_assigned', activeDoctorName);
                    fd.append('doctor_name', activeDoctorName);
                    fd.append('doctor_id', activeDoctorId);
                    await fetch('api.php', { method: 'POST', body: fd });
                } catch(e){
                    console.warn('MySQL save warning:', e);
                }

                // Send patient to Google Sheet
                sendPatientToGoogleSheet(newPatient);
            }

            document.getElementById('preId').innerHTML = `REGISTRATION ID: <strong style="color: #10b981;">${registrationId}</strong>`;

            // Save active patient in session
            try {
                sessionStorage.setItem('medigoCurrentPatientId', registrationId);
                sessionStorage.setItem('medigoCurrentPatientName', name);
            } catch(e){}

            const toast = document.getElementById('successToast');
            if (currentEditId) {
                toast.querySelector('span').textContent = "Patient profile updated successfully!";
            } else {
                toast.querySelector('span').textContent = `Patient ${name} registered successfully!`;
            }
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
                window.location.href = `Add_patient.php?id=${encodeURIComponent(registrationId)}&mode=view`;
            }, 800);
        }

        // Reset inputs and sync preview
        function resetForm() {
            if (confirm("Reset registration profile and discard changes?")) {
                document.getElementById('patientRegistrationForm').reset();
                document.getElementById('preId').innerHTML = `REGISTRATION ID: <strong style="color: #f59e0b;">PENDING</strong>`;
                updatePreview();
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id') || urlParams.get('patientId') || urlParams.get('patient');
            const mode = urlParams.get('mode') || (id ? 'view' : '');

            // 1. Fetch latest patients from MySQL API for reference and merge without overwriting local patients
            try {
                const response = await fetch('api.php?action=get_patients');
                const res = await response.json();
                if (res.success && res.patients && res.patients.length > 0) {
                    let localList = [];
                    try {
                        const raw = localStorage.getItem(PATIENTS_STORAGE_KEY);
                        if (raw) localList = JSON.parse(raw) || [];
                    } catch(e){}
                    globalPatientsList = mergePatients(res.patients, localList);
                    savePatients(globalPatientsList);
                }
            } catch(e) {
                console.warn('API fetch fallback in Add_patient:', e);
            }

            // If no ID is passed in URL query params, this is a FRESH new patient registration -> Keep form blank!
            if (!id && mode !== 'view' && mode !== 'edit') {
                currentEditId = null;
                isViewMode = false;
                const formEl = document.getElementById('patientRegistrationForm');
                if (formEl) formEl.reset();
                document.getElementById('preName').textContent = "John Doe";
                document.getElementById('preBlood').textContent = "--";
                document.getElementById('preDisease').textContent = "Not specified";
                document.getElementById('preAgeGender').textContent = "--";
                document.getElementById('preId').innerHTML = `REGISTRATION ID: <strong style="color: #f59e0b;">PENDING</strong>`;
                updatePreview();
                return;
            }

            // Target search string
            const targetStr = String(id || '').toLowerCase().trim();
            const patients = getStoredPatients();
            let patient = null;

            if (targetStr) {
                patient = patients.find(p => {
                    const pid = String(p.patient_id || p.id || '').toLowerCase().trim();
                    const pname = String(p.name || '').toLowerCase().trim();
                    const pdb = String(p.db_id || '').toLowerCase().trim();
                    return pid === targetStr || pname === targetStr || (targetStr.length > 2 && (pname.includes(targetStr) || targetStr.includes(pname))) || (pdb && pdb === targetStr);
                });
            }

            // Guaranteed Fallback if patient object was not found in array
            if (!patient && (id || mode === 'view')) {
                const sessName = sessionStorage.getItem('medigoCurrentPatientName') || urlParams.get('name') || 'Registered Patient';
                const sessId = id || sessionStorage.getItem('medigoCurrentPatientId') || 'PAT-1001';
                patient = {
                    id: sessId,
                    patient_id: sessId,
                    name: sessName,
                    dob: '',
                    age: '35 Years',
                    gender: 'Male',
                    blood: 'O+',
                    disease: 'General Health',
                    status: 'Treatment',
                    phone: '+91 98765 43210',
                    email: '',
                    allergies: 'None',
                    contactName: '',
                    relationship: '',
                    contactPhone: ''
                };
            }

            if (patient) {
                const patIdentifier = patient.patient_id || patient.id || id || 'PAT-1001';
                currentEditId = patIdentifier;
                populateForm(patient);

                // Sync active patient to session
                try {
                    sessionStorage.setItem('medigoCurrentPatientId', patIdentifier);
                    sessionStorage.setItem('medigoCurrentPatientName', patient.name || '');
                } catch(e){}

                if (mode !== 'edit') {
                    isViewMode = true;
                    disableForm();
                    const submitBtn = document.querySelector('.btn-submit');
                    const cancelBtn = document.querySelector('.btn-cancel');
                    if (submitBtn) submitBtn.style.display = 'none';
                    if (cancelBtn) cancelBtn.style.display = 'none';

                    const safePatName = (patient.name || 'Patient').replace(/'/g, "\\'");

                    const pageHeader = document.querySelector('.page-header');
                    if (pageHeader) {
                        pageHeader.classList.add('view-header-layout');
                        pageHeader.innerHTML = `
                            <div>
                                <h1 style="margin: 0; font-size: 1.8rem; font-weight: 800; color: var(--text-main);">Patient Profile Details</h1>
                                <p style="margin: 4px 0 0 0; color: var(--text-muted); font-size: 0.95rem;">Viewing registered profile for <strong>${patient.name}</strong> (${patIdentifier}).</p>
                            </div>
                            <div style="display: flex; gap: 12px; justify-content: center; align-items: center; flex-wrap: wrap;">
                                <button class="btn-primary-action" onclick="window.location.href='patienthistory.php?id=' + encodeURIComponent('${patIdentifier}')">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Patient History
                                </button>
                                <button class="btn-primary-action" onclick="window.location.href='PatientReports.php?patient=' + encodeURIComponent('${safePatName}') + '&id=' + encodeURIComponent('${patIdentifier}') + '&mode=view'">
                                    <i class="fa-solid fa-file-waveform"></i> Diagnostic Reports
                                </button>
                                <button class="btn-primary-action" onclick="window.location.href='Add_newentery.php?id=' + encodeURIComponent('${patIdentifier}')">
                                    <i class="fa-solid fa-file-circle-plus"></i> New Entry
                                </button>
                            </div>
                            <div style="display: flex; justify-content: flex-end; align-items: center;">
                                <button class="btn-back" onclick="window.location.href='Allpatient.php'">
                                    <i class="fa-solid fa-arrow-left"></i> Back to Directory
                                </button>
                            </div>
                        `;
                    }
                } else {
                    const headerH1 = document.querySelector('.page-header h1');
                    const headerP = document.querySelector('.page-header p');
                    const submitBtn = document.querySelector('.btn-submit');
                    if (headerH1) headerH1.textContent = "Edit Patient Profile";
                    if (headerP) headerP.textContent = "Modify the patient profile details below.";
                    if (submitBtn) submitBtn.textContent = "Save Changes";
                }
            }

            updatePreview();
        });
    </script>
</body>

</html>
