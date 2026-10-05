<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management Dashboard</title>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS Variables & Reset */
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
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
        }

        /* Dashboard Layout */
        .dashboard-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2rem;
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

        /* Main Content Styling */
        .main-content {
            width: 100%;
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
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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

        /* Stats Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .stat-info p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Filter Controls */
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
            background: #fff;
        }

        /* Table Area */
        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            overflow-x: auto;
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

        /* Table Rows details */
        .doctor-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .doctor-avatar-placeholder {
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

        .doctor-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .doctor-details p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Badges */
        .badge {
            padding: 0.25rem 0.6rem;
            border-radius: 50px;
            font-size: 0.75rem;
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

        /* Action Buttons */
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            padding: 0.3rem;
            border-radius: 4px;
            transition: background 0.2s ease;
        }

        .btn-edit { color: var(--primary-color); }
        .btn-edit:hover { background-color: #e0e7ff; }
        .btn-delete { color: var(--danger); }
        .btn-delete:hover { background-color: #fee2e2; }

        /* Patients Column Pill and Badges */
        .patients-pill {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--success);
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .patients-pill:hover {
            background-color: #d1fae5;
            border-color: #34d399;
        }
        /* Patient Badges in Modal */
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

        /* Modal Styling */
        .modal {
            display: none; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: fadeIn 0.25s ease;
        }

        @keyframes fadeIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .close-btn {
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .close-btn:hover {
            color: var(--text-dark);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 0.65rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary-color);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.8rem;
            margin-top: 1.5rem;
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

        @media(max-width: 768px) {
            .main-content {
                padding: 1rem;
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
        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Header -->
            <header class="main-header">
                <div class="header-title">
                    <h1>Doctor Directory</h1>
                    <p>Manage clinic specialists and availability</p>
                </div>
                <a href="add_doctor.php" id="addDoctorBtn" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add Doctor
                </a>
            </header>

            <!-- Stats Widgets -->
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-user-md"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="totalDoctors">0</h3>
                        <p>Total Doctors</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="activeDoctors">0</h3>
                        <p>Active Now</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-orange">
                        <i class="fa-solid fa-plane-departure"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="onLeaveDoctors">0</h3>
                        <p>On Leave</p>
                    </div>
                </div>
            </section>

            <!-- Search and Filter Bar -->
            <section class="control-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or specialization...">
                </div>
                <div class="filter-box">
                    <select id="statusFilter">
                        <option value="all">All Statuses</option>
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                    </select>
                </div>
            </section>

            <!-- Table Section -->
            <section class="table-container">
                <table id="doctorsTable">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Contact</th>
                            <th>Patients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="doctorsTableBody">
                        <!-- Dynamic rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Add Doctor Modal -->
    <div id="doctorModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Doctor</h2>
                <span class="close-btn" id="closeModalBtn">&times;</span>
            </div>
            <form id="doctorForm">
                <input type="hidden" id="doctorId">
                
                <div class="form-group">
                    <label for="docName">Full Name</label>
                    <input type="text" id="docName" required placeholder="e.g., Dr. Elizabeth Blackwell">
                </div>

                <div class="form-group">
                    <label for="docSpec">Specialization</label>
                    <input type="text" id="docSpec" required placeholder="e.g., Cardiology">
                </div>

                <div class="form-group">
                    <label for="docEmail">Email Address</label>
                    <input type="email" id="docEmail" required placeholder="e.g., dr.blackwell@hospital.com">
                </div>

                <div class="form-group">
                    <label for="docStatus">Status</label>
                    <select id="docStatus">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" id="cancelBtn" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Doctor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Patients Modal -->
    <div id="patientsModal" class="modal">
        <div class="modal-content" style="max-width: 550px;">
            <div class="modal-header">
                <h2 id="patientsModalTitle">Assigned Patients</h2>
                <span class="close-btn" id="closePatientsModalBtn">&times;</span>
            </div>
            <div class="modal-body" style="padding: 1rem 0;">
                <div id="patientsListContainer" style="max-height: 350px; overflow-y: auto; padding: 0 1rem;">
                    <!-- Patient list will be loaded here -->
                </div>
            </div>
            <div class="form-actions" style="padding: 1rem 0 0; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <a href="patientmanagement.php" class="btn btn-primary" style="text-decoration: none; font-size: 0.85rem;">
                    <i class="fa-solid fa-user-injured"></i> Manage Patients
                </a>
                <button type="button" id="closePatientsBtn" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Initial Standard Doctors Data matching DB
        const defaultDoctors = [
            { id: 1, name: "Dr. Raj Patel", specialization: "Cardiology", email: "raj.patel@medigo.com", status: "Active", phone: "+91 98234 11223", experience: "12+ Years" },
            { id: 2, name: "Dr. Jane Smith", specialization: "Neurology", email: "jane.smith@medigo.com", status: "Active", phone: "+91 98456 33445", experience: "15+ Years" },
            { id: 3, name: "Dr. Robert Chen", specialization: "Pediatrics", email: "robert.chen@medigo.com", status: "Active", phone: "+91 98112 55667", experience: "8+ Years" },
            { id: 4, name: "Dr. Marcus Vance", specialization: "Emergency Medicine", email: "marcus.v@medigo.com", status: "Active", phone: "+91 98776 99887", experience: "10+ Years" }
        ];

        // Standard Patients matching DB
        const defaultPatients = [
            { id: 101, name: "Arjun Sharma", disease: "Hypertension", condition: "Stable", phone: "+91 98711 22334", doctor: "Dr. Raj Patel", room: "Room 204, Ward B" },
            { id: 102, name: "Priya Verma", disease: "Migraine", condition: "Serious", phone: "+91 98622 33445", doctor: "Dr. Jane Smith", room: "Room 105, Ward A" },
            { id: 103, name: "Rohan Gupta", disease: "Seasonal Flu", condition: "Stable", phone: "+91 98533 44556", doctor: "Dr. Robert Chen", room: "Room 302, Pediatrics" }
        ];

        // Clean obsolete mock data from localStorage if present
        if (localStorage.getItem('doctors') && localStorage.getItem('doctors').includes('Dr. Smit Prajapati')) {
            localStorage.removeItem('doctors');
            localStorage.removeItem('patients');
        }

        // Initialize doctors state from local storage or use standard defaults
        let doctors = JSON.parse(localStorage.getItem('doctors')) || defaultDoctors;

        // DOM Selectors
        const tableBody = document.getElementById('doctorsTableBody');
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const modal = document.getElementById('doctorModal');
        const addDoctorBtn = document.getElementById('addDoctorBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const doctorForm = document.getElementById('doctorForm');
        const modalTitle = document.getElementById('modalTitle');

        // Patients Modal DOM Selectors
        const patientsModal = document.getElementById('patientsModal');
        const closePatientsModalBtn = document.getElementById('closePatientsModalBtn');
        const closePatientsBtn = document.getElementById('closePatientsBtn');
        const patientsListContainer = document.getElementById('patientsListContainer');
        const patientsModalTitle = document.getElementById('patientsModalTitle');

        // Fields in Modal Form
        const docIdField = document.getElementById('doctorId');
        const docNameField = document.getElementById('docName');
        const docSpecField = document.getElementById('docSpec');
        const docEmailField = document.getElementById('docEmail');
        const docStatusField = document.getElementById('docStatus');

        // Stats Counters
        const totalDocsEl = document.getElementById('totalDoctors');
        const activeDocsEl = document.getElementById('activeDoctors');
        const leaveDocsEl = document.getElementById('onLeaveDoctors');

        // Run initialization
        document.addEventListener('DOMContentLoaded', () => {
            loadDoctorsFromDb();
            
            // Search and Filter Listeners
            searchInput.addEventListener('input', renderDashboard);
            statusFilter.addEventListener('change', renderDashboard);

            // Modal Action Listeners
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            doctorForm.addEventListener('submit', handleFormSubmit);

            // Patients Modal Action Listeners
            closePatientsModalBtn.addEventListener('click', closePatientsModal);
            closePatientsBtn.addEventListener('click', closePatientsModal);

            // Close modal when clicking outside of it
            window.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
                if (e.target === patientsModal) closePatientsModal();
            });
        });

        // Load doctors from MySQL database
        async function loadDoctorsFromDb() {
            try {
                const response = await fetch('api.php?action=get_doctors');
                const res = await response.json();
                if (res && res.status === 'success' && res.data && res.data.length > 0) {
                    doctors = res.data.map(d => ({
                        id: parseInt(d.id),
                        name: d.name,
                        specialization: d.specialty || d.department,
                        email: d.email || '',
                        phone: d.phone || '',
                        status: d.status === 'Available' ? 'Active' : (d.status || 'Active')
                    }));
                }
            } catch (err) {
                console.warn('Using local fallback for doctors list:', err);
            }
            renderDashboard();
        }

        // Close Patients Modal
        function closePatientsModal() {
            patientsModal.style.display = 'none';
        }

        // Update Statistics Cards
        function updateStats() {
            totalDocsEl.textContent = doctors.length;
            activeDocsEl.textContent = doctors.filter(doc => doc.status === 'Active' || doc.status === 'Available').length;
            leaveDocsEl.textContent = doctors.filter(doc => doc.status === 'On Leave').length;
        }

        // Generate the Avatar Initials (e.g. Dr. Jane Smith -> JS)
        function getInitials(name) {
            const cleanName = name.replace("Dr. ", "");
            const parts = cleanName.split(" ");
            if (parts.length >= 2) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return parts[0] ? parts[0][0].toUpperCase() : "?";
        }

        // Render Table List and Update Dashboard Info
        function renderDashboard() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusVal = statusFilter.value;

            // Filter logic
            const filteredDoctors = doctors.filter(doc => {
                const matchesSearch = doc.name.toLowerCase().includes(searchTerm) || 
                                      doc.specialization.toLowerCase().includes(searchTerm);
                
                const matchesStatus = statusVal === 'all' || doc.status === statusVal;

                return matchesSearch && matchesStatus;
            });

            // Populate data to HTML structure
            tableBody.innerHTML = '';
            
            const patientList = JSON.parse(localStorage.getItem('patients')) || defaultPatients;

            if (filteredDoctors.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: #64748b;">No doctors found matching your query.</td></tr>`;
            } else {
                filteredDoctors.forEach(doc => {
                    const initials = getInitials(doc.name);
                    const statusClass = (doc.status === 'Active' || doc.status === 'Available') ? 'badge-active' : 'badge-leave';
                    const doctorPatientsCount = patientList.filter(p => p.doctor === doc.name).length;
                    
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="doctor-profile">
                                <div class="doctor-avatar-placeholder">${initials}</div>
                                <div class="doctor-details">
                                    <h4>${doc.name}</h4>
                                    <p>ID: #${doc.id}</p>
                                </div>
                            </div>
                        </td>
                        <td>${doc.specialization}</td>
                        <td>
                            <div>${doc.email}</div>
                            ${doc.phone ? `<div style="font-size: 11px; color: #64748b; margin-top: 3px;"><i class="fa-solid fa-phone" style="font-size: 10px; margin-right: 4px; color: #0048ff;"></i>${doc.phone}</div>` : ''}
                        </td>
                        <td>
                            <div onclick="viewPatients('${doc.name.replace(/'/g, "\\'")}')" class="patients-pill" title="Click to view patient list">
                                <i class="fa-solid fa-user-injured"></i>
                                <span>${doctorPatientsCount} ${doctorPatientsCount === 1 ? 'Patient' : 'Patients'}</span>
                            </div>
                        </td>
                        <td><span class="badge ${statusClass}">${doc.status}</span></td>
                        <td>
                            <button onclick="editDoctor(${doc.id})" class="action-btn btn-edit" title="Edit Doctor Details">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="deleteDoctor(${doc.id})" class="action-btn btn-delete" title="Delete Doctor Record">
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

        // Redirect to Patient History Page for the specific doctor
        function viewPatients(doctorName) {
            window.location.href = `patient_history.php?doctor=${encodeURIComponent(doctorName)}`;
        }

        // Open Form Modal (Serves both Add and Edit actions)
        function openModal(doc = null) {
            modal.style.display = 'flex';
            if (doc) {
                modalTitle.textContent = "Edit Doctor Details";
                docIdField.value = doc.id;
                docNameField.value = doc.name;
                docSpecField.value = doc.specialization;
                docEmailField.value = doc.email;
                docStatusField.value = doc.status;
            } else {
                modalTitle.textContent = "Add New Doctor";
                doctorForm.reset();
                docIdField.value = '';
            }
        }

        // Close Modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Handle Form Submissions (Create and Update operations)
        async function handleFormSubmit(e) {
            e.preventDefault();
            
            const idVal = docIdField.value;
            const nameVal = docNameField.value.trim();
            const specVal = docSpecField.value.trim();
            const emailVal = docEmailField.value.trim();
            const statusVal = docStatusField.value;

            // Save to MySQL database via api.php
            try {
                const response = await fetch('api.php?action=add_doctor', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: idVal ? parseInt(idVal) : 0,
                        name: nameVal,
                        specialty: specVal,
                        department: specVal,
                        email: emailVal,
                        status: statusVal
                    })
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    // Refresh data directly from DB
                    await loadDoctorsFromDb();
                }
            } catch (err) {
                console.warn('Database save error:', err);
            }

            closeModal();
        }

        // Select Doctor for Editing
        function editDoctor(id) {
            const selectedDoc = doctors.find(doc => doc.id === id);
            if (selectedDoc) {
                openModal(selectedDoc);
            }
        }

        // Delete Doctor Record
        async function deleteDoctor(id) {
            if (confirm("Are you sure you want to remove this doctor record?")) {
                try {
                    await fetch('api.php?action=delete_doctor', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                    await loadDoctorsFromDb();
                } catch (err) {
                    console.warn('Database delete error:', err);
                }
            }
        }

        // Persistence Management
        function saveToLocalStorage() {
            localStorage.setItem('doctors', JSON.stringify(doctors));
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
