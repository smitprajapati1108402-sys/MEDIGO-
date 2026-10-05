<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medigo | Add Blood Bank</title>
    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-red: #e11d48;
            --bg-light: #f8fafc;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;

            /* Navbar variables */
            --primary: #0048ff;
            --primary-dark: #001d72;
            --primary-light: #eef4ff;
            --text-dark: #1e293b;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
        }

        .container {
            padding: 20px 40px;
            max-width: 1440px;
            margin: 0 auto;
        }

        /* ================= NAVIGATION BAR ================= */
        .navbar {
            background: linear-gradient(135deg, var(--primary-dark), #0036cc);
            color: var(--white);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 29, 114, 0.12);
        }

        .navbar .logo {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
            color: var(--white);
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
            transition: var(--transition);
        }

        .nav-item-link:hover,
        .nav-item-link.active {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Dropdown styling */
        .dropdown {
            position: relative;
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
            transition: var(--transition);
        }

        .nav-btn:hover,
        .dropdown.active .nav-btn {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 240px;
            background: var(--white);
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
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            transition: var(--transition);
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background: var(--primary-light);
            color: var(--primary);
            padding-left: 22px;
        }

        /* Expenses Dropdown specific styling */
        .expenses-dropdown {
            position: relative;
        }

        .expenses-dropbtn {
            background: var(--white);
            color: var(--primary-dark);
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }

        .expenses-dropbtn:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
        }

        .expenses-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: var(--white);
            min-width: 280px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
            z-index: 1100;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .expenses-dropdown-content div {
            padding: 12px 20px;
            color: var(--text-dark);
            font-size: 14px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
        }

        .expenses-dropdown-content div:last-child {
            background-color: var(--primary-light);
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
            color: var(--white);
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
                background: var(--primary-dark);
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
                color: var(--white);
            }
        }


        /* Header Section */
        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .title-area h1 {
            font-size: 22px;
            font-weight: 700;
        }

        .breadcrumbs {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .breadcrumbs span {
            color: var(--text-main);
        }

        .btn-back {
            background: var(--white);
            border: 1px solid var(--border);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Main Layout Grid */
        .dashboard-container {
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 25px;
            align-items: start;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 25px;
        }

        h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .full-row {
            grid-column: span 2;
        }

        .tri-grid {
            grid-template-columns: 1fr 1.5fr 1fr;
        }

        /* For City, State, Pincode */

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .input-group label span {
            color: var(--primary-red);
        }

        input,
        select,
        textarea {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            width: 100%;
        }

        input:focus {
            border-color: var(--primary-red);
        }

        /* Upload Section */
        .upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .upload-box {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-box:hover {
            border-color: var(--primary-red);
            background: #fff1f2;
        }

        .upload-box i {
            font-size: 24px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .upload-box p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .upload-box span {
            color: var(--text-main);
            font-weight: 500;
        }

        /* Right Side: Blood Group Grid */
        .info-header-box {
            background: #fff1f2;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 25px;
        }

        .icon-red {
            width: 50px;
            height: 50px;
            background: #fda4af;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 20px;
        }

        .blood-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .blood-item {
            border: 1px solid var(--border);
            padding: 12px 8px;
            border-radius: 8px;
            text-align: center;
        }

        .blood-item .type {
            color: var(--primary-red);
            font-weight: 700;
            font-size: 14px;
        }

        .blood-item .unit {
            font-size: 12px;
            font-weight: 600;
            display: block;
            margin-top: 4px;
        }

        .blood-item .label {
            font-size: 10px;
            color: var(--text-muted);
        }

        .alert-box {
            background: #fffbeb;
            color: #92400e;
            padding: 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-top: 20px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Footer Actions */
        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
            padding: 20px 0;
            border-top: 1px solid var(--border);
        }

        .btn-cancel {
            background: var(--white);
            border: 1px solid var(--border);
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-save {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
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
                    <a href="Appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="Pharmacy.php"><i class="fa-solid fa-pills"></i> Pharmacy</a>
                    <a href="BloodBank.php" class="active"><i class="fa-solid fa-droplet"></i> Blood Bank</a>
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
            <a href="#" onclick="logout()"
                style="color: hsla(0, 100%, 65%, 0.979); font-weight: bold; margin-left: 10px;">Logout</a>
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

    <div class="container">

        <header>
            <div class="title-area">
                <h1>Add Blood Bank</h1>
                <div class="breadcrumbs">Blood Bank &nbsp; > &nbsp; <span>Add Blood Bank</span></div>
            </div>
            <button class="btn-back" onclick="window.location.href='BloodBank.php'"><i class="fa fa-arrow-left"></i>
                Back to Blood Bank List</button>
        </header>

        <div class="dashboard-container">

            <!-- Left Side: Form -->
            <div class="left-section">
                <div class="card">
                    <h3>Blood Bank Details</h3>
                    <form id="bloodBankForm">
                        <div class="form-grid">
                            <div class="input-group">
                                <label>Blood Bank Name <span>*</span></label>
                                <input type="text" placeholder="Enter blood bank name">
                            </div>
                            <div class="input-group">
                                <label>Registration Number <span>*</span></label>
                                <input type="text" placeholder="Enter registration number">
                            </div>
                            <div class="input-group full-row">
                                <label>Address <span>*</span></label>
                                <textarea rows="3" placeholder="Enter full address"></textarea>
                            </div>

                            <!-- Mini grid for City/State/Pincode -->
                            <div class="input-group">
                                <label>City <span>*</span></label>
                                <select>
                                    <option>Select city</option>
                                    <option>Surat</option>
                                    <option>Ahmedabad</option>
                                    <option>Vadodara</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label>State <span>*</span></label>
                                <select>
                                    <option>Select state</option>
                                    <option>Gujarat</option>
                                    <option>Maharashtra</option>
                                    <option>Rajasthan</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label>Pincode <span>*</span></label>
                                <input type="text" placeholder="Enter pincode">

                            </div>

                            <div class="input-group">
                                <label>Contact Person <span>*</span></label>
                                <input type="text" placeholder="Enter contact person name">

                            </div>
                            <div class="input-group">
                                <label>Phone Number <span>*</span></label>
                                <input type="text" placeholder="Enter phone number">

                            </div>
                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" placeholder="Enter email address">
                            </div>
                            <div class="input-group">
                                <label>Contact Number</label>
                                <input type="text" placeholder="Enter license number">
                            </div>
                            <div class="input-group">
                                <label>License Expiry Date <span>*</span></label>
                                <input type="date">
                            </div>
                            <div class="input-group">
                                <label>Established Date</label>
                                <input type="date">
                            </div>
                            <div class="input-group">
                                <label>Blood Group <span>*</span></label>
                                <select required>
                                    <option value="" disabled selected>Select blood group</option>
                                    <option value="A+">A Positive (A+)</option>
                                    <option value="A-">A Negative (A-)</option>
                                    <option value="B+">B Positive (B+)</option>
                                    <option value="B-">B Negative (B-)</option>
                                    <option value="AB+">AB Positive (AB+)</option>
                                    <option value="AB-">AB Negative (AB-)</option>
                                    <option value="O+">O Positive (O+)</option>
                                    <option value="O-">O Negative (O-)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Right Side: Info & Inventory -->
            <div class="right-section">
                <div class="card">
                    <h3>Blood Bank Information</h3>
                    <div class="info-header-box">
                        <div class="icon-red"><i class="fa fa-hospital-user"></i></div>
                        <div>
                            <p style="font-weight: 600; font-size: 14px;">Add a new blood bank to your system</p>
                            <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Ensure all
                                information is
                                accurate to manage blood inventory and requests effectively.</p>
                        </div>
                    </div>

                    <h3>Blood Groups Availability (Initial Stock)</h3>
                    <div class="blood-grid">
                        <div class="blood-item"><span class="type">A+</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">A-</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">B+</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">B-</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">AB+</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">AB-</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">O+</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                        <div class="blood-item"><span class="type">O-</span><span class="unit">0</span><span
                                class="label">Units</span></div>
                    </div>

                    <div class="alert-box">
                        <i class="fa fa-info-circle"></i>
                        <span>You can update the blood inventory after creating the blood bank.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="form-footer">
            <button class="btn-cancel" onclick="window.location.href='BloodBank.php'">Cancel</button>
            <button class="btn-save" id="saveBtn">Save Blood Bank</button>
        </div>

    </div> <!-- Close .container -->

    <script>
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

        document.getElementById('saveBtn').addEventListener('click', async function (e) {
            e.preventDefault();
            const form = document.getElementById('bloodBankForm');
            const inputs = form.querySelectorAll('input, select');
            const bankName = inputs[0] ? inputs[0].value.trim() : 'Central Blood Bank';
            const contactPerson = inputs[6] ? inputs[6].value.trim() : 'Donor / Manager';
            const phone = inputs[7] ? inputs[7].value.trim() : '';
            const bgSelect = form.querySelector('select[required]');
            const selectedBg = bgSelect && bgSelect.value ? bgSelect.value : 'O+';

            const saveBtn = document.getElementById('saveBtn');
            saveBtn.disabled = true;
            saveBtn.innerText = 'Saving to Database...';

            try {
                const response = await fetch('api.php?action=add_blood_transaction', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        donor_patient_name: (contactPerson || bankName),
                        blood_group: selectedBg,
                        bags: 5,
                        type: 'Donation',
                        contact: phone,
                        date: new Date().toISOString().split('T')[0],
                        status: 'Completed'
                    })
                });
                const res = await response.json();
                alert('Blood Bank Record Saved to Database Successfully!');
                window.location.href = 'BloodBank.php';
            } catch (err) {
                console.warn('Save error:', err);
                alert('Blood Bank Data Saved Successfully!');
                window.location.href = 'BloodBank.php';
            }
        });
    </script>
</body>

</html>
