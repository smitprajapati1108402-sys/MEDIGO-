<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medigo | Medical Report Entry</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0052ea;
            --bg-body: #f1f4f9;
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --green: #22c55e;
            --red: #ef4444;
            --yellow: #f59e0b;

            /* Navbar specific variables */
            --nav-primary: #0048ff;
            --nav-primary-dark: #001d72;
            --nav-primary-light: #eef4ff;
            --nav-white: #ffffff;
            --nav-text-dark: #1e293b;
            --nav-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-size: 13px;
        }

        /* Main content and containers */
        .main-content {
            flex: 1;
            padding: 20px;
            width: 100%;
        }

        /* ================= NAVIGATION BAR ================= */
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

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .breadcrumbs {
            color: var(--text-muted);
            font-size: 12px;
        }

        .breadcrumbs a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumbs a:hover {
            color: var(--text-main);
        }

        .breadcrumbs span {
            color: var(--text-main);
            font-weight: 500;
        }

        .report-id-box {
            background: #fee2e2;
            color: var(--red);
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .copy-btn {
            background: white;
            border: 1px solid #fca5a5;
            padding: 4px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--primary);
        }

        /* Main Layout */
        .dashboard-container {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 20px;
        }

        /* Card Styling */
        .card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 15px;
            font-weight: 600;
        }

        .section-num {
            background: var(--primary);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        /* Form Grid */
        .input-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }

        .form-group label span {
            color: var(--red);
        }

        /* Modified CSS: Width 100% added to keep elements inside their grid columns */
        input,
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            transition: 0.2s;
            background: #fafafa;
        }

        input:focus,
        select:focus {
            border-color: var(--primary);
            background: white;
        }

        /* Modified CSS: Search input container styling corrected */
        .search-input {
            position: relative;
            width: 100%;
        }

        .search-input input {
            padding-right: 32px;
        }

        /* Ensures text doesn't overlap the search icon */
        .search-input i {
            position: absolute;
            right: 10px;
            top: 11px;
            color: var(--text-muted);
        }

        /* Table Section */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            background: #f8fafc;
            padding: 12px;
            font-size: 11px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
        }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-normal {
            background: #dcfce7;
            color: #166534;
        }

        .status-high {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-add-test {
            border: 1px solid var(--primary);
            background: white;
            color: var(--primary);
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
        }

        .del-btn {
            color: var(--red);
            cursor: pointer;
        }

        /* Sidebar Sections */
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            align-items: center;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .upload-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .upload-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .upload-icon {
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .btn-upload {
            background: white;
            border: 1px solid var(--border);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            cursor: pointer;
        }

        /* Signature */
        .signature-box {
            text-align: center;
            border-top: 1px solid var(--border);
            padding-top: 15px;
            margin-top: 15px;
        }

        .sig-font {
            font-family: 'Brush Script MT', cursive;
            font-size: 24px;
            color: #1e293b;
        }

        /* Footer Toolbar */
        .toolbar {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            padding-bottom: 50px;
        }

        .btn-tool {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: white;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-send {
            background: #ecfdf5;
            color: #059669;
            border-color: #a7f3d0;
        }

        /* Specific Responsive */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
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
            <div class="dropdown" id="servicesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('servicesMenu', event)">
                    Services <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="servicesMenu">
                    <a href="doctormanagement.php"><i class="fa-solid fa-user-md"></i> Doctor Management</a>
                    <a href="patientmanagement.php"><i class="fa-solid fa-user-injured"></i> Patient Management</a>
                    <a href="Appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="Pharmacy.php"><i class="fa-solid fa-pills"></i> Pharmacy</a>
                    <a href="BloodBank.php"><i class="fa-solid fa-droplet"></i> Blood Bank</a>
                </div>
            </div>

            <!-- Resources Dropdown -->
            <div class="dropdown active" id="resourcesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('resourcesMenu', event)">
                    Resources <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="resourcesMenu">
                    <a href="hospitalreport.php"><i class="fa-solid fa-chart-line"></i> Hospital Reports</a>
                    <a href="MedicalReport.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Medical Report</a>
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
        <header class="header">
        <div class="breadcrumbs"><a href="MedicalReport.php">Reports</a> &nbsp; &gt; &nbsp; <span>Medical Report Entry</span></div>
        <div class="report-id-box">
            Report ID : MR20250527001
            <button class="copy-btn"><i class="far fa-copy"></i></button>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Left Side -->
        <div class="main-left">
            <!-- 1. Patient Information -->
            <div class="card">
                <div class="section-title"><span class="section-num">1</span> Patient Information</div>
                <div class="input-grid">
                    <div class="form-group">
                        <label>Patient ID <span>*</span></label>
                        <div class="search-input">
                            <input type="text" id="patientId" placeholder="e.g. 101">
                            <i class="fa fa-search" id="patientSearchIcon" style="cursor: pointer;"></i>
                        </div>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Patient Name <span>*</span></label>
                        <input type="text" id="patientName" placeholder="Patient Name">
                    </div>
                    <div class="form-group">
                        <label>Age <span>*</span></label>
                        <div style="display: flex; gap: 5px;">
                            <input type="text" id="patientAge" placeholder="Age" style="width: 55px;">
                            <input type="text" value="Years" readonly style="width: 60px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gender <span>*</span></label>
                        <select id="patientGender">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Non-binary">Non-binary</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blood Group</label>
                        <select id="patientBloodGroup">
                            <option value="">Select</option>
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
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Mobile Number <span>*</span></label>
                        <input type="text" id="patientMobile" placeholder="Mobile Number">
                    </div>
                </div>
            </div>

            <!-- 2. Doctor Information -->
            <div class="card">
                <div class="section-title"><span class="section-num">2</span> Doctor Information</div>
                <div class="input-grid">
                    <div class="form-group">
                        <label>Doctor Name <span>*</span></label>
                        <select id="doctorName">
                            <option value="">Select Doctor</option>
                            <option value="Dr. Raj Patel">Dr. Raj Patel</option>
                            <option value="Dr. Jane Smith">Dr. Jane Smith</option>
                            <option value="Dr. Robert Chen">Dr. Robert Chen</option>
                            <option value="Dr. Marcus Vance">Dr. Marcus Vance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department <span>*</span></label>
                        <select id="doctorDepartment">
                            <option value="">Select Department</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Neurology">Neurology</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Emergency Medicine">Emergency Medicine</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Doctor ID</label>
                        <input type="text" id="doctorId" placeholder="Doctor ID">
                    </div>
                    <div class="form-group">
                        <label>Appointment ID</label>
                        <div class="search-input">
                            <input type="text" id="appointmentId" placeholder="Appointment ID">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Report Details -->
            <div class="card">
                <div class="section-title"><span class="section-num">3</span> Report Details</div>
                <div class="input-grid">
                    <div class="form-group">
                        <label>Report Type <span>*</span></label>
                        <select>
                            <option>Blood Test</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Collection Date <span>*</span></label>
                        <input type="text" value="27/05/2025">
                    </div>
                    <div class="form-group">
                        <label>Report Date <span>*</span></label>
                        <input type="text" value="27/05/2025">
                    </div>
                    <div class="form-group">
                        <label>Sample Type</label>
                        <select>
                            <option>Blood</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Symptoms</label>
                        <textarea id="symptoms" rows="2" placeholder="Symptoms"></textarea>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Diagnosis</label>
                        <textarea id="diagnosis" rows="2" placeholder="Diagnosis"></textarea>
                    </div>
                    <div class="form-group" style="grid-column: span 4;">
                        <label>Treatment / Notes</label>
                        <textarea rows="2">Rest, Plenty of fluids and Paracetamol if required.</textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Test Results -->
            <div class="card">
                <div class="section-title"><span class="section-num">4</span> Test Results</div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Test Name</th>
                            <th>Result</th>
                            <th>Unit</th>
                            <th>Normal Range</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Hemoglobin (Hb)</td>
                            <td><input type="text" value="13.5" style="width: 60px;"></td>
                            <td>g/dL</td>
                            <td>12.0 - 16.0</td>
                            <td><span class="status-pill status-normal">Normal</span></td>
                            <td>-</td>
                            <td><i class="fa fa-trash del-btn"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Total WBC Count</td>
                            <td><input type="text" value="12,000" style="width: 60px;"></td>
                            <td>/cumm</td>
                            <td>4,000 - 11,000</td>
                            <td><span class="status-pill status-high">High</span></td>
                            <td>Slightly High</td>
                            <td><i class="fa fa-trash del-btn"></i></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn-add-test">+ Add New Test</button>
            </div>

            <!-- Bottom Toolbar -->
            <div class="toolbar">
                <button class="btn-tool btn-save"><i class="fa fa-save"></i> Save Report</button>
                <button class="btn-tool"><i class="fa fa-eye"></i> Preview</button>
                <button class="btn-tool"><i class="fa fa-print"></i> Print</button>
                <button class="btn-tool"><i class="fa fa-download"></i> Download PDF</button>
                <button class="btn-tool btn-send"><i class="fa fa-paper-plane"></i> Send to Patient</button>
            </div>
        </div>

        <!-- Right Side Sidebar -->
        <div class="main-right">
            <div class="card">
                <div class="section-title"><i class="fa fa-file-medical" style="color: var(--primary);"></i> Report
                    Summary</div>
                <div class="summary-row"><span>Patient Condition</span> <span class="badge-green">Stable</span></div>
                <div class="summary-row"><span>Risk Level</span> <span
                        style="color: var(--green); font-weight: 700;">Low</span></div>
                <div class="summary-row"><span>Follow-up Date</span> <span>25/06/2025</span></div>
                <div class="summary-row"><span>Next Visit</span> <span>25/06/2025</span></div>
                <div class="summary-row"><span>Report Status</span> <span
                        style="color: var(--primary); font-weight: 700;">Draft</span></div>
            </div>

            <div class="card">
                <div class="section-title"><i class="fa fa-cloud-upload-alt" style="color: var(--primary);"></i> Upload
                    Documents</div>
                <div class="upload-item">
                    <div class="upload-info">
                        <div class="upload-icon" style="background: #fee2e2; color: var(--red);"><i
                                class="far fa-file-pdf"></i></div>
                        <div>
                            <p>Upload PDF Report</p><small style="color: var(--text-muted);">PDF, Max size 5MB</small>
                        </div>
                    </div>
                    <button class="btn-upload">Upload</button>
                </div>
                <div class="upload-item">
                    <div class="upload-info">
                        <div class="upload-icon" style="background: #dcfce7; color: var(--green);"><i
                                class="far fa-image"></i></div>
                        <div>
                            <p>Upload Scan/Image</p><small style="color: var(--text-muted);">JPG, PNG, Max size
                                5MB</small>
                        </div>
                    </div>
                    <button class="btn-upload">Upload</button>
                </div>
            </div>

            <div class="card">
                <div class="section-title"><i class="fa fa-sticky-note" style="color: var(--primary);"></i> Notes /
                    Remarks</div>
                <textarea rows="4" style="width: 100%;" placeholder="Add any additional notes..."></textarea>
                <p style="text-align: right; color: var(--text-muted); font-size: 10px; margin-top: 5px;">0 / 500
                    Characters</p>
            </div>

            <div class="card">
                <div class="section-title"><i class="fa fa-check-circle" style="color: var(--primary);"></i> Doctor
                    Signature</div>
                <div class="signature-box">
                    <div class="sig-font">Raj Patel</div>
                    <p style="font-weight: 700; margin-top: 10px;">Dr. Raj Patel</p>
                    <p style="color: var(--text-muted); font-size: 11px;">MBBS, MD (Cardiology)</p>
                    <p style="color: var(--text-muted); font-size: 11px;">Reg. No. DOC-101</p>
                </div>
            </div>
        </div>
    </div>
    </div> <!-- Closing div for main-content wrapper -->

    <script>
        // Check if old data is stored in localStorage and clean it up to prevent mismatched names
        if (localStorage.getItem('doctors') && (localStorage.getItem('doctors').includes('Dr. Smit Prajapati') || localStorage.getItem('doctors').includes('Dr. John Doe'))) {
            localStorage.removeItem('doctors');
            localStorage.removeItem('patients');
        }

        // Copy Report ID functionality
        document.querySelector('.copy-btn').addEventListener('click', () => {
            alert('Report ID Copied to Clipboard!');
        });

        // Save Report functionality
        document.querySelector('.btn-save').addEventListener('click', (e) => {
            e.preventDefault();
            alert('Report Saved Successfully!');
            window.location.href = 'MedicalReport.php';
        });

        // Send to Patient functionality
        document.querySelector('.btn-send').addEventListener('click', (e) => {
            e.preventDefault();
            alert('Report Sent to Patient Successfully!');
            window.location.href = 'MedicalReport.php';
        });

        // Add Test Row Simulation
        document.querySelector('.btn-add-test').addEventListener('click', () => {
            const table = document.querySelector('tbody');
            const rowCount = table.rows.length + 1;
            const newRow = `
                <tr>
                    <td>${rowCount}</td>
                    <td><input type="text" placeholder="Test Name"></td>
                    <td><input type="text" style="width: 60px;"></td>
                    <td>-</td>
                    <td>-</td>
                    <td><span class="status-pill status-normal">Normal</span></td>
                    <td>-</td>
                    <td><i class="fa fa-trash del-btn"></i></td>
                </tr>
            `;
            table.insertAdjacentHTML('beforeend', newRow);
        });

        // Dynamic Patient Data Store from MySQL
        let livePatientsList = [];

        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('api.php?action=get_patients');
                const result = await response.json();
                if (result && result.status === 'success' && result.data) {
                    livePatientsList = result.data.map(p => ({
                        id: p.id,
                        patient_id: p.patient_id || ('PAT-' + p.id),
                        name: p.name,
                        age: p.age || 30,
                        gender: p.gender || 'Male',
                        blood_group: p.blood_group || 'O+',
                        phone: p.phone || '',
                        disease: p.disease || '',
                        doctor: p.doctor_assigned || 'Dr. Raj Patel',
                        address: p.address || ''
                    }));
                }
            } catch (err) {
                console.warn('Fallback loading live patients:', err);
            }
        });

        // Patient ID Autocomplete Lookup logic
        function autofillPatientDetails(enteredId) {
            if (!enteredId) return;

            const cleanId = enteredId.toLowerCase().replace('#', '').replace(/pat-?/i, '').replace(/pt/i, '').trim();

            const defaultPatients = [
                { id: 1001, patient_id: "PAT-1001", name: "Arjun Sharma", age: 45, gender: "Male", blood_group: "O+", disease: "Hypertension", phone: "+91 98711 22334", doctor: "Dr. Raj Patel" },
                { id: 1002, patient_id: "PAT-1002", name: "Priya Verma", age: 28, gender: "Female", blood_group: "B+", disease: "Migraine", phone: "+91 98622 33445", doctor: "Dr. Jane Smith" },
                { id: 1003, patient_id: "PAT-1003", name: "Rohan Gupta", age: 12, gender: "Male", blood_group: "A+", disease: "Seasonal Flu", phone: "+91 98533 44556", doctor: "Dr. Robert Chen" }
            ];

            const patients = (livePatientsList && livePatientsList.length > 0) ? livePatientsList : (JSON.parse(localStorage.getItem('patients')) || defaultPatients);

            const matchedPatient = patients.find(p => {
                const pIdStr = String(p.patient_id || p.id).toLowerCase().replace('#', '').replace(/pat-?/i, '').replace(/pt/i, '').trim();
                const pNumStr = String(p.id).trim();
                const pNameStr = String(p.name).toLowerCase().trim();
                return pIdStr === cleanId || pNumStr === cleanId || pNameStr.includes(cleanId);
            });

            if (matchedPatient) {
                // Populate Patient Name
                document.getElementById('patientName').value = matchedPatient.name;
                document.getElementById('patientAge').value = matchedPatient.age || 30;
                document.getElementById('patientGender').value = matchedPatient.gender || 'Male';
                document.getElementById('patientBloodGroup').value = matchedPatient.blood_group || 'O+';
                document.getElementById('patientMobile').value = matchedPatient.phone || '';
                document.getElementById('diagnosis').value = matchedPatient.disease || 'General Evaluation';
                document.getElementById('symptoms').value = (matchedPatient.disease || 'General Checkup') + ", Vital Check";

                // Populate Doctor Info
                const doctorName = matchedPatient.doctor;
                const doctorSelect = document.getElementById('doctorName');

                let matchedDocOption = false;
                for (let i = 0; i < doctorSelect.options.length; i++) {
                    if (doctorSelect.options[i].text.toLowerCase().includes(doctorName.toLowerCase()) ||
                        doctorName.toLowerCase().includes(doctorSelect.options[i].text.toLowerCase())) {
                        doctorSelect.selectedIndex = i;
                        matchedDocOption = true;
                        break;
                    }
                }

                if (!matchedDocOption && doctorName) {
                    const opt = document.createElement('option');
                    opt.value = doctorName;
                    opt.textContent = doctorName;
                    doctorSelect.appendChild(opt);
                    doctorSelect.value = doctorName;
                }

                const docMap = {
                    "Dr. Raj Patel": { id: "DOC-101", dept: "Cardiology" },
                    "Dr. Jane Smith": { id: "DOC-102", dept: "Neurology" },
                    "Dr. Robert Chen": { id: "DOC-103", dept: "Pediatrics" },
                    "Dr. Marcus Vance": { id: "DOC-104", dept: "Emergency Medicine" }
                };

                const docDetails = docMap[doctorName] || { id: "DOC-101", dept: "Cardiology" };

                document.getElementById('doctorId').value = docDetails.id;

                const deptSelect = document.getElementById('doctorDepartment');
                let matchedDeptOption = false;
                for (let i = 0; i < deptSelect.options.length; i++) {
                    if (deptSelect.options[i].text.toLowerCase().includes(docDetails.dept.toLowerCase())) {
                        deptSelect.selectedIndex = i;
                        matchedDeptOption = true;
                        break;
                    }
                }

                if (!matchedDeptOption && docDetails.dept) {
                    const opt = document.createElement('option');
                    opt.value = docDetails.dept;
                    opt.textContent = docDetails.dept;
                    deptSelect.appendChild(opt);
                    deptSelect.value = docDetails.dept;
                }

                // Populate Appointment ID
                document.getElementById('appointmentId').value = "APT202606" + matchedPatient.id;

                // Update Doctor signature card
                const sigBox = document.querySelector('.signature-box');
                if (sigBox) {
                    const cleanDocName = doctorName.replace("Dr. ", "");
                    sigBox.innerHTML = `
                        <div class="sig-font">${cleanDocName}</div>
                        <p style="font-weight: 700; margin-top: 10px;">${doctorName}</p>
                        <p style="color: var(--text-muted); font-size: 11px;">MBBS, MD (${docDetails.dept})</p>
                        <p style="color: var(--text-muted); font-size: 11px;">Reg. No. G-${matchedPatient.id}</p>
                    `;
                }
            }
        }

        // Attach listeners
        document.getElementById('patientId').addEventListener('input', function () {
            autofillPatientDetails(this.value.trim());
        });

        document.getElementById('patientSearchIcon').addEventListener('click', function () {
            autofillPatientDetails(document.getElementById('patientId').value.trim());
        });

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
