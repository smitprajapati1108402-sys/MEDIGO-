<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Information & Directory Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
            <div class="dropdown active" id="aboutDropdown">
                <button class="nav-btn" onclick="toggleDropdown('aboutMenu', event)">
                    About <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="aboutMenu">
                    <a href="Hospital_informatio.php" class="active"><i class="fa-solid fa-circle-info"></i> Hospital Information</a>
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
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Hospital Information Center</h2>
                <p class="text-xs text-slate-500">Live directory, inventory resources, and real-time operations overview.</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="toggleModal('broadcastModal')" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                    <i class="fa-solid fa-bullhorn text-xs"></i> Post Live Notice
                </button>
            </div>
        </header>

        <!-- Main Dashboard Body -->
        <div class="p-6 space-y-6 max-w-[1500px] mx-auto w-full">
            
            <!-- Operational Level Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Status Card 1: Emergency Level -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Emergency Status</span>
                        <span class="text-xl font-black text-emerald-600 block mt-1">NORMAL (Level 1)</span>
                        <span class="text-[10px] text-slate-500 block mt-1">No active diversions in place</span>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-3 rounded-lg">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>
                </div>

                <!-- Status Card 2: Bed Capacity -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Facility Capacity</span>
                        <span class="text-xl font-black text-slate-900 block mt-1">284 / 350 <span class="text-xs font-normal text-slate-500">Beds</span></span>
                        <span class="text-[10px] text-amber-600 font-semibold block mt-1"><i class="fa-solid fa-triangle-exclamation"></i> 81.1% Occupancy</span>
                    </div>
                    <div class="bg-indigo-50 text-indigo-600 p-3 rounded-lg">
                        <i class="fa-solid fa-bed text-lg"></i>
                    </div>
                </div>

                <!-- Status Card 3: Blood Reserves -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Blood Bank Reserves</span>
                        <span class="text-xl font-black text-slate-900 block mt-1">94% Capacity</span>
                        <span class="text-[10px] text-emerald-600 font-semibold block mt-1"><i class="fa-solid fa-circle-check"></i> Stock levels optimal</span>
                    </div>
                    <div class="bg-rose-50 text-rose-600 p-3 rounded-lg">
                        <i class="fa-solid fa-droplet text-lg"></i>
                    </div>
                </div>

                <!-- Status Card 4: On-Duty Staff -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Staff Count On-Duty</span>
                        <span class="text-xl font-black text-slate-900 block mt-1">142 <span class="text-xs font-normal text-slate-500">Clinicians</span></span>
                        <span class="text-[10px] text-slate-500 block mt-1">8 Doctors, 134 Caregivers</span>
                    </div>
                    <div class="bg-blue-50 text-blue-600 p-3 rounded-lg">
                        <i class="fa-solid fa-user-doctor text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Two Column Overview: Resource Reserves & Live System Notices -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Critical Resource Reserves (2 Columns on Large Screens) -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm lg:col-span-2 space-y-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Key Resource Reserves</h3>
                        <p class="text-xs text-slate-500">High-level overview of life-support and emergency stock tracking.</p>
                    </div>
                    <!-- Inventory Bar Grid -->
                    <div class="space-y-4 pt-2">
                        <!-- Resource Item 1 -->
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                                <span>Medical Oxygen (Liquid Cylinders)</span>
                                <span>180 / 200 Units (90%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-full w-[90%]"></div>
                            </div>
                        </div>
                        <!-- Resource Item 2 -->
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                                <span>Ventilators (Active in ICU / Total Reserve)</span>
                                <span>14 / 35 Available (40%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full w-[40%]"></div>
                            </div>
                        </div>
                        <!-- Resource Item 3 -->
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                                <span>Disposable Medical Gloves & PPE Kits</span>
                                <span>12,500 / 15,000 Boxes (83%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-[83%]"></div>
                            </div>
                        </div>
                        <!-- Resource Item 4 -->
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                                <span>Cardiac Defibrillators</span>
                                <span>28 / 30 Units (93%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-[93%]"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Broadcast Notices Panel -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-base">Live Notices</h3>
                                <p class="text-xs text-slate-500">Urgent facility or staff broadcasts.</p>
                            </div>
                            <span class="animate-pulse flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                        </div>
                        <!-- Scrollable Notices List -->
                        <div class="space-y-3 max-h-56 overflow-y-auto pr-1" id="broadcastContainer">
                            <!-- JS will populate these lists dynamically -->
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 mt-4 text-center">
                        <button onclick="toggleModal('broadcastModal')" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                            <i class="fa-solid fa-plus mr-1"></i> Post Announcement
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table: Central Department Contact Directory -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg">Hospital Department Contact Directory</h3>
                        <p class="text-xs text-slate-500">Live communication endpoints, physical locations, and unit leads.</p>
                    </div>
                    <!-- Search Input -->
                    <div class="relative w-full md:w-80">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" id="directorySearch" onkeyup="searchDirectory()" placeholder="Search departments, leads, location..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                    </div>
                </div>
                <!-- Contacts Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="directoryTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                <th class="py-4 px-6">Department Name</th>
                                <th class="py-4 px-6">Internal Extension</th>
                                <th class="py-4 px-6">Department Lead</th>
                                <th class="py-4 px-6">Physical Location</th>
                                <th class="py-4 px-6">Current Operational State</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700" id="directoryBody">
                            <!-- JS will generate table rows dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal: Add Live Notice / System Broadcast -->
    <div id="broadcastModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">Post System Notice</h3>
                <button onclick="toggleModal('broadcastModal')" class="text-slate-400 hover:text-slate-600 transition-colors text-lg"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="newBroadcastForm" onsubmit="submitBroadcast(event)" class="p-6 space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Notice Priority Level</label>
                    <select required id="form-priority" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        <option value="critical">Critical (Red Flag)</option>
                        <option value="warning">Warning (Amber Flag)</option>
                        <option value="info">General Information (Blue Flag)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Notice Message</label>
                    <textarea id="form-message" required rows="3" placeholder="Enter instructions, maintenance briefs, or shift alert messages..." class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"></textarea>
                </div>
                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('broadcastModal')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-xs transition-colors">Cancel</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg text-xs transition-colors">Post Notice</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Script File -->
    <script>
        // Core Memory Storage
        let broadcasts = [
            {
                id: 1,
                priority: "critical",
                time: "10:30 AM",
                message: "CT Scanner Suite 2 undergoing scheduled emergency software maintenance until 13:00 today."
            },
            {
                id: 2,
                priority: "warning",
                time: "09:15 AM",
                message: "High Patient Volume reported in the ER clinic. Non-urgent cases are experiencing extended wait-times."
            },
            {
                id: 3,
                priority: "info",
                time: "08:45 AM",
                message: "Blood collection drive open until Friday at Wing B Atrium. Staff donations welcomed."
            }
        ];

        const directory = [
            { name: "Emergency Department", extension: "Ext 4911", lead: "Dr. Marcus Vance", location: "Wing A, Floor 1", status: "Active", statusClass: "bg-emerald-100 text-emerald-800" },
            { name: "Cardiology", extension: "Ext 4022", lead: "Dr. Elena Rostova", location: "Wing B, Floor 3", status: "Active", statusClass: "bg-emerald-100 text-emerald-800" },
            { name: "Radiology & Imaging", extension: "Ext 4310", lead: "Dr. Julian Kovic", location: "Wing A, Floor 1", status: "Partial Capacity", statusClass: "bg-amber-100 text-amber-800" },
            { name: "Pediatrics Clinic", extension: "Ext 4150", lead: "Dr. Sarah Jenkins", location: "Wing C, Floor 2", status: "Active", statusClass: "bg-emerald-100 text-emerald-800" },
            { name: "Intensive Care Unit (ICU)", extension: "Ext 4800", lead: "Dr. Katherine Vance", location: "Wing B, Floor 2", status: "High Occupancy", statusClass: "bg-red-100 text-red-800" },
            { name: "Oncology Department", extension: "Ext 4490", lead: "Dr. Alan Mercer", location: "Wing D, Floor 4", status: "Active", statusClass: "bg-emerald-100 text-emerald-800" },
            { name: "Pharmacy Services", extension: "Ext 4210", lead: "PharmD. Rita Glass", location: "Lobby Level, Wing B", status: "Active", statusClass: "bg-emerald-100 text-emerald-800" }
        ];

        // Initialize dashboard state on load
        document.addEventListener("DOMContentLoaded", () => {
            loadHospitalInfoFromDb();
        });

        // Fetch Live Hospital Info and Broadcasts from MySQL Database (api.php)
        async function loadHospitalInfoFromDb() {
            try {
                const response = await fetch('api.php?action=get_hospital_info');
                const result = await response.json();
                if (result && result.status === 'success' && result.data) {
                    if (result.data.broadcasts && result.data.broadcasts.length > 0) {
                        broadcasts = result.data.broadcasts;
                    }
                    if (result.data.departments && result.data.departments.length > 0) {
                        directory.length = 0;
                        result.data.departments.forEach(dept => {
                            let statusClass = "bg-emerald-100 text-emerald-800";
                            if (dept.status === 'High Occupancy') statusClass = "bg-red-100 text-red-800";
                            else if (dept.status === 'Partial Capacity') statusClass = "bg-amber-100 text-amber-800";
                            
                            directory.push({
                                name: dept.name,
                                extension: dept.extension,
                                lead: dept.lead,
                                location: dept.location,
                                status: dept.status,
                                statusClass: statusClass
                            });
                        });
                    }
                }
            } catch (e) {
                console.warn("Using offline / fallback cache for hospital info:", e);
            }
            renderBroadcasts();
            renderDirectory();
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

        // Render Broadcasts List on UI
        function renderBroadcasts() {
            const container = document.getElementById('broadcastContainer');
            container.innerHTML = '';

            broadcasts.forEach(notice => {
                let borderTheme = "border-blue-200 bg-blue-50/50 text-blue-800";
                let icon = "fa-circle-info text-blue-500";

                if (notice.priority === "critical") {
                    borderTheme = "border-rose-200 bg-rose-50/50 text-rose-800";
                    icon = "fa-triangle-exclamation text-rose-500";
                } else if (notice.priority === "warning") {
                    borderTheme = "border-amber-200 bg-amber-50/50 text-amber-800";
                    icon = "fa-circle-exclamation text-amber-500";
                }

                const item = document.createElement('div');
                item.className = `p-3.5 rounded-lg border text-xs leading-relaxed flex gap-3 ${borderTheme}`;
                item.innerHTML = `
                    <span class="mt-0.5"><i class="fa-solid ${icon} text-sm"></i></span>
                    <div>
                        <div class="flex items-center justify-between font-bold mb-1">
                            <span class="uppercase tracking-wider text-[10px] opacity-80">${notice.priority} Notice</span>
                            <span class="opacity-60 text-[10px] font-medium"><i class="fa-regular fa-clock"></i> ${notice.time || 'Recent'}</span>
                        </div>
                        <p class="font-medium">${notice.message}</p>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        // Render Department Contacts Table List
        function renderDirectory(searchQuery = '') {
            const body = document.getElementById('directoryBody');
            body.innerHTML = '';

            const filtered = directory.filter(entry => {
                const searchStr = (entry.name + " " + entry.lead + " " + entry.location).toLowerCase();
                return searchStr.includes(searchQuery.toLowerCase());
            });

            if (filtered.length === 0) {
                body.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-8 text-center text-sm font-semibold text-slate-400">
                            No matching departments found in directory.
                        </td>
                    </tr>
                `;
                return;
            }

            filtered.forEach(entry => {
                const row = document.createElement('tr');
                row.className = "hover:bg-slate-50 transition-colors";
                row.innerHTML = `
                    <td class="py-4 px-6 font-bold text-slate-900">${entry.name}</td>
                    <td class="py-4 px-6 font-mono text-xs font-semibold text-indigo-600">${entry.extension}</td>
                    <td class="py-4 px-6 font-medium text-slate-700">${entry.lead}</td>
                    <td class="py-4 px-6 text-xs text-slate-500 font-medium">${entry.location}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ${entry.statusClass}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span> ${entry.status}
                        </span>
                    </td>
                `;
                body.appendChild(row);
            });
        }

        // Directory Live Filtering Interface Function
        function searchDirectory() {
            const query = document.getElementById('directorySearch').value;
            renderDirectory(query);
        }

        // Submit and Render custom notice event (Saves to MySQL)
        async function submitBroadcast(event) {
            event.preventDefault();

            const priority = document.getElementById('form-priority').value;
            const message = document.getElementById('form-message').value;

            // Generate time string
            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const newNotice = {
                priority: priority,
                time: timeStr,
                message: message
            };

            // Post to MySQL Database via api.php
            try {
                const response = await fetch('api.php?action=add_broadcast', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newNotice)
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    broadcasts.unshift(newNotice);
                } else {
                    broadcasts.unshift(newNotice);
                }
            } catch (err) {
                broadcasts.unshift(newNotice);
            }
            
            // Clean interface fields and hide modal
            document.getElementById('newBroadcastForm').reset();
            toggleModal('broadcastModal');

            // Render updated live elements
            renderBroadcasts();
        }

        // Toggle mobile menu visibility
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
