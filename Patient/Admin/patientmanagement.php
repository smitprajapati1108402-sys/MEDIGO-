<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management Directory</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* CSS Variables & Reset */
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;

            /* Admin dashboard shared variables */
            --primary: #0048ff;
            --primary-dark: #001d72;
            --primary-light: #eef4ff;
            --white: #ffffff;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
        }

        /* Header */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .header-title p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0036cc;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid var(--border-color);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .icon-blue {
            background: #e0e7ff;
            color: #0048ff;
        }

        .icon-green {
            background: #d1fae5;
            color: #10b981;
        }

        .icon-orange {
            background: #fef3c7;
            color: #d97706;
        }

        .icon-red {
            background: #fee2e2;
            color: #ef4444;
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .stat-info p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Control Bar */
        .control-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.2rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            transition: border 0.2s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
        }

        .filter-box select {
            padding: 0.6rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            background-color: #fff;
        }

        /* Table container */
        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .patient-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .patient-avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #eef4ff;
            color: #0048ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .patient-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .patient-details p {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* Condition Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-stable {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-serious {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-critical {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Action Buttons */
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            margin-right: 0.5rem;
        }

        .btn-edit {
            color: var(--primary);
        }

        .btn-edit:hover {
            background-color: var(--primary-light);
        }

        .btn-delete {
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: #fee2e2;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 2000;
            padding: 1rem;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-btn {
            font-size: 1.5rem;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #0f172a;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .btn-modal {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
        }

        .btn-modal-primary {
            background-color: var(--primary);
            color: #fff;
        }

        .btn-modal-primary:hover {
            background-color: #0036cc;
        }

        .btn-modal-secondary {
            background-color: #e2e8f0;
            color: #334155;
        }

        .btn-modal-secondary:hover {
            background-color: #cbd5e1;
        }

        .flex-container {
            display: flex;
            gap: 0.5rem;
        }

        .flex-container select {
            width: 100px;
        }

        .hidden {
            display: none !important;
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
                    <a href="patientmanagement.php" class="active"><i class="fa-solid fa-user-injured"></i> Patient
                        Management</a>
                    <a href="Appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
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

    <!-- Main Content Area -->
    <div class="dashboard-container">
        <!-- Header -->
        <header class="main-header">
            <div class="header-title">
                <h1>Patient Directory</h1>
                <p>Manage admitted patients, diagnostics, and doctor assignments</p>
            </div>
            <a href="add_patient.php" id="addPatientBtn" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Patient
            </a>
        </header>

        <!-- Stats Grid -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-procedures"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalPatients">0</h3>
                    <p>Total Admitted</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stablePatients">0</h3>
                    <p>Stable Condition</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-orange">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-info">
                    <h3 id="seriousPatients">0</h3>
                    <p>Serious Condition</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <div class="stat-info">
                    <h3 id="criticalPatients">0</h3>
                    <p>Critical Condition</p>
                </div>
            </div>
        </section>

        <!-- Search and Filter Bar -->
        <section class="control-bar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search by name or diagnosis...">
            </div>
            <div class="filter-box">
                <select id="conditionFilter">
                    <option value="all">All Conditions</option>
                    <option value="Stable">Stable</option>
                    <option value="Serious">Serious</option>
                    <option value="Critical">Critical</option>
                </select>
            </div>
        </section>

        <!-- Table Container -->
        <section class="table-container">
            <table id="patientsTable">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Diagnosis</th>
                        <th>Assigned Doctor</th>
                        <th>Condition</th>
                        <th>Contact</th>
                        <th>Room/Ward</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="patientsTableBody">
                    <!-- Dynamic rows via JavaScript -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Patient Form Modal -->
    <div id="patientModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Register New Patient</h2>
                <span class="close-btn" id="closeModalBtn">&times;</span>
            </div>
            <form id="patientForm">
                <div class="modal-body">
                    <input type="hidden" id="patientId">

                    <div class="form-group">
                        <label for="patName">Full Name</label>
                        <input type="text" id="patName" required placeholder="e.g. Aarav Patel">
                    </div>

                    <div class="form-group">
                        <label for="patDisease">Diagnosis / Disease</label>
                        <input type="text" id="patDisease" required placeholder="e.g. Acute Appendicitis">
                    </div>

                    <div class="form-group">
                        <label for="patDoc">Assigned Doctor</label>
                        <select id="patDoc" required>
                            <!-- Populated dynamically from localStorage doctors -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="patCondition">Condition Level</label>
                        <select id="patCondition" required>
                            <option value="Stable">Stable</option>
                            <option value="Serious">Serious</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Contact Number</label>
                        <div class="flex-container">
                            <select id="form-country-code" class="font-mono">
                                <option value="+91">+91</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                                <option value="+61">+61</option>
                                <option value="other">Other</option>
                            </select>
                            <input type="tel" id="patPhone" required placeholder="e.g. 98765 43210" class="font-mono">
                        </div>
                        <div id="custom-country-code-container" class="hidden mt-2">
                            <input type="text" id="form-custom-country-code" placeholder="Enter custom code (e.g. +55)"
                                class="font-mono">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="patRoom">Room / Ward Assignment</label>
                        <input type="text" id="patRoom" required placeholder="e.g. Ward A, Room 102">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="cancelBtn" class="btn-modal btn-modal-secondary">Cancel</button>
                    <button type="submit" class="btn-modal btn-modal-primary">Save Patient</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Block -->
    <script>
        // Standard Patients matching DB
        const defaultPatients = [
            { id: 101, name: "Arjun Sharma", disease: "Hypertension", condition: "Stable", phone: "+91 98711 22334", doctor: "Dr. Raj Patel", room: "Room 204, Ward B" },
            { id: 102, name: "Priya Verma", disease: "Migraine", condition: "Serious", phone: "+91 98622 33445", doctor: "Dr. Jane Smith", room: "Room 105, Ward A" },
            { id: 103, name: "Rohan Gupta", disease: "Seasonal Flu", condition: "Stable", phone: "+91 98533 44556", doctor: "Dr. Robert Chen", room: "Room 302, Pediatrics" }
        ];

        // Clean obsolete mock data from localStorage if present
        if (localStorage.getItem('patients') && localStorage.getItem('patients').includes('Aarav Patel')) {
            localStorage.removeItem('doctors');
            localStorage.removeItem('patients');
        }

        // Initialize state from local storage or use defaults
        let patients = JSON.parse(localStorage.getItem('patients')) || defaultPatients;

        // DOM Elements
        const tableBody = document.getElementById('patientsTableBody');
        const searchInput = document.getElementById('searchInput');
        const conditionFilter = document.getElementById('conditionFilter');
        const modal = document.getElementById('patientModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const patientForm = document.getElementById('patientForm');
        const modalTitle = document.getElementById('modalTitle');
        const patDocSelect = document.getElementById('patDoc');

        // Fields in Modal Form
        const patIdField = document.getElementById('patientId');
        const patNameField = document.getElementById('patName');
        const patDiseaseField = document.getElementById('patDisease');
        const patDocField = document.getElementById('patDoc');
        const patConditionField = document.getElementById('patCondition');
        const patPhoneField = document.getElementById('patPhone');
        const countryCodeSelect = document.getElementById('form-country-code');
        const customCountryCodeContainer = document.getElementById('custom-country-code-container');
        const customCountryCodeInput = document.getElementById('form-custom-country-code');
        const patRoomField = document.getElementById('patRoom');

        // Stats Counters
        const totalPatientsEl = document.getElementById('totalPatients');
        const stablePatientsEl = document.getElementById('stablePatients');
        const seriousPatientsEl = document.getElementById('seriousPatients');
        const criticalPatientsEl = document.getElementById('criticalPatients');

        document.addEventListener('DOMContentLoaded', () => {
            loadPatientsAndDoctorsFromDb();

            // Search & Filter Events
            searchInput.addEventListener('input', renderDashboard);
            conditionFilter.addEventListener('change', renderDashboard);

            // Modal Events
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            patientForm.addEventListener('submit', handleFormSubmit);

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // Toggle custom country code
            countryCodeSelect.addEventListener('change', (e) => {
                if (e.target.value === 'other') {
                    customCountryCodeContainer.classList.remove('hidden');
                    customCountryCodeInput.setAttribute('required', 'required');
                    patPhoneField.placeholder = "Phone Number";
                } else {
                    customCountryCodeContainer.classList.add('hidden');
                    customCountryCodeInput.removeAttribute('required');
                    customCountryCodeInput.value = '';

                    if (e.target.value === '+91') {
                        patPhoneField.placeholder = "e.g. 98765 43210";
                    } else if (e.target.value === '+1') {
                        patPhoneField.placeholder = "e.g. (555) 019-2811";
                    } else {
                        patPhoneField.placeholder = "Phone Number";
                    }
                }
            });
        });

        // Load Patients & Doctors from MySQL Database
        async function loadPatientsAndDoctorsFromDb() {
            try {
                // Fetch doctors for dropdown
                const docRes = await fetch('api.php?action=get_doctors');
                const docData = await docRes.json();
                if (docData && docData.status === 'success' && docData.data && docData.data.length > 0) {
                    patDocSelect.innerHTML = '<option value="" disabled selected>Choose Doctor</option>';
                    docData.data.forEach(doc => {
                        const opt = document.createElement('option');
                        opt.value = doc.name;
                        opt.textContent = doc.name + ' (' + (doc.specialty || doc.department) + ')';
                        patDocSelect.appendChild(opt);
                    });
                } else {
                    populateDoctorsDropdown();
                }

                // Fetch patients
                const patRes = await fetch('api.php?action=get_patients');
                const patData = await patRes.json();
                if (patData && patData.status === 'success' && patData.data && patData.data.length > 0) {
                    patients = patData.data.map(p => ({
                        id: parseInt(p.id),
                        name: p.name,
                        disease: p.disease || 'General Diagnosis',
                        doctor: p.doctor_assigned || 'Dr. Raj Patel',
                        condition: p.status === 'Discharged' ? 'Stable' : (p.status || 'Stable'),
                        phone: p.phone || '+91 98711 22334',
                        room: p.address || 'Room 204, Ward B'
                    }));
                }
            } catch (err) {
                console.warn('Using local fallback for patient list:', err);
                populateDoctorsDropdown();
            }
            renderDashboard();
        }

        // Populate Assigned Doctor options from localStorage
        function populateDoctorsDropdown() {
            const defaultDoctors = [
                { name: "Dr. Raj Patel" },
                { name: "Dr. Jane Smith" },
                { name: "Dr. Robert Chen" },
                { name: "Dr. Marcus Vance" }
            ];
            const doctorsList = JSON.parse(localStorage.getItem('doctors')) || defaultDoctors;

            patDocSelect.innerHTML = '<option value="" disabled selected>Choose Doctor</option>';
            doctorsList.forEach(doc => {
                const opt = document.createElement('option');
                opt.value = doc.name;
                opt.textContent = doc.name;
                patDocSelect.appendChild(opt);
            });
        }

        // Get initials for profile picture
        function getInitials(name) {
            const parts = name.split(" ");
            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return parts[0] ? parts[0][0].toUpperCase() : "?";
        }

        // Update statistics cards
        function updateStats() {
            totalPatientsEl.textContent = patients.length;
            stablePatientsEl.textContent = patients.filter(p => p.condition === 'Stable').length;
            seriousPatientsEl.textContent = patients.filter(p => p.condition === 'Serious' || p.condition === 'Admitted').length;
            criticalPatientsEl.textContent = patients.filter(p => p.condition === 'Critical').length;
        }

        // Render patient table list
        function renderDashboard() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const condVal = conditionFilter.value;

            const filteredPatients = patients.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(searchTerm) ||
                    p.disease.toLowerCase().includes(searchTerm) ||
                    (p.doctor && p.doctor.toLowerCase().includes(searchTerm));

                const matchesCondition = condVal === 'all' || p.condition === condVal;
                return matchesSearch && matchesCondition;
            });

            tableBody.innerHTML = '';

            if (filteredPatients.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: #64748b; padding: 2rem;">No patients found.</td></tr>`;
            } else {
                filteredPatients.forEach(p => {
                    const initials = getInitials(p.name);
                    let badgeClass = 'badge-stable';
                    if (p.condition === 'Serious' || p.condition === 'Admitted') badgeClass = 'badge-serious';
                    if (p.condition === 'Critical') badgeClass = 'badge-critical';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="patient-profile">
                                <div class="patient-avatar-placeholder">${initials}</div>
                                <div class="patient-details">
                                    <h4>${p.name}</h4>
                                    <p>ID: #${p.id}</p>
                                </div>
                            </div>
                        </td>
                        <td>${p.disease}</td>
                        <td><b>${p.doctor || 'Unassigned'}</b></td>
                        <td><span class="badge ${badgeClass}">${p.condition}</span></td>
                        <td>${p.phone}</td>
                        <td>${p.room}</td>
                        <td>
                            <button onclick="editPatient(${p.id})" class="action-btn btn-edit" title="Edit Patient Details">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="deletePatient(${p.id})" class="action-btn btn-delete" title="Remove Patient Record">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });
            }

            updateStats();
            saveToLocalStorage();
        }

        // Open Form Modal
        function openModal(pat = null) {
            modal.style.display = 'flex';

            if (pat) {
                modalTitle.textContent = "Edit Patient Details";
                patIdField.value = pat.id;
                patNameField.value = pat.name;
                patDiseaseField.value = pat.disease;
                patDocField.value = pat.doctor;
                patConditionField.value = pat.condition;
                patRoomField.value = pat.room;

                // Parse country code and phone number for splitting
                let fullPhone = pat.phone || "";
                let code = "+91";
                let num = fullPhone;

                const standardPrefixes = ["+91", "+1", "+44", "+61"];
                const matchedPrefix = standardPrefixes.find(pref => fullPhone.startsWith(pref));

                if (matchedPrefix) {
                    code = matchedPrefix;
                    num = fullPhone.substring(matchedPrefix.length).trim();
                    countryCodeSelect.value = code;
                    customCountryCodeContainer.classList.add('hidden');
                    customCountryCodeInput.removeAttribute('required');
                } else if (fullPhone.startsWith("+")) {
                    const spaceIdx = fullPhone.indexOf(" ");
                    if (spaceIdx > 0) {
                        code = fullPhone.substring(0, spaceIdx);
                        num = fullPhone.substring(spaceIdx + 1);
                    }
                    countryCodeSelect.value = "other";
                    customCountryCodeContainer.classList.remove('hidden');
                    customCountryCodeInput.value = code;
                    customCountryCodeInput.setAttribute('required', 'required');
                } else {
                    countryCodeSelect.value = "+91";
                    customCountryCodeContainer.classList.add('hidden');
                    customCountryCodeInput.removeAttribute('required');
                }

                patPhoneField.value = num;
            } else {
                modalTitle.textContent = "Register New Patient";
                patientForm.reset();
                patIdField.value = '';
                countryCodeSelect.value = "+91";
                customCountryCodeContainer.classList.add('hidden');
                customCountryCodeInput.removeAttribute('required');
                patPhoneField.placeholder = "e.g. 98765 43210";
            }
        }

        // Close Modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Save Patient
        async function handleFormSubmit(e) {
            e.preventDefault();

            const idVal = patIdField.value;
            const nameVal = patNameField.value.trim();
            const diseaseVal = patDiseaseField.value.trim();
            const docVal = patDocField.value;
            const condVal = patConditionField.value;
            const phoneVal = patPhoneField.value.trim();
            const roomVal = patRoomField.value.trim();

            const codeVal = countryCodeSelect.value;
            const customCode = customCountryCodeInput.value.trim();
            const selectedCode = codeVal === 'other' ? customCode : codeVal;
            const fullPhone = `${selectedCode} ${phoneVal}`;

            if (!docVal) {
                alert("Please select an assigned doctor.");
                return;
            }

            // Save to MySQL via api.php
            let savedId = idVal ? parseInt(idVal) : 0;
            try {
                const response = await fetch('api.php?action=add_patient', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: savedId,
                        name: nameVal,
                        disease: diseaseVal,
                        doctor_assigned: docVal,
                        status: condVal,
                        phone: fullPhone,
                        address: roomVal
                    })
                });
                const res = await response.json();
                if (res && res.data && res.data.id) {
                    savedId = parseInt(res.data.id);
                }
            } catch (err) {
                console.warn('Database save error for patient:', err);
            }

            if (idVal) {
                // Edit
                patients = patients.map(p => {
                    if (p.id === parseInt(idVal)) {
                        return { ...p, name: nameVal, disease: diseaseVal, doctor: docVal, condition: condVal, phone: fullPhone, room: roomVal };
                    }
                    return p;
                });
            } else {
                // Create
                const newPatient = {
                    id: savedId || (Date.now() % 100000),
                    name: nameVal,
                    disease: diseaseVal,
                    doctor: docVal,
                    condition: condVal,
                    phone: fullPhone,
                    room: roomVal
                };
                patients.unshift(newPatient);
            }

            closeModal();
            renderDashboard();
        }

        // Select for editing
        function editPatient(id) {
            const pat = patients.find(p => p.id === id);
            if (pat) {
                openModal(pat);
            }
        }

        // Remove patient
        async function deletePatient(id) {
            if (confirm("Are you sure you want to discharge or delete this patient's record?")) {
                try {
                    await fetch('api.php?action=delete_patient', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                } catch (err) {
                    console.warn("Delete patient API error:", err);
                }
                patients = patients.filter(p => p.id !== id);
                renderDashboard();
            }
        }

        // Save to LocalStorage
        function saveToLocalStorage() {
            localStorage.setItem('patients', JSON.stringify(patients));
        }

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

        // Logout
        function logout() {
            if (confirm("Confirm session termination and return to login?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>

</html>
