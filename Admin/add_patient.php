<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Intake & Registration Terminal</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Variables */
        :root {
            --primary: #0048ff;
            --primary-dark: #001d72;
            --primary-light: #eef4ff;
            --white: #ffffff;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --text-dark: #1e293b;
        }

        /* Smooth state transitions */
        .priority-indicator {
            transition: all 0.3s ease;
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans flex flex-col h-screen overflow-hidden">

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
                    <a href="patientmanagement.php" class="active"><i class="fa-solid fa-user-injured"></i> Patient Management</a>
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

    <!-- Main Content Container -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Patient Intake Registration</h2>
                <p class="text-xs text-slate-500">Log incoming admissions, assign initial triage priorities, and record emergency details.</p>
            </div>
        </header>

        <!-- Intake Form Layout Grid -->
        <div class="p-6 max-w-[1500px] mx-auto w-full">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                
                <!-- COLUMN 1 & 2: Registration Input Form -->
                <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-8 space-y-6">
                    <form id="patientIntakeForm" onsubmit="registerPatient(event)" class="space-y-6">
                        
                        <!-- Section 1: Demographics -->
                        <div class="space-y-4">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2"><i class="fa-solid fa-address-card text-teal-600"></i> Demographics & Personal Info</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Full Name</label>
                                    <input type="text" id="form-name" required placeholder="e.g. Eleanor Vance" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Date of Birth</label>
                                    <input type="date" id="form-dob" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Gender Identity</label>
                                    <select id="form-gender" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                        <option value="" disabled selected>Select</option>
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Non-binary">Non-binary</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Blood Type</label>
                                    <select id="form-blood" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                        <option value="O+">O Positive (O+)</option>
                                        <option value="O-">O Negative (O-)</option>
                                        <option value="A+">A Positive (A+)</option>
                                        <option value="A-">A Negative (A-)</option>
                                        <option value="B+">B Positive (B+)</option>
                                        <option value="B-">B Negative (B-)</option>
                                        <option value="AB+">AB Positive (AB+)</option>
                                        <option value="AB-">AB Negative (AB-)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Contact Number</label>
                                    <input type="tel" id="form-phone" required placeholder="e.g. +1 (555) 012-3456" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all font-mono">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Clinical Intake -->
                        <div class="space-y-4 pt-2">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2"><i class="fa-solid fa-stethoscope text-teal-600"></i> Clinical Triage & Symptoms</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Primary Presenting Symptom</label>
                                    <input type="text" id="form-symptoms" required placeholder="e.g. Acute chest pain, shortness of breath" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Triage Priority Level</label>
                                    <select id="form-priority" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all font-semibold">
                                        <option value="low" class="text-emerald-600">Low (Routine / Non-Urgent)</option>
                                        <option value="medium" selected class="text-amber-600">Medium (Urgent / Under Watch)</option>
                                        <option value="high" class="text-orange-600">High (Emergency / Severe)</option>
                                        <option value="critical" class="text-red-600">Critical (Immediate Resuscitation Required)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Assigned Doctor</label>
                                    <select id="form-doctor" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                        <option value="Dr. Raj Patel">Dr. Raj Patel (Cardiology)</option>
                                        <option value="Dr. Jane Smith">Dr. Jane Smith (Neurology)</option>
                                        <option value="Dr. Robert Chen">Dr. Robert Chen (Pediatrics)</option>
                                        <option value="Dr. Marcus Vance">Dr. Marcus Vance (Emergency Medicine)</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Allergies (Separated by commas)</label>
                                    <input type="text" id="form-allergies" placeholder="e.g. Penicillin, Peanuts, Latex" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Emergency Contact -->
                        <div class="space-y-4 pt-2">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2"><i class="fa-solid fa-phone-volume text-teal-600"></i> Emergency Contact</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Contact Name</label>
                                    <input type="text" id="form-emerg-name" required placeholder="e.g. Julian Vance" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Relationship</label>
                                    <input type="text" id="form-emerg-relation" required placeholder="e.g. Spouse, Parent" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Emergency Phone</label>
                                    <input type="tel" id="form-emerg-phone" required placeholder="e.g. +1 (555) 019-9821" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all font-mono">
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Discard Controls -->
                        <div class="pt-6 border-t border-slate-100 flex justify-end gap-2">
                            <button type="reset" onclick="resetIntakePreview()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-lg text-xs transition-colors">Clear Form</button>
                            <button type="submit" id="submitBtn" class="bg-teal-600 hover:bg-teal-700 text-white font-bold px-5 py-2.5 rounded-lg text-xs transition-colors flex items-center gap-2">Admit Patient</button>
                        </div>
                    </form>
                </div>

                <!-- COLUMN 3: Real-Time Preview Intake Card & Recent Intake log -->
                <div class="space-y-6">
                    
                    <!-- Dynamic Live Preview Patient intake Card -->
                    <div id="preview-container" class="priority-indicator bg-white rounded-xl shadow-md border-2 border-slate-200 p-6 flex flex-col justify-between min-h-[340px]">
                        <div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-1.5 text-xs">
                                    <i class="fa-solid fa-hospital-user text-teal-600"></i>
                                    <span class="font-bold text-slate-400 uppercase tracking-wider">Triage Intake Card</span>
                                </div>
                                <span id="preview-priority-badge" class="priority-indicator text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider bg-slate-100 text-slate-600">
                                    PENDING
                                </span>
                            </div>

                            <!-- Core Profile Details -->
                            <div class="flex items-start gap-4 mt-5">
                                <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center font-bold text-base shadow-inner">
                                    PT
                                </div>
                                <div class="min-w-0">
                                    <h4 id="preview-name" class="font-bold text-base text-slate-900 leading-tight truncate">Eleanor Vance</h4>
                                    <p class="text-xs text-slate-500 mt-1 font-semibold">
                                        DOB: <span id="preview-dob" class="font-mono">YYYY-MM-DD</span> | <span id="preview-age">Age: --</span>
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Blood Type: <span id="preview-blood" class="font-bold text-slate-700">O+</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Symptom and Emergency details -->
                        <div class="space-y-2 border-t border-slate-100 pt-3 text-xs">
                            <div class="flex items-start gap-1">
                                <span class="font-bold text-slate-500 min-w-[70px]">Symptom:</span>
                                <span id="preview-symptoms" class="text-slate-700 italic truncate max-w-[200px]">None specified</span>
                            </div>
                            <div class="flex items-start gap-1">
                                <span class="font-bold text-slate-500 min-w-[70px]">Assigned Doc:</span>
                                <span id="preview-doctor" class="text-slate-700 font-semibold truncate max-w-[200px]">None selected</span>
                            </div>
                            <div class="flex items-start gap-1">
                                <span class="font-bold text-slate-500 min-w-[70px]">Allergies:</span>
                                <span id="preview-allergies" class="text-red-600 font-semibold truncate max-w-[200px]">No known allergies</span>
                            </div>
                            <div class="flex items-start gap-1">
                                <span class="font-bold text-slate-500 min-w-[70px]">Emerg. Contact:</span>
                                <span id="preview-emerg" class="text-slate-700 truncate max-w-[200px]">--</span>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="border-t border-slate-100 pt-3 flex justify-between items-center text-[10px] text-slate-400">
                            <span>ID: <span class="font-mono font-bold text-slate-600">PX-INTAKE-PENDING</span></span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1"><i class="fa-solid fa-circle-check text-[9px]"></i> VALID FOR ADMISSION</span>
                        </div>
                    </div>

                    <!-- Session Admissions Log -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Session Admissions</h3>
                            <p class="text-xs text-slate-400">Patients registered during this active interface session.</p>
                        </div>
                        <!-- List Container -->
                        <div class="space-y-3 max-h-48 overflow-y-auto pr-1" id="sessionPatientsList">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- Success Toast Notification -->
    <div id="toastNotification" class="fixed bottom-6 right-6 transform translate-y-24 opacity-0 bg-slate-900 text-white px-4 py-3.5 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-300 z-50">
        <div class="bg-teal-500 text-white p-1 rounded-full text-xs h-6 w-6 flex items-center justify-center">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <span class="text-sm font-bold block leading-none">Patient Successfully Admitted</span>
            <span class="text-[10px] text-slate-400">Record synced to live facility ward and scheduling rosters.</span>
        </div>
    </div>

    <!-- Active Interface Script Section -->
    <script>
        // Session memory storage matching DB
        let admittedPatients = [
            {
                name: "Arjun Sharma",
                age: "45 yrs",
                blood: "O+",
                priority: "medium",
                symptom: "Hypertension",
                id: "PAT-1001"
            },
            {
                name: "Priya Verma",
                age: "28 yrs",
                blood: "B+",
                priority: "high",
                symptom: "Migraine",
                id: "PAT-1002"
            },
            {
                name: "Rohan Gupta",
                age: "12 yrs",
                blood: "A+",
                priority: "low",
                symptom: "Seasonal Flu",
                id: "PAT-1003"
            }
        ];

        // Dynamic Doctors Dropdown Population from Database & LocalStorage
        async function populateDoctorsDropdown() {
            const docSelect = document.getElementById('form-doctor');
            if (!docSelect) return;

            const defaultDoctors = [
                { name: "Dr. Raj Patel", specialty: "Cardiology" },
                { name: "Dr. Jane Smith", specialty: "Neurology" },
                { name: "Dr. Robert Chen", specialty: "Pediatrics" },
                { name: "Dr. Marcus Vance", specialty: "Emergency Medicine" }
            ];

            try {
                const res = await fetch('api.php?action=get_doctors');
                const data = await res.json();
                if (data && data.status === 'success' && data.data && data.data.length > 0) {
                    docSelect.innerHTML = '<option value="" disabled selected>Choose Doctor</option>';
                    data.data.forEach(doc => {
                        const opt = document.createElement('option');
                        opt.value = doc.name;
                        opt.textContent = doc.name + ' (' + (doc.specialty || doc.department || 'General Medicine') + ')';
                        docSelect.appendChild(opt);
                    });
                    return;
                }
            } catch (e) {
                console.warn("API doctors fetch fallback:", e);
            }

            const doctorsList = JSON.parse(localStorage.getItem('doctors')) || defaultDoctors;
            docSelect.innerHTML = '<option value="" disabled selected>Choose Doctor</option>';
            doctorsList.forEach(doc => {
                const opt = document.createElement('option');
                opt.value = doc.name;
                opt.textContent = doc.name;
                docSelect.appendChild(opt);
            });
        }

        // Fetch recent patient admissions from DB
        async function loadRecentAdmissionsFromDb() {
            try {
                const res = await fetch('api.php?action=get_patients');
                const data = await res.json();
                if (data && data.status === 'success' && data.data && data.data.length > 0) {
                    admittedPatients = data.data.slice(0, 5).map(p => ({
                        name: p.name,
                        age: (p.age ? p.age + ' yrs' : '30 yrs'),
                        blood: p.blood_group || 'O+',
                        priority: (p.status === 'Critical' ? 'critical' : (p.status === 'Serious' ? 'high' : 'medium')),
                        symptom: p.disease || 'General Diagnosis',
                        id: p.patient_id || ('PAT-' + p.id)
                    }));
                    renderRecentAdmissions();
                }
            } catch (e) {
                console.warn("API recent admissions fetch fallback:", e);
            }
        }

        // Initialization
        document.addEventListener("DOMContentLoaded", () => {
            populateDoctorsDropdown();
            renderRecentAdmissions();
            loadRecentAdmissionsFromDb();
            initLiveListeners();
            updatePriorityTheme('medium'); // Default select state on page load
        });

        // Compute age dynamically on input based on current year 2026
        function calculateAge(dobString) {
            if (!dobString) return "Age: --";
            const today = new Date();
            const birthDate = new Date(dobString);
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age >= 0 ? `Age: ${age} yrs` : "Age: --";
        }

        // Initialize change listeners for live data updates
        function initLiveListeners() {
            const name = document.getElementById('form-name');
            const dob = document.getElementById('form-dob');
            const blood = document.getElementById('form-blood');
            const symptoms = document.getElementById('form-symptoms');
            const priority = document.getElementById('form-priority');
            const doctor = document.getElementById('form-doctor');
            const allergies = document.getElementById('form-allergies');
            const emergName = document.getElementById('form-emerg-name');
            const emergRelation = document.getElementById('form-emerg-relation');

            name.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                document.getElementById('preview-name').innerText = val ? val : "Eleanor Vance";
            });

            dob.addEventListener('change', (e) => {
                const val = e.target.value;
                document.getElementById('preview-dob').innerText = val;
                document.getElementById('preview-age').innerText = calculateAge(val);
            });

            blood.addEventListener('change', (e) => {
                document.getElementById('preview-blood').innerText = e.target.value;
            });

            symptoms.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                document.getElementById('preview-symptoms').innerText = val ? val : "None specified";
            });

            allergies.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                const previewAllergies = document.getElementById('preview-allergies');
                if (val) {
                    previewAllergies.innerText = val;
                    previewAllergies.className = "text-red-600 font-bold truncate max-w-[200px]";
                } else {
                    previewAllergies.innerText = "No known allergies";
                    previewAllergies.className = "text-slate-600 font-normal truncate max-w-[200px]";
                }
            });

            priority.addEventListener('change', (e) => {
                updatePriorityTheme(e.target.value);
            });

            // Handle composite Emergency Contacts
            function updateEmergContact() {
                const nameVal = emergName.value.trim();
                const relationVal = emergRelation.value.trim();
                const previewEmerg = document.getElementById('preview-emerg');
                if (nameVal && relationVal) {
                    previewEmerg.innerText = `${nameVal} (${relationVal})`;
                } else if (nameVal) {
                    previewEmerg.innerText = nameVal;
                } else {
                    previewEmerg.innerText = "--";
                }
            }
            emergName.addEventListener('input', updateEmergContact);
            emergRelation.addEventListener('input', updateEmergContact);

            doctor.addEventListener('change', (e) => {
                document.getElementById('preview-doctor').innerText = e.target.value;
            });
        }

        // Map selected priority tags to high-fidelity colors
        function updatePriorityTheme(priority) {
            const container = document.getElementById('preview-container');
            const badge = document.getElementById('preview-priority-badge');

            // Reset classes
            container.className = "priority-indicator bg-white rounded-xl shadow-md border-2 p-6 flex flex-col justify-between h-80";
            badge.className = "priority-indicator text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider";

            switch (priority) {
                case 'low':
                    container.classList.add('border-emerald-200');
                    badge.classList.add('bg-emerald-50', 'text-emerald-700');
                    badge.innerText = "Priority: Low";
                    break;
                case 'medium':
                    container.classList.add('border-amber-200');
                    badge.classList.add('bg-amber-50', 'text-amber-700');
                    badge.innerText = "Priority: Medium";
                    break;
                case 'high':
                    container.classList.add('border-orange-200');
                    badge.classList.add('bg-orange-50', 'text-orange-700');
                    badge.innerText = "Priority: High";
                    break;
                case 'critical':
                    container.classList.add('border-red-400', 'ring-2', 'ring-red-100');
                    badge.classList.add('bg-red-500', 'text-white', 'animate-pulse');
                    badge.innerText = "PRIORITY: CRITICAL";
                    break;
                default:
                    container.classList.add('border-slate-200');
                    badge.classList.add('bg-slate-100', 'text-slate-600');
                    badge.innerText = "PENDING";
            }
        }

        // Render recent patient list
        function renderRecentAdmissions() {
            const container = document.getElementById('sessionPatientsList');
            container.innerHTML = '';

            if (admittedPatients.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-6">
                        <span class="text-xs text-slate-400 font-semibold block">No patients logged in this session.</span>
                    </div>
                `;
                return;
            }

            admittedPatients.forEach(patient => {
                let badgeClass = "bg-slate-100 text-slate-600";
                if (patient.priority === 'critical') badgeClass = "bg-red-100 text-red-800 font-bold";
                else if (patient.priority === 'high') badgeClass = "bg-orange-100 text-orange-800";
                else if (patient.priority === 'medium') badgeClass = "bg-amber-100 text-amber-800";
                else if (patient.priority === 'low') badgeClass = "bg-emerald-100 text-emerald-800";

                const item = document.createElement('div');
                item.className = "flex items-center gap-3 p-3 rounded-lg border border-slate-100 bg-slate-50/50 text-xs";
                item.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center">
                        ${patient.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 truncate">${patient.name}</h4>
                        <p class="text-[10px] text-slate-500 truncate">${patient.age} | Blood: ${patient.blood} | ${patient.symptom}</p>
                    </div>
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded ${badgeClass} uppercase tracking-wider">
                        ${patient.priority}
                    </span>
                `;
                container.prepend(item); // New admissions are placed at the top of the list
            });
        }

        // Handle intake form submission
        async function registerPatient(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submitBtn');

            // Collect values
            const name = document.getElementById('form-name').value.trim();
            const dob = document.getElementById('form-dob').value;
            const gender = document.getElementById('form-gender') ? document.getElementById('form-gender').value : 'Male';
            const blood = document.getElementById('form-blood').value;
            const symptoms = document.getElementById('form-symptoms').value.trim();
            const priority = document.getElementById('form-priority').value;
            const phone = document.getElementById('form-phone').value.trim() || "+91 98711 22334";
            const selectedDocVal = document.getElementById('form-doctor').value || "Dr. Raj Patel";
            
            const emergName = document.getElementById('form-emerg-name') ? document.getElementById('form-emerg-name').value.trim() : '';
            const emergRelation = document.getElementById('form-emerg-relation') ? document.getElementById('form-emerg-relation').value.trim() : '';
            const emergPhone = document.getElementById('form-emerg-phone') ? document.getElementById('form-emerg-phone').value.trim() : '';
            const allergies = document.getElementById('form-allergies') ? document.getElementById('form-allergies').value.trim() : '';

            // Compute patient age values
            const computedAge = parseInt(calculateAge(dob).replace("Age: ", "")) || 30;

            // Shift button to loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin text-xs"></i> Registering Patient...`;

            try {
                // Generate random intake ID
                const randomId = `PX-${Math.floor(Math.random() * (999999 - 100000) + 100000)}`;

                let conditionMapped = "Stable";
                if (priority === "high") conditionMapped = "Serious";
                else if (priority === "critical") conditionMapped = "Critical";

                const addressString = emergName ? `Emergency: ${emergName} (${emergRelation}) - ${emergPhone}` : 'General Ward';

                // Save to MySQL database via api.php
                const response = await fetch('api.php?action=add_patient', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        patient_id: randomId,
                        name: name,
                        age: computedAge,
                        gender: gender || 'Male',
                        blood_group: blood,
                        phone: phone,
                        address: addressString,
                        doctor_assigned: selectedDocVal,
                        disease: symptoms,
                        status: conditionMapped
                    })
                });

                const res = await response.json();

                if (!response.ok || (res && res.status !== 'success')) {
                    const errorDetails = (res && res.message) ? res.message : 'Database error occurred while registering patient.';
                    throw new Error(errorDetails);
                }

                const newPatient = {
                    name: name,
                    age: computedAge + " yrs",
                    blood: blood,
                    priority: priority,
                    symptom: symptoms,
                    id: (res && res.data && res.data.patient_id) ? res.data.patient_id : randomId
                };

                // Add to state list and update UI roster
                admittedPatients.push(newPatient);

                // Map and sync to main patients list in localStorage
                let patientsList = JSON.parse(localStorage.getItem('patients')) || [];
                const newPatientForMgmt = {
                    id: (res && res.data && res.data.id) ? parseInt(res.data.id) : Date.now() % 100000,
                    name: name,
                    disease: symptoms,
                    condition: conditionMapped,
                    phone: phone,
                    doctor: selectedDocVal,
                    room: addressString
                };
                patientsList.push(newPatientForMgmt);
                localStorage.setItem('patients', JSON.stringify(patientsList));

                document.getElementById('patientIntakeForm').reset();
                resetIntakePreview();
                renderRecentAdmissions();

                // Restore submit button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = `Admit Patient`;

                // Display success toast validation
                launchToast();

                setTimeout(() => {
                    window.location.href = 'patientmanagement.php';
                }, 1200);
            } catch (err) {
                console.error("Save patient error:", err);
                alert("⚠️ Error saving patient to database:\n" + err.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = `Admit Patient`;
            }
        }

        // Reset badge preview template
        function resetIntakePreview() {
            document.getElementById('preview-name').innerText = "Eleanor Vance";
            document.getElementById('preview-dob').innerText = "YYYY-MM-DD";
            document.getElementById('preview-age').innerText = "Age: --";
            document.getElementById('preview-blood').innerText = "O+";
            document.getElementById('preview-symptoms').innerText = "None specified";
            document.getElementById('preview-doctor').innerText = "None selected";
            document.getElementById('preview-allergies').innerText = "No known allergies";
            document.getElementById('preview-emerg').innerText = "--";
            updatePriorityTheme('medium');
        }

        // Trigger success toast notification popup
        function launchToast() {
            const toast = document.getElementById('toastNotification');
            if (!toast) return;
            
            // Pop up
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Hide after 3.5 seconds
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3500);
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

        // Logout
        function logout() {
            if (confirm("Confirm session termination and return to login?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>
</html>
