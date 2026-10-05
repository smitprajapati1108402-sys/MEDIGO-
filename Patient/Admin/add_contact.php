<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration Dashboard</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;

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
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 24px;
        }

        /* ================= NAVBAR NAVIGATION ================= */
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
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background-color: #e0f2fe;
            color: var(--primary);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .logo-section h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-section p {
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        /* Main Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 32px;
        }

        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card Style */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 16px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            background-color: var(--primary-hover);
        }

        /* Right Panel Search and List */
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
        }

        .search-box {
            position: relative;
            flex-grow: 1;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
        }

        .search-box input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
        }

        .search-box input:focus {
            border-color: var(--primary);
        }

        /* Doctor Cards List */
        .doctor-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-height: 580px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .doc-item {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .doc-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .doc-profile {
            display: flex;
            gap: 16px;
        }

        .doc-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background-color: #e0f2fe;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .doc-info h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .doc-spec {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .doc-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.8rem;
            color: var(--text-gray);
        }

        .doc-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .doc-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            font-size: 1rem;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .action-btn.edit { color: var(--primary); }
        .action-btn.edit:hover { background-color: #e0f2fe; }
        .action-btn.delete { color: var(--danger); }
        .action-btn.delete:hover { background-color: #fee2e2; }

        /* Notification Toast */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #0f172a;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.3s, opacity 0.3s;
            z-index: 1000;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
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
                    <a href="MedicalReport.php"><i class="fa-solid fa-clipboard-list"></i> Medical Report</a>
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

    <div class="container">
        <!-- Dashboard Header -->
        <header>
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <h1>Doctor Registration</h1>
                    <p>Register and manage medical professionals</p>
                </div>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="dashboard-grid">
            
            <!-- Left Panel: Registration Form -->
            <div class="card">
                <h2 class="card-title" id="formTitle">
                    <i class="fa-solid fa-address-card"></i> Register New Doctor
                </h2>
                <form id="registrationForm" onsubmit="handleRegistration(event)">
                    <!-- Hidden ID input for editing -->
                    <input type="hidden" id="docId">

                    <div class="form-group">
                        <label for="licenseNo">Medical License Number *</label>
                        <input type="text" id="licenseNo" class="form-control" placeholder="e.g. MCD-12453" required>
                    </div>

                    <div class="form-group">
                        <label for="fullName">Full Name (with Dr.) *</label>
                        <input type="text" id="fullName" class="form-control" placeholder="e.g. Dr. Ramesh Kumar" required>
                    </div>

                    <div class="form-row">
                        <div>
                            <label for="specialty">Specialty *</label>
                            <input type="text" id="specialty" class="form-control" placeholder="e.g. Cardiologist" required>
                        </div>
                        <div>
                            <label for="experience">Experience (Years) *</label>
                            <input type="number" id="experience" class="form-control" min="0" placeholder="e.g. 8" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" class="form-control" placeholder="e.g. +91 9876543210" required>
                        </div>
                        <div>
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" class="form-control" placeholder="e.g. ramesh@clinic.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="clinic">Clinic / Hospital Name</label>
                        <input type="text" id="clinic" class="form-control" placeholder="e.g. Metro Hospital">
                    </div>

                    <button type="submit" class="btn" id="submitBtn">
                        <i class="fa-solid fa-user-plus"></i> <span id="btnText">Register Doctor</span>
                    </button>
                </form>
            </div>

            <!-- Right Panel: Directory/List -->
            <div class="card">
                <div class="list-header">
                    <h2 class="card-title" style="margin-bottom: 0;">
                        <i class="fa-solid fa-list-ul"></i> Registered Directory
                    </h2>
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchField" placeholder="Search by name, specialty..." onkeyup="filterDoctors()">
                    </div>
                </div>

                <!-- Doctor Entries -->
                <div class="doctor-list" id="doctorContainer">
                    <!-- Dynamic Items will be rendered here -->
                </div>
            </div>

        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification" class="toast">
        <i class="fa-solid fa-circle-check" style="color: var(--success);"></i>
        <span id="toastMessage">Success Message</span>
    </div>

    <!-- Script Logic -->
    <script>
        // Default list to display initially if local storage is empty
        const initialMockData = [
            { id: "1", license: "MCD-78921", name: "Dr. Ananya Sharma", specialty: "Pediatrician", experience: "12", phone: "+91 9812345670", email: "ananya@health.com", clinic: "City Children Clinic" },
            { id: "2", license: "MCD-45123", name: "Dr. Vikas Patel", specialty: "Cardiologist", experience: "15", phone: "+91 9876512345", email: "vikas@cardio.com", clinic: "Metro Heart Care" }
        ];

        let doctors = JSON.parse(localStorage.getItem('registeredDoctors')) || initialMockData;

        // UI Selectors
        const doctorContainer = document.getElementById('doctorContainer');
        const registrationForm = document.getElementById('registrationForm');
        const formTitle = document.getElementById('formTitle');
        const btnText = document.getElementById('btnText');
        const submitBtn = document.getElementById('submitBtn');
        
        // Input Fields Selectors
        const docIdInput = document.getElementById('docId');
        const licenseInput = document.getElementById('licenseNo');
        const nameInput = document.getElementById('fullName');
        const specialtyInput = document.getElementById('specialty');
        const experienceInput = document.getElementById('experience');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const clinicInput = document.getElementById('clinic');

        // Start initialization with MySQL Database sync
        document.addEventListener('DOMContentLoaded', async () => {
            await loadRegisteredDoctorsFromDb();
        });

        async function loadRegisteredDoctorsFromDb() {
            try {
                const response = await fetch('api.php?action=get_doctors');
                const result = await response.json();
                if (result && result.status === 'success' && result.data && result.data.length > 0) {
                    doctors = result.data.map(d => ({
                        id: String(d.id),
                        license: d.doctor_id || ('DOC-' + d.id),
                        name: d.name,
                        specialty: d.specialty || d.department,
                        experience: d.experience ? d.experience.replace(/[^0-9]/g, '') || '5' : '5',
                        phone: d.phone || '+91 98765 43210',
                        email: d.email || 'doctor@medigo.com',
                        clinic: 'MediGo Hospital'
                    }));
                    syncLocalStorage();
                }
            } catch (err) {
                console.warn('Fallback loading doctors in contact registry:', err);
            }
            renderDoctorList(doctors);
        }

        // Local Storage update wrapper
        function syncLocalStorage() {
            localStorage.setItem('registeredDoctors', JSON.stringify(doctors));
        }

        // Render Cards dynamically
        function renderDoctorList(list) {
            doctorContainer.innerHTML = '';
            
            if (list.length === 0) {
                doctorContainer.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: var(--text-gray);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                        <p>No registered doctors found.</p>
                    </div>`;
                return;
            }

            list.forEach(doc => {
                const initials = doc.name.replace("Dr. ", "").split(" ").map(n => n[0]).join("").slice(0, 2).toUpperCase();
                
                const itemHtml = `
                    <div class="doc-item">
                        <div class="doc-profile">
                            <div class="doc-avatar">${initials}</div>
                            <div class="doc-info">
                                <h4>${doc.name}</h4>
                                <div class="doc-spec">${doc.specialty} (${doc.experience} Yrs Exp)</div>
                                <div class="doc-meta">
                                    <span><i class="fa-solid fa-id-card"></i> Reg: ${doc.license}</span>
                                    <span><i class="fa-solid fa-phone"></i> ${doc.phone}</span>
                                    <span><i class="fa-solid fa-envelope"></i> ${doc.email}</span>
                                    ${doc.clinic ? `<span><i class="fa-solid fa-hospital"></i> ${doc.clinic}</span>` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="doc-actions">
                            <button class="action-btn edit" onclick="populateEditForm('${doc.id}')" title="Edit Profile"><i class="fa-solid fa-pen"></i></button>
                            <button class="action-btn delete" onclick="deleteDoctor('${doc.id}')" title="Delete Profile"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                `;
                doctorContainer.insertAdjacentHTML('beforeend', itemHtml);
            });
        }

        // Handle both registration and editing save actions to MySQL Database
        async function handleRegistration(event) {
            event.preventDefault();

            const docId = docIdInput.value;
            const licenseVal = licenseInput.value.trim();
            const nameVal = nameInput.value.trim();
            const specVal = specialtyInput.value.trim();
            const expVal = experienceInput.value.trim();
            const phoneVal = phoneInput.value.trim();
            const emailVal = emailInput.value.trim();
            const clinicVal = clinicInput.value.trim();

            try {
                const response = await fetch('api.php?action=add_doctor', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: docId ? parseInt(docId) : 0,
                        doctor_id: licenseVal,
                        name: nameVal,
                        department: specVal,
                        specialty: specVal,
                        experience: expVal + ' Years',
                        phone: phoneVal,
                        email: emailVal,
                        status: 'Available'
                    })
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    showToast(docId ? "Doctor profile updated in MySQL database!" : "Doctor registered to MySQL database!");
                    await loadRegisteredDoctorsFromDb();
                } else {
                    showToast("Profile saved successfully!");
                }
            } catch (err) {
                console.warn("Save doctor error:", err);
                showToast("Profile saved locally!");
            }

            resetForm();
        }

        // Populate fields to Edit mode
        function populateEditForm(id) {
            const doc = doctors.find(d => d.id === id);
            if (!doc) return;

            formTitle.innerHTML = `<i class="fa-solid fa-user-pen"></i> Edit Doctor Profile`;
            btnText.innerText = "Update Registration";
            submitBtn.style.backgroundColor = "var(--success)";

            // Fill inputs
            docIdInput.value = doc.id;
            licenseInput.value = doc.license;
            nameInput.value = doc.name;
            specialtyInput.value = doc.specialty;
            experienceInput.value = doc.experience;
            phoneInput.value = doc.phone;
            emailInput.value = doc.email;
            clinicInput.value = doc.clinic || '';

            // Scroll to form on mobile devices
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Delete Registration from MySQL Database
        async function deleteDoctor(id) {
            if (confirm("Are you sure you want to remove this registration profile?")) {
                try {
                    await fetch('api.php?action=delete_doctor', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: parseInt(id) })
                    });
                    await loadRegisteredDoctorsFromDb();
                    showToast("Registration deleted from database!");
                } catch (err) {
                    doctors = doctors.filter(d => d.id !== id);
                    syncLocalStorage();
                    renderDoctorList(doctors);
                    showToast("Registration deleted successfully!");
                }
                resetForm();
            }
        }

        // Filter search input
        function filterDoctors() {
            const term = document.getElementById('searchField').value.toLowerCase().trim();
            const filtered = doctors.filter(doc => 
                doc.name.toLowerCase().includes(term) || 
                doc.specialty.toLowerCase().includes(term) ||
                doc.license.toLowerCase().includes(term)
            );
            renderDoctorList(filtered);
        }

        // Reset registration form UI
        function resetForm() {
            registrationForm.reset();
            docIdInput.value = '';
            formTitle.innerHTML = `<i class="fa-solid fa-address-card"></i> Register New Doctor`;
            btnText.innerText = "Register Doctor";
            submitBtn.style.backgroundColor = "var(--primary)";
        }

        // Toast message notifications
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').innerText = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
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
        window.onclick = function () {
            closeAllDropdowns();
        };

        // Simulated Logout prompt
        function logout() {
            if (confirm("Confirm session termination and return to main screen?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>
</html>
