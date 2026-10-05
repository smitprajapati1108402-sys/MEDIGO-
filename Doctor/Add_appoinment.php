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
    <title>MediCare - Schedule Appointment</title>
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

        /* Wrapper */
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

        /* Grid Setup */
        .schedule-grid {
            display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px;
        }

        @media (max-width: 1024px) {
            .schedule-grid { grid-template-columns: 1fr; }
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

        /* Interactive Time Slots Slots styling */
        .slots-title {
            font-size: 0.82rem; font-weight: 700; color: var(--text-main); margin-bottom: 8px;
        }

        .slots-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px;
        }

        .slot-chip {
            border: 1px solid var(--border-color); background-color: #fafbfd;
            padding: 12px; border-radius: 10px; text-align: center;
            font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
        }

        .slot-chip:hover:not(.booked) {
            border-color: var(--primary); color: var(--primary); background-color: var(--info-light);
        }

        .slot-chip.active {
            background-color: var(--primary); color: white; border-color: var(--primary);
        }

        .slot-chip.booked {
            background-color: #f1f5f9; color: #cbd5e1; border-color: #e2e8f0;
            cursor: not-allowed; text-decoration: line-through;
        }

        /* Patient Summary Preview Card (Sticky column) */
        .preview-sticky { position: sticky; top: 100px; }
        .patient-summary-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
            margin-bottom: 24px;
        }
        .patient-header { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; }
        .patient-avatar { width: 52px; height: 52px; background-color: var(--info-light); color: var(--info); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: bold; }
        .patient-details h3 { font-size: 1.05rem; font-weight: 800; }
        .patient-details p { font-size: 0.8rem; color: var(--text-muted); }

        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .info-item { display: flex; flex-direction: column; gap: 4px; }
        .info-label { font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
        .info-value { font-size: 0.88rem; font-weight: 600; color: var(--text-main); }

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

    <div class="wrapper">
        <div class="page-header">
            <div>
                <h1>Schedule Appointment</h1>
                <p>Choose clinical time slots and configure patient details to book a consultation [INDEX].</p>
            </div>
            <button class="btn-back" onclick="window.location.href='Appointment.php'">
                <i class="fa-solid fa-arrow-left"></i> Back to Schedule
            </button>
        </div>

        <form id="scheduleForm" onsubmit="submitAppointmentForm(event)">
            <div class="schedule-grid">
                
                <!-- Left Input Fields -->
                <div>
                    <div class="form-card">
                        <div class="card-title"><i class="fa-solid fa-calendar-check"></i> Booking Configurations</div>
                        
                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="patientSelector">Select Patient Name *</label>
                                <input type="text" id="patientSelector" required oninput="onPatientSelect()" placeholder="Type patient name or select..." list="patientList" autocomplete="off">
                                <datalist id="patientList">
                                    <option value="Arjun Sharma">Arjun Sharma (PAT-1001)</option>
                                    <option value="Priya Verma">Priya Verma (PAT-1002)</option>
                                    <option value="Rohan Gupta">Rohan Gupta (PAT-1003)</option>
                                    <option value="Rahul Sharma">Rahul Sharma (PAT-1004)</option>
                                    <option value="Amit Shah">Amit Shah (PAT-1005)</option>
                                </datalist>
                            </div>
                            <div class="input-group">
                                <label for="apptDate">Select Date *</label>
                                <input type="date" id="apptDate" required value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" onchange="onDateChange()">
                            </div>
                        </div>

                        <!-- Time Slot Select Grid -->
                        <div class="input-group" style="margin-bottom: 20px;">
                            <span class="slots-title">Select Morning Time Slot *</span>
                            <div class="slots-grid">
                                <div class="slot-chip" onclick="selectSlot(this)">09:00 AM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">09:30 AM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">10:15 AM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">11:00 AM</div>
                            </div>

                            <span class="slots-title">Select Afternoon Time Slot *</span>
                            <div class="slots-grid">
                                <div class="slot-chip" onclick="selectSlot(this)">02:00 PM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">02:45 PM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">03:30 PM</div>
                                <div class="slot-chip" onclick="selectSlot(this)">04:15 PM</div>
                            </div>
                        </div>

                        <div class="inputs-row">
                            <div class="input-group">
                                <label for="visitType">Type of Visit *</label>
                                <select id="visitType" required>
                                    <option value="Regular Checkup">Regular Checkup</option>
                                    <option value="Follow-up Consultation">Follow-up Consultation</option>
                                    <option value="Emergency Treatment">Emergency Treatment</option>
                                    <option value="ECG Diagnostics">ECG Diagnostics</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="meetingType">Consultation Mode *</label>
                                <select id="meetingType" required>
                                    <option value="Online">Online (Video Call)</option>
                                    <option value="Offline" selected>Offline (In-Person)</option>
                                </select>
                            </div>
                        </div>

                        <div class="inputs-row full">
                            <div class="input-group">
                                <label for="symptoms">Symptoms & Clinical Notes</label>
                                <textarea id="symptoms" rows="3" placeholder="Enter patient symptom details..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="action-bar">
                        <button type="button" class="btn-cancel" onclick="resetForm()">Clear Options</button>
                        <button type="submit" class="btn-submit">Book Appointment</button>
                    </div>
                </div>

                <!-- Right Column Sticky Profile Preview -->
                <div class="preview-sticky">
                    <div class="patient-summary-card">
                        <div class="patient-header">
                            <div class="patient-avatar" id="prevAvatar">--</div>
                            <div class="patient-details">
                                <h3 id="prevName">Select Patient</h3>
                                <p id="prevID">ID: --</p>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Age / Gender</span>
                                <span class="info-value" id="prevAgeGender">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Mobile Contact</span>
                                <span class="info-value" id="prevPhone">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Blood Group</span>
                                <span class="info-value" id="prevBlood">--</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Selected Slot</span>
                                <span class="info-value" id="prevSlot" style="color: var(--primary);">Not chosen yet</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Consultation Mode</span>
                                <span class="info-value" id="prevMethod">Offline (In-Person)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- Success Toast Popup -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>Appointment slot booked successfully!</span>
    </div>

    <script>
        // Server pre-rendered patient list from MySQL
        const serverPatients = <?php echo json_encode($server_patients ?? []); ?>;

        // Dynamic Patient Dictionary
        let patientData = {
            "Arjun Sharma": { ageGender: "42 / Male", blood: "O+", phone: "+91 98765 43210", avatar: "AS", id: "PAT-1001" },
            "Priya Verma": { ageGender: "29 / Female", blood: "A+", phone: "+91 98234 56789", avatar: "PV", id: "PAT-1002" },
            "Amit Shah": { ageGender: "56 / Male", blood: "B+", phone: "+91 97123 45678", avatar: "AS", id: "PAT-1003" },
            "Rohan Gupta": { ageGender: "23 / Male", blood: "AB+", phone: "+91 96012 34567", avatar: "RG", id: "PAT-1004" },
            "Ananya Iyer": { ageGender: "34 / Female", blood: "B-", phone: "+91 95501 23456", avatar: "AI", id: "PAT-1005" }
        };

        async function initPatientDirectory() {
            // First load from server pre-rendered PHP list
            if (Array.isArray(serverPatients) && serverPatients.length > 0) {
                const dl = document.getElementById('patientList');
                if (dl) dl.innerHTML = '';
                serverPatients.forEach(p => {
                    const pName = p.name;
                    const pId = p.patient_id || p.id;
                    patientData[pName] = {
                        ageGender: `${p.age || '--'} / ${p.gender || '--'}`,
                        blood: p.blood || "O+",
                        phone: p.phone || "--",
                        avatar: getInitials(pName),
                        id: pId
                    };
                    if (dl) {
                        const opt = document.createElement('option');
                        opt.value = pName;
                        opt.textContent = `${pName} (${pId})`;
                        dl.appendChild(opt);
                    }
                });
            }

            // Also fetch live from MySQL api.php
            try {
                const res = await fetch('api.php?action=get_patients');
                const data = await res.json();
                if (data.success && Array.isArray(data.patients) && data.patients.length > 0) {
                    const dl = document.getElementById('patientList');
                    if (dl) dl.innerHTML = '';
                    data.patients.forEach(p => {
                        patientData[p.name] = {
                            ageGender: `${p.age || '--'} / ${p.gender || '--'}`,
                            blood: p.blood || "O+",
                            phone: p.phone || "--",
                            avatar: getInitials(p.name),
                            id: p.id
                        };
                        if (dl) {
                            const opt = document.createElement('option');
                            opt.value = p.name;
                            opt.textContent = `${p.name} (${p.id})`;
                            dl.appendChild(opt);
                        }
                    });
                }
            } catch (e) {
                console.warn('Live patient fetch error:', e);
            }
        }

        let selectedTime = null;

        function getInitials(name) {
            if (!name) return "--";
            const parts = name.trim().split(/\s+/);
            if (parts.length >= 2) {
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            } else if (parts.length === 1 && parts[0].length > 0) {
                return parts[0].slice(0, 2).toUpperCase();
            }
            return "--";
        }

        function onPatientSelect() {
            const select = document.getElementById('patientSelector').value;
            const patient = patientData[select];
            if (patient) {
                document.getElementById('prevAvatar').textContent = patient.avatar;
                document.getElementById('prevName').textContent = select;
                document.getElementById('prevID').textContent = `ID: ${patient.id}`;
                document.getElementById('prevAgeGender').textContent = patient.ageGender;
                document.getElementById('prevBlood').textContent = patient.blood;
                document.getElementById('prevPhone').textContent = patient.phone;
            } else {
                document.getElementById('prevAvatar').textContent = select ? getInitials(select) : '--';
                document.getElementById('prevName').textContent = select || 'Select Patient';
                document.getElementById('prevID').textContent = select ? 'ID: New Patient' : 'ID: --';
                document.getElementById('prevAgeGender').textContent = '--';
                document.getElementById('prevBlood').textContent = '--';
                document.getElementById('prevPhone').textContent = '--';
            }
        }

        // Custom function to highlight active timeslot chip
        function selectSlot(element) {
            document.querySelectorAll('.slot-chip').forEach(chip => {
                chip.classList.remove('active');
            });

            element.classList.add('active');
            selectedTime = element.textContent.trim();
            document.getElementById('prevSlot').textContent = selectedTime;
        }

        function getSelectedFormattedDate() {
            const dateValue = document.getElementById('apptDate').value;
            if (!dateValue) return "";
            const parts = dateValue.split("-");
            if (parts.length !== 3) return "";
            const year = parts[0];
            const monthIndex = parseInt(parts[1], 10) - 1;
            const day = String(parseInt(parts[2], 10)).padStart(2, '0');
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return `${day} ${months[monthIndex]} ${year}`;
        }

        function updateSlotsAvailability() {
            const selectedFormattedDate = getSelectedFormattedDate();
            let db = JSON.parse(localStorage.getItem('medigo_appts')) || [];
            const bookedSlots = db
                .filter(appt => appt.status !== 'Cancelled' && appt.datetime && appt.datetime.startsWith(selectedFormattedDate))
                .map(appt => {
                    const parts = appt.datetime.split(" - ");
                    return parts[1] ? parts[1].trim() : "";
                });
            document.querySelectorAll('.slot-chip').forEach(chip => {
                const slotTime = chip.textContent.trim();
                chip.classList.remove('active');
                if (bookedSlots.includes(slotTime)) {
                    chip.classList.add('booked');
                    chip.removeAttribute('onclick');
                } else {
                    chip.classList.remove('booked');
                    chip.setAttribute('onclick', 'selectSlot(this)');
                }
            });
            selectedTime = null;
            document.getElementById('prevSlot').textContent = "Not chosen yet";
        }

        function onDateChange() {
            const dateInput = document.getElementById('apptDate');
            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayStr = `${y}-${m}-${d}`;

            if (dateInput.value && dateInput.value < todayStr) {
                alert("Cannot select a past date. Please select today or a future date.");
                dateInput.value = todayStr;
            }
            updateSlotsAvailability();
        }

        async function submitAppointmentForm(event) {
            event.preventDefault();
            if (!selectedTime) {
                alert("Please select an available morning or afternoon time slot.");
                return;
            }
            const patientName = document.getElementById('patientSelector').value.trim();
            const dateValue = document.getElementById('apptDate').value;
            const visitType = document.getElementById('visitType').value;
            const meetingType = document.getElementById('meetingType').value;
            const symptoms = document.getElementById('symptoms').value || "Regular checkup consultation";

            if (!patientName) {
                alert("Please enter or select a patient name.");
                return;
            }

            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayFormatted = `${y}-${m}-${d}`;

            if (dateValue < todayFormatted) {
                alert("Cannot book an appointment on a past date. Please pick today or a future date.");
                return;
            }

            const parts = dateValue.split("-");
            const year = parts[0];
            const monthIndex = parseInt(parts[1], 10) - 1;
            const day = String(parseInt(parts[2], 10)).padStart(2, '0');
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const formattedDate = `${day} ${months[monthIndex]} ${year}`;

            const patientInfo = patientData[patientName] || {};
            const phone = patientInfo.phone || '+91 98765 43210';
            const docName = (window.currentDoctor && window.currentDoctor.name) ? window.currentDoctor.name : 'Dr. PRAJAPATI SMIT MANOJKUMAR';

            // Submit directly to MySQL Database via api.php
            try {
                const formData = new FormData();
                formData.append('patient', patientName);
                formData.append('doctor', docName);
                formData.append('date', dateValue);
                formData.append('time', selectedTime);
                formData.append('type', visitType);
                formData.append('method', meetingType);
                formData.append('phone', phone);
                formData.append('symptoms', symptoms);
                formData.append('status', 'Confirmed');

                const response = await fetch('api.php?action=add_appointment', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                const newId = result.success ? result.apt_id : `APT-${Math.floor(1000 + Math.random() * 9000)}`;

                // Update local storage backup
                const newAppt = {
                    id: newId,
                    patientName: patientName,
                    datetime: `${formattedDate} - ${selectedTime}`,
                    type: visitType,
                    method: meetingType,
                    status: "Confirmed"
                };
                let db = JSON.parse(localStorage.getItem('medigo_appts')) || [];
                db.unshift(newAppt);
                localStorage.setItem('medigo_appts', JSON.stringify(db));

                const toast = document.getElementById('successToast');
                if (result.success) {
                    toast.querySelector('span').textContent = `Appointment ${newId} booked and saved in MySQL Database!`;
                }
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                    window.location.href = "Appointment.php";
                }, 1800);

            } catch (err) {
                console.error("API error, saving locally:", err);
                const newId = `APT-${Math.floor(1000 + Math.random() * 9000)}`;
                const newAppt = {
                    id: newId,
                    patientName: patientName,
                    datetime: `${formattedDate} - ${selectedTime}`,
                    type: visitType,
                    method: meetingType,
                    status: "Pending"
                };
                let db = JSON.parse(localStorage.getItem('medigo_appts')) || [];
                db.unshift(newAppt);
                localStorage.setItem('medigo_appts', JSON.stringify(db));

                const toast = document.getElementById('successToast');
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                    window.location.href = "Appointment.php";
                }, 1800);
            }
        }

        function resetForm() {
            if (confirm("Reset current scheduling configurations?")) {
                document.getElementById('scheduleForm').reset();
                selectedTime = null;
                document.getElementById('prevAvatar').textContent = '--';
                document.getElementById('prevName').textContent = 'Select Patient';
                document.getElementById('prevID').textContent = 'ID: --';
                document.getElementById('prevAgeGender').textContent = '--';
                document.getElementById('prevBlood').textContent = '--';
                document.getElementById('prevPhone').textContent = '--';
                document.getElementById('prevSlot').textContent = 'Not chosen yet';
                document.getElementById('prevMethod').textContent = 'Offline (In-Person)';
                
                const today = new Date();
                const y = today.getFullYear();
                const m = String(today.getMonth() + 1).padStart(2, '0');
                const d = String(today.getDate()).padStart(2, '0');
                const todayFormatted = `${y}-${m}-${d}`;
                const dateInput = document.getElementById('apptDate');
                if (dateInput) {
                    dateInput.min = todayFormatted;
                    dateInput.value = todayFormatted;
                }
                updateSlotsAvailability();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initPatientDirectory();

            const today = new Date();
            const y = today.getFullYear();
            const m = String(today.getMonth() + 1).padStart(2, '0');
            const d = String(today.getDate()).padStart(2, '0');
            const todayFormatted = `${y}-${m}-${d}`;
            const dateInput = document.getElementById('apptDate');
            if (dateInput) {
                dateInput.min = todayFormatted;
                if (!dateInput.value || dateInput.value < todayFormatted) {
                    dateInput.value = todayFormatted;
                }
            }
            
            document.getElementById('meetingType').addEventListener('change', (e) => {
                document.getElementById('prevMethod').textContent = e.target.value === 'Online' ? 'Online (Video Call)' : 'Offline (In-Person)';
            });
            
            updateSlotsAvailability();
        });
    </script>
</body>

</html>
