<?php
require_once 'db_connect.php';

$server_records = [];
if (!empty($db_connected) && !empty($conn)) {
    $res = mysqli_query($conn, "SELECT * FROM `revenue_records` ORDER BY `payment_date` DESC, `id` DESC");
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $server_records[] = [
                'id' => $r['invoice_no'] ?: ('INV-' . $r['id']),
                'invoice_no' => $r['invoice_no'] ?: ('INV-' . $r['id']),
                'patient_id' => $r['patient_id'] ?? 'PAT-1001',
                'patient_name' => $r['patient_name'] ?? 'Patient',
                'doctor_name' => $r['doctor_name'] ?? ($current_doc_name ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'),
                'service_type' => $r['service_type'] ?? 'Consultation',
                'payment_method' => $r['payment_method'] ?? 'UPI',
                'amount' => (float)($r['amount'] ?? 500),
                'discount' => (float)($r['discount'] ?? 0),
                'tax' => (float)($r['tax'] ?? 0),
                'net_amount' => (float)($r['net_amount'] ?? 500),
                'payment_status' => $r['payment_status'] ?? 'Paid',
                'payment_date' => $r['payment_date'] ?? date('Y-m-d')
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
    <title>Medi Go - Revenue & Consultation Billing Reports</title>
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

        .kpi-icon.green { background: var(--success-light); color: var(--success); }
        .kpi-icon.blue { background: var(--info-light); color: var(--primary); }
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

        .inv-badge {
            font-weight: 800;
            color: var(--primary);
            background: #eff6ff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.82rem;
        }

        .pay-method-badge {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f1f5f9;
            color: #334155;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-card {
            background: white;
            border-radius: 14px;
            max-width: 540px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 30px;
            position: relative;
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
                <h1><i class="fa-solid fa-money-bill-trend-up" style="color: var(--primary);"></i> Doctor Revenue & Billing Reports</h1>
                <p>Consultation fees, insurance settlement statements, and service revenue analytics</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Statement</button>
                <button type="button" class="btn btn-primary" onclick="exportRevenueCSV()"><i class="fa-solid fa-download"></i> Export Statement</button>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>₹1,48,500</h3>
                    <p>Total Revenue (Year to Date)</p>
                </div>
                <div class="kpi-icon green"><i class="fa-solid fa-indian-rupee-sign"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>₹54,200</h3>
                    <p>Current Month Gross Earnings</p>
                </div>
                <div class="kpi-icon blue"><i class="fa-solid fa-wallet"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>₹8,400</h3>
                    <p>Pending Insurance Claims</p>
                </div>
                <div class="kpi-icon amber"><i class="fa-solid fa-receipt"></i></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-info">
                    <h3>₹620</h3>
                    <p>Average Fee per Patient</p>
                </div>
                <div class="kpi-icon purple"><i class="fa-solid fa-chart-line"></i></div>
            </div>
        </div>

        <!-- Analytics Charts -->
        <div class="analytics-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fa-solid fa-chart-area" style="color: var(--primary);"></i> Monthly Revenue Trajectory (₹)</h3>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">Year 2026</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="revGrowthChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3><i class="fa-solid fa-credit-card" style="color: #059669;"></i> Payment Methods Share</h3>
                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">By Volume</span>
                </div>
                <div style="height: 260px;">
                    <canvas id="payMethodChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main);"><i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Doctor Billing & Settlement Log</h3>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Showing <?php echo count($server_records); ?> Invoices</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient Information</th>
                            <th>Service Description</th>
                            <th>Payment Mode</th>
                            <th>Gross Amount</th>
                            <th>Net Received</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($server_records as $rec): ?>
                            <tr>
                                <td><span class="inv-badge"><?php echo htmlspecialchars($rec['id']); ?></span></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($rec['patient_name']); ?></strong>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);"><?php echo htmlspecialchars($rec['patient_id']); ?></div>
                                </td>
                                <td><strong><?php echo htmlspecialchars($rec['service_type']); ?></strong></td>
                                <td><span class="pay-method-badge"><?php echo htmlspecialchars($rec['payment_method']); ?></span></td>
                                <td>₹<?php echo number_format($rec['amount'], 2); ?></td>
                                <td><strong style="color: #0f172a;">₹<?php echo number_format($rec['net_amount'], 2); ?></strong></td>
                                <td><?php echo date('d M Y', strtotime($rec['payment_date'])); ?></td>
                                <td><span style="color: var(--success); font-weight: 700;"><i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($rec['payment_status']); ?></span></td>
                                <td style="text-align: right;">
                                    <button type="button" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;" onclick="viewInvoiceReceipt('<?php echo htmlspecialchars($rec['id']); ?>', '<?php echo htmlspecialchars($rec['patient_name']); ?>', '<?php echo htmlspecialchars($rec['service_type']); ?>', '<?php echo $rec['net_amount']; ?>', '<?php echo $rec['payment_method']; ?>')"><i class="fa-solid fa-receipt"></i> View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal-overlay" id="receiptModal">
        <div class="modal-card">
            <div style="text-align: center; border-bottom: 2px solid #084382; padding-bottom: 16px; margin-bottom: 18px;">
                <h3 style="color: #084382; font-weight: 800; font-size: 1.3rem;"><i class="fa-solid fa-square-h"></i> MEDI GO HOSPITAL</h3>
                <p style="font-size: 0.8rem; color: #64748b;">Clinical Consultation Fee Receipt • GSTIN: 24AAACM1234F1Z5</p>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 16px;">
                <div>
                    <div><strong>Invoice No:</strong> <span id="recInvoice">INV-2026-001</span></div>
                    <div><strong>Patient:</strong> <span id="recPatient">Arjun Sharma</span></div>
                </div>
                <div style="text-align: right;">
                    <div><strong>Date:</strong> <span><?php echo date('d M Y'); ?></span></div>
                    <div><strong>Doctor:</strong> <span><?php echo htmlspecialchars($current_doctor['name'] ?? 'Dr. PRAJAPATI SMIT MANOJKUMAR'); ?></span></div>
                </div>
            </div>

            <div style="background: #f8fafc; border-radius: 8px; padding: 14px; margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; font-weight: 700; border-bottom: 1px dashed #cbd5e1; padding-bottom: 8px;">
                    <span id="recService">Cardiology OPD Consultation</span>
                    <span id="recAmount">₹600.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 0.85rem; color: #475569;">
                    <span>Payment Mode:</span>
                    <strong id="recMethod">UPI Online</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 1rem; font-weight: 800; color: #084382;">
                    <span>Total Amount Paid:</span>
                    <span id="recTotal">₹600.00</span>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('receiptModal').style.display = 'none';">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Receipt</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Revenue Growth Chart
            const ctxGrowth = document.getElementById('revGrowthChart').getContext('2d');
            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                    datasets: [{
                        label: 'Earnings (₹)',
                        data: [38000, 42500, 47000, 52000, 50500, 58000, 61000, 64500, 54200],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointRadius: 4
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

            // Payment Method Chart
            const ctxPay = document.getElementById('payMethodChart').getContext('2d');
            new Chart(ctxPay, {
                type: 'pie',
                data: {
                    labels: ['UPI / QR Code', 'Health Insurance TPA', 'Debit / Credit Card', 'Cash'],
                    datasets: [{
                        data: [48, 28, 16, 8],
                        backgroundColor: ['#0a52a3', '#10b981', '#f59e0b', '#64748b'],
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

        function viewInvoiceReceipt(inv, patient, service, amount, method) {
            document.getElementById('recInvoice').textContent = inv;
            document.getElementById('recPatient').textContent = patient;
            document.getElementById('recService').textContent = service;
            document.getElementById('recAmount').textContent = '₹' + parseFloat(amount).toFixed(2);
            document.getElementById('recMethod').textContent = method;
            document.getElementById('recTotal').textContent = '₹' + parseFloat(amount).toFixed(2);
            document.getElementById('receiptModal').style.display = 'flex';
        }

        function exportRevenueCSV() {
            let csv = 'Invoice No,Patient Name,Service,Payment Method,Net Amount,Date,Status\n';
            <?php foreach ($server_records as $r): ?>
                csv += `"<?php echo $r['id']; ?>","<?php echo $r['patient_name']; ?>","<?php echo $r['service_type']; ?>","<?php echo $r['payment_method']; ?>","<?php echo $r['net_amount']; ?>","<?php echo $r['payment_date']; ?>","<?php echo $r['payment_status']; ?>"\n`;
            <?php endforeach; ?>
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('href', url);
            a.setAttribute('download', 'medigo_doctor_revenue_report.csv');
            a.click();
        }
    </script>
</body>
</html>
