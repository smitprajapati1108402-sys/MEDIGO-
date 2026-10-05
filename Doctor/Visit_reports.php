<?php
require_once 'db_connect.php';

$server_visits = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `patient_visits` ORDER BY `visit_date` DESC, `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_visits[] = [
                'id' => $r['visit_id'] ?: ('VIS-' . $r['id']),
                'patient_id' => $r['patient_id'] ?? 'PAT-1001',
                'patient_name' => $r['patient_name'] ?? 'Patient',
                'doctor_name' => $r['doctor_name'] ?? ($current_doc_name ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'),
                'visit_date' => $r['visit_date'] ?? date('Y-m-d'),
                'visit_time' => $r['visit_time'] ?? '10:00 AM',
                'visit_type' => $r['visit_type'] ?? 'OPD Consultation',
                'department' => $r['department'] ?? 'Cardiology',
                'diagnosis' => $r['diagnosis'] ?? 'Clinical Diagnosis',
                'bp' => $r['bp'] ?? '120/80',
                'pulse' => $r['pulse'] ?? '72 bpm',
                'fee' => (float)($r['fee'] ?? 500),
                'status' => $r['status'] ?? 'Completed',
                'notes' => $r['notes'] ?? ''
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
    <title>Medi Go - Patient Visit & Consultation Reports</title>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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

        .btn {
            padding: 10px 18px;
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

        .btn-primary { background-color: var(--primary); color: white; }
        .btn-secondary { background-color: white; color: var(--text-main); border: 1px solid var(--border-color); }

        /* 3. KPI Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        .kpi-info h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .kpi-info p {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        .kpi-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .kpi-icon.blue { background: var(--info-light); color: var(--primary); }
        .kpi-icon.green { background: var(--success-light); color: var(--success); }
        .kpi-icon.amber { background: var(--warning-light); color: var(--warning); }
        .kpi-icon.purple { background: #f3e8ff; color: #7e22ce; }

        /* 4. Analytics Grid */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .chart-header h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* 5. Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            padding: 14px 18px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            text-transform: uppercase;
        }

        td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.88rem;
            vertical-align: middle;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .visit-type-badge {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            background: #eff6ff;
            color: var(--primary);
        }

        .visit-type-badge.emergency {
            background: var(--danger-light);
            color: var(--danger);
        }

        .visit-type-badge.followup {
            background: var(--success-light);
            color: var(--success);
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
                <li class="nav-item active">
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

    <!-- 2. Workspace Body -->
    <div class="wrapper">
        <div class="page-header">
            <div class="header-title">
                <h1><i class="fa-solid fa-hospital-user" style="color: var(--primary);"></i> Patient Visits & OPD Consultation Reports</h1>
                <p>Track clinical patient footfall, OPD consultations, emergency admissions, and follow-up metrics</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Statement</button>
                <button type="button" class="btn btn-primary" onclick="exportVisitsCSV()"><i class="fa-solid fa-download"></i> Export CSV</button>
            </div>
        </div>

        <!-- KPI Summary Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>284</h3>
                    <p>Total Patient Encounters</p>
                </div>
                <div class="kpi-icon blue"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>78.5%</h3>
                    <p>OPD Consultations</p>
                </div>
                <div class="kpi-icon green"><i class="fa-solid fa-stethoscope"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>16 Mins</h3>
                    <p>Avg Consultation Duration</p>
                </div>
                <div class="kpi-icon amber"><i class="fa-solid fa-stopwatch"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>21.5%</h3>
                    <p>Emergency & Inpatient Reviews</p>
                </div>
                <div class="kpi-icon purple"><i class="fa-solid fa-truck-medical"></i></div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="analytics-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fa-solid fa-chart-simple" style="color: var(--primary);"></i> Weekly Consultation Footfall</h3>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">Current Month</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="footfallChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fa-solid fa-chart-pie" style="color: #059669;"></i> Visit Type Breakdown</h3>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">Distribution</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="visitTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main);"><i class="fa-solid fa-clipboard-list" style="color: var(--primary);"></i> Doctor-Patient Clinical Visit Log</h3>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Showing <?php echo count($server_visits); ?> Visits</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Visit ID</th>
                            <th>Patient Information</th>
                            <th>Date & Time</th>
                            <th>Consultation Type</th>
                            <th>Clinical Diagnosis</th>
                            <th>Vitals (BP/HR)</th>
                            <th>Fee (₹)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($server_visits as $v): ?>
                            <tr>
                                <td><strong style="color: var(--primary);"><?php echo htmlspecialchars($v['id']); ?></strong></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($v['patient_name']); ?></strong>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);"><?php echo htmlspecialchars($v['patient_id']); ?> • <?php echo htmlspecialchars($v['department']); ?></div>
                                </td>
                                <td>
                                    <strong><?php echo date('d M Y', strtotime($v['visit_date'])); ?></strong>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);"><?php echo htmlspecialchars($v['visit_time']); ?></div>
                                </td>
                                <td>
                                    <?php 
                                    $vClass = 'visit-type-badge';
                                    if (stripos($v['visit_type'], 'Emergency') !== false) $vClass .= ' emergency';
                                    if (stripos($v['visit_type'], 'Follow') !== false) $vClass .= ' followup';
                                    ?>
                                    <span class="<?php echo $vClass; ?>"><?php echo htmlspecialchars($v['visit_type']); ?></span>
                                </td>
                                <td><strong><?php echo htmlspecialchars($v['diagnosis']); ?></strong></td>
                                <td><span style="font-size: 0.82rem; font-weight: 700; color: #475569;"><?php echo htmlspecialchars($v['bp']); ?> | <?php echo htmlspecialchars($v['pulse']); ?></span></td>
                                <td><strong>₹<?php echo number_format($v['fee'], 2); ?></strong></td>
                                <td><span style="color: var(--success); font-weight: 700;"><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($v['status']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Footfall Chart
            const ctxFoot = document.getElementById('footfallChart').getContext('2d');
            new Chart(ctxFoot, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    datasets: [{
                        label: 'Patients Consulted',
                        data: [42, 38, 48, 52, 45, 32],
                        backgroundColor: '#0a52a3',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Visit Type Chart
            const ctxType = document.getElementById('visitTypeChart').getContext('2d');
            new Chart(ctxType, {
                type: 'doughnut',
                data: {
                    labels: ['General OPD', 'Follow-up Checkup', 'Emergency Review', 'Specialist Assessment'],
                    datasets: [{
                        data: [52, 26, 12, 10],
                        backgroundColor: ['#0a52a3', '#10b981', '#ef4444', '#8b5cf6'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' } } }
                    }
                }
            });
        });

        function exportVisitsCSV() {
            let csv = 'Visit ID,Patient Name,Patient ID,Date,Type,Diagnosis,Fee\n';
            <?php foreach ($server_visits as $v): ?>
                csv += `"<?php echo $v['id']; ?>","<?php echo $v['patient_name']; ?>","<?php echo $v['patient_id']; ?>","<?php echo $v['visit_date']; ?>","<?php echo $v['visit_type']; ?>","<?php echo $v['diagnosis']; ?>","<?php echo $v['fee']; ?>"\n`;
            <?php endforeach; ?>
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('href', url);
            a.setAttribute('download', 'medigo_patient_visits.csv');
            a.click();
        }
    </script>
</body>
</html>
