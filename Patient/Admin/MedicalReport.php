<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Medical Record Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar styling for a clean layout */
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
            <div class="dropdown active" id="resourcesDropdown">
                <button class="nav-btn" onclick="toggleDropdown('resourcesMenu', event)">
                    Resources <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="dropdown-content" id="resourcesMenu">
                    <a href="hospitalreport.php"><i class="fa-solid fa-chart-line"></i> Hospital Reports</a>
                    <a href="MedicalReport.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Medical
                        Report</a>
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
            <a href="#" onclick="logout()"
                style="color: hsla(0, 100%, 65%, 0.979); font-weight: bold; margin-left: 10px;">Logout</a>
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
                <h2 class="text-xl font-bold text-slate-900">Patient File & Health Timeline</h2>
                <p class="text-xs text-slate-500">Centralized electronic health record storage and consultation history.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="Add_newentery.php"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i> New Entry
                </a>
            </div>
        </header>

        <!-- Main Dashboard Body -->
        <div class="p-6 space-y-6 max-w-[1400px] mx-auto w-full">

            <!-- Patient Demographics Header Card -->
            <div
                class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col lg:flex-row justify-between gap-6">
                <!-- Profile Base -->
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 text-2xl font-semibold">
                        AS
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-xl font-bold text-slate-900">Arjun Sharma</h3>
                            <span
                                class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Active
                                Patient</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Patient ID: <span
                                class="font-mono text-slate-700">#PAT-1001</span> | DOB: Aug 15, 1980 (Age 45)</p>
                    </div>
                </div>
                <!-- Vital Stats / Metadata Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 flex-1 max-w-2xl lg:ml-auto">
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="text-xs text-slate-400 block font-medium">Blood Type</span>
                        <span class="text-base font-bold text-slate-800">O Positive (O+)</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="text-xs text-slate-400 block font-medium">Height / Weight</span>
                        <span class="text-base font-bold text-slate-800">178 cm / 75 kg</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="text-xs text-slate-400 block font-medium">Primary Allergies</span>
                        <span class="text-xs font-bold text-red-600 truncate block mt-0.5"
                            title="Penicillin">Penicillin</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 text-center">
                        <span class="text-xs text-slate-400 block font-medium">Emergency Contact</span>
                        <span class="text-xs font-bold text-slate-800 block mt-0.5">Ananya Sharma (Spouse)</span>
                    </div>
                </div>
            </div>

            <!-- Vitals Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- BP -->
                <div
                    class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Blood
                            Pressure</span>
                        <span class="text-2xl font-black text-slate-900 block mt-1">118/76 <span
                                class="text-xs font-medium text-slate-500">mmHg</span></span>
                        <span class="text-[10px] font-semibold text-emerald-600 mt-1 inline-flex items-center gap-0.5">
                            <i class="fa-solid fa-circle-check"></i> Normal range
                        </span>
                    </div>
                    <div class="bg-red-50 text-red-500 p-3.5 rounded-lg">
                        <i class="fa-solid fa-heart-pulse text-xl"></i>
                    </div>
                </div>
                <!-- Heart Rate -->
                <div
                    class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Heart Rate</span>
                        <span class="text-2xl font-black text-slate-900 block mt-1">72 <span
                                class="text-xs font-medium text-slate-500">bpm</span></span>
                        <span class="text-[10px] font-semibold text-emerald-600 mt-1 inline-flex items-center gap-0.5">
                            <i class="fa-solid fa-circle-check"></i> Resting Normal
                        </span>
                    </div>
                    <div class="bg-blue-50 text-blue-500 p-3.5 rounded-lg">
                        <i class="fa-solid fa-wave-square text-xl"></i>
                    </div>
                </div>
                <!-- Oxygen Saturation -->
                <div
                    class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Oxygen
                            Level</span>
                        <span class="text-2xl font-black text-slate-900 block mt-1">98% <span
                                class="text-xs font-medium text-slate-500">SpO2</span></span>
                        <span class="text-[10px] font-semibold text-emerald-600 mt-1 inline-flex items-center gap-0.5">
                            <i class="fa-solid fa-circle-check"></i> Stable
                        </span>
                    </div>
                    <div class="bg-teal-50 text-teal-500 p-3.5 rounded-lg">
                        <i class="fa-solid fa-lungs text-xl"></i>
                    </div>
                </div>
                <!-- Body Temp -->
                <div
                    class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Temperature</span>
                        <span class="text-2xl font-black text-slate-900 block mt-1">36.7&deg;C <span
                                class="text-xs font-medium text-slate-500">(98.1&deg;F)</span></span>
                        <span class="text-[10px] font-semibold text-emerald-600 mt-1 inline-flex items-center gap-0.5">
                            <i class="fa-solid fa-circle-check"></i> Apyrexial
                        </span>
                    </div>
                    <div class="bg-amber-50 text-amber-500 p-3.5 rounded-lg">
                        <i class="fa-solid fa-thermometer-half text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Medical Record Filter & Timeline Grid -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Filters Header -->
                <div
                    class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-2 border-b md:border-b-0 pb-3 md:pb-0 overflow-x-auto">
                        <button onclick="filterRecords('all')" id="btn-filter-all"
                            class="px-4 py-2 text-xs font-bold rounded-lg transition-colors bg-slate-900 text-white">All
                            Records</button>
                        <button onclick="filterRecords('consultation')" id="btn-filter-consultation"
                            class="px-4 py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Consultations</button>
                        <button onclick="filterRecords('prescription')" id="btn-filter-prescription"
                            class="px-4 py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Prescriptions</button>
                        <button onclick="filterRecords('lab')" id="btn-filter-lab"
                            class="px-4 py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">Lab
                            Results</button>
                    </div>
                    <!-- Search Input -->
                    <div class="relative w-full md:w-80">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" id="recordSearch" onkeyup="searchRecords()"
                            placeholder="Search symptoms, medications, clinicians..."
                            class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- EHR Timeline Component -->
                <div class="p-6">
                    <div class="relative border-l border-slate-200 ml-4 space-y-8" id="timelineContainer">
                        <!-- Javascript generates active nodes dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal: View Medical Entry Details -->
    <div id="viewDetailsModal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div
            class="bg-white w-full max-w-xl rounded-xl shadow-xl overflow-hidden border border-slate-200 flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <span id="modal-category-badge"
                        class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full"></span>
                    <h3 id="modal-title" class="text-lg font-bold text-slate-900 mt-2"></h3>
                </div>
                <button onclick="toggleModal('viewDetailsModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors text-lg"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6 space-y-4 text-sm text-slate-700">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Clinician</span>
                        <span id="modal-clinician" class="font-semibold text-slate-800"></span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Date Recorded</span>
                        <span id="modal-date" class="font-semibold text-slate-800"></span>
                    </div>
                </div>
                <div class="border-t border-slate-100 pt-4">
                    <span class="text-xs text-slate-400 font-medium block mb-1">Clinical Evaluation & Summary</span>
                    <p id="modal-details"
                        class="leading-relaxed bg-slate-50 p-4 rounded-lg text-slate-600 border border-slate-100 whitespace-pre-wrap">
                    </p>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button onclick="toggleModal('viewDetailsModal')"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-4 py-2 rounded-lg text-xs transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add New Medical Record -->
    <div id="addRecordModal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900">Add New Medical Record</h3>
                <button onclick="toggleModal('addRecordModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors text-lg"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="newRecordForm" onsubmit="submitNewRecord(event)" class="p-6 space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Entry Title
                        / Diagnosis</label>
                    <input type="text" required id="form-title"
                        placeholder="e.g. Acute Pharyngitis, Lipid Panel Follow-up"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Category</label>
                        <select required id="form-category"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <option value="consultation">Consultation / Visit</option>
                            <option value="prescription">Prescription</option>
                            <option value="lab">Lab Result</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Clinician</label>
                        <input type="text" required id="form-clinician" placeholder="e.g. Dr. Sarah Jenkins"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Clinician
                        Notes & Details</label>
                    <textarea id="form-details" required rows="4"
                        placeholder="Enter symptoms observed, instructions, dosage, or outcomes..."
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"></textarea>
                </div>
                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('addRecordModal')"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-4 py-2 rounded-lg text-xs transition-colors">Cancel</button>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition-colors">Save
                        Entry</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Interface Script -->
    <script>
        // Core EHR Memory State
        let records = [
            {
                id: 1,
                date: "2026-05-18",
                type: "Consultation",
                category: "consultation",
                title: "Primary Assessment: Hypertension Follow-up",
                doctor: "Dr. Raj Patel (Cardiology)",
                details: "Patient presented for routine cardiovascular evaluation and blood pressure check. Blood pressure recorded at 128/82 mmHg on current anti-hypertensive regimen.\n\nPlan:\n- Continue standard lifestyle modifications and low sodium diet.\n- Daily blood pressure log maintenance.\n- Follow up in 3 months.",
                badgeStyle: "bg-blue-50 text-blue-700 border-blue-200",
                icon: "fa-stethoscope text-blue-500"
            },
            {
                id: 2,
                date: "2026-05-18",
                type: "Prescription",
                category: "prescription",
                title: "Amlodipine 5mg Tablet Dispensed",
                doctor: "Dr. Raj Patel (Cardiology)",
                details: "Dispensed: Amlodipine Besylate 5mg oral tablets.\nDirections: Take 1 tablet once daily in the morning with water.\nQuantity: 30 tablets. 2 refills authorized.",
                badgeStyle: "bg-purple-50 text-purple-700 border-purple-200",
                icon: "fa-pills text-purple-500"
            },
            {
                id: 3,
                date: "2026-04-12",
                type: "Lab Result",
                category: "lab",
                title: "Comprehensive Metabolic Panel (CMP)",
                doctor: "Dr. Jane Smith (Neurology)",
                details: "Analyzed sample parameters within physiologically optimal reference bounds.\n\n- Glucose, Serum: 92 mg/dL (Normal: 70-99)\n- BUN: 14 mg/dL (Normal: 6-20)\n- Creatinine: 0.88 mg/dL (Normal: 0.57-1.25)\n- eGFR: >90 mL/min/1.73m² (Normal: >60)\n- Potassium: 4.1 mmol/L (Normal: 3.5-5.1)\n- Sodium: 139 mmol/L (Normal: 134-144)",
                badgeStyle: "bg-emerald-50 text-emerald-700 border-emerald-200",
                icon: "fa-vial text-emerald-500"
            },
            {
                id: 4,
                date: "2026-03-01",
                type: "Consultation",
                category: "consultation",
                title: "Neurology Consultation: Headache Management",
                doctor: "Dr. Jane Smith (Neurology)",
                details: "Patient reported occasional tension headaches under high stress. Neurological examination cranial nerves II-XII intact, motor strength 5/5 bilateral.\n\nRecommended hydration, adequate sleep schedule, and stress management.",
                badgeStyle: "bg-blue-50 text-blue-700 border-blue-200",
                icon: "fa-stethoscope text-blue-500"
            }
        ];

        let activeFilter = 'all';

        // Load the initial interface render
        document.addEventListener("DOMContentLoaded", () => {
            renderTimeline();
        });

        // Toggle Modal Visibility
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        // Render Timeline with optional filters or queries
        function renderTimeline(filterType = 'all', searchQuery = '') {
            const container = document.getElementById('timelineContainer');
            container.innerHTML = '';

            // Filter down source array
            const filtered = records.filter(record => {
                const matchesCategory = filterType === 'all' || record.category === filterType;

                // Convert criteria into simplified lower-case searching
                const textSearch = (record.title + " " + record.doctor + " " + record.details + " " + record.type).toLowerCase();
                const matchesSearch = textSearch.includes(searchQuery.toLowerCase());

                return matchesCategory && matchesSearch;
            });

            if (filtered.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-3 block"></i>
                        <span class="text-sm font-bold text-slate-400">No matching medical records found.</span>
                    </div>
                `;
                return;
            }

            // Generate Timeline HTML nodes
            filtered.forEach(record => {
                const node = document.createElement('div');
                node.className = "relative pl-8 group cursor-pointer";
                node.onclick = () => openRecordDetails(record.id);

                node.innerHTML = `
                    <!-- Timeline Node Indicator -->
                    <span class="absolute left-[-17px] top-1.5 bg-white border-2 border-slate-200 group-hover:border-emerald-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors z-10">
                        <i class="fa-solid ${record.icon} text-xs"></i>
                    </span>
                    <!-- Entry Card -->
                    <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full border ${record.badgeStyle}">${record.type}</span>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">${record.title}</h4>
                            </div>
                            <span class="text-xs font-bold text-slate-400 flex items-center gap-1">
                                <i class="fa-regular fa-calendar text-[11px]"></i> ${formatDate(record.date)}
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-slate-500 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-doctor text-[10px]"></i> Recorded by ${record.doctor}
                        </p>
                        <p class="text-xs text-slate-600 line-clamp-2 mt-2 leading-relaxed">${record.details}</p>
                        <div class="mt-3 flex justify-end">
                            <span class="text-[10px] font-bold text-emerald-600 flex items-center gap-1 hover:underline">
                                Read Clinical Summary <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                `;
                container.appendChild(node);
            });
        }

        // Format dates into readable representations
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        // Filter Controls Trigger
        function filterRecords(category) {
            activeFilter = category;

            // Reset tab styling
            const buttons = ['all', 'consultation', 'prescription', 'lab'];
            buttons.forEach(btn => {
                const el = document.getElementById(`btn-filter-${btn}`);
                if (btn === category) {
                    el.className = "px-4 py-2 text-xs font-bold rounded-lg transition-colors bg-slate-900 text-white";
                } else {
                    el.className = "px-4 py-2 text-xs font-bold rounded-lg text-slate-600 hover:bg-slate-100 transition-colors";
                }
            });

            const searchQuery = document.getElementById('recordSearch').value;
            renderTimeline(activeFilter, searchQuery);
        }

        // Search Query Trigger
        function searchRecords() {
            const query = document.getElementById('recordSearch').value;
            renderTimeline(activeFilter, query);
        }

        // Display Detailed modal view of entry
        function openRecordDetails(id) {
            const record = records.find(r => r.id === id);
            if (!record) return;

            document.getElementById('modal-title').innerText = record.title;
            document.getElementById('modal-clinician').innerText = record.doctor;
            document.getElementById('modal-date').innerText = formatDate(record.date);
            document.getElementById('modal-details').innerText = record.details;

            const badge = document.getElementById('modal-category-badge');
            badge.innerText = record.type;
            badge.className = `px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full border ${record.badgeStyle}`;

            toggleModal('viewDetailsModal');
        }

        // Submit and prepend new medical records
        function submitNewRecord(event) {
            event.preventDefault();

            const title = document.getElementById('form-title').value;
            const category = document.getElementById('form-category').value;
            const doctorName = document.getElementById('form-clinician').value;
            const details = document.getElementById('form-details').value;

            // Determine display styles based on selector choice
            let type = "Consultation";
            let badgeStyle = "bg-blue-50 text-blue-700 border-blue-200";
            let icon = "fa-stethoscope text-blue-500";

            if (category === 'prescription') {
                type = "Prescription";
                badgeStyle = "bg-purple-50 text-purple-700 border-purple-200";
                icon = "fa-pills text-purple-500";
            } else if (category === 'lab') {
                type = "Lab Result";
                badgeStyle = "bg-emerald-50 text-emerald-700 border-emerald-200";
                icon = "fa-vial text-emerald-500";
            }

            // Create entry structure
            const newRecord = {
                id: Date.now(),
                date: new Date().toISOString().split('T')[0],
                type: type,
                category: category,
                title: title,
                doctor: doctorName,
                details: details,
                badgeStyle: badgeStyle,
                icon: icon
            };

            // Prepend new element to State, reset form controls, and hide Modal
            records.unshift(newRecord);
            document.getElementById('newRecordForm').reset();
            toggleModal('addRecordModal');

            // Force refresh of the UI display list
            renderTimeline(activeFilter, document.getElementById('recordSearch').value);
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
