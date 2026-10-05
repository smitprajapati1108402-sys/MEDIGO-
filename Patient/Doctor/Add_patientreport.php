<?php
require_once 'db_connect.php';

$server_patients = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patients` ORDER BY `name` ASC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_patients[] = $r;
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
    <title>MediCare - Upload Patient Report</title>
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

        /* Navbar */
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

        .wrapper {
            max-width: 1440px; margin: 0 auto; padding: 32px;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;
        }
        .page-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
        .page-header p { color: var(--text-muted); font-size: 0.95rem; }

        .btn-back {
            background-color: transparent; color: var(--primary); border: 1px solid var(--primary);
            padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-back:hover { background-color: var(--primary); color: white; }

        /* Grid */
        .upload-grid {
            display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px;
        }

        @media (max-width: 1024px) {
            .upload-grid { grid-template-columns: 1fr; }
        }

        .form-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.1rem; font-weight: 800; color: var(--text-main);
            margin-bottom: 20px; border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px; display: flex; align-items: center; gap: 10px;
        }
        .card-title i { color: var(--primary); }

        .inputs-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
        .inputs-row.full { grid-template-columns: 1fr; }

        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-size: 0.8rem; font-weight: 700; color: var(--text-main); }
        .input-group input, .input-group select, .input-group textarea {
            padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px;
            outline: none; font-size: 0.9rem; background-color: #fafbfd;
        }

        /* Drag & Drop */
        .upload-zone {
            border: 2px dashed #cbd5e1; border-radius: 16px; padding: 40px 20px;
            text-align: center; background-color: #fafbfd; cursor: pointer;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px;
        }
        .upload-zone.dragover { border-color: var(--primary); background-color: var(--info-light); }
        .upload-zone i { font-size: 2.5rem; color: var(--primary); }
        .upload-zone h4 { font-size: 0.95rem; font-weight: 700; }
        .upload-zone p { font-size: 0.78rem; color: var(--text-muted); }
        .file-input { display: none; }

        /* Progress Card */
        .progress-card {
            display: none; background-color: #fafbfd; border: 1px solid var(--border-color);
            border-radius: 12px; padding: 16px; margin-top: 20px; align-items: center; gap: 14px;
        }
        .progress-icon { font-size: 1.5rem; color: var(--primary); }
        .progress-details { flex-grow: 1; }
        .progress-details .file-name { font-size: 0.85rem; font-weight: 700; margin-bottom: 4px; }
        .progress-bar-container { background-color: #e2e8f0; height: 6px; border-radius: 50px; overflow: hidden; }
        .progress-bar-fill { background-color: var(--primary); height: 100%; width: 0%; transition: width 0.1s linear; }
        .progress-percent { font-size: 0.78rem; font-weight: 700; color: var(--text-muted); }

        /* Preview card */
        .preview-sticky { position: sticky; top: 100px; }
        .patient-summary-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
        }
        .patient-header { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; }
        .patient-avatar { width: 52px; height: 52px; background-color: var(--info-light); color: var(--info); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: bold; }
        .patient-details h3 { font-size: 1.05rem; font-weight: 800; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .info-item { display: flex; flex-direction: column; gap: 4px; }
        .info-label { font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
        .info-value { font-size: 0.88rem; font-weight: 600; }

        .action-bar { display: flex; justify-content: flex-end; gap: 16px; margin-top: 24px; }
        .btn-cancel { background-color: #e2e8f0; color: var(--text-main); border: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; cursor: pointer; }
        .btn-submit { background-color: var(--primary); color: white; border: none; padding: 12px 32px; border-radius: 12px; font-weight: 700; cursor: pointer; }

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

    <div class="wrapper">
        <div class="page-header">
            <div>
                <h1>Clinical Report Upload</h1>
                <p>Register, verify, and upload diagnostic files dynamically to patient databases [INDEX].</p>
            </div>
            <button class="btn-back" onclick="window.location.href='PatientReports.php'">
                <i class="fa-solid fa-arrow-left"></i> Back to Reports
            </button>
        </div>

        <form id="uploadReportForm" onsubmit="submitReportForm(event)">
            <div class="upload-grid">
                <div>
                    <div class="form-card">
                        <div class="card-title"><i class="fa-solid fa-file-invoice"></i> Report Details</div>
                        
                        <!-- Row 1: Patient and Category -->
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="patientSelector">Select Patient *</label>
                                <select id="patientSelector" required onchange="onPatientSelect()">
                                    <option value="" disabled selected>Select registered patient</option>
                                    <option value="Arjun Sharma">Arjun Sharma (PAT-1001)</option>
                                    <option value="Priya Verma">Priya Verma (PAT-1002)</option>
                                    <option value="Rohan Gupta">Rohan Gupta (PAT-1003)</option>
                                    <option value="Rahul Sharma">Rahul Sharma (PAT-1004)</option>
                                    <option value="Amit Shah">Amit Shah (PAT-1005)</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="reportCategory">Report Category *</label>
                                <select id="reportCategory" required>
                                    <option value="" disabled selected>Select category</option>
                                    <option value="Lipid Profile (Blood)">Lipid Profile (Blood Test)</option>
                                    <option value="Electrocardiogram (ECG)">Electrocardiogram (ECG)</option>
                                    <option value="Head MRI scan">Head MRI / Brain Scan</option>
                                    <option value="HbA1c Diabetes Profile">HbA1c Diabetes Profile</option>
                                    <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Patient Age and Patient Gender -->
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="reportAge">Patient Age *</label>
                                <input type="number" id="reportAge" required placeholder="e.g. 45" oninput="updatePreviewFromInputs()">
                            </div>
                            <div class="input-group">
                                <label for="reportGender">Patient Gender *</label>
                                <select id="reportGender" required onchange="updatePreviewFromInputs()">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Blood Group and Allergies -->
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="reportBloodGroup">Blood Group *</label>
                                <select id="reportBloodGroup" required onchange="updatePreviewFromInputs()">
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
                            <div class="input-group">
                                <label for="reportAllergies">Allergies *</label>
                                <input type="text" id="reportAllergies" required placeholder="e.g. Dust, Penicillin or None" oninput="updatePreviewFromInputs()">
                            </div>
                        </div>

                        <!-- Row 4: Manual Report ID and Diagnostics Laboratory -->
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="reportIdInput">Report Reference ID *</label>
                                <input type="text" id="reportIdInput" required placeholder="e.g. REP-7049" oninput="onIdInput()">
                            </div>
                            <div class="input-group">
                                <label for="labName">Diagnostics Laboratory *</label>
                                <input type="text" id="labName" required placeholder="e.g. Standard Diagnostics Corp.">
                            </div>
                        </div>

                        <!-- Row 5: Verification Status -->
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="reportStatus">Verification Status *</label>
                                <select id="reportStatus" required>
                                    <option value="Approved">Approved</option>
                                    <option value="Review">Pending Review</option>
                                    <option value="Critical">Critical Alert</option>
                                </select>
                            </div>
                        </div>

                        <div class="inputs-row full">
                            <div class="input-group">
                                <label for="findings">Diagnostic Findings & Notes</label>
                                <textarea id="findings" rows="3" placeholder="Enter notes..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="card-title"><i class="fa-solid fa-cloud-arrow-up"></i> Diagnostic File Upload</div>
                        <div class="upload-zone" id="dropZone" onclick="triggerFileSelect()">
                            <i class="fa-solid fa-file-pdf"></i>
                            <h4>Drag & Drop your report file here</h4>
                            <p>or click to browse from device (PDF, JPEG, PNG, max 10MB)</p>
                            <input type="file" id="fileInput" class="file-input" accept=".pdf,.png,.jpg,.jpeg" onchange="handleFileSelection()">
                        </div>

                        <!-- Progress Bar Card -->
                        <div class="progress-card" id="progressContainer">
                            <i class="fa-solid fa-circle-notch fa-spin progress-icon" id="progressSpinner"></i>
                            <i class="fa-solid fa-circle-check progress-icon" style="color: var(--success); display: none;" id="progressCheck"></i>
                            <div class="progress-details">
                                <div class="file-name" id="fileNameText">report_file.pdf</div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar-fill" id="progressBar"></div>
                                </div>
                                <span class="progress-percent" id="progressPercent">0%</span>
                            </div>
                        </div>
                    </div>

                    <div class="action-bar">
                        <button type="button" class="btn-cancel" onclick="resetForm()">Clear Form</button>
                        <button type="submit" class="btn-submit">Upload & Save Report</button>
                    </div>
                </div>

                <!-- Preview Column -->
                <div class="preview-sticky">
                    <div class="patient-summary-card">
                        <div class="patient-header">
                            <div class="patient-avatar" id="prevAvatar">--</div>
                            <div class="patient-details">
                                <h3 id="prevName">Select Patient</h3>
                                <p id="prevID">ID: --</p>
                                <!-- Custom Report ID Preview -->
                                <p id="prevRepID" style="font-size: 0.78rem; font-weight: 700; color: var(--primary); margin-top: 4px;">REPORT REF: --</p>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Age / Gender</span>
                                <span class="info-value" id="prevAgeGender">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Allergies</span>
                                <span class="info-value" id="prevAllergies" style="color: var(--danger);">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Blood Group</span>
                                <span class="info-value" id="prevBlood">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Assigned Doctor</span>
                                <span class="info-value"><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>Clinical report successfully saved to database!</span>
    </div>

    <script>
        const serverPatients = <?php echo json_encode($server_patients ?? []); ?>;

        let patientData = {
            "Arjun Sharma": { ageGender: "42 / Male", blood: "O+", allergies: "Dust & Penicillin", avatar: "AS", id: "PAT-1001" },
            "Priya Verma": { ageGender: "29 / Female", blood: "A+", allergies: "Sulfonamides", avatar: "PV", id: "PAT-1002" },
            "Amit Shah": { ageGender: "56 / Male", blood: "B+", allergies: "None", avatar: "AS", id: "PAT-1003" },
            "Rohan Gupta": { ageGender: "23 / Male", blood: "AB+", allergies: "None", avatar: "RG", id: "PAT-1004" },
            "Ananya Iyer": { ageGender: "34 / Female", blood: "B-", allergies: "Ibuprofen", avatar: "AI", id: "PAT-1005" }
        };

        let activeFile = null;

        function getInitials(name) {
            if (!name) return "--";
            const parts = name.trim().split(/\s+/);
            if (parts.length >= 2) return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            return parts[0].slice(0, 2).toUpperCase();
        }

        async function initPatientDirectory() {
            if (Array.isArray(serverPatients) && serverPatients.length > 0) {
                const select = document.getElementById('patientSelector');
                if (select) {
                    select.innerHTML = '<option value="" disabled selected>Select registered patient...</option>';
                    serverPatients.forEach(p => {
                        const pName = p.name;
                        const pId = p.patient_id || p.id;
                        patientData[pName] = {
                            ageGender: `${p.age || '40'} / ${p.gender || 'Male'}`,
                            blood: p.blood || "O+",
                            allergies: p.allergies || "None",
                            avatar: getInitials(pName),
                            id: pId
                        };
                        const opt = document.createElement('option');
                        opt.value = pName;
                        opt.textContent = `${pName} (${pId})`;
                        select.appendChild(opt);
                    });
                }
            }

            try {
                const res = await fetch('api.php?action=get_patients');
                const data = await res.json();
                if (data.success && Array.isArray(data.patients) && data.patients.length > 0) {
                    const select = document.getElementById('patientSelector');
                    if (select) {
                        select.innerHTML = '<option value="" disabled selected>Select registered patient...</option>';
                        data.patients.forEach(p => {
                            patientData[p.name] = {
                                ageGender: `${p.age || '40'} / ${p.gender || 'Male'}`,
                                blood: p.blood || "O+",
                                allergies: p.allergies || "None",
                                avatar: getInitials(p.name),
                                id: p.id
                            };
                            const opt = document.createElement('option');
                            opt.value = p.name;
                            opt.textContent = `${p.name} (${p.id})`;
                            select.appendChild(opt);
                        });
                    }
                }
            } catch(e){}
        }

        function onPatientSelect() {
            const select = document.getElementById('patientSelector').value;
            const patient = patientData[select];
            if (patient) {
                document.getElementById('prevAvatar').textContent = patient.avatar;
                document.getElementById('prevName').textContent = select;
                document.getElementById('prevID').textContent = `ID: ${patient.id}`;
                
                const parts = (patient.ageGender || '').split(' / ');
                document.getElementById('reportAge').value = (parts[0] || '').replace(/\D/g, '');
                document.getElementById('reportGender').value = parts[1] || 'Male';
                document.getElementById('reportBloodGroup').value = patient.blood || 'O+';
                document.getElementById('reportAllergies').value = patient.allergies || 'None';

                document.getElementById('prevAgeGender').textContent = patient.ageGender;
                document.getElementById('prevBlood').textContent = patient.blood;
                document.getElementById('prevAllergies').textContent = patient.allergies;
            }
        }

        function updatePreviewFromInputs() {
            const age = document.getElementById('reportAge').value.trim();
            const gender = document.getElementById('reportGender').value;
            const blood = document.getElementById('reportBloodGroup').value;
            const allergies = document.getElementById('reportAllergies').value.trim();

            const displayAge = age ? age : "--";
            const displayGender = gender ? gender : "--";
            document.getElementById('prevAgeGender').textContent = `${displayAge} / ${displayGender}`;
            document.getElementById('prevBlood').textContent = blood ? blood : "--";
            document.getElementById('prevAllergies').textContent = allergies ? allergies : "--";
        }

        // Live report ID text update in preview card
        function onIdInput() {
            const idVal = document.getElementById('reportIdInput').value.trim();
            document.getElementById('prevRepID').textContent = idVal ? `REPORT REF: ${idVal.toUpperCase()}` : "REPORT REF: --";
        }

        function triggerFileSelect() { document.getElementById('fileInput').click(); }

        function handleFileSelection() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                activeFile = file;

                let sizeStr = "";
                if (file.size > 1024 * 1024) {
                    sizeStr = `(${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
                } else {
                    sizeStr = `(${(file.size / 1024).toFixed(1)} KB)`;
                }

                simulateFileUpload(`${file.name} ${sizeStr}`);
            }
        }

        function simulateFileUpload(name) {
            const progressCard = document.getElementById('progressContainer');
            const fileNameText = document.getElementById('fileNameText');
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');
            const progressSpinner = document.getElementById('progressSpinner');
            const progressCheck = document.getElementById('progressCheck');

            progressCard.style.display = 'flex';
            fileNameText.textContent = name;
            progressBar.style.width = '0%';
            progressPercent.textContent = '0%';
            progressSpinner.style.display = 'block';
            progressCheck.style.display = 'none';

            let percent = 0;
            const interval = setInterval(() => {
                percent += Math.floor(Math.random() * 20) + 10;
                if (percent >= 100) {
                    percent = 100;
                    clearInterval(interval);
                    progressSpinner.style.display = 'none';
                    progressCheck.style.display = 'block';
                }
                progressBar.style.width = `${percent}%`;
                progressPercent.textContent = `${percent}%`;
            }, 80);
        }

        async function submitReportForm(event) {
            event.preventDefault();

            const patientName = document.getElementById('patientSelector').value;
            if (!patientName) {
                alert("Please select a patient.");
                return;
            }

            const category = document.getElementById('reportCategory').value;
            const customId = document.getElementById('reportIdInput').value.trim().toUpperCase() || `REP-${Math.floor(1000 + Math.random() * 9000)}`;
            const labName = document.getElementById('labName').value || 'Medigo Central Lab';
            const status = document.getElementById('reportStatus').value;
            const findings = document.getElementById('findings') ? document.getElementById('findings').value : '';

            const age = document.getElementById('reportAge').value.trim();
            const gender = document.getElementById('reportGender').value;
            const blood = document.getElementById('reportBloodGroup').value;
            const allergies = document.getElementById('reportAllergies').value.trim();
            const patientInfo = patientData[patientName] || {};
            const patientId = patientInfo.id || 'PAT-1001';
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';

            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${y}-${m}-${d}`;

            // 1. Submit to MySQL API
            try {
                const formData = new FormData();
                formData.append('patientId', patientId);
                formData.append('patientName', patientName);
                formData.append('reportType', category);
                formData.append('category', category);
                formData.append('doctor', docName);
                formData.append('summary', `Lab: ${labName}. Findings: ${findings || 'Normal diagnostic review'}`);
                formData.append('results', `Status: ${status}. Verified.`);

                const res = await fetch('api.php?action=add_report', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();
            } catch(e) {
                console.warn('Database error:', e);
            }

            // 2. Save locally
            const newRecord = {
                id: customId,
                patientName: patientName,
                category: category,
                lab: labName,
                date: formattedDate,
                status: status,
                age: age,
                gender: gender,
                blood: blood,
                allergies: allergies
            };

            let db = JSON.parse(localStorage.getItem('medigo_reports')) || [];
            db.unshift(newRecord);
            localStorage.setItem('medigo_reports', JSON.stringify(db));

            const toast = document.getElementById('successToast');
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
                window.location.href = "PatientReports.php";
            }, 1800);
        }

        function resetForm() {
            if (confirm("Reset current upload details?")) {
                document.getElementById('uploadReportForm').reset();
                document.getElementById('progressContainer').style.display = 'none';
                document.getElementById('prevRepID').textContent = "REPORT REF: --";
                document.getElementById('prevAvatar').textContent = "--";
                document.getElementById('prevName').textContent = "Select Patient";
                document.getElementById('prevID').textContent = "ID: --";
                document.getElementById('prevAgeGender').textContent = "--";
                document.getElementById('prevBlood').textContent = "--";
                document.getElementById('prevAllergies').textContent = "--";
                activeFile = null;
            }
        }

        document.addEventListener('DOMContentLoaded', initPatientDirectory);
    </script>
</body>

</html>
