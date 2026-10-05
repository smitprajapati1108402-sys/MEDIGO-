<?php
require_once 'db_connect.php';

$server_today_queue = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `appointments` WHERE `appointment_date` = CURRENT_DATE ORDER BY `id` ASC");
    if (!$res || mysqli_num_rows($res) === 0) {
        $res = mysqli_query($conn, "SELECT * FROM `appointments` ORDER BY `id` ASC LIMIT 8");
    }
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $p_name = $r['patient_name'] ?? 'Patient';
            $server_today_queue[] = [
                'id' => $r['apt_id'] ?? $r['id'] ?? 'APT-001',
                'patientName' => $p_name,
                'avatar' => strtoupper(substr($p_name, 0, 2)),
                'time' => $r['appointment_time'] ?? '09:30 AM',
                'type' => $r['type'] ?? $r['appointment_type'] ?? 'Regular Checkup',
                'method' => $r['method'] ?? 'Offline',
                'status' => $r['status'] ?? 'Confirmed',
                'bp' => $r['bp'] ?? '120/80',
                'hr' => $r['hr'] ?? '72 bpm',
                'temp' => $r['temp'] ?? '98.6 °F',
                'symptoms' => $r['symptoms'] ?? 'Regular checkup'
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
    <title>MediCare - Today's Appointments</title>
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

        /* Navbar CSS (Consistent Design) */
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

        .nav-left { display: flex; align-items: center; gap: 40px; }
        .brand {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.4rem; font-weight: 800; color: white; text-decoration: none;
        }
        .brand i { font-size: 1.6rem; }
        .nav-menu { display: flex; align-items: center; list-style: none; gap: 8px; height: 100%; }
        .nav-item { position: relative; height: 100%; display: flex; align-items: center; }
        .nav-item>a {
            color: rgba(255, 255, 255, 0.85); text-decoration: none; font-size: 0.9rem;
            font-weight: 600; padding: 8px 16px; border-radius: 8px;
        }
        .nav-item.active>a { background-color: rgba(255, 255, 255, 0.12); color: white; }

        .dropdown {
            position: absolute; top: 90%; left: 0; background-color: white; border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1); min-width: 210px; padding: 8px;
            list-style: none; display: none; flex-direction: column; gap: 4px; z-index: 1100;
            border: 1px solid var(--border-color);
        }
        .nav-item:hover .dropdown { display: flex; }
        .dropdown li a {
            color: var(--text-main); text-decoration: none; font-size: 0.85rem; font-weight: 600;
            padding: 10px 12px; border-radius: 6px; display: flex; align-items: center; gap: 10px;
        }
        .dropdown li a i { color: var(--primary); width: 16px; }
        .dropdown li a:hover { background-color: var(--bg-color); color: var(--primary); }

        /* Wrapper Layout */
        .wrapper {
            max-width: 1440px; margin: 0 auto; padding: 32px;
        }

        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
        .page-header p { color: var(--text-muted); font-size: 0.95rem; }

        /* Daily Summary Stats Blocks */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px;
        }

        .stat-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 20px; display: flex; align-items: center; gap: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
        }
        .stat-icon.blue { background-color: var(--info-light); color: var(--info); }
        .stat-icon.green { background-color: var(--success-light); color: var(--success); }
        .stat-icon.orange { background-color: var(--warning-light); color: var(--warning); }
        .stat-icon.red { background-color: var(--danger-light); color: var(--danger); }

        .stat-data { display: flex; flex-direction: column; }
        .stat-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); }
        .stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-main); }

        /* Split Workspace Grid */
        .today-grid {
            display: grid; grid-template-columns: 1.3fr 1fr; gap: 28px;
        }

        @media (max-width: 1024px) {
            .today-grid { grid-template-columns: 1fr; }
        }

        /* Left Side List Card */
        .queue-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .queue-header {
            font-size: 1.05rem; font-weight: 800; color: var(--text-main);
            border-bottom: 1px solid var(--border-color); padding-bottom: 14px; margin-bottom: 20px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .queue-header span { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }

        .table-responsive { width: 100%; overflow-x: auto; }
        .queue-table { width: 100%; border-collapse: collapse; text-align: left; }

        .queue-table th {
            color: var(--text-muted); font-size: 0.78rem; font-weight: 700;
            text-transform: uppercase; padding: 12px 14px; border-bottom: 1px solid var(--border-color);
        }

        .queue-table td {
            font-size: 0.88rem; padding: 16px 14px; border-bottom: 1px solid var(--border-color);
            white-space: nowrap; cursor: pointer;
        }

        .queue-table tr:hover td { background-color: #fafbfc; }

        .td-time { font-weight: 700; color: var(--primary); }
        .td-patient { font-weight: 700; color: var(--text-main); }

        .status-badge {
            font-size: 0.72rem; font-weight: 700; padding: 4px 10px;
            border-radius: 50px; display: inline-block;
        }
        .status-badge.confirmed { background-color: var(--success-light); color: var(--success); }
        .status-badge.pending { background-color: var(--warning-light); color: var(--warning); }
        .status-badge.completed { background-color: #f0fdf4; color: #15803d; }
        .status-badge.noshow { background-color: var(--danger-light); color: var(--danger); }

        .action-links { display: flex; gap: 8px; }
        .btn-action {
            border: 1px solid var(--border-color); border-radius: 6px;
            padding: 4px 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer;
            background-color: white; transition: all 0.2s;
        }
        .btn-action.done { border-color: var(--success); color: var(--success); }
        .btn-action.done:hover { background-color: var(--success); color: white; }
        .btn-action.noshow { border-color: var(--danger); color: var(--danger); }
        .btn-action.noshow:hover { background-color: var(--danger); color: white; }

        /* Right Side Consultation Card */
        .consult-sticky { position: sticky; top: 100px; }

        .consult-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .consult-title {
            font-size: 1rem; font-weight: 800; color: var(--text-main); margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color); padding-bottom: 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .consult-title i { color: var(--primary); }

        .vitals-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px;
        }

        .vital-box {
            background-color: #f8fafc; border: 1px solid var(--border-color);
            border-radius: 10px; padding: 12px; text-align: center;
        }
        .vital-box span { font-size: 0.72rem; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 4px; }
        .vital-box strong { font-size: 0.95rem; font-weight: 800; color: var(--text-main); }

        .symptom-section {
            background-color: #fafbeb; border: 1px solid #fef08a;
            border-radius: 12px; padding: 16px; margin-bottom: 24px;
        }
        .symptom-section h4 { font-size: 0.82rem; font-weight: 800; color: #854d0e; margin-bottom: 6px; }
        .symptom-section p { font-size: 0.85rem; color: #713f12; line-height: 1.4; }

        .patient-card-header {
            display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
        }
        .patient-avatar {
            width: 44px; height: 44px; background-color: var(--info-light);
            color: var(--info); font-size: 1.2rem; font-weight: bold;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }
        .patient-head-meta h3 { font-size: 1rem; font-weight: 800; }
        .patient-head-meta p { font-size: 0.78rem; color: var(--text-muted); }

        .btn-history-link {
            display: block; width: 100%; text-align: center;
            background-color: var(--bg-color); color: var(--primary);
            border: 1px solid var(--border-color); border-radius: 10px;
            padding: 12px; font-size: 0.85rem; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-history-link:hover { background-color: var(--primary); color: white; border-color: var(--primary); }
    </style>
</head>

<body>

    <!-- 1. Horizontal Navbar -->
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

    <!-- 2. Body Wrapper -->
    <div class="wrapper">
        <div class="page-header">
            <h1>Today's Queue Dashboard</h1>
            <p>Monitor current daily patient waiting times, symptoms, and checkup statuses.</p>
        </div>

        <!-- Metrics Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-users"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Total Queue Today</span>
                    <span class="stat-value" id="stat-total">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Checkups Completed</span>
                    <span class="stat-value" id="stat-completed">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fa-solid fa-user-clock"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Patients Waiting</span>
                    <span class="stat-value" id="stat-waiting">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i class="fa-solid fa-heart-circle-exclamation"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Emergency Consults</span>
                    <span class="stat-value" id="stat-emergency">0</span>
                </div>
            </div>
        </div>

        <!-- Split Workspace Grid -->
        <div class="today-grid">
            
            <!-- Left Side Today's Patient List -->
            <div class="queue-card">
                <div class="queue-header">
                    Today's Active Queue List
                    <span>11 Jun 2026 &bull; Thursday</span>
                </div>

                <div class="table-responsive">
                    <table class="queue-table">
                        <thead>
                            <tr>
                                <th>Assigned Time</th>
                                <th>Patient Name</th>
                                <th>Consultation Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="queueTableBody">
                            <!-- Loaded Dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Side Active Consultation Panel (No Add Appointment button here) -->
            <div class="consult-sticky">
                <div class="consult-card">
                    <div class="consult-title">
                        <i class="fa-solid fa-user-md"></i> Clinical Vitals Panel
                    </div>

                    <!-- Selected Patient Vitals Card -->
                    <div id="vitalsCardContent">
                        <div class="patient-card-header">
                            <div class="patient-avatar" id="activeAvatar">--</div>
                            <div class="patient-head-meta">
                                <h3 id="activeName">Select a Patient</h3>
                                <p id="activeID">Click "Review Vitals" from queue</p>
                                <p id="activeMethod" style="font-size: 0.78rem; font-weight: 600; margin-top: 4px; color: var(--primary);"></p>
                            </div>
                        </div>

                        <!-- Vitals summary -->
                        <div class="vitals-grid">
                            <div class="vital-box">
                                <span>Blood Pressure</span>
                                <strong id="activeBP">--</strong>
                            </div>
                            <div class="vital-box">
                                <span>Heart Rate</span>
                                <strong id="activeHR">--</strong>
                            </div>
                            <div class="vital-box">
                                <span>Temperature</span>
                                <strong id="activeTemp">--</strong>
                            </div>
                        </div>

                        <!-- Symptom Brief -->
                        <div class="symptom-section">
                            <h4>Observation Remarks / Symptoms</h4>
                            <p id="activeSymptoms">Please choose an active patient from the daily checkup waiting queue to inspect pre-consultation vitals.</p>
                        </div>

                        <!-- Patient history deep link -->
                        <a href="patienthistory.php" class="btn-history-link">
                            <i class="fa-solid fa-notes-medical"></i> View Full Medical History
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Live JS Queue Controller -->
    <script>
        // Server MySQL Today's Appointments with Vitals metrics
        const serverQueue = <?php echo json_encode($server_today_queue ?? []); ?>;
        const defaultTodayQueue = [
            { id: "APT-1092", patientName: "Arjun Sharma", avatar: "AS", time: "09:30 AM", type: "Regular Checkup", method: "Offline", status: "Confirmed", bp: "130/82", hr: "76 bpm", temp: "98.6 °F", symptoms: "Patient reported for scheduled monthly hypertension follow-up. Mild morning headache noted. Regular medication on track." },
            { id: "APT-4820", patientName: "Priya Verma", avatar: "PV", time: "10:15 AM", type: "Regular Checkup", method: "Online", status: "Confirmed", bp: "115/76", hr: "72 bpm", temp: "98.4 °F", symptoms: "Migraine follow-up. Visual aura attacks reduced. Experiencing mild fatigue under Propranolol dose." },
            { id: "APT-9931", patientName: "Amit Shah", avatar: "AS", time: "11:00 AM", type: "Emergency Consultation", method: "Offline", status: "Confirmed", bp: "155/95", hr: "94 bpm", temp: "99.1 °F", symptoms: "Mild chest discomfort with palpitations during morning walks. Normal pulse, but slight hypertensive spike noted." },
            { id: "APT-2248", patientName: "Rohan Gupta", avatar: "RG", time: "12:30 PM", type: "Regular Checkup", method: "Online", status: "Pending", bp: "118/75", hr: "78 bpm", temp: "98.6 °F", symptoms: "General checkup post viral flu recovery. Lungs clear." }
        ];

        let activeQueue = serverQueue.length > 0 ? serverQueue : defaultTodayQueue;

        // Fetch or Initialize Database
        function getDatabase() {
            return activeQueue;
        }

        // Render Active Queue Table
        function renderQueue() {
            const queue = getDatabase();
            const tbody = document.getElementById('queueTableBody');
            tbody.innerHTML = '';

            if (queue.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 24px;">No appointments in today's queue.</td></tr>`;
                updateMetrics([]);
                return;
            }

            queue.forEach((appt, index) => {
                const tr = document.createElement('tr');
                
                // Clicking anywhere on row populates Vitals panel
                tr.onclick = () => selectPatient(index);

                tr.innerHTML = `
                    <td class="td-time">${appt.time}</td>
                    <td class="td-patient">${appt.patientName}</td>
                    <td>
                        <div>${appt.type}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                            <i class="${appt.method === 'Online' ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> ${appt.method || 'Offline'}
                        </div>
                    </td>
                    <td><span class="status-badge ${appt.status.toLowerCase()}">${appt.status}</span></td>
                    <td>
                        <div class="action-links" onclick="event.stopPropagation();">
                            ${appt.status !== 'Completed' && appt.status !== 'NoShow' && appt.status !== 'Cancelled' ? `
                                <button class="btn-action done" onclick="updateQueueStatus(${index}, 'Completed')"><i class="fa-solid fa-check"></i> Done</button>
                                <button class="btn-action noshow" onclick="updateQueueStatus(${index}, 'NoShow')"><i class="fa-solid fa-user-xmark"></i> No Show</button>
                            ` : `<button class="btn-action" style="cursor: default; opacity: 0.7;" disabled><i class="fa-solid fa-check-double"></i> ${appt.status}</button>`}
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updateMetrics(queue);
        }

        // Update Counter Summary
        function updateMetrics(queue) {
            let total = queue.length;
            let completed = 0;
            let waiting = 0;
            let emergency = 0;

            queue.forEach(appt => {
                if (appt.status === 'Completed') completed++;
                else if (appt.status === 'Confirmed' || appt.status === 'Pending') waiting++;
                
                if (appt.type && appt.type.includes('Emergency') && appt.status !== 'Completed') emergency++;
            });

            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-completed').textContent = completed;
            document.getElementById('stat-waiting').textContent = waiting;
            document.getElementById('stat-emergency').textContent = emergency;
        }

        // Sync Vitals Panel dynamically on click
        function selectPatient(index) {
            const appt = getDatabase()[index];
            if (!appt) return;
            
            document.getElementById('activeAvatar').textContent = appt.avatar || (appt.patientName ? appt.patientName.substring(0, 2).toUpperCase() : 'PT');
            document.getElementById('activeName').textContent = appt.patientName;
            document.getElementById('activeID').textContent = appt.id;
            document.getElementById('activeBP').textContent = appt.bp || '120/80';
            document.getElementById('activeHR').textContent = appt.hr || '72 bpm';
            document.getElementById('activeTemp').textContent = appt.temp || '98.6 °F';
            document.getElementById('activeSymptoms').textContent = appt.symptoms || 'General observation and follow up.';
            document.getElementById('activeMethod').innerHTML = `<i class="${appt.method === 'Online' ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> Mode: ${appt.method || 'Offline'}`;

            const patIdent = appt.patientId || appt.patient_id || appt.patientName || appt.id;
            try {
                sessionStorage.setItem('medigoCurrentPatientId', patIdent);
                sessionStorage.setItem('medigoCurrentPatientName', appt.patientName || '');
            } catch(e){}

            const histLink = document.querySelector('.btn-history-link');
            if (histLink) {
                histLink.href = `patienthistory.php?id=${encodeURIComponent(patIdent)}`;
            }
        }

        // Live Queue checkout (completed/no show)
        function updateQueueStatus(index, newStatus) {
            const appt = activeQueue[index];
            if (!appt) return;
            appt.status = newStatus;
            renderQueue();

            // Sync with MySQL Database via API
            const formData = new FormData();
            formData.append('id', appt.id);
            formData.append('status', newStatus);

            fetch('api.php?action=update_appointment_status', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log('Status updated in MySQL:', data);
            })
            .catch(err => {
                console.log('Saved locally. Server sync pending:', err);
            });
        }

        // Trigger Setup on Document Launch
        document.addEventListener('DOMContentLoaded', () => {
            // Check if live API has fresher queue
            fetch('api.php?action=get_today_appointments')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.queue && data.queue.length > 0) {
                    activeQueue = data.queue;
                    renderQueue();
                    selectPatient(0);
                }
            })
            .catch(() => {
                // Keep serverQueue fallback
            });

            renderQueue();
            selectPatient(0);
        });
    </script>
</body>

</html>
