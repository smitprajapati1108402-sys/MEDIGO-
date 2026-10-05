<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Configuration & System Settings</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Smooth transitions for high fidelity toggles and alerts */
        .toggle-dot {
            transition: transform 0.2s ease-in-out;
        }
        .toggle-bg {
            transition: background-color 0.2s ease-in-out;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0048ff;
            --primary-dark: #001d72;
            --primary-light: #eef4ff;
            --white: #ffffff;
            --text-dark: #1e293b;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar {
            font-family: 'Poppins', sans-serif;
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

        .dropdown-content a.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* Expenses Dropdown specific styling */
        .expenses-dropdown {
            position: relative;
            font-family: 'Poppins', sans-serif;
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen">

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
            <div class="dropdown active" id="settingsDropdown">
                <button class="nav-btn" onclick="toggleDropdown('settingsMenu', event)">
                    Settings <i class="fa-solid fa-gear"></i>
                </button>
                <div class="dropdown-content" id="settingsMenu">
                    <a href="Seeting.php" class="active"><i class="fa-solid fa-sliders"></i> Hospital Settings</a>
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

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Hospital Administration Settings</h2>
                <p class="text-xs text-slate-500">Manage organizational standards, data protection compliance, and system endpoints.</p>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="p-6 max-w-[1200px] mx-auto w-full">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col lg:flex-row min-h-[600px]">
                
                <!-- Internal Settings Navigation Tabs (Left Rail) -->
                <div class="w-full lg:w-64 border-b lg:border-b-0 lg:border-r border-slate-200 bg-slate-50/50 p-4 space-y-1">
                    <button onclick="switchTab('general')" id="tab-btn-general" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-blue-600 bg-blue-50/50">
                        <i class="fa-solid fa-hospital text-base"></i> General Identity
                    </button>
                    <button onclick="switchTab('security')" id="tab-btn-security" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-shield-halved text-base"></i> Security & Roles
                    </button>
                    <button onclick="switchTab('alerts')" id="tab-btn-alerts" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-bell text-base"></i> Alarm Thresholds
                    </button>
                    <button onclick="switchTab('integrations')" id="tab-btn-integrations" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-network-wired text-base"></i> EHR Integration (FHIR)
                    </button>
                </div>

                <!-- Settings Content Forms (Right Panel) -->
                <div class="flex-1 p-6 lg:p-8">
                    <form id="settingsForm" onsubmit="saveSystemSettings(event)">
                        
                        <!-- TAB 1: General Identity -->
                        <div id="tab-general" class="space-y-6">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-base font-bold text-slate-900">General Institution Identity</h3>
                                <p class="text-xs text-slate-500">Global profiles used for reporting headers and billing standards.</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Facility Registry Name</label>
                                    <input type="text" value="Saint Jude Memorial Hospital" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">National Provider Identifier (NPI)</label>
                                    <input type="text" value="9482014852" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all font-mono">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Official Address</label>
                                    <input type="text" value="4800 Medical Center Parkway, Suite 100, Metropolis" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Default Operational Timezone</label>
                                    <select class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option>GMT -5:00 Eastern Time (US/Canada)</option>
                                        <option>GMT -6:00 Central Time (US/Canada)</option>
                                        <option>GMT +0:00 London (Greenwich Mean Time)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Security & Session Rules -->
                        <div id="tab-security" class="space-y-6 hidden">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-base font-bold text-slate-900">Security Parameters & Access Rules</h3>
                                <p class="text-xs text-slate-500">Configure regulatory standards regarding session lifespan and audit logging.</p>
                            </div>
                            <div class="space-y-4">
                                <!-- Setting Row 1: Session Timeout -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-slate-50 rounded-lg border border-slate-100">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">Automatic Session Timeout</h4>
                                        <p class="text-xs text-slate-500">Enforce workspace logout after clinical inactivity to safeguard HIPAA compliance.</p>
                                    </div>
                                    <select class="px-3 py-1.5 border border-slate-200 bg-white rounded-lg text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>10 Minutes</option>
                                        <option selected>15 Minutes</option>
                                        <option>30 Minutes</option>
                                    </select>
                                </div>
                                <!-- Setting Row 2: MFA Switch -->
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-100">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">Enforce Multi-Factor Authentication (MFA)</h4>
                                        <p class="text-xs text-slate-500">Require secondary code generation for all physician and system administrator accounts.</p>
                                    </div>
                                    <button type="button" onclick="toggleSwitch(this)" id="mfa-switch" class="toggle-bg bg-emerald-500 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                        <span class="toggle-dot translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                                <!-- Setting Row 3: Biometric Override -->
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-100">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">Enable Mobile Biometric Login Override</h4>
                                        <p class="text-xs text-slate-500">Allow nurse check-in and vitals update bypasses via authenticated face ID scanning on hospital tablet hardware.</p>
                                    </div>
                                    <button type="button" onclick="toggleSwitch(this)" id="biometric-switch" class="toggle-bg bg-slate-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                        <span class="toggle-dot translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Alarm Thresholds -->
                        <div id="tab-alerts" class="space-y-6 hidden">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-base font-bold text-slate-900">Automated Notification & Capacity Thresholds</h3>
                                <p class="text-xs text-slate-500">Set margins that trigger automatic system-wide administrative broadcasts.</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Critical ICU Occupancy Alert Threshold</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <input type="number" value="90" min="50" max="100" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all pr-8">
                                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 text-sm font-bold pointer-events-none">%</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Target Patient-to-Nurse Ratio</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <input type="text" value="4:1" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Critical Resource Alerts</label>
                                    <p class="text-xs text-slate-400 mb-3">Notify procurement team if stock level drops below specified parameters.</p>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                            <span>Medical Oxygen Reserve</span>
                                            <span class="text-blue-600">Notify at < 15%</span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                            <span>Blood Bank Reserve Level</span>
                                            <span class="text-blue-600">Notify at < 10%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: FHIR/EHR Integration Settings -->
                        <div id="tab-integrations" class="space-y-6 hidden">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-base font-bold text-slate-900">EHR Core Interoperability (HL7 / FHIR)</h3>
                                <p class="text-xs text-slate-500">Configure connection endpoints with cloud Electronic Health Records repositories.</p>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">FHIR Base API Server URL</label>
                                    <input type="url" value="https://fhir.stjude-memorial.org/v4/fhir" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all font-mono">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">System Client ID</label>
                                        <input type="text" value="CLIENT-STJ-948210" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all font-mono">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">EHR Sync Interval</label>
                                        <select class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                            <option>Real-time Webhook</option>
                                            <option selected>Every 5 minutes</option>
                                            <option>Hourly Batch</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-100 mt-2">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">Auto-Push Discharges to State Registries</h4>
                                        <p class="text-xs text-slate-500">Instantly route infectious disease records and discharge datasets to public safety health nodes.</p>
                                    </div>
                                    <button type="button" onclick="toggleSwitch(this)" id="sync-switch" class="toggle-bg bg-emerald-500 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                        <span class="toggle-dot translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Global Footer Form Controls -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between gap-4 flex-wrap">
                            <span class="text-xs text-slate-400 font-medium">Last modification logged at: June 2, 2026, 09:12 AM</span>
                            <div class="flex gap-2">
                                <button type="button" onclick="resetForm()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2 rounded-lg text-xs transition-colors">Discard Draft</button>
                                <button type="submit" id="saveBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2 rounded-lg text-xs transition-colors flex items-center gap-2">
                                    Save Configurations
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </main>

    <!-- Success Toast Notification -->
    <div id="toastNotification" class="fixed bottom-6 right-6 transform translate-y-24 opacity-0 bg-slate-900 text-white px-4 py-3.5 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-300 z-50">
        <div class="bg-emerald-500 text-white p-1 rounded-full text-xs h-6 w-6 flex items-center justify-center">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <span class="text-sm font-bold block leading-none">System Settings Saved</span>
            <span class="text-[10px] text-slate-400">Configurations successfully pushed to the local server.</span>
        </div>
    </div>

    <!-- Interface Script Section -->
    <script>
        // Tab Nav state management
        let currentActiveTab = 'general';

        function switchTab(targetTab) {
            // Hide previous tab, remove highlight classes
            document.getElementById(`tab-${currentActiveTab}`).classList.add('hidden');
            const prevBtn = document.getElementById(`tab-btn-${currentActiveTab}`);
            prevBtn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:bg-slate-100";

            // Reveal selected tab, add active highlight classes
            document.getElementById(`tab-${targetTab}`).classList.remove('hidden');
            const newBtn = document.getElementById(`tab-btn-${targetTab}`);
            newBtn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all text-blue-600 bg-blue-50/50";

            // Store status
            currentActiveTab = targetTab;
        }

        // Custom High-Fidelity Slide Toggle Handler
        function toggleSwitch(buttonEl) {
            const spanDot = buttonEl.querySelector('.toggle-dot');
            const isChecked = buttonEl.getAttribute('aria-checked') === 'true';

            if (isChecked) {
                // Untoggle state
                buttonEl.setAttribute('aria-checked', 'false');
                buttonEl.classList.remove('bg-emerald-500');
                buttonEl.classList.add('bg-slate-200');
                spanDot.classList.remove('translate-x-5');
                spanDot.classList.add('translate-x-0');
            } else {
                // Toggle state
                buttonEl.setAttribute('aria-checked', 'true');
                buttonEl.classList.remove('bg-slate-200');
                buttonEl.classList.add('bg-emerald-500');
                spanDot.classList.remove('translate-x-0');
                spanDot.classList.add('translate-x-5');
            }
        }

        // Save Settings Simulator
        function saveSystemSettings(event) {
            event.preventDefault();
            const saveBtn = document.getElementById('saveBtn');

            // Show loading indicators inside the button
            saveBtn.disabled = true;
            saveBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin text-xs"></i> Saving...`;

            setTimeout(() => {
                // Restore button appearance
                saveBtn.disabled = false;
                saveBtn.innerHTML = `Save Configurations`;

                // Launch Toast Message
                launchToast();
            }, 1000);
        }

        // Animate and display Toast Alert
        function launchToast() {
            const toast = document.getElementById('toastNotification');
            
            // Pop up
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Slide back out of view after 3 seconds
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }

        // Reset Settings Form Draft
        function resetForm() {
            document.getElementById('settingsForm').reset();
            
            // Force reset of toggle values to initial layout statuses
            resetToggle('mfa-switch', true);
            resetToggle('biometric-switch', false);
            resetToggle('sync-switch', true);
        }

        // Helper: Reset toggle positions to consistent states on form discard
        function resetToggle(elementId, shouldBeActive) {
            const btn = document.getElementById(elementId);
            const spanDot = btn.querySelector('.toggle-dot');
            
            if (shouldBeActive) {
                btn.setAttribute('aria-checked', 'true');
                btn.className = "toggle-bg bg-emerald-500 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none";
                spanDot.className = "toggle-dot translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out";
            } else {
                btn.setAttribute('aria-checked', 'false');
                btn.className = "toggle-bg bg-slate-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none";
                spanDot.className = "toggle-dot translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out";
            }
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
