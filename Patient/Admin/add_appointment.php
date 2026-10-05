<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medigo | Add Appointment</title>
    <!-- Icons and Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #008080;
            --primary-dark: #006666;
            --bg-gradient: linear-gradient(135deg, #e0f2f1 0%, #ffffff 100%);
            --glass: rgba(255, 255, 255, 0.95);
            --text-main: #2d3436;
            --text-sub: #636e72;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 40px 20px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .page-header-wrapper {
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-main);
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-sub);
            margin-top: 4px;
        }

        /* ================= NAVIGATION BAR ================= */
        :root {
            /* Navbar specific variables */
            --nav-primary: #0048ff;
            --nav-primary-dark: #001d72;
            --nav-primary-light: #eef4ff;
            --nav-white: #ffffff;
            --nav-text-dark: #1e293b;
            --nav-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--nav-primary-dark), #0036cc);
            color: var(--nav-white);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 29, 114, 0.12);
            width: 100%;
        }

        .navbar * {
            box-sizing: border-box;
        }

        .navbar .logo {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
            color: var(--nav-white);
        }

        .navbar .logo span {
            color: #6ab7ff;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-direction: row;
        }

        .nav-item-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            padding: 8px 14px;
            border-radius: 8px;
            transition: var(--nav-transition);
        }

        .nav-item-link:hover,
        .nav-item-link.active {
            color: var(--nav-white);
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Dropdown styling */
        .dropdown {
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        .nav-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            cursor: pointer;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--nav-transition);
        }

        .nav-btn:hover,
        .dropdown.active .nav-btn {
            color: var(--nav-white);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 240px;
            background: var(--nav-white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 1100;
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: slideDropdown 0.2s ease-out;
        }

        @keyframes slideDropdown {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-content a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            color: var(--nav-text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            transition: var(--nav-transition);
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background: var(--nav-primary-light);
            color: var(--nav-primary);
            padding-left: 22px;
        }

        .dropdown-content a.active {
            background: var(--nav-primary-light);
            color: var(--nav-primary);
        }

        /* Expenses Dropdown specific styling */
        .expenses-dropdown {
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        .expenses-dropbtn {
            background: var(--nav-white);
            color: var(--nav-primary-dark);
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--nav-transition);
        }

        .expenses-dropbtn:hover {
            background: var(--nav-primary-light);
            transform: translateY(-1px);
        }

        .expenses-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: var(--nav-white);
            min-width: 280px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
            z-index: 1100;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .expenses-dropdown-content div {
            padding: 12px 20px;
            color: var(--nav-text-dark);
            font-size: 14px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
        }

        .expenses-dropdown-content div:last-child {
            background-color: var(--nav-primary-light);
            border-bottom: none;
            font-weight: 700;
        }

        .expenses-dropdown:hover .expenses-dropdown-content {
            display: block;
        }

        /* Mobile responsive menu button */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--nav-white);
            font-size: 24px;
            cursor: pointer;
        }

        /* Responsiveness */
        @media(max-width: 991px) {
            .navbar {
                padding: 15px 25px;
            }

            .mobile-toggle {
                display: block;
            }

            .navbar .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--nav-primary-dark);
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                align-items: stretch;
            }

            .navbar .nav-links.active {
                display: flex;
            }

            .dropdown-content {
                position: static;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.05);
                border: none;
                margin-top: 5px;
            }

            .dropdown-content a {
                color: var(--nav-white);
            }
        }

        .appointment-container {
            background: var(--glass);
            width: 100%;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid #edf2f7;
            overflow: hidden;
            animation: slideIn 0.6s ease-out;
        }

        /* Form Body */
        .form-body {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }

        .input-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 15px;
        }

        .input-group.align-start {
            align-items: flex-start;
        }

        .input-group label {
            width: 175px;
            min-width: 175px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-group label i { color: var(--primary); }

        .input-group input, .input-group select, .input-group textarea {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #edf2f7;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
            background: #fdfdfd;
            width: 100%;
        }

        @media (max-width: 768px) {
            .input-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .input-group label {
                width: auto;
                min-width: auto;
            }
        }

        .input-group input:focus, .input-group select:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 128, 128, 0.1);
        }

        .full-width { grid-column: span 2; }
        @media (max-width: 600px) { .full-width { grid-column: span 1; } }

        /* Buttons */
        .form-footer {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            border: none;
        }

        .btn-cancel {
            background: #f1f2f6;
            color: var(--text-sub);
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 128, 128, 0.3);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Success Message Overlay */
        #success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 100;
        }

        .success-card {
            text-align: center;
            animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .success-icon {
            font-size: 60px;
            color: #2ecc71;
            margin-bottom: 20px;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- ================= NAVBAR NAVIGATION ================= -->
    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-square-h"></i> Medi<span>Go</span>
        </div>

        <button class="mobile-toggle" onclick="toggleMobileMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="nav-links" id="navLinks">
            <a href="admin_dashboard.php" class="nav-item-link">Home</a>

            <!-- Services Dropdown -->
            <div class="dropdown active" id="servicesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('servicesMenu', event)">
                    Services <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="servicesMenu">
                    <a href="doctormanagement.php"><i class="fa-solid fa-user-md"></i> Doctor Management</a>
                    <a href="patientmanagement.php"><i class="fa-solid fa-user-injured"></i> Patient Management</a>
                    <a href="Appointment.php" class="active"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="Pharmacy.php"><i class="fa-solid fa-pills"></i> Pharmacy</a>
                    <a href="BloodBank.php"><i class="fa-solid fa-droplet"></i> Blood Bank</a>
                </div>
            </div>

            <!-- Resources Dropdown -->
            <div class="dropdown" id="resourcesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('resourcesMenu', event)">
                    Resources <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="resourcesMenu">
                    <a href="hospitalreport.php"><i class="fa-solid fa-chart-line"></i> Hospital Reports</a>
                    <a href="MedicalReport.php"><i class="fa-solid fa-clipboard-list"></i> Medical Records</a>
                </div>
            </div>

            <!-- About Dropdown -->
            <div class="dropdown" id="aboutDropdown">
                <button class="nav-btn" onclick="toggleDropdown('aboutMenu', event)">
                    About <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="aboutMenu">
                    <a href="Hospital_informatio.php"><i class="fa-solid fa-circle-info"></i> Hospital Information</a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="dropdown" id="settingsDropdown">
                <button class="nav-btn" onclick="toggleDropdown('settingsMenu', event)">
                    Settings <i class="fa-solid fa-gear"></i>
                </button>
                <div class="dropdown-content" id="settingsMenu">
                    <a href="Seeting.php"><i class="fa-solid fa-sliders"></i> Hospital Settings</a>
                </div>
            </div>

            <a href="contact.php" class="nav-item-link">Contact</a>
            <a href="#" onclick="logout()" style="color: hsla(0, 100%, 65%, 0.979); font-weight: bold; margin-left: 10px;">Logout</a>
        </div>

        <!-- EXPENSES DROPDOWN -->
        <div class="expenses-dropdown">
            <button class="expenses-dropbtn">Expenses</button>
            <div class="expenses-dropdown-content">
                <div>Medicine Purchase <span>85,000</span></div>
                <div>Doctor Salary <span>4,50,000</span></div>
                <div>Staff Salary <span>2,20,000</span></div>
                <div>Electricity Bill <span>65,000</span></div>
                <div><b>Total:</b> <b>8,20,000</b></div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header-wrapper">
            <h2 class="page-title">New Appointment</h2>
            <p class="page-subtitle">Fill in the details below to schedule a new patient visit.</p>
        </div>

        <div class="appointment-container">
            <div class="form-body">
            <form id="appointmentForm">
                <div class="form-grid">
                    <!-- Patient Name -->
                    <div class="input-group">
                        <label><i class="fas fa-user"></i> Patient Full Name</label>
                        <input type="text" id="patientName" placeholder="e.g. John Doe" required>
                    </div>

                    <!-- Phone Number -->
                    <div class="input-group">
                        <label><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="tel" id="patientPhone" placeholder="+1 (555) 000-0000" required>
                    </div>

                    <!-- Department -->
                    <div class="input-group">
                        <label><i class="fas fa-stethoscope"></i> Department</label>
                        <select id="dept" required>
                            <option value="">Select Department</option>
                            <option value="cardiology">Cardiology</option>
                            <option value="neurology">Neurology</option>
                            <option value="pediatrics">Pediatrics</option>
                            <option value="emergency">Emergency Medicine</option>
                        </select>
                    </div>

                    <!-- Select Doctor -->
                    <div class="input-group">
                        <label><i class="fas fa-user-md"></i> Assigned Doctor</label>
                        <select id="doctor" required>
                            <option value="">Choose Doctor</option>
                            <option value="1">Dr. Raj Patel</option>
                            <option value="2">Dr. Jane Smith</option>
                            <option value="3">Dr. Robert Chen</option>
                            <option value="4">Dr. Marcus Vance</option>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="input-group">
                        <label><i class="fas fa-calendar-alt"></i> Preferred Date</label>
                        <input type="date" id="appDate" required>
                    </div>

                    <!-- Time -->
                    <div class="input-group">
                        <label><i class="fas fa-clock"></i> Preferred Time</label>
                        <select id="appTime" required>
                            <option value="">Select Time Slot</option>
                            <option value="09:00 AM">09:00 AM</option>
                            <option value="09:30 AM">09:30 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="10:30 AM">10:30 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="11:30 AM">11:30 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="12:30 PM">12:30 PM</option>
                            <option value="01:00 PM">01:00 PM</option>
                            <option value="01:30 PM">01:30 PM</option>
                            <option value="02:00 PM">02:00 PM</option>
                            <option value="02:30 PM">02:30 PM</option>
                            <option value="03:00 PM">03:00 PM</option>
                            <option value="03:30 PM">03:30 PM</option>
                            <option value="04:00 PM">04:00 PM</option>
                            <option value="04:30 PM">04:30 PM</option>
                            <option value="05:00 PM">05:00 PM</option>
                        </select>
                    </div>

                    <!-- Message/Notes -->
                    <div class="input-group full-width align-start">
                        <label style="margin-top: 10px;"><i class="fas fa-comment-medical"></i> Notes / Reason for Visit</label>
                        <textarea id="notes" rows="3" placeholder="Brief description of symptoms..."></textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-cancel" onclick="window.history.back()">Discard</button>
                    <button type="submit" class="btn btn-submit">Confirm Appointment</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Success Overlay -->
    <div id="success-overlay">
        <div class="success-card">
            <div class="success-icon"><i class="fas fa-check-circle"></i></div>
            <h2 style="color: var(--text-main);">Appointment Confirmed!</h2>
            <p style="color: var(--text-sub); margin: 10px 0 25px;">The appointment has been successfully added to Medigo.</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button class="btn btn-submit" onclick="resetForm()">Add Another</button>
                <button class="btn btn-cancel" onclick="window.location.href='Appointment.php'">Go to Appointments</button>
            </div>
        </div>
    </div>

    <script>
        // Populate doctors from MySQL Database
        async function loadDoctors() {
            try {
                const res = await fetch('api.php?action=get_doctors');
                const data = await res.json();
                if (data && data.status === 'success' && data.data && data.data.length > 0) {
                    const docSelect = document.getElementById('doctor');
                    docSelect.innerHTML = '<option value="">Choose Doctor</option>';
                    data.data.forEach(doc => {
                        const opt = document.createElement('option');
                        opt.value = doc.name;
                        opt.textContent = doc.name + ' (' + (doc.specialty || doc.department || 'General') + ')';
                        docSelect.appendChild(opt);
                    });
                }
            } catch (e) {
                console.warn(e);
            }
        }
        document.addEventListener('DOMContentLoaded', loadDoctors);

        document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            // Gather inputs
            const patientName = document.getElementById('patientName').value.trim();
            const patientPhone = document.getElementById('patientPhone').value.trim();
            const deptSelect = document.getElementById('dept');
            const deptName = deptSelect.options[deptSelect.selectedIndex].text;
            const doctorSelect = document.getElementById('doctor');
            const doctorName = doctorSelect.value || doctorSelect.options[doctorSelect.selectedIndex].text;
            const date = document.getElementById('appDate').value;
            const time = document.getElementById('appTime').value;
            const reason = document.getElementById('notes').value.trim();
            
            try {
                // Save directly to MySQL database via api.php
                const res = await fetch('api.php?action=add_appointment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        patient_name: patientName,
                        doctor_name: doctorName,
                        department: deptName,
                        phone: patientPhone,
                        appointment_date: date,
                        appointment_time: time,
                        reason: reason || "General Medical Consultation",
                        status: "Confirmed"
                    })
                });

                const resData = await res.json();

                // Construct new appointment object for local cache
                const newAppointment = {
                    id: (resData && resData.data && resData.data.id) ? parseInt(resData.data.id) : Date.now(),
                    patient: patientName,
                    doctor: `${doctorName} (${deptName})`,
                    date: date,
                    time: time,
                    type: "In-person",
                    reason: reason || "No description provided.",
                    status: "Confirmed"
                };
                
                let list = JSON.parse(localStorage.getItem('appointments')) || [];
                list.unshift(newAppointment);
                localStorage.setItem('appointments', JSON.stringify(list));
                
                document.getElementById('success-overlay').style.display = 'flex';
                submitBtn.innerHTML = 'Confirm Appointment';
            } catch (err) {
                console.error("Save appointment error:", err);
                alert("Error booking appointment in database: " + err.message);
                submitBtn.innerHTML = 'Confirm Appointment';
            }
        });

        function resetForm() {
            document.getElementById('appointmentForm').reset();
            document.getElementById('success-overlay').style.display = 'none';
        }

        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('appDate').setAttribute('min', today);

        // Toggle mobile menu visibility
        function toggleMobileMenu() {
            const menu = document.getElementById('navLinks');
            menu.classList.toggle('active');
        }

        // Handle Dropdown System
        function toggleDropdown(menuId, event) {
            event.stopPropagation();
            const dropdownMenu = document.getElementById(menuId);
            const isShown = dropdownMenu.classList.contains('show');

            closeAllDropdowns();

            if (!isShown) {
                dropdownMenu.classList.add('show');
            }
        }

        function closeAllDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(drop => {
                drop.classList.remove('show');
            });
        }

        // Click outside closes dropdown events
        window.addEventListener('click', function () {
            closeAllDropdowns();
        });

        // Simulated Logout prompt
        function logout() {
            if (confirm("Confirm session termination and return to main screen?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>
</html>
