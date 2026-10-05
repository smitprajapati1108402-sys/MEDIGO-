<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Performance Analytics Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
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
            <div class="dropdown active" id="resourcesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('resourcesMenu', event)">
                    Resources <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="resourcesMenu">
                    <a href="hospitalreport.php" class="active"><i class="fa-solid fa-chart-line"></i> Hospital Reports</a>
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

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col">
        <!-- Top Navigation / Header -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Hospital Performance Dashboard</h2>
                <p class="text-sm text-slate-500">Overview of operational efficiency and patient care statistics.</p>
            </div>
            <!-- Header Controls -->
            <div class="flex items-center gap-4">
                <button onclick="updateDashboardData()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                    <i class="fa-solid fa-rotate"></i> Refresh Data
                </button>
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-semibold border border-slate-300">
                    AD
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-6 space-y-6 max-w-[1600px] mx-auto w-full">
            
            <!-- KPI Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-sm font-medium text-slate-500 block">Total Active Patients</span>
                        <span id="kpi-patients" class="text-3xl font-bold text-slate-900 block mt-1">342</span>
                        <span class="text-xs font-semibold text-emerald-600 mt-2 inline-flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up"></i> 12% vs last week
                        </span>
                    </div>
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl">
                        <i class="fa-solid fa-hospital-user text-2xl"></i>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-sm font-medium text-slate-500 block">Bed Occupancy Rate</span>
                        <span id="kpi-occupancy" class="text-3xl font-bold text-slate-900 block mt-1">78.5%</span>
                        <span class="text-xs font-semibold text-emerald-600 mt-2 inline-flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up"></i> 2.4% vs last week
                        </span>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl">
                        <i class="fa-solid fa-bed text-2xl"></i>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-sm font-medium text-slate-500 block">Avg. ER Wait Time</span>
                        <span id="kpi-wait-time" class="text-3xl font-bold text-slate-900 block mt-1">18 mins</span>
                        <span class="text-xs font-semibold text-rose-600 mt-2 inline-flex items-center gap-1">
                            <i class="fa-solid fa-arrow-down"></i> -4 mins vs yesterday
                        </span>
                    </div>
                    <div class="bg-amber-50 text-amber-600 p-4 rounded-xl">
                        <i class="fa-regular fa-clock text-2xl"></i>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-sm font-medium text-slate-500 block">Patient Satisfaction</span>
                        <span id="kpi-satisfaction" class="text-3xl font-bold text-slate-900 block mt-1">4.7 / 5.0</span>
                        <span class="text-xs font-semibold text-emerald-600 mt-2 inline-flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up"></i> 0.3% improvement
                        </span>
                    </div>
                    <div class="bg-purple-50 text-purple-600 p-4 rounded-xl">
                        <i class="fa-regular fa-face-smile text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Admissions & Discharges (Line Chart) -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">Patient Flow Overview</h3>
                            <p class="text-xs text-slate-500">Admissions and discharges comparison for the current week</p>
                        </div>
                        <select class="border border-slate-200 text-xs font-medium text-slate-600 px-3 py-1.5 rounded-lg bg-slate-50 focus:outline-none">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    <div class="h-80 w-full">
                        <canvas id="flowChart"></canvas>
                    </div>
                </div>

                <!-- Patients by Department (Doughnut Chart) -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="mb-4">
                        <h3 class="font-bold text-slate-900 text-lg">Department Allocation</h3>
                        <p class="text-xs text-slate-500">Current active cases grouped by department</p>
                    </div>
                    <div class="h-64 w-full relative flex items-center justify-center">
                        <canvas id="deptChart"></canvas>
                    </div>
                    <div class="mt-4 border-t border-slate-100 pt-4 flex justify-between text-xs text-slate-500">
                        <span>Total Tracked: <strong id="dept-total" class="text-slate-800">342 Patients</strong></span>
                        <a href="#" class="text-blue-600 hover:underline">View details</a>
                    </div>
                </div>
            </div>

            <!-- Table Section: Operational Overview -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg">Departmental Operational Status</h3>
                        <p class="text-xs text-slate-500">Real-time capacity and average wait-times across core departments</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </span>
                            <input type="text" id="tableSearch" onkeyup="filterTable()" placeholder="Search department..." class="pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white w-full sm:w-64">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="statusTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                <th class="py-4 px-6">Department</th>
                                <th class="py-4 px-6">Occupancy Rate</th>
                                <th class="py-4 px-6">Staff on Duty</th>
                                <th class="py-4 px-6">Avg Wait Time</th>
                                <th class="py-4 px-6">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <!-- Emergency -->
                            <tr>
                                <td class="py-4 px-6 font-semibold text-slate-950">Emergency Room (ER)</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                            <div class="bg-red-500 h-full w-[92%]"></div>
                                        </div>
                                        <span class="font-medium text-xs text-slate-500">92%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">24/30 Doctors/Nurses</td>
                                <td class="py-4 px-6">18 mins</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> High Load
                                    </span>
                                </td>
                            </tr>
                            <!-- Cardiology -->
                            <tr>
                                <td class="py-4 px-6 font-semibold text-slate-950">Cardiology</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                            <div class="bg-amber-500 h-full w-[78%]"></div>
                                        </div>
                                        <span class="font-medium text-xs text-slate-500">78%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">15/18 Doctors/Nurses</td>
                                <td class="py-4 px-6">12 mins</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Normal-Busy
                                    </span>
                                </td>
                            </tr>
                            <!-- ICU -->
                            <tr>
                                <td class="py-4 px-6 font-semibold text-slate-950">Intensive Care Unit (ICU)</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full w-[65%]"></div>
                                        </div>
                                        <span class="font-medium text-xs text-slate-500">65%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">12/12 Doctors/Nurses</td>
                                <td class="py-4 px-6">N/A</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stable
                                    </span>
                                </td>
                            </tr>
                            <!-- Pediatrics -->
                            <tr>
                                <td class="py-4 px-6 font-semibold text-slate-950">Pediatrics</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                                            <div class="bg-emerald-500 h-full w-[45%]"></div>
                                        </div>
                                        <span class="font-medium text-xs text-slate-500">45%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">10/15 Doctors/Nurses</td>
                                <td class="py-4 px-6">8 mins</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stable
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Interactive JS Functionality -->
    <script>
        // Global references to Chart objects to allow updates
        let flowChart, deptChart;

        // Initialize charts when DOM is fully loaded
        document.addEventListener("DOMContentLoaded", () => {
            initFlowChart();
            initDeptChart();
        });

        // Patient Flow Line Chart Configuration
        function initFlowChart() {
            const ctx = document.getElementById('flowChart').getContext('2d');
            flowChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [
                        {
                            label: 'Admissions',
                            data: [65, 78, 72, 89, 84, 62, 70],
                            borderColor: '#2563eb', // Blue
                            backgroundColor: 'rgba(37, 99, 235, 0.05)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2
                        },
                        {
                            label: 'Discharges',
                            data: [52, 68, 79, 74, 88, 70, 64],
                            borderColor: '#0d9488', // Teal
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Department Allocation Doughnut Chart Configuration
        function initDeptChart() {
            const ctx = document.getElementById('deptChart').getContext('2d');
            deptChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Emergency', 'Cardiology', 'ICU', 'Pediatrics', 'General Ward'],
                    datasets: [{
                        data: [120, 65, 45, 52, 60],
                        backgroundColor: [
                            '#ef4444', // Red (Emergency)
                            '#f59e0b', // Amber (Cardiology)
                            '#06b6d4', // Cyan (ICU)
                            '#10b981', // Emerald (Pediatrics)
                            '#6366f1'  // Indigo (General Ward)
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: { size: 11 }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // Feature: Simulated dynamic refresh of dashboard statistics
        function updateDashboardData() {
            // Randomly update KPI values to demonstrate dynamic UI updates
            const newPatients = Math.floor(Math.random() * (400 - 280) + 280);
            const newOccupancy = (Math.random() * (95 - 65) + 65).toFixed(1);
            const newWaitTime = Math.floor(Math.random() * (25 - 10) + 10);
            const newSatisfaction = (Math.random() * (5.0 - 4.2) + 4.2).toFixed(1);

            document.getElementById('kpi-patients').innerText = newPatients;
            document.getElementById('kpi-occupancy').innerText = `${newOccupancy}%`;
            document.getElementById('kpi-wait-time').innerText = `${newWaitTime} mins`;
            document.getElementById('kpi-satisfaction').innerText = `${newSatisfaction} / 5.0`;
            document.getElementById('dept-total').innerText = `${newPatients} Patients`;

            // Randomize Admissions / Discharges Chart data
            flowChart.data.datasets[0].data = Array.from({length: 7}, () => Math.floor(Math.random() * (95 - 50) + 50));
            flowChart.data.datasets[1].data = Array.from({length: 7}, () => Math.floor(Math.random() * (95 - 50) + 50));
            flowChart.update();

            // Randomize Department chart allocation proportionally matching total active patients
            let remaining = newPatients;
            const values = [];
            for (let i = 0; i < 4; i++) {
                const part = Math.floor(Math.random() * (remaining * 0.3));
                values.push(part);
                remaining -= part;
            }
            values.push(remaining); // Remaining patients placed in last category

            deptChart.data.datasets[0].data = values;
            deptChart.update();
        }

        // Feature: Filter rows in the Departmental table dynamically based on input
        function filterTable() {
            const input = document.getElementById("tableSearch");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("statusTable");
            const tr = table.getElementsByTagName("tr");

            // Loop through all table rows (ignoring header), hide those that do not match the query
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    const textValue = td.textContent || td.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
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
