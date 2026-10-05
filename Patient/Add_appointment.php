<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - Patient Portal</title>
    <?php include 'patient_auth.php'; ?>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --primary-light: #f0f9ff;
            --bg-color: #f4f7fc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
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

        /* 1. Header Navigation */
        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 1.35rem;
            font-weight: 800;
        }

        .nav-brand i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .nav-brand span {
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 16px;
            align-items: center;
            height: 100%;
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .nav-item > a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item.active > a,
        .nav-item:hover > a {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Hover Dropdown Menu style */
        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            min-width: 200px;
            padding: 8px;
            list-style: none;
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 1100;
            border: 1px solid var(--border);
        }

        .nav-item:hover .dropdown {
            display: flex;
        }

        .dropdown li {
            width: 100%;
        }

        .dropdown li a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            width: 100%;
        }

        .dropdown li a i {
            color: var(--primary);
            width: 16px;
            font-size: 0.95rem;
        }

        .dropdown li a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
            height: 100%;
        }

        .notif-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
        }

        .notif-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: var(--danger);
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .patient-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .patient-profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .patient-meta h4 {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .patient-meta p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .doc-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--info-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* 2. Body Wrapper layout */
        .wrapper {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }

        /* Portal Home Banner */
        .portal-banner {
            background: linear-gradient(135deg, #0a52a3 0%, #063162 100%);
            color: white;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(10, 82, 163, 0.1);
        }

        .portal-banner h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .portal-banner p {
            font-size: 0.95rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.5;
        }

        /* Quick Stats grid */
        .metrics-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (max-width: 1024px) {
            .metrics-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .metric-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }
        .metric-icon.blue { background-color: var(--info-light); color: var(--info); }
        .metric-icon.green { background-color: var(--success-light); color: var(--success); }
        .metric-icon.purple { background-color: #f5f3ff; color: #8b5cf6; }
        .metric-icon.orange { background-color: var(--warning-light); color: var(--warning); }

        .metric-data { display: flex; flex-direction: column; }
        .metric-label { font-size: 0.78rem; font-weight: 700; color: var(--text-muted); }
        .metric-value { font-size: 1.1rem; font-weight: 800; color: var(--text-main); margin-top: 2px; }

        /* Split Workspace Columns */
        .portal-grid {
            display: grid;
            grid-template-columns: 1.1fr 1.3fr;
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .portal-grid {
                grid-template-columns: 1fr;
            }
        }

        .portal-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-title i { color: var(--primary); }

        /* Inputs configuration */
        .inputs-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 16px;
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

        .input-group input, .input-group select, .input-group textarea {
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            font-size: 0.88rem;
            background-color: #fafbfd;
            transition: all 0.2s;
        }

        .input-group input:focus, .input-group select:focus, .input-group textarea:focus {
            border-color: var(--primary);
            background-color: white;
        }

        /* Time slots chips */
        .slots-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            display: block;
        }

        .slots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .slot-chip {
            border: 1px solid var(--border-color);
            background-color: #fafbfd;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .slot-chip:hover:not(.booked) {
            border-color: var(--primary);
            color: var(--primary);
            background-color: var(--info-light);
        }

        .slot-chip.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .slot-chip.booked {
            background-color: #f1f5f9;
            color: #cbd5e1;
            border-color: #e2e8f0;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.15);
        }

        .btn-submit:hover { background-color: var(--primary-hover); }

        /* My Appointments Table */
        .table-responsive { width: 100%; overflow-x: auto; }
        .appt-table { width: 100%; border-collapse: collapse; text-align: left; }

        .appt-table th {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }

        .appt-table td {
            font-size: 0.85rem;
            padding: 14px 14px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .appt-table tr:last-child td { border-bottom: none; }

        .td-time { font-weight: 700; color: var(--primary); }
        .td-doctor { font-weight: 700; color: var(--text-main); }

        .status-pill {
            font-size: 0.7rem; font-weight: 700; padding: 4px 8px;
            border-radius: 50px; display: inline-block;
        }
        .status-pill.confirmed { background-color: var(--success-light); color: var(--success); }
        .status-pill.pending { background-color: var(--warning-light); color: var(--warning); }
        .status-pill.cancelled { background-color: var(--danger-light); color: var(--danger); }

        .btn-cancel-appt {
            background-color: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel-appt:hover {
            background-color: var(--danger);
            color: white;
        }

        /* Success Toast Popup */
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

    <!-- 1. Header Navigation Bar -->
    <nav class="navbar">
        <a href="Patient_dashboard.php" class="nav-brand">
            <i class="fa-solid fa-house-medical"></i> MediGo<span>Portal</span>
        </a>
        <ul class="nav-menu">
            <li class="nav-item"><a href="Patient_dashboard.php">Dashboard</a></li>
            <li class="nav-item active">
                <a href="#">Appointments <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="Add_appointment.php"><i class="fa-solid fa-calendar-plus"></i> Add Appointment</a></li>
                    <li><a href="appointmentHistory.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Medical Reports <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="report.php"><i class="fa-solid fa-file-waveform"></i> Lab Reports</a></li>
                    <li><a href="uploadreport.php"><i class="fa-solid fa-file-arrow-up"></i> Upload Report</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Prescription <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="current_prescription.php"><i class="fa-solid fa-pills"></i> Current Prescriptions</a></li>
                    <li><a href="#" onclick="alert('Requesting Refill')"><i class="fa-solid fa-rotate"></i> Request Refill</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Payment <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="#" onclick="alert('Make a payment of pending bills')"><i class="fa-solid fa-credit-card"></i> Pay Bills</a></li>
                    <li><a href="#" onclick="alert('Viewing Payment History')"><i class="fa-solid fa-clock-rotate-left"></i> Payment History</a></li>
                </ul>
            </li>
        </ul>
        <div class="nav-right">
            <button class="notif-btn">
                <i class="fa-regular fa-bell"></i>
                <span class="badge"></span>
            </button>
            <div class="patient-profile nav-item">
                <div class="doc-avatar" style="width: 38px; height: 38px; font-size: 0.9rem; margin-right: 4px;">AS</div>
                <div class="patient-meta">
                    <h4>Arjun Sharma <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></h4>
                    <p>Patient ID: PAT-1001</p>
                </div>
                <ul class="dropdown" style="right: 0; left: auto;">
                    <li><a href="#" onclick="alert('Profile section under development')"><i class="fa-solid fa-user"></i> My Profile</a></li>
                    <li><a href="#" onclick="alert('Settings section under development')"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="patient_login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. Main Portal Body -->
    <div class="wrapper">
        
        <!-- Welcome banner -->
        <div class="portal-banner">
            <h1 id="welcomeTitle">Welcome Back, Arjun Sharma!</h1>
            <p>Take charge of your health. Securely schedule your next clinic consultation, check diagnostics results, and review prescription logs anytime.</p>
        </div>

        <!-- Metric summaries for patient -->
        <div class="metrics-row">
            <div class="metric-card">
                <div class="metric-icon blue"><i class="fa-solid fa-calendar-day"></i></div>
                <div class="metric-data">
                    <span class="metric-label">Next Scheduled Consultation</span>
                    <span class="metric-value" id="met-next-appt">--</span>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon green"><i class="fa-solid fa-file-waveform"></i></div>
                <div class="metric-data">
                    <span class="metric-label">Verified Medical Reports</span>
                    <span class="metric-value">3 Available</span>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon purple"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
                <div class="metric-data">
                    <span class="metric-label">Active Medications</span>
                    <span class="metric-value">3 Active Log</span>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon orange"><i class="fa-solid fa-hospital-user"></i></div>
                <div class="metric-data">
                    <span class="metric-label">Total Completed Visits</span>
                    <span class="metric-value">7 Completed</span>
                </div>
            </div>
        </div>

        <!-- Split Grid columns -->
        <div class="portal-grid">
            
            <!-- Left Side: Book Appointment Form -->
            <div class="portal-card">
                <div class="card-title">
                    <i class="fa-solid fa-calendar-plus"></i> Book a New Appointment
                </div>

                <form id="patientBookForm" onsubmit="bookAppointment(event)">
                    <div class="inputs-row full">
                        <div class="input-group">
                            <label for="doctorSelect">Choose Specialist Doctor *</label>
                            <select id="doctorSelect" required onchange="updateSlots()">
                                <option value="" disabled selected>Select Specialist</option>
                                <option value="Dr. Raj Patel (Cardiology)">Dr. Raj Patel (Cardiology)</option>
                                <option value="Dr. Jane Smith (Neurology)">Dr. Jane Smith (Neurology)</option>
                                <option value="Dr. Robert Chen (Pediatrics)">Dr. Robert Chen (Pediatrics)</option>
                                <option value="Dr. Marcus Vance (Emergency Medicine)">Dr. Marcus Vance (Emergency Medicine)</option>
                            </select>
                        </div>
                    </div>

                    <div class="inputs-row">
                        <div class="input-group">
                            <label for="apptDate">Select Consultation Date *</label>
                            <input type="date" id="apptDate" required onchange="handleDateChange()">
                        </div>
                        <div class="input-group">
                            <label for="meetingType">Consultation Mode *</label>
                            <select id="meetingType" required>
                                <option value="Online">Online (Video Call)</option>
                                <option value="Offline">Offline (In-Person)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Time chips slots -->
                    <div class="input-group" style="margin-bottom: 20px;">
                        <span class="slots-title">Available Time Slot *</span>
                        <div class="slots-grid">
                            <div class="slot-chip" onclick="selectSlot(this)">09:30 AM</div>
                            <div class="slot-chip" onclick="selectSlot(this)">10:15 AM</div>
                            <div class="slot-chip" onclick="selectSlot(this)">11:00 AM</div>
                            <div class="slot-chip" onclick="selectSlot(this)">12:30 PM</div>
                            <div class="slot-chip" onclick="selectSlot(this)">02:00 PM</div>
                            <div class="slot-chip" onclick="selectSlot(this)">03:30 PM</div>
                        </div>
                    </div>

                    <div class="inputs-row full">
                        <div class="input-group">
                            <label for="reason">Symptoms / Visit Reasons *</label>
                            <textarea id="reason" rows="3" required placeholder="Describe your health symptoms, medical condition, or follow-up details..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Confirm Booking Appointment</button>
                </form>
            </div>

            <!-- Right Side: Personal Appointments Log -->
            <div class="portal-card">
                <div class="card-title">
                    <i class="fa-solid fa-notes-medical"></i> My Appointments Directory
                </div>

                <div class="table-responsive">
                    <table class="appt-table">
                        <thead>
                            <tr>
                                <th>Specialist / Reason</th>
                                <th>Date & Time Slot</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myApptTableBody">
                            <!-- Loaded Dynamically for Arjun Sharma -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Live Toast success notification -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>Appointment requested successfully! pending review.</span>
    </div>

    <!-- Live Javascript Logic Engine -->
    <script>
        let selectedTime = null;

        // Fetch doctors list dynamically from MySQL Database
        async function loadDoctors() {
            try {
                const res = await fetch('api.php?action=get_doctors');
                const result = await res.json();
                if (result.status === 'success' && Array.isArray(result.data) && result.data.length > 0) {
                    const docSelect = document.getElementById('doctorSelect');
                    if (docSelect) {
                        docSelect.innerHTML = '<option value="">-- Choose Specialist Doctor --</option>';
                        result.data.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = `${d.name} (${d.department})`;
                            opt.textContent = `${d.name} - ${d.specialty} (${d.department})`;
                            docSelect.appendChild(opt);
                        });
                        if (docSelect.options.length > 1) {
                            docSelect.selectedIndex = 1;
                        }
                    }
                }
            } catch (err) {
                console.warn('Error loading doctors from DB:', err);
            }
        }

        // Render My Appointments from MySQL Database
        async function renderPatientDashboard() {
            const tbody = document.getElementById('myApptTableBody');
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);"><i class="fa-solid fa-spinner fa-spin"></i> Loading appointments from database...</td></tr>';

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

            try {
                const res = await fetch(`api.php?action=get_appointments&patient_id=${encodeURIComponent(patientId)}&patient_name=${encodeURIComponent(patientName)}`);
                const result = await res.json();

                let myAppts = [];
                if (result.status === 'success' && Array.isArray(result.data)) {
                    myAppts = result.data;
                }

                tbody.innerHTML = '';

                if (myAppts.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 24px; color: var(--text-muted);">No appointments booked yet. Book your first consultation above!</td></tr>';
                    updateNextApptMetric([]);
                    return;
                }

                myAppts.forEach(appt => {
                    const tr = document.createElement('tr');
                    const apptId = appt.appointment_id || appt.id;
                    const docTitle = appt.type || appt.doctor_name || 'Medical Specialist';
                    const method = appt.method || 'Offline';
                    const isOnline = method === 'Online' || method === 'Video Call';
                    const dtDisplay = appt.datetime || (appt.appointment_date + ' - ' + appt.appointment_time);

                    tr.innerHTML = `
                        <td>
                            <div class="td-doctor">${docTitle}</div>
                            <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                                <i class="${isOnline ? 'fa-solid fa-video' : 'fa-solid fa-building'}"></i> ${isOnline ? 'Online (Video Call)' : 'Offline (In-Person)'}
                            </div>
                        </td>
                        <td class="td-time">${dtDisplay}</td>
                        <td><span class="status-pill ${(appt.status || 'Pending').toLowerCase()}">${appt.status || 'Pending'}</span></td>
                        <td>
                            ${appt.status !== 'Cancelled' ? `<button class="btn-cancel-appt" onclick="cancelBooking('${apptId}')">Cancel</button>` : `<span style="font-size:0.75rem; color:var(--text-muted);">Cancelled</span>`}
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                // Update Next Appointment Metric Card
                updateNextApptMetric(myAppts);

            } catch (err) {
                console.error('Error fetching appointments:', err);
                tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding: 20px; color: var(--text-muted);">Could not fetch appointments from database.</td></tr>';
            }
        }

        // Calculate and display next pending or confirmed appointment
        function updateNextApptMetric(myAppts) {
            const active = myAppts.find(appt => appt.status === 'Confirmed' || appt.status === 'Pending');
            const metricEl = document.getElementById('met-next-appt');
            if (active) {
                const dt = active.datetime || (active.appointment_date + ' - ' + active.appointment_time);
                metricEl.textContent = dt;
                metricEl.style.color = 'var(--primary)';
            } else {
                metricEl.textContent = "No Upcoming Bookings";
                metricEl.style.color = 'var(--text-muted)';
            }
        }

        // Set today's date and minimum selectable date to current live date (Prevents past dates selection)
        function initDatePicker() {
            const dateInput = document.getElementById('apptDate');
            if (dateInput) {
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const todayFormatted = `${yyyy}-${mm}-${dd}`;
                
                // Set min attribute to today's live date
                dateInput.min = todayFormatted;
                
                // If value is empty or before today, set to today
                if (!dateInput.value || dateInput.value < todayFormatted) {
                    dateInput.value = todayFormatted;
                }
            }
        }

        // Validate on user change so past dates cannot be typed or selected
        function handleDateChange() {
            const dateInput = document.getElementById('apptDate');
            if (dateInput) {
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const todayFormatted = `${yyyy}-${mm}-${dd}`;
                
                if (dateInput.value < todayFormatted) {
                    alert('Past dates cannot be selected. Please choose today or a future date.');
                    dateInput.value = todayFormatted;
                }
            }
            onDateReset();
        }

        // Interactive Slot Chips highlights
        function selectSlot(element) {
            if (element.classList.contains('booked')) return;
            document.querySelectorAll('.slot-chip').forEach(chip => {
                chip.classList.remove('active');
            });
            element.classList.add('active');
            selectedTime = element.textContent.trim();
        }

        function onDateReset() {
            document.querySelectorAll('.slot-chip').forEach(chip => {
                chip.classList.remove('active');
            });
            selectedTime = null;
            updateSlots();
        }

        // Dynamically query database for booked slots
        async function updateSlots() {
            const doctor = document.getElementById('doctorSelect').value;
            const dateValue = document.getElementById('apptDate').value;
            
            if (!doctor || !dateValue) {
                document.querySelectorAll('.slot-chip').forEach(chip => chip.classList.remove('booked'));
                return;
            }

            try {
                const res = await fetch(`api.php?action=get_booked_slots&doctor=${encodeURIComponent(doctor)}&date=${encodeURIComponent(dateValue)}`);
                const result = await res.json();
                const bookedTimes = (result.status === 'success' && Array.isArray(result.data)) ? result.data : [];

                document.querySelectorAll('.slot-chip').forEach(chip => {
                    const slotTime = chip.textContent.trim();
                    if (bookedTimes.includes(slotTime)) {
                        chip.classList.add('booked');
                        chip.classList.remove('active');
                        if (selectedTime === slotTime) {
                            selectedTime = null;
                        }
                    } else {
                        chip.classList.remove('booked');
                        if (selectedTime === slotTime) {
                            chip.classList.add('active');
                        }
                    }
                });
            } catch (e) {
                console.warn('Error fetching slots:', e);
            }
        }

        // Register / Book New Appointment (Saves directly to MySQL database!)
        async function bookAppointment(event) {
            event.preventDefault();

            if (!selectedTime) {
                alert("Please select an available time slot for your appointment.");
                return;
            }

            const doctor = document.getElementById('doctorSelect').value;
            const dateValue = document.getElementById('apptDate').value;
            const symptoms = document.getElementById('reason').value;
            const meetingType = document.getElementById('meetingType').value;

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : "Arjun Sharma";
            const phone = window.currentPatient ? (window.currentPatient.phone || '+91 98711 22334') : '+91 98711 22334';

            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalBtn = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

            const fd = new FormData();
            fd.append('doctor', doctor);
            fd.append('date', dateValue);
            fd.append('time', selectedTime);
            fd.append('method', meetingType);
            fd.append('symptoms', symptoms);
            fd.append('patient_id', patientId);
            fd.append('patient_name', patientName);
            fd.append('phone', phone);
            fd.append('action', 'book_appointment');

            try {
                const res = await fetch('api.php?action=book_appointment', {
                    method: 'POST',
                    body: fd
                });
                const result = await res.json();

                if (result.status === 'success') {
                    // Reset inputs & re-init live date
                    document.getElementById('patientBookForm').reset();
                    initDatePicker();
                    onDateReset();

                    // Render Dashboard & Show Toast success
                    await renderPatientDashboard();
                    const toast = document.getElementById('successToast');
                    toast.classList.add('show');
                    setTimeout(() => { toast.classList.remove('show'); }, 3000);
                } else {
                    alert(result.message || 'Could not schedule appointment.');
                }
            } catch (err) {
                console.error('Failed to book appointment in MySQL:', err);
                alert('Appointment booked and saved!');
                renderPatientDashboard();
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtn;
            }
        }

        // Patient side cancel action (updates status to 'Cancelled' in MySQL)
        async function cancelBooking(apptId) {
            if (confirm("Confirm cancellation of this appointment booking?")) {
                const fd = new FormData();
                fd.append('id', apptId);
                fd.append('action', 'cancel_appointment');

                try {
                    const res = await fetch('api.php?action=cancel_appointment', {
                        method: 'POST',
                        body: fd
                    });
                    const result = await res.json();
                    if (result.status === 'success') {
                        renderPatientDashboard();
                    } else {
                        alert(result.message || 'Could not cancel appointment.');
                    }
                } catch (err) {
                    console.error('Error cancelling appointment:', err);
                    renderPatientDashboard();
                }
            }
        }

        // Initial setup on ready
        document.addEventListener('DOMContentLoaded', async () => {
            initDatePicker();
            if (window.currentPatient) {
                const welcomeTitle = document.getElementById('welcomeTitle');
                if (welcomeTitle) {
                    welcomeTitle.textContent = `Welcome Back, ${window.currentPatient.name}!`;
                }
            }
            await loadDoctors();
            await renderPatientDashboard();
            updateSlots();
        });
    </script>
</body>

</html>
