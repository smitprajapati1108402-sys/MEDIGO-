<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Contact Directory Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->

    <style>
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
            <div class="dropdown" id="settingsDropdown">
                <button class="nav-btn" onclick="toggleDropdown('settingsMenu', event)">
                    Settings <i class="fa-solid fa-gear"></i>
                </button>
                <div class="dropdown-content" id="settingsMenu">
                    <a href="Seeting.php"><i class="fa-solid fa-sliders"></i> Hospital Settings</a>
                </div>
            </div>

            <a href="contact.php" class="nav-item-link active">Contact</a>
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
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Staff & Emergency Contacts</h2>
                <p class="text-xs text-slate-500">Directory of on-duty clinicians, administrative leads, and medical support staff.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="add_contact.php" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                    <i class="fa-solid fa-user-plus text-xs"></i> Add Contact
                </a>
            </div>
        </header>

        <!-- Dashboard Workspace -->
        <div class="p-6 space-y-6 max-w-[1400px] mx-auto w-full">
            
            <!-- Quick Stat Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Directory</span>
                        <span id="stat-total" class="text-2xl font-black text-slate-900 block mt-1">0</span>
                    </div>
                    <div class="bg-indigo-50 text-indigo-600 p-3 rounded-lg"><i class="fa-solid fa-users text-lg"></i></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Currently On-Duty</span>
                        <span id="stat-onduty" class="text-2xl font-black text-emerald-600 block mt-1">0</span>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-3 rounded-lg"><i class="fa-solid fa-user-clock text-lg"></i></div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Off-Duty / Standby</span>
                        <span id="stat-offduty" class="text-2xl font-black text-slate-500 block mt-1">0</span>
                    </div>
                    <div class="bg-slate-100 text-slate-500 p-3 rounded-lg"><i class="fa-solid fa-moon text-lg"></i></div>
                </div>
            </div>

            <!-- Directory Controls -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Filter Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
                    <button onclick="filterContacts('all')" id="filter-all" class="px-3.5 py-1.5 text-xs font-bold rounded-lg bg-slate-900 text-white transition-colors">All Staff</button>
                    <button onclick="filterContacts('clinical')" id="filter-clinical" class="px-3.5 py-1.5 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Clinical Staff</button>
                    <button onclick="filterContacts('administration')" id="filter-administration" class="px-3.5 py-1.5 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Administration</button>
                    <button onclick="filterContacts('support')" id="filter-support" class="px-3.5 py-1.5 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Support Services</button>
                </div>
                <!-- Search Box -->
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="contactSearch" onkeyup="searchContacts()" placeholder="Search staff name, pager, department..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Contacts Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="contactsGrid">
                <!-- Dynamically populated via JavaScript -->
            </div>

        </div>
    </main>

    <!-- Modal: View Detailed Profile -->
    <div id="viewContactModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <div id="modal-avatar" class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg"></div>
                    <div>
                        <h3 id="modal-name" class="font-bold text-slate-900 text-base"></h3>
                        <p id="modal-role" class="text-xs text-slate-500 font-semibold"></p>
                    </div>
                </div>
                <button onclick="toggleModal('viewContactModal')" class="text-slate-400 hover:text-slate-600 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6 space-y-4 text-sm text-slate-700">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Department / Team</span>
                        <span id="modal-dept" class="font-semibold text-slate-800"></span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Current Status</span>
                        <span id="modal-status-badge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold mt-0.5"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-xs text-slate-400 font-medium block">Primary Pager / Mobile</span>
                        <span id="modal-phone" class="font-mono font-semibold text-slate-800"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-xs text-slate-400 font-medium block">Institutional Email</span>
                        <span id="modal-email" class="font-mono font-semibold text-indigo-600"></span>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 bg-slate-50 flex gap-2 justify-end">
                <a id="modal-email-btn" href="#" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-4 py-2 rounded-lg text-xs transition-colors"><i class="fa-regular fa-envelope mr-1"></i> Send Email</a>
                <a id="modal-call-btn" href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition-colors"><i class="fa-solid fa-phone mr-1"></i> Dial Pager</a>
            </div>
        </div>
    </div>

    <!-- Modal: Add New Contact Form -->
    <div id="addContactModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Register Staff Contact</h3>
                <button onclick="toggleModal('addContactModal')" class="text-slate-400 hover:text-slate-600 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="newContactForm" onsubmit="submitNewContact(event)" class="p-6 space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Full Name</label>
                    <input type="text" required id="form-name" placeholder="e.g. Dr. Arthur Pendelton" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Roster Role / Title</label>
                        <input type="text" required id="form-role" placeholder="e.g. Head of Cardiology" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Department Sector</label>
                        <select required id="form-dept" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                            <option value="clinical">Clinical Staff</option>
                            <option value="administration">Administration</option>
                            <option value="support">Support Services</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Pager / Ext Number</label>
                        <input type="text" required id="form-phone" placeholder="e.g. +1 (555) 019-2810" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                        <input type="email" required id="form-email" placeholder="e.g. a.pendelton@clinic.org" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Shift On-Duty Status</label>
                    <select required id="form-status" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        <option value="on-duty">On-Duty / Active</option>
                        <option value="off-duty">Off-Duty / Standby</option>
                    </select>
                </div>
                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('addContactModal')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs transition-colors">Cancel</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs transition-colors">Save Contact</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Interface Script Section -->
    <script>
        // Core Contact State Memory
        let contacts = [
            {
                id: 1,
                name: "Dr. Sarah Jenkins",
                role: "Chief Pulmonologist",
                dept: "clinical",
                deptName: "Clinical Staff",
                email: "s.jenkins@hospital.org",
                phone: "+1 (555) 019-2834",
                status: "on-duty",
                avatar: "SJ",
                color: "bg-blue-600"
            },
            {
                id: 2,
                name: "Marcus Vance",
                role: "Emergency Room Lead",
                dept: "clinical",
                deptName: "Clinical Staff",
                email: "m.vance@hospital.org",
                phone: "+1 (555) 014-9821",
                status: "on-duty",
                avatar: "MV",
                color: "bg-rose-600"
            },
            {
                id: 3,
                name: "Rita Glass",
                role: "Chief Pharmacist",
                dept: "support",
                deptName: "Support Services",
                email: "r.glass@hospital.org",
                phone: "+1 (555) 017-4830",
                status: "off-duty",
                avatar: "RG",
                color: "bg-emerald-600"
            },
            {
                id: 4,
                name: "Julian Kovic",
                role: "Lead Radiologist",
                dept: "clinical",
                deptName: "Clinical Staff",
                email: "j.kovic@hospital.org",
                phone: "+1 (555) 011-3849",
                status: "on-duty",
                avatar: "JK",
                color: "bg-indigo-600"
            },
            {
                id: 5,
                name: "Arthur Pendelton",
                role: "Chief Operational Officer",
                dept: "administration",
                deptName: "Administration",
                email: "a.pendelton@hospital.org",
                phone: "+1 (555) 010-9932",
                status: "on-duty",
                avatar: "AP",
                color: "bg-amber-600"
            },
            {
                id: 6,
                name: "Liza Sterling",
                role: "Clinical Nurse Manager",
                dept: "clinical",
                deptName: "Clinical Staff",
                email: "l.sterling@hospital.org",
                phone: "+1 (555) 016-8314",
                status: "off-duty",
                avatar: "LS",
                color: "bg-purple-600"
            }
        ];

        let activeFilter = 'all';

        // Load the initial roster on launch directly from MySQL Database
        document.addEventListener("DOMContentLoaded", async () => {
            await loadContactsFromDb();
        });

        async function loadContactsFromDb() {
            try {
                const response = await fetch('api.php?action=get_contacts');
                const result = await response.json();
                if (result && result.status === 'success' && result.data && result.data.length > 0) {
                    const bgClasses = ['bg-blue-600', 'bg-rose-600', 'bg-emerald-600', 'bg-indigo-600', 'bg-purple-600', 'bg-amber-600'];
                    contacts = result.data.map((c, i) => {
                        const initials = c.name.replace("Dr. ", "").split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        return {
                            id: parseInt(c.id),
                            name: c.name,
                            role: c.subject || 'Staff Member',
                            dept: 'clinical',
                            deptName: c.subject || 'Clinical Staff',
                            email: c.email || 'staff@medigo.com',
                            phone: c.phone || '+91 98765 43210',
                            status: 'on-duty',
                            avatar: initials,
                            color: bgClasses[i % bgClasses.length]
                        };
                    });
                }
            } catch (err) {
                console.warn('Using fallback contacts list:', err);
            }
            renderContacts();
        }

        // Toggle Modal Displays
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        // Render Cards and Update Stat Counters
        function renderContacts(filterType = 'all', searchQuery = '') {
            const grid = document.getElementById('contactsGrid');
            grid.innerHTML = '';

            // Filter down database based on search query and tabs
            const filtered = contacts.filter(item => {
                const matchesFilter = filterType === 'all' || item.dept === filterType;
                const matchesSearch = (item.name + " " + item.role + " " + item.deptName).toLowerCase().includes(searchQuery.toLowerCase());
                return matchesFilter && matchesSearch;
            });

            // Update Statistics Counters
            document.getElementById('stat-total').innerText = contacts.length;
            document.getElementById('stat-onduty').innerText = contacts.filter(c => c.status === 'on-duty').length;
            document.getElementById('stat-offduty').innerText = contacts.filter(c => c.status === 'off-duty').length;

            if (filtered.length === 0) {
                grid.className = "flex justify-center items-center py-12 w-full col-span-full";
                grid.innerHTML = `
                    <div class="text-center">
                        <i class="fa-solid fa-address-book text-4xl text-slate-200 mb-3 block"></i>
                        <span class="text-sm font-bold text-slate-400">No contacts match the active filters.</span>
                    </div>
                `;
                return;
            } else {
                // Ensure proper layout wrapping is restored
                grid.className = "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6";
            }

            // Generate Contact Card elements
            filtered.forEach(item => {
                const isOnline = item.status === 'on-duty';
                const statusText = isOnline ? 'On-Duty' : 'Off-Duty / Standby';
                const dotColor = isOnline ? 'bg-emerald-500' : 'bg-slate-300';

                const card = document.createElement('div');
                card.className = "bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative flex flex-col justify-between";
                card.innerHTML = `
                    <div>
                        <!-- Status indicator dot top right -->
                        <span class="absolute top-4 right-4 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full ${isOnline ? 'bg-emerald-400 opacity-75' : 'bg-slate-300'}"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 ${dotColor}"></span>
                        </span>

                        <!-- Profile Info Summary -->
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm ${item.color}">
                                ${item.avatar}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm truncate max-w-[140px]">${item.name}</h4>
                                <p class="text-[11px] text-slate-400 font-semibold truncate max-w-[140px]">${item.role}</p>
                            </div>
                        </div>

                        <!-- Mini Details -->
                        <div class="space-y-2 border-t border-slate-100 pt-3 text-xs text-slate-600">
                            <p class="truncate"><i class="fa-regular fa-envelope text-slate-400 w-4"></i> ${item.email}</p>
                            <p class="font-mono"><i class="fa-solid fa-phone text-slate-400 w-4"></i> ${item.phone}</p>
                            <p class="font-semibold text-[10px]"><i class="fa-solid fa-hospital-user text-slate-400 w-4"></i> ${item.deptName}</p>
                        </div>
                    </div>

                    <!-- Card Action Footer -->
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">${statusText}</span>
                        <button onclick="viewProfile(${item.id})" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-1">
                            Full Profile <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Search Interface Key Listener
        function searchContacts() {
            const query = document.getElementById('contactSearch').value;
            renderContacts(activeFilter, query);
        }

        // Category Tab Switch Trigger
        function filterContacts(category) {
            activeFilter = category;

            // Reset tab styling elements
            const tabs = ['all', 'clinical', 'administration', 'support'];
            tabs.forEach(tab => {
                const el = document.getElementById(`filter-${tab}`);
                if (tab === category) {
                    el.className = "px-3.5 py-1.5 text-xs font-bold rounded-lg bg-slate-900 text-white transition-colors";
                } else {
                    el.className = "px-3.5 py-1.5 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors";
                }
            });

            const query = document.getElementById('contactSearch').value;
            renderContacts(activeFilter, query);
        }

        // Pop Open Detailed Profile Modal
        function viewProfile(id) {
            const contact = contacts.find(c => c.id === id);
            if (!contact) return;

            const isOnline = contact.status === 'on-duty';

            document.getElementById('modal-name').innerText = contact.name;
            document.getElementById('modal-role').innerText = contact.role;
            document.getElementById('modal-dept').innerText = contact.deptName;
            document.getElementById('modal-phone').innerText = contact.phone;
            document.getElementById('modal-email').innerText = contact.email;

            // Set Email/Call href action properties
            document.getElementById('modal-email-btn').setAttribute('href', `mailto:${contact.email}`);
            document.getElementById('modal-call-btn').setAttribute('href', `tel:${contact.phone}`);

            // Construct Avatar design elements
            const av = document.getElementById('modal-avatar');
            av.innerText = contact.avatar;
            av.className = `w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg ${contact.color}`;

            // Handle badge styles
            const badge = document.getElementById('modal-status-badge');
            badge.innerText = isOnline ? 'On-Duty' : 'Off-Duty';
            badge.className = `inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1 ${isOnline ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-800'}`;

            toggleModal('viewContactModal');
        }

        // Add New Contact to State and Database
        async function submitNewContact(event) {
            event.preventDefault();

            const name = document.getElementById('form-name').value;
            const role = document.getElementById('form-role').value;
            const dept = document.getElementById('form-dept').value;
            const phone = document.getElementById('form-phone').value;
            const email = document.getElementById('form-email').value;
            const status = document.getElementById('form-status').value;

            // Map UI selectors to clean descriptions
            let deptName = "Clinical Staff";
            if (dept === 'administration') deptName = "Administration";
            else if (dept === 'support') deptName = "Support Services";

            const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            const bgClasses = ['bg-blue-600', 'bg-rose-600', 'bg-emerald-600', 'bg-indigo-600', 'bg-purple-600', 'bg-amber-600'];
            const randomColor = bgClasses[Math.floor(Math.random() * bgClasses.length)];

            try {
                const response = await fetch('api.php?action=add_contact', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone: phone,
                        subject: role,
                        message: `Department: ${deptName}, Status: ${status}`
                    })
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    await loadContactsFromDb();
                } else {
                    contacts.push({
                        id: Date.now(),
                        name: name,
                        role: role,
                        dept: dept,
                        deptName: deptName,
                        email: email,
                        phone: phone,
                        status: status,
                        avatar: initials,
                        color: randomColor
                    });
                }
            } catch (err) {
                contacts.push({
                    id: Date.now(),
                    name: name,
                    role: role,
                    dept: dept,
                    deptName: deptName,
                    email: email,
                    phone: phone,
                    status: status,
                    avatar: initials,
                    color: randomColor
                });
            }

            // Reset UI inputs and clear modal state
            document.getElementById('newContactForm').reset();
            toggleModal('addContactModal');

            // Force visual list reload matching active selections
            renderContacts(activeFilter, document.getElementById('contactSearch').value);
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
