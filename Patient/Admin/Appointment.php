<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management Dashboard</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        body {
            font-family: 'Poppins', sans-serif;
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

<body class="bg-gray-50 text-gray-800 min-h-screen">

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
                    <a href="patientmanagement.php"><i class="fa-solid fa-user-injured"></i> Patient Management</a>
                    <a href="Appointment.php" class="active"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white p-2.5 rounded-xl">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">CareSched</h1>
                    <p class="text-sm text-gray-500 mt-1">Appointment Management Portal</p>
                </div>
            </div>
            <!-- Action Controls: Date & Add Button -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <div class="flex items-center justify-center space-x-2 bg-gray-100 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 shadow-sm">
                    <i data-lucide="clock" class="w-4 h-4 text-gray-500"></i>
                    <span id="current-date-display">Today: June 1, 2026</span>
                </div>
                <a href="add_appointment.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-sm transition flex items-center justify-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Add Appointment
                </a>
            </div>
        </div>

        <!-- Metrics Section -->
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Booked</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1" id="stat-total">0</h3>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Confirmed</p>
                <h3 class="text-2xl font-bold text-green-700 mt-1" id="stat-confirmed">0</h3>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Pending Approval</p>
                <h3 class="text-2xl font-bold text-yellow-700 mt-1" id="stat-pending">0</h3>
            </div>
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cancelled</p>
                <h3 class="text-2xl font-bold text-gray-500 mt-1" id="stat-cancelled">0</h3>
            </div>
        </section>

        <!-- Main Layout -->
        <div class="w-full space-y-6">

            <!-- Filter and Search controls -->
            <div
                class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="relative w-full md:w-72">
                    <input type="text" id="search-bar" oninput="handleFilterAndSearch()"
                        placeholder="Search Doctor or Specialty..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                </div>

                <div class="flex items-center space-x-1 overflow-x-auto w-full md:w-auto">
                    <button onclick="setFilter('All')" id="filter-btn-All"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-gray-900 text-white transition">All</button>
                    <button onclick="setFilter('Confirmed')" id="filter-btn-Confirmed"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Confirmed</button>
                    <button onclick="setFilter('Pending')" id="filter-btn-Pending"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Pending</button>
                    <button onclick="setFilter('Cancelled')" id="filter-btn-Cancelled"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Cancelled</button>
                </div>
            </div>

            <!-- Appointment Cards List Container -->
            <div id="appointments-container" class="space-y-4">
                <!-- Cards will be dynamically injected here -->
            </div>

            <!-- Empty State Screen -->
            <div id="empty-state"
                class="hidden bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center">
                <div
                    class="bg-gray-50 text-gray-400 p-4 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="calendar-x" class="w-8 h-8"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900">No appointments found</h4>
                <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">Try adjusting your filters or search terms.</p>
            </div>

        </div>
    </main>

    <script>
        // Database State (Persistent Storage via localStorage)
        const defaultAppointments = [
            {
                id: 1,
                patient: "Arjun Sharma",
                doctor: "Dr. Raj Patel (Cardiology)",
                date: "2026-06-03",
                time: "10:00 AM",
                type: "In-person",
                reason: "Routine cardiovascular assessment & checkup.",
                status: "Confirmed"
            },
            {
                id: 2,
                patient: "Priya Verma",
                doctor: "Dr. Jane Smith (Neurology)",
                date: "2026-06-05",
                time: "02:30 PM",
                type: "Video Call",
                reason: "Follow-up consultation for migraine evaluation.",
                status: "Pending"
            },
            {
                id: 3,
                patient: "Rohan Gupta",
                doctor: "Dr. Robert Chen (Pediatrics)",
                date: "2026-06-10",
                time: "09:00 AM",
                type: "In-person",
                reason: "Annual physical wellness examination.",
                status: "Confirmed"
            },
            {
                id: 4,
                patient: "Rahul Sharma",
                doctor: "Dr. Marcus Vance (Emergency Medicine)",
                date: "2026-06-12",
                time: "11:30 AM",
                type: "In-person",
                reason: "Trauma recovery follow-up.",
                status: "Confirmed"
            }
        ];

        let appointments = JSON.parse(localStorage.getItem('appointments')) || defaultAppointments;
        let currentFilter = 'All';

        // Load appointments from MySQL Database
        async function loadAppointmentsFromDb() {
            try {
                const res = await fetch('api.php?action=get_appointments');
                const data = await res.json();
                if (data && data.status === 'success' && data.data && data.data.length > 0) {
                    appointments = data.data.map(a => ({
                        id: parseInt(a.id),
                        patient: a.patient_name,
                        doctor: a.doctor_name + (a.department ? ' (' + a.department + ')' : ''),
                        date: a.appointment_date,
                        time: a.appointment_time,
                        type: 'In-person',
                        reason: a.reason || 'General medical consultation',
                        status: a.status || 'Confirmed'
                    }));
                    localStorage.setItem('appointments', JSON.stringify(appointments));
                }
            } catch (err) {
                console.warn('Using local storage fallback for appointments:', err);
            }
            updateStats();
            renderAppointments();
        }

        // Initialize Icons & UI elements
        window.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            // Format dynamic date indicator
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date-display').innerText = `Today: ${new Date().toLocaleDateString('en-US', options)}`;

            loadAppointmentsFromDb();
        });

        // Function: Update Header KPI Stats
        function updateStats() {
            const total = appointments.length;
            const confirmed = appointments.filter(a => a.status === 'Confirmed').length;
            const pending = appointments.filter(a => a.status === 'Pending').length;
            const cancelled = appointments.filter(a => a.status === 'Cancelled').length;

            document.getElementById('stat-total').innerText = total;
            document.getElementById('stat-confirmed').innerText = confirmed;
            document.getElementById('stat-pending').innerText = pending;
            document.getElementById('stat-cancelled').innerText = cancelled;
        }

        // Function: Generate clean date label format
        function formatReadableDate(dateString) {
            const dateObj = new Date(dateString + 'T00:00:00'); // Prevent UTC local-shift
            return dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        // Function: Render appointments onto the list
        function renderAppointments() {
            const container = document.getElementById('appointments-container');
            const emptyState = document.getElementById('empty-state');
            const searchQuery = document.getElementById('search-bar').value.toLowerCase();

            // Filter appointments list based on state controls
            const filtered = appointments.filter(appt => {
                const matchesFilter = currentFilter === 'All' || appt.status === currentFilter;
                const matchesSearch = appt.doctor.toLowerCase().includes(searchQuery) ||
                    (appt.patient && appt.patient.toLowerCase().includes(searchQuery)) ||
                    appt.reason.toLowerCase().includes(searchQuery);
                return matchesFilter && matchesSearch;
            });

            if (filtered.length === 0) {
                container.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            container.classList.remove('hidden');
            emptyState.classList.add('hidden');

            container.innerHTML = filtered.map(appt => {
                // Status Color Styling Class assignment
                let statusBadgeClass = '';
                if (appt.status === 'Confirmed') statusBadgeClass = 'bg-green-50 text-green-700 border-green-200';
                else if (appt.status === 'Pending') statusBadgeClass = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                else if (appt.status === 'Cancelled') statusBadgeClass = 'bg-gray-100 text-gray-500 border-gray-200';

                // Check and style actions depending on state
                const isActionable = appt.status !== 'Cancelled';

                return `
                    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition duration-200 hover:shadow-md">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                    ${appt.status}
                                </span>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full font-medium flex items-center gap-1">
                                    <i data-lucide="${appt.type === 'In-person' ? 'map-pin' : 'video'}" class="w-3 h-3"></i>
                                    ${appt.type}
                                </span>
                            </div>

                            <h4 class="text-base font-bold text-gray-900">${appt.doctor} ${appt.patient ? `<span class="text-sm font-medium text-gray-500">• Patient: ${appt.patient}</span>` : ''}</h4>
                            
                            <p class="text-sm text-gray-500 max-w-md">${appt.reason || 'No description provided.'}</p>
                            
                            <div class="flex items-center gap-4 text-xs font-medium text-gray-500 pt-1">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                    ${formatReadableDate(appt.date)}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                                    ${appt.time}
                                </span>
                            </div>
                        </div>

                        ${isActionable ? `
                            <div class="flex items-center space-x-2 self-stretch md:self-auto pt-2 md:pt-0">
                                <button onclick="cancelAppointment(${appt.id})" class="flex-1 md:flex-none border border-red-200 text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg text-xs font-semibold transition duration-150 flex items-center justify-center gap-1.5">
                                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Cancel
                                </button>
                                ${appt.status === 'Pending' ? `
                                    <button onclick="approveAppointment(${appt.id})" class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition duration-150 flex items-center justify-center gap-1.5">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Confirm
                                    </button>
                                ` : ''}
                            </div>
                        ` : `
                            <div class="text-xs text-gray-400 italic font-medium">No actions available</div>
                        `}
                    </div>
                `;
            }).join('');

            // Repopulate dynamic icons
            lucide.createIcons();
        }

        // Function: Handle filter state changes and class updates
        function setFilter(filterType) {
            currentFilter = filterType;

            const filters = ['All', 'Confirmed', 'Pending', 'Cancelled'];
            filters.forEach(f => {
                const btn = document.getElementById(`filter-btn-${f}`);
                if (f === filterType) {
                    btn.className = "px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-gray-900 text-white transition";
                } else {
                    btn.className = "px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-100 transition";
                }
            });

            renderAppointments();
        }

        // Handle typing searches
        function handleFilterAndSearch() {
            renderAppointments();
        }

        // Action: Cancel Appointment in MySQL Database
        async function cancelAppointment(id) {
            try {
                await fetch('api.php?action=update_appointment_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, status: 'Cancelled' })
                });
            } catch (err) {
                console.warn('API error updating status:', err);
            }
            const apptIndex = appointments.findIndex(a => a.id === id);
            if (apptIndex > -1) {
                appointments[apptIndex].status = 'Cancelled';
                localStorage.setItem('appointments', JSON.stringify(appointments));
                updateStats();
                renderAppointments();
            }
        }

        // Action: Confirm / Approve Pending Appointment in MySQL Database
        async function approveAppointment(id) {
            try {
                await fetch('api.php?action=update_appointment_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, status: 'Confirmed' })
                });
            } catch (err) {
                console.warn('API error updating status:', err);
            }
            const apptIndex = appointments.findIndex(a => a.id === id);
            if (apptIndex > -1) {
                appointments[apptIndex].status = 'Confirmed';
                localStorage.setItem('appointments', JSON.stringify(appointments));
                updateStats();
                renderAppointments();
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
