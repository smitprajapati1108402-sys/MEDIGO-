<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboard New Medical Staff</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Variables for Navigation */
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

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
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

    <!-- Main Content Container -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Physician Onboarding Terminal</h2>
                <p class="text-xs text-slate-500">Register incoming medical officers, configure departmental privileges, and set default clinic shifts.</p>
            </div>
        </header>

        <!-- Form Workspace Layout -->
        <div class="p-6 max-w-[1400px] mx-auto w-full">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                
                <!-- COLUMN 1 & 2: Registration Input Form -->
                <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6 lg:p-8 space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-base font-bold text-slate-900">Credential & Personal Information</h3>
                        <p class="text-xs text-slate-500">Inputs must match official state licensing medical certificates.</p>
                    </div>

                    <form id="doctorOnboardForm" onsubmit="registerDoctor(event)" class="space-y-6">
                        <!-- Step 1: Identity -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Full Name (with Prefix)</label>
                                <input type="text" id="form-name" required placeholder="e.g. Dr. Arthur Mercer" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Specialty Department</label>
                                <select id="form-specialty" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="" disabled selected>Select Specialization</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Neurology">Neurology</option>
                                    <option value="Pediatrics">Pediatrics</option>
                                    <option value="General Surgery">General Surgery</option>
                                    <option value="Internal Medicine">Internal Medicine</option>
                                    <option value="Dermatology">Dermatology</option>
                                </select>
                            </div>
                        </div>

                        <!-- Step 2: Professional Licensing -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">National Provider Identifier (NPI)</label>
                                <input type="text" id="form-npi" required pattern="^[0-9]{10}$" placeholder="10-digit NPI number" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pager / Contact Number</label>
                                <div class="flex gap-2">
                                    <select id="form-country-code" class="px-2 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono min-w-[85px]">
                                        <option value="+91">+91</option>
                                        <option value="+1">+1</option>
                                        <option value="+44">+44</option>
                                        <option value="+61">+61</option>
                                        <option value="+81">+81</option>
                                        <option value="+49">+49</option>
                                        <option value="+971">+971</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <input type="tel" id="form-phone" required placeholder="e.g. 98765 43210" class="flex-1 min-w-0 px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono">
                                </div>
                                <div id="custom-country-code-container" class="hidden mt-2">
                                    <input type="text" id="form-custom-country-code" placeholder="Enter custom country code (e.g. +55)" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email Endpoint</label>
                                <input type="email" id="form-email" required placeholder="e.g. a.mercer@clinic.org" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono">
                            </div>
                        </div>

                        <!-- Step 3: Shift Allocations -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Default Ward Assignment</label>
                                <input type="text" id="form-ward" required placeholder="e.g. Wing B, Floor 3, Clinic Room 312" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Roster Shift Type</label>
                                <select id="form-shift" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                    <option value="Morning Shift (06:00 - 14:00)">Morning Shift (06:00 - 14:00)</option>
                                    <option value="Afternoon Shift (14:00 - 22:00)">Afternoon Shift (14:00 - 22:00)</option>
                                    <option value="Night Emergency Duty (22:00 - 06:00)">Night Emergency Duty (22:00 - 06:00)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-6 border-t border-slate-100 flex justify-end gap-2">
                            <button type="reset" onclick="resetBadgePreview()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-5 py-2.5 rounded-lg text-xs transition-colors">Clear Fields</button>
                            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-lg text-xs transition-colors flex items-center gap-2">Onboard Clinician</button>
                        </div>
                    </form>
                </div>

                <!-- COLUMN 3: Real-Time Preview Badge & Recent Registrations -->
                <div class="space-y-6">
                    
                    <!-- Real-Time ID Badge Preview Card -->
                    <div class="bg-gradient-to-br from-blue-700 to-indigo-900 rounded-xl shadow-lg border border-indigo-950 p-6 text-white relative overflow-hidden flex flex-col justify-between h-72">
                        <!-- Holographic background flare -->
                        <span class="absolute -right-16 -top-16 w-44 h-44 bg-blue-500 rounded-full blur-3xl opacity-30 pointer-events-none"></span>
                        
                        <div>
                            <!-- Badge Header -->
                            <div class="flex items-center justify-between border-b border-indigo-500/30 pb-3">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-hospital text-sm text-blue-300"></i>
                                    <span class="text-[10px] uppercase tracking-widest font-bold text-blue-200">St. Jude Medical</span>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-500 text-blue-50">MEDICAL OFFICER</span>
                            </div>

                            <!-- Doctor Profile Info -->
                            <div class="flex items-center gap-4 mt-6">
                                <div id="preview-avatar" class="w-14 h-14 rounded-full bg-white text-indigo-900 border-2 border-indigo-400 flex items-center justify-center font-bold text-lg shadow-inner">
                                    ??
                                </div>
                                <div>
                                    <h4 id="preview-name" class="font-bold text-base leading-tight">Dr. Full Name</h4>
                                    <p id="preview-specialty" class="text-xs text-blue-200 mt-1 font-semibold">Specialization</p>
                                    <p id="preview-npi" class="text-[10px] text-indigo-200 mt-0.5 font-mono">NPI-0000000000</p>
                                </div>
                            </div>
                        </div>

                        <!-- Badge Footer -->
                        <div class="border-t border-indigo-500/30 pt-3 flex justify-between items-center text-[10px] text-indigo-200">
                            <div>
                                <span class="block opacity-60">SHIFT</span>
                                <span id="preview-shift" class="font-semibold text-blue-100">Morning Shift (06:00 - 14:00)</span>
                            </div>
                            <span class="font-bold text-xs"><i class="fa-solid fa-circle-check text-emerald-400"></i> ACTIVE</span>
                        </div>
                    </div>

                    <!-- Recently Added Staff Panel -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Session Registrations</h3>
                            <p class="text-xs text-slate-400">Physicians onboarded during this browser session.</p>
                        </div>
                        <!-- List container -->
                        <div class="space-y-3 max-h-56 overflow-y-auto pr-1" id="recentDoctorsList">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

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
            <span class="text-sm font-bold block leading-none">Clinician Onboarded</span>
            <span class="text-[10px] text-slate-400">Credentials synchronized to global physician registry database.</span>
        </div>
    </div>

    <!-- Interface Script Section -->
    <script>
        // Recently Added Memory State
        let onboardedDoctors = [];

        // On document ready
        document.addEventListener("DOMContentLoaded", () => {
            loadRecentDoctors();
            initLiveListeners();
        });

        // Fetch recent doctors from MySQL Database
        async function loadRecentDoctors() {
            try {
                const response = await fetch('api.php?action=get_doctors');
                const res = await response.json();
                if (res && res.status === 'success' && res.data && res.data.length > 0) {
                    onboardedDoctors = res.data.slice(0, 5).map(doc => {
                        const parts = (doc.name || '').replace("Dr. ", "").split(' ');
                        const initials = parts.map(p => p[0]).join('').substring(0, 2).toUpperCase() || 'DR';
                        return {
                            name: doc.name,
                            specialty: doc.specialty || doc.department || 'General Medicine',
                            npi: doc.doctor_id || 'DOC-000',
                            shift: doc.timing || 'Morning Shift (06:00 - 14:00)',
                            avatar: initials,
                            phone: doc.phone || ''
                        };
                    });
                }
            } catch (err) {
                console.warn('Unable to load recent doctors from DB:', err);
                onboardedDoctors = [
                    { name: "Dr. Raj Patel", specialty: "Cardiology", npi: "DOC-101", shift: "Morning Shift (09:00 - 14:00)", avatar: "RP", phone: "+91 98234 11223" },
                    { name: "Dr. Jane Smith", specialty: "Neurology", npi: "DOC-102", shift: "Day Shift (10:00 - 16:00)", avatar: "JS", phone: "+91 98456 33445" }
                ];
            }
            renderRecentDoctors();
        }

        // Setup real-time listeners to populate the badge preview
        function initLiveListeners() {
            const nameInput = document.getElementById('form-name');
            const specialtyInput = document.getElementById('form-specialty');
            const npiInput = document.getElementById('form-npi');
            const shiftInput = document.getElementById('form-shift');
            const countryCodeSelect = document.getElementById('form-country-code');
            const customCountryCodeContainer = document.getElementById('custom-country-code-container');
            const customCountryCodeInput = document.getElementById('form-custom-country-code');
            const phoneInput = document.getElementById('form-phone');

            // Name updates
            nameInput.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                document.getElementById('preview-name').innerText = val ? val : "Dr. Full Name";
                
                // Set initials avatar preview
                const parts = val.replace("Dr. ", "").split(' ');
                const initials = parts.map(p => p[0]).join('').substring(0, 2).toUpperCase();
                document.getElementById('preview-avatar').innerText = initials ? initials : "??";
            });

            // Specialty updates
            specialtyInput.addEventListener('change', (e) => {
                document.getElementById('preview-specialty').innerText = e.target.value;
            });

            // NPI updates
            npiInput.addEventListener('input', (e) => {
                const val = e.target.value.trim();
                document.getElementById('preview-npi').innerText = val ? `NPI-${val}` : "NPI-0000000000";
            });

            // Shift updates
            shiftInput.addEventListener('change', (e) => {
                document.getElementById('preview-shift').innerText = e.target.value;
            });

            // Country code selector listener to toggle custom input
            countryCodeSelect.addEventListener('change', (e) => {
                if (e.target.value === 'other') {
                    customCountryCodeContainer.classList.remove('hidden');
                    customCountryCodeInput.setAttribute('required', 'required');
                    phoneInput.placeholder = "Phone Number";
                } else {
                    customCountryCodeContainer.classList.add('hidden');
                    customCountryCodeInput.removeAttribute('required');
                    customCountryCodeInput.value = '';
                    
                    // Set placeholders based on country code
                    if (e.target.value === '+91') {
                        phoneInput.placeholder = "e.g. 98765 43210";
                    } else if (e.target.value === '+1') {
                        phoneInput.placeholder = "e.g. (555) 019-2811";
                    } else if (e.target.value === '+44') {
                        phoneInput.placeholder = "e.g. 7700 900077";
                    } else {
                        phoneInput.placeholder = "Phone Number";
                    }
                }
            });
        }

        // Render recent physician listings
        function renderRecentDoctors() {
            const container = document.getElementById('recentDoctorsList');
            container.innerHTML = '';

            if (onboardedDoctors.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-6">
                        <span class="text-xs text-slate-400 font-semibold block">No physicians registered yet.</span>
                    </div>
                `;
                return;
            }

            onboardedDoctors.forEach(doc => {
                const item = document.createElement('div');
                item.className = "flex items-center gap-3 p-3 rounded-lg border border-slate-100 bg-slate-50/50 text-xs";
                item.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center">
                        ${doc.avatar}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 truncate">${doc.name}</h4>
                        <p class="text-[10px] text-slate-500 truncate">${doc.specialty} | NPI: ${doc.npi}</p>
                    </div>
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 truncate max-w-[80px]" title="${doc.shift}">
                        Shift Set
                    </span>
                `;
                container.prepend(item); // New doctors show up first
            });
        }

        // Handle physician registration form submission
        async function registerDoctor(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submitBtn');

            // Form validation
            const name = document.getElementById('form-name').value.trim();
            const specialty = document.getElementById('form-specialty').value;
            const npi = document.getElementById('form-npi').value.trim();
            const shift = document.getElementById('form-shift').value;
            const email = document.getElementById('form-email').value.trim();
            
            const countryCodeSelect = document.getElementById('form-country-code').value;
            const customCountryCode = document.getElementById('form-custom-country-code').value.trim();
            const phoneNum = document.getElementById('form-phone').value.trim();
            const selectedCode = countryCodeSelect === 'other' ? customCountryCode : countryCodeSelect;
            const fullPhone = `${selectedCode} ${phoneNum}`.trim();

            if (!name) {
                alert("Please enter doctor's full name.");
                return;
            }

            if (!specialty) {
                alert("Please select a specialty department.");
                return;
            }

            // Enter submission loading transition
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin text-xs"></i> Registering to Database...`;

            try {
                // Generate Doctor ID from NPI or random
                const docId = npi ? `DOC-${npi.slice(-4)}` : `DOC-${Math.floor(100 + Math.random() * 900)}`;

                // Save to MySQL Database via api.php
                const response = await fetch('api.php?action=add_doctor', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        doctor_id: docId,
                        name: name,
                        department: specialty,
                        specialty: specialty,
                        experience: '5+ Years',
                        email: email,
                        phone: fullPhone,
                        timing: shift,
                        fee: 500.00,
                        status: 'Available'
                    })
                });

                const res = await response.json();

                if (res && res.status === 'success') {
                    // Parse initials
                    const parts = name.replace("Dr. ", "").split(' ');
                    const initials = parts.map(p => p[0]).join('').substring(0, 2).toUpperCase() || 'DR';

                    // Append new doctor structure to local recent session list
                    const newDoc = {
                        name: name,
                        specialty: specialty,
                        npi: docId,
                        shift: shift,
                        avatar: initials,
                        phone: fullPhone
                    };
                    onboardedDoctors.push(newDoc);

                    // Sync to localStorage
                    let doctorsList = JSON.parse(localStorage.getItem('doctors')) || [];
                    doctorsList.push({
                        id: res.data ? res.data.id : Date.now(),
                        name: name,
                        specialization: specialty,
                        email: email,
                        status: "Active",
                        phone: fullPhone
                    });
                    localStorage.setItem('doctors', JSON.stringify(doctorsList));

                    // Reset form, rebuild preview, update list
                    document.getElementById('doctorOnboardForm').reset();
                    resetBadgePreview();
                    renderRecentDoctors();

                    // Restore submit button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `Onboard Clinician`;

                    // Display success toast notification
                    launchToast();

                    // Redirect back to doctor management directory after 1.2 seconds
                    setTimeout(() => {
                        window.location.href = 'doctormanagement.php';
                    }, 1200);
                } else {
                    alert("Failed to save doctor to database: " + (res.message || "Unknown error"));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `Onboard Clinician`;
                }
            } catch (err) {
                console.error("Save doctor API error:", err);
                alert("Error connecting to database. Please make sure MySQL is running in XAMPP.");
                submitBtn.disabled = false;
                submitBtn.innerHTML = `Onboard Clinician`;
            }
        }

        // Reset real-time ID Badge Preview to baseline state
        function resetBadgePreview() {
            document.getElementById('preview-name').innerText = "Dr. Full Name";
            document.getElementById('preview-avatar').innerText = "??";
            document.getElementById('preview-specialty').innerText = "Specialization";
            document.getElementById('preview-npi').innerText = "NPI-0000000000";
            document.getElementById('preview-shift').innerText = "Morning Shift (06:00 - 14:00)";
            
            // Reset custom country code container and inputs
            document.getElementById('custom-country-code-container').classList.add('hidden');
            document.getElementById('form-custom-country-code').removeAttribute('required');
            document.getElementById('form-phone').placeholder = "e.g. 98765 43210";
        }

        // Animate and trigger success toast notification popup
        function launchToast() {
            const toast = document.getElementById('toastNotification');
            
            // Pop up
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Slide back out of view after 3.5 seconds
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

        // Simulated Logout prompt
        function logout() {
            if (confirm("Confirm session termination and return to main screen?")) {
                window.location.href = "admin_login.php";
            }
        }
    </script>
</body>
</html>
