<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History - MediGo</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        /* Header / Banner Card for Doctor Details */
        .doctor-banner {
            background: linear-gradient(135deg, #ffffff, #f1f5f9);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .doctor-banner-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .doctor-large-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            border: 2px solid #cbd5e1;
        }

        .doctor-banner-details h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .doctor-banner-details .specialization {
            font-size: 1rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .doctor-contact-row {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .doctor-contact-row span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .doctor-contact-row i {
            color: var(--primary);
        }

        /* Badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-leave {
            background-color: #fee2e2;
            color: #991b1b;
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

        /* Stats Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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

        .icon-blue { background: #e0e7ff; color: #4f46e5; }
        .icon-green { background: #d1fae5; color: #10b981; }
        .icon-orange { background: #fef3c7; color: #d97706; }
        .icon-red { background: #fee2e2; color: #ef4444; }

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
            border-color: var(--primary-color);
        }

        .filter-box select {
            padding: 0.6rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            background: var(--white);
        }

        /* Table Area */
        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            overflow-x: auto;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            font-size: 0.95rem;
        }

        .patient-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e2e8f0;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .patient-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .patient-details p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background-color: #cbd5e1;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
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

        /* Modal and Timeline Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--white);
            border-radius: 16px;
            width: 95%;
            max-width: 1200px;
            height: 90vh;
            max-height: 90vh;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            animation: modalFadeIn 0.3s ease-out;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-light);
        }

        .close-btn {
            font-size: 1.8rem;
            font-weight: 700;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s ease;
            line-height: 1;
        }

        .close-btn:hover {
            color: var(--text-dark);
        }

        @keyframes modalFadeIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .timeline-node {
            position: relative;
            padding-bottom: 0.5rem;
        }

        .timeline-node::before {
            content: '';
            position: absolute;
            left: -29px;
            top: 6px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--white);
            border: 3px solid var(--primary);
            z-index: 2;
        }

        .timeline-date {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .timeline-card {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .timeline-card h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .timeline-card .clinician {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .timeline-card p {
            font-size: 0.85rem;
            color: var(--text-dark);
            line-height: 1.5;
            background-color: var(--bg-light);
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid var(--primary);
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
                    <a href="doctormanagement.php" class="active"><i class="fa-solid fa-user-md"></i> Doctor Management</a>
                    <a href="patientmanagement.php"><i class="fa-solid fa-user-injured"></i> Patient Management</a>
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

    <div class="dashboard-container">
        <!-- Back Button and Title -->
        <div class="btn-container">
            <a href="doctormanagement.php" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back to Doctor Directory
            </a>
        </div>

        <!-- Doctor Details Banner -->
        <div class="doctor-banner">
            <div class="doctor-banner-info">
                <div class="doctor-large-avatar" id="docAvatar">?</div>
                <div class="doctor-banner-details">
                    <h2 id="docName">Doctor Name</h2>
                    <div class="specialization" id="docSpecialization">Specialization</div>
                    <div class="doctor-contact-row">
                        <span><i class="fa-solid fa-envelope"></i> <span id="docEmail">email@medigo.com</span></span>
                        <span><i class="fa-solid fa-phone"></i> <span id="docPhone">Phone Number</span></span>
                    </div>
                </div>
            </div>
            <div>
                <span class="badge badge-active" id="docStatus">Active</span>
            </div>
        </div>

        <!-- Stats Grid for Patient breakdown -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-user-injured"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalPatients">0</h3>
                    <p>Assigned Patients</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-face-smile"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stablePatients">0</h3>
                    <p>Stable Patients</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-orange">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-info">
                    <h3 id="seriousPatients">0</h3>
                    <p>Serious Patients</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <div class="stat-info">
                    <h3 id="criticalPatients">0</h3>
                    <p>Critical Patients</p>
                </div>
            </div>
        </section>

        <!-- Search and Filter Bar -->
        <section class="control-bar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search patients by name or diagnosis...">
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

        <!-- Patients History Table -->
        <section class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Diagnosis / Disease</th>
                        <th>Condition</th>
                        <th>Room / Ward</th>
                        <th>Contact</th>
                        <th style="text-align: right; padding-right: 2.5rem;">Actions</th>
                    </tr>
                </thead>
                <tbody id="patientsTableBody">
                    <!-- Loaded dynamically -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Patient Medical History & Report Modal -->
    <div id="patientReportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-clipboard-user" style="color: var(--primary); font-size: 1.4rem;"></i>
                    <h2 id="reportModalTitle" style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark);">Patient Clinical File</h2>
                </div>
                <span class="close-btn" onclick="closeReportModal()">&times;</span>
            </div>
            
            <div class="modal-body" style="padding: 1.5rem; overflow-y: auto; flex: 1; display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Patient Summary Card inside modal -->
                <div style="background-color: var(--bg-light); border: 1px solid var(--border-color); padding: 1rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <h3 id="reportPatientName" style="font-weight: 700; font-size: 1.1rem; color: var(--text-dark);">Patient Name</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 2px;">Patient ID: <span id="reportPatientId" style="font-weight: 600;">#101</span></p>
                    </div>
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
                        <span style="font-size: 0.8rem; padding: 4px 12px; border-radius: 50px; background-color: #cbd5e1; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; color: var(--text-dark);">
                            <i class="fa-solid fa-bed" style="color: var(--primary);"></i> <span id="reportPatientRoom">Room</span>
                        </span>
                        <span id="reportPatientCondition" class="badge">Condition</span>
                    </div>
                </div>

                <!-- Section: Timeline of Past Appointments & Checkups -->
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                        <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Past Checkups & Consultation Timeline
                    </h4>
                    <div id="reportTimelineContainer" style="position: relative; border-left: 2px solid var(--border-color); margin-left: 20px; padding-left: 20px; display: flex; flex-direction: column; gap: 1.5rem; padding-top: 5px; padding-bottom: 5px;">
                        <!-- Timeline Nodes loaded dynamically -->
                    </div>
                </div>
            </div>

            <div class="form-actions" style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); background-color: var(--bg-light); display: flex; justify-content: flex-end;">
                <button type="button" onclick="closeReportModal()" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Close Clinical File</button>
            </div>
        </div>
    </div>

    <script>
        // Standard Doctors matching DB
        const defaultDoctors = [
            { id: 1, name: "Dr. Raj Patel", specialization: "Cardiology", email: "raj.patel@medigo.com", status: "Active", phone: "+91 98234 11223" },
            { id: 2, name: "Dr. Jane Smith", specialization: "Neurology", email: "jane.smith@medigo.com", status: "Active", phone: "+91 98456 33445" },
            { id: 3, name: "Dr. Robert Chen", specialization: "Pediatrics", email: "robert.chen@medigo.com", status: "Active", phone: "+91 98112 55667" },
            { id: 4, name: "Dr. Marcus Vance", specialization: "Emergency Medicine", email: "marcus.v@medigo.com", status: "Active", phone: "+91 98776 99887" }
        ];

        // Standard Patients matching DB
        const defaultPatients = [
            { id: 101, name: "Arjun Sharma", disease: "Hypertension", condition: "Stable", phone: "+91 98711 22334", doctor: "Dr. Raj Patel", room: "Room 204, Ward B" },
            { id: 102, name: "Priya Verma", disease: "Migraine", condition: "Serious", phone: "+91 98622 33445", doctor: "Dr. Jane Smith", room: "Room 105, Ward A" },
            { id: 103, name: "Rohan Gupta", disease: "Seasonal Flu", condition: "Stable", phone: "+91 98533 44556", doctor: "Dr. Robert Chen", room: "Room 302, Pediatrics" }
        ];

        // Retrieve URL Parameter
        const urlParams = new URLSearchParams(window.location.search);
        const doctorName = urlParams.get('doctor');

        // Dynamic State Lists
        let doctors = JSON.parse(localStorage.getItem('doctors')) || defaultDoctors;
        let patients = JSON.parse(localStorage.getItem('patients')) || defaultPatients;

        // DOM Elements
        const docAvatar = document.getElementById('docAvatar');
        const docNameEl = document.getElementById('docName');
        const docSpecEl = document.getElementById('docSpecialization');
        const docEmailEl = document.getElementById('docEmail');
        const docPhoneEl = document.getElementById('docPhone');
        const docStatusEl = document.getElementById('docStatus');

        const totalPatientsEl = document.getElementById('totalPatients');
        const stablePatientsEl = document.getElementById('stablePatients');
        const seriousPatientsEl = document.getElementById('seriousPatients');
        const criticalPatientsEl = document.getElementById('criticalPatients');

        const patientsListContainer = document.getElementById('patientsListContainer');
        const patientSearchInput = document.getElementById('patientSearch');
        const conditionFilterSelect = document.getElementById('conditionFilter');

        // Current Selected Doctor
        let currentDoctor = null;

        // Initialize Page
        document.addEventListener('DOMContentLoaded', async () => {
            await loadHistoryDataFromDb();

            // Search and Filter Listeners
            patientSearchInput.addEventListener('input', renderAssignedPatients);
            conditionFilterSelect.addEventListener('change', renderAssignedPatients);
        });

        // Fetch Live Doctors and Patients from MySQL Database
        async function loadHistoryDataFromDb() {
            try {
                const [docRes, patRes] = await Promise.all([
                    fetch('api.php?action=get_doctors').then(r => r.json()),
                    fetch('api.php?action=get_patients').then(r => r.json())
                ]);

                if (docRes && docRes.status === 'success' && docRes.data && docRes.data.length > 0) {
                    doctors = docRes.data.map(d => ({
                        id: parseInt(d.id),
                        name: d.name,
                        specialization: d.specialty || d.department,
                        email: d.email || '',
                        phone: d.phone || '',
                        status: d.status || 'Active'
                    }));
                }

                if (patRes && patRes.status === 'success' && patRes.data && patRes.data.length > 0) {
                    patients = patRes.data.map(p => ({
                        id: parseInt(p.id),
                        patient_id: p.patient_id || ('PAT-' + p.id),
                        name: p.name,
                        disease: p.disease || 'Evaluation',
                        condition: p.status === 'Discharged' ? 'Stable' : 'Admitted',
                        phone: p.phone || '',
                        doctor: p.doctor_assigned || '',
                        room: p.address || 'Ward B'
                    }));
                }
            } catch (err) {
                console.warn('Using local fallback in patient history:', err);
            }

            initDoctorProfile();
            renderAssignedPatients();
        }

        // Initialize doctor profile details based on parameter or default
        function initDoctorProfile() {
            if (doctorName) {
                currentDoctor = doctors.find(d => d.name.toLowerCase() === doctorName.toLowerCase());
            }

            // Fallback to the first available doctor
            if (!currentDoctor && doctors.length > 0) {
                currentDoctor = doctors[0];
            }

            if (currentDoctor) {
                docNameEl.textContent = currentDoctor.name;
                docSpecEl.textContent = currentDoctor.specialization;
                docEmailEl.textContent = currentDoctor.email;
                docPhoneEl.textContent = currentDoctor.phone;

                // Status Badge Color Handling
                docStatusEl.textContent = currentDoctor.status;
                docStatusEl.className = 'badge ' + (currentDoctor.status === 'Active' || currentDoctor.status === 'Available' ? 'badge-active' : 'badge-leave');

                // Initials
                docAvatar.textContent = getInitials(currentDoctor.name);
            }
        }

        // Generate Profile Initials
        function getInitials(name) {
            const cleanName = name.replace("Dr. ", "");
            const parts = cleanName.split(" ");
            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return parts[0] ? parts[0][0].toUpperCase() : "DR";
        }

        // Render Assigned Patients Table List
        function renderAssignedPatients() {
            if (!currentDoctor) return;

            const searchTerm = patientSearchInput.value.toLowerCase().trim();
            const selectedCondition = conditionFilterSelect.value;

            // Filter patients by matching assigned doctor
            const assignedPatients = patients.filter(p => {
                const isAssigned = p.doctor && p.doctor.toLowerCase().includes(currentDoctor.name.toLowerCase());
                const matchesSearch = p.name.toLowerCase().includes(searchTerm) || p.disease.toLowerCase().includes(searchTerm);
                const matchesCondition = selectedCondition === 'all' || p.condition.toLowerCase() === selectedCondition.toLowerCase();

                return isAssigned && matchesSearch && matchesCondition;
            });

            // Update stats counter cards for this specific doctor
            const allDoctorPatients = patients.filter(p => p.doctor && p.doctor.toLowerCase().includes(currentDoctor.name.toLowerCase()));
            totalPatientsEl.textContent = allDoctorPatients.length;
            stablePatientsEl.textContent = allDoctorPatients.filter(p => p.condition === 'Stable').length;
            seriousPatientsEl.textContent = allDoctorPatients.filter(p => p.condition === 'Serious').length;
            criticalPatientsEl.textContent = allDoctorPatients.filter(p => p.condition === 'Critical').length;

            patientsListContainer.innerHTML = '';

            if (assignedPatients.length === 0) {
                patientsListContainer.innerHTML = `<tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No patients currently assigned to ${currentDoctor.name} matching criteria.</td></tr>`;
                return;
            }

            assignedPatients.forEach(p => {
                const tr = document.createElement('tr');
                const initials = getInitials(p.name);
                let badgeClass = 'badge-stable';
                if (p.condition === 'Serious') badgeClass = 'badge-serious';
                if (p.condition === 'Critical') badgeClass = 'badge-critical';

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
                    <td><b>${p.disease}</b></td>
                    <td><span class="badge ${badgeClass}">${p.condition}</span></td>
                    <td>${p.phone}</td>
                    <td>${p.room}</td>
                    <td>
                        <button onclick="viewPatientTimeline(${p.id}, '${p.name.replace(/'/g, "\\'")}', '${p.disease.replace(/'/g, "\\'")}', '${p.condition}', '${p.room.replace(/'/g, "\\'")}')" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem; font-weight: 600; border-radius: 6px; background-color: var(--primary); cursor: pointer;" title="View Medical History & Checkup Timeline">
                            <i class="fa-solid fa-notes-medical"></i> Medical Records
                        </button>
                    </td>
                `;
                patientsListContainer.appendChild(tr);
            });
        }

        // Mock Database of past checkups & timeline reports
        const defaultPatientReports = {
            101: [
                {
                    date: "2026-06-10",
                    title: "Follow-up Checkup: Blood Pressure Stabilization",
                    clinician: "Dr. Raj Patel",
                    category: "consultation",
                    badgeClass: "badge-stable",
                    details: "Patient returned for a follow-up assessment of hypertension. Resting blood pressure measured at 122/80 mmHg, indicating excellent therapeutic response to Telmisartan 40mg. ECG confirmed sinus rhythm with no ischemia. Instructed to maintain low-sodium diet and routine morning walks."
                },
                {
                    date: "2026-06-07",
                    title: "Initial Checkup: Primary Hypertension Assessment",
                    clinician: "Dr. Raj Patel",
                    category: "consultation",
                    badgeClass: "badge-serious",
                    details: "Patient presented with recurring morning headaches, occasional dizziness, and elevated home BP readings averaging 155/95 mmHg. Baseline lipid profile and kidney function panel ordered. Started on daily Telmisartan with weekly monitoring."
                }
            ],
            102: [
                {
                    date: "2026-06-12",
                    title: "Neurology Review: Migraine Prophylaxis",
                    clinician: "Dr. Jane Smith",
                    category: "consultation",
                    badgeClass: "badge-serious",
                    details: "Follow-up consultation for refractory migraine with visual aura. Patient reports a 60% reduction in headache episode frequency following initiation of prophylactic therapy. Advised trigger diary maintenance and hydration."
                },
                {
                    date: "2026-06-05",
                    title: "Emergency Neurology Consultation",
                    clinician: "Dr. Jane Smith",
                    category: "consultation",
                    badgeClass: "badge-critical",
                    details: "Patient presented to emergency outpatient wing with severe unilateral throbbing headache accompanied by photophobia and nausea. Brain MRI without contrast performed, showing normal intracranial morphology without acute vascular insult."
                }
            ],
            103: [
                {
                    date: "2026-06-11",
                    title: "Pediatric Follow-up: Viral Recovery",
                    clinician: "Dr. Robert Chen",
                    category: "consultation",
                    badgeClass: "badge-stable",
                    details: "Post-illness assessment for seasonal flu. Body temperature normal (98.4°F) for 72 hours. Appetite fully restored, lung fields clear bilaterally. Cleared for school resumption."
                },
                {
                    date: "2026-06-08",
                    title: "Initial Pediatric Consultation",
                    clinician: "Dr. Robert Chen",
                    category: "consultation",
                    badgeClass: "badge-serious",
                    details: "Patient presented with fever of 101.8°F, rhinorrhea, dry cough, and lethargy for 2 days. Rapid flu test positive for Influenza A. Prescribed supportive antipyretic therapy, hydration, and rest."
                }
            ]
        };

        // Detailed Patient Medical History Modal implementation
        const reportModal = document.getElementById('patientReportModal');
        const reportPatientName = document.getElementById('reportPatientName');
        const reportPatientId = document.getElementById('reportPatientId');
        const reportPatientRoom = document.getElementById('reportPatientRoom');
        const reportPatientCondition = document.getElementById('reportPatientCondition');
        const reportTimelineContainer = document.getElementById('reportTimelineContainer');

        function viewReport(patientId, patientName, patientDisease, patientCondition, patientRoom) {
            reportPatientName.textContent = patientName;
            reportPatientId.textContent = `#${patientId}`;
            reportPatientRoom.textContent = patientRoom;
            
            // Set condition badge
            reportPatientCondition.textContent = patientCondition;
            let badgeClass = 'badge-stable';
            if (patientCondition === 'Serious') badgeClass = 'badge-serious';
            if (patientCondition === 'Critical') badgeClass = 'badge-critical';
            reportPatientCondition.className = `badge ${badgeClass}`;

            // Get reports list
            const patientLogs = getPatientReports(patientId, patientName, patientDisease);
            
            // Render Timeline nodes
            reportTimelineContainer.innerHTML = '';
            patientLogs.forEach(log => {
                const node = document.createElement('div');
                node.className = 'timeline-node';
                
                // Format checkup date
                const dateObj = new Date(log.date);
                const readableDate = dateObj.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                node.innerHTML = `
                    <div class="timeline-date"><i class="fa-regular fa-calendar-check" style="margin-right: 4px;"></i> ${readableDate}</div>
                    <div class="timeline-card">
                        <h5>${log.title}</h5>
                        <div class="clinician"><i class="fa-solid fa-user-doctor"></i> Clinician: ${log.clinician}</div>
                        <p>${log.details}</p>
                    </div>
                `;
                reportTimelineContainer.appendChild(node);
            });

            reportModal.style.display = 'flex';
        }

        function closeReportModal() {
            reportModal.style.display = 'none';
        }

        function getPatientReports(patientId, patientName, patientDisease) {
            let reportsDb = JSON.parse(localStorage.getItem('patient_reports')) || defaultPatientReports;
            if (reportsDb[patientId]) {
                return reportsDb[patientId];
            }
            
            // Generate standard initial timeline event for new patient
            const defaultEntry = [
                {
                    date: new Date().toISOString().split('T')[0],
                    title: `Admitted for Diagnosis & Checkup: ${patientDisease}`,
                    clinician: doctorInfo.name,
                    category: "consultation",
                    badgeClass: "badge-stable",
                    details: `Patient registered and admitted under active medical evaluation for ${patientDisease}. Vital signs are monitored daily and remain stable.`
                }
            ];
            reportsDb[patientId] = defaultEntry;
            localStorage.setItem('patient_reports', JSON.stringify(reportsDb));
            return defaultEntry;
        }

        // Close report modal when clicking outside of it or overlay
        window.addEventListener('click', (e) => {
            if (e.target === reportModal) closeReportModal();
        });

        // Click outside closes dropdown events
        window.addEventListener('click', function () {
            closeAllDropdowns();
        });

        // Simulated Logout
        function logout() {
            if (confirm("Confirm session termination and return to main screen?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>

</html>

