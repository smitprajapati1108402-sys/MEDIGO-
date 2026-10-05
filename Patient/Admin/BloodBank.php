<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management Portal</title>
    <!-- Tailwind CSS for modern responsive styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
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
<body class="bg-slate-50 text-slate-800 min-h-screen">

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
                    <a href="Appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="Pharmacy.php"><i class="fa-solid fa-pills"></i> Pharmacy</a>
                    <a href="BloodBank.php" class="active"><i class="fa-solid fa-droplet"></i> Blood Bank</a>
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
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="bg-rose-600 text-white p-2.5 rounded-xl shadow-md shadow-rose-200">
                    <i data-lucide="droplet" class="w-6 h-6 fill-current"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">LifeStream</h1>
                    <p class="text-sm text-slate-500 mt-1">Blood Bank & Inventory Registry &bull; System Date: June 1, 2026</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-rose-50 text-rose-700 px-4 py-2 rounded-xl text-xs font-semibold border border-rose-100 flex items-center gap-2 shadow-sm shadow-rose-50">
                    <span class="h-2.5 w-2.5 rounded-full bg-rose-600 animate-pulse"></span>
                    Live Monitor Active
                </span>
                <button onclick="window.location.href='add_bloodbank.php'" class="bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 flex items-center gap-2 shadow-md shadow-rose-100">
                    <i data-lucide="plus" class="w-4 h-4"></i> Add Blood Record
                </button>
            </div>
        </div>

        <!-- Analytics Overview -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stock</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1" id="stat-total-stock">0 Units</h3>
                </div>
                <div class="bg-rose-50 text-rose-600 p-3 rounded-xl">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider">Critical Shortages</p>
                    <h3 class="text-2xl font-bold text-amber-700 mt-1" id="stat-critical">0 Groups</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 p-3 rounded-xl">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider">Pending Testing</p>
                    <h3 class="text-2xl font-bold text-blue-700 mt-1" id="stat-pending">0 Units</h3>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                    <i data-lucide="flask-conical" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider">Dispatched (Month)</p>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1" id="stat-dispatched">0 Units</h3>
                </div>
                <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl">
                    <i data-lucide="truck" class="w-6 h-6"></i>
                </div>
            </div>
        </section>

        <!-- Main Workspace Split -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Live Blood Stock Grid & History -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Blood Group Stock Cards -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-slate-900">Real-Time Blood Levels</h2>
                        <span class="text-xs text-slate-400">Reserve Safe Limit: 20 Units</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="blood-grid">
                        <!-- Dynamic Blood Type Cards Generated here -->
                    </div>
                </div>

                <!-- Transaction Log -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="font-bold text-slate-900">Recent Registry Transactions</h3>
                            <p class="text-xs text-slate-500">Record of incoming donations and outgoing distributions</p>
                        </div>
                        
                        <!-- Search & Filter History -->
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <select id="filter-type" onchange="renderTransactions()" class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                <option value="All">All Actions</option>
                                <option value="Donation">Donation</option>
                                <option value="Dispatch">Dispatch</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <th class="p-4">Contact Person</th>
                                    <th class="p-4">Blood Group</th>
                                    <th class="p-4">Type</th>
                                    <th class="p-4">Volume</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4">Date</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-table" class="divide-y divide-slate-100">
                                <!-- Loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Side: Logistics Logger Form -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-24 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="clipboard-list" class="w-5 h-5 text-rose-600"></i>
                            Log Transaction
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Register new blood deposits or process dispatch requests immediately.</p>
                    </div>

                    <form id="logistics-form" class="space-y-4">
                        <!-- Transaction Mode Toggle -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Transaction Type</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="border-2 border-rose-500 bg-rose-50/50 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center" id="label-type-donation">
                                    <input type="radio" name="tx-type" value="Donation" checked onchange="toggleFormMode('Donation')" class="sr-only">
                                    <i data-lucide="heart" class="w-5 h-5 text-rose-600 mb-1"></i>
                                    <span class="text-xs font-bold text-rose-700">Donation</span>
                                </label>
                                <label class="border-2 border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center" id="label-type-dispatch">
                                    <input type="radio" name="tx-type" value="Dispatch" onchange="toggleFormMode('Dispatch')" class="sr-only">
                                    <i data-lucide="truck" class="w-5 h-5 text-slate-500 mb-1" id="icon-type-dispatch"></i>
                                    <span class="text-xs font-bold text-slate-600" id="text-type-dispatch">Dispatch</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1" id="form-label-person">Donor Full Name</label>
                            <input type="text" id="input-person" required placeholder="e.g. John Doe" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Blood Group</label>
                                <select id="input-blood-group" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                                    <option value="" disabled selected>Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Volume (Units)</label>
                                <input type="number" id="input-volume" min="1" max="10" required placeholder="e.g. 1" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                            </div>
                        </div>

                        <!-- Info/Validation Alert (Hidden by default) -->
                        <div id="form-validation-alert" class="hidden p-3 bg-red-50 text-red-700 text-xs rounded-lg border border-red-200 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0"></i>
                            <span id="validation-error-text">Insufficient blood stock to dispatch.</span>
                        </div>

                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition duration-150 shadow-md shadow-rose-100">
                            Process Transaction
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </main>

    <script>
        // System baseline date
        const SYSTEM_DATE = new Date().toISOString().split('T')[0];

        // Localized Blood Stock Quantities (Target safety limit: 20 units)
        const defaultBloodStock = {
            "A+": 42,
            "A-": 25,
            "B+": 38,
            "B-": 12,  // Critical
            "AB+": 28,
            "AB-": 8,   // Critical
            "O+": 65,
            "O-": 15    // Critical
        };

        const defaultTransactions = [
            { id: 1, person: "Dr. Avery Smith (Red Cross)", bloodGroup: "O-", type: "Dispatch", volume: 4, date: "2026-06-01", status: "Completed" },
            { id: 2, person: "Sarah Miller", bloodGroup: "B+", type: "Donation", volume: 2, date: "2026-05-30", status: "Completed" },
            { id: 3, person: "City General Hospital", bloodGroup: "AB-", type: "Dispatch", volume: 5, date: "2026-05-28", status: "Completed" },
            { id: 4, person: "Robert Vance", bloodGroup: "A+", type: "Donation", volume: 3, date: "2026-05-25", status: "Completed" }
        ];

        let bloodStock = JSON.parse(localStorage.getItem('bloodStock')) || defaultBloodStock;
        let transactions = JSON.parse(localStorage.getItem('bloodTransactions')) || defaultTransactions;

        function saveDatabase() {
            localStorage.setItem('bloodStock', JSON.stringify(bloodStock));
            localStorage.setItem('bloodTransactions', JSON.stringify(transactions));
        }

        const targetLimit = 100; // Capacity scale for rendering percentage bar
        const safetyLimit = 20;

        window.addEventListener('DOMContentLoaded', async () => {
            lucide.createIcons();
            await loadBloodBankFromDb();
        });

        // Load Blood Stock and Transaction History from MySQL Database
        async function loadBloodBankFromDb() {
            try {
                const response = await fetch('api.php?action=get_blood_stock');
                const res = await response.json();
                if (res && res.status === 'success' && res.data) {
                    if (res.data.stock && res.data.stock.length > 0) {
                        res.data.stock.forEach(item => {
                            bloodStock[item.blood_group] = parseInt(item.bags_available) || 0;
                        });
                    }
                    if (res.data.transactions && res.data.transactions.length > 0) {
                        transactions = res.data.transactions.map(t => ({
                            id: parseInt(t.id),
                            person: t.donor_patient_name,
                            bloodGroup: t.blood_group,
                            type: t.type,
                            volume: parseInt(t.bags) || 1,
                            date: t.date,
                            status: t.status
                        }));
                    }
                    saveDatabase();
                }
            } catch (err) {
                console.warn('Using local fallback for blood bank:', err);
            }
            updateKPIs();
            renderBloodGrid();
            renderTransactions();
        }

        // Function: Redraw and calculate totals for KPI tiles
        function updateKPIs() {
            let totalStockVal = 0;
            let criticalCount = 0;

            for (const [group, units] of Object.entries(bloodStock)) {
                totalStockVal += units;
                if (units < safetyLimit) {
                    criticalCount++;
                }
            }

            const pendingUnits = transactions
                .filter(tx => tx.type === 'Donation' && tx.status === 'Pending Testing')
                .reduce((sum, tx) => sum + tx.volume, 0);

            const dispatchedUnits = transactions
                .filter(tx => tx.type === 'Dispatch')
                .reduce((sum, tx) => sum + tx.volume, 0);

            document.getElementById('stat-total-stock').innerText = `${totalStockVal} Units`;
            document.getElementById('stat-critical').innerText = `${criticalCount} Groups`;
            document.getElementById('stat-pending').innerText = `${pendingUnits} Units`;
            document.getElementById('stat-dispatched').innerText = `${dispatchedUnits} Units`;
        }

        // Function: Render the Interactive Blood Grid with Safety Levels
        function renderBloodGrid() {
            const gridContainer = document.getElementById('blood-grid');
            
            gridContainer.innerHTML = Object.entries(bloodStock).map(([group, units]) => {
                const percentage = Math.min((units / targetLimit) * 100, 100);
                
                let textClass = 'text-slate-900';
                let bgBadgeClass = 'bg-green-50 text-green-700 border-green-200';
                let barClass = 'bg-rose-500';
                let alertLabel = 'Safe Reserve';

                if (units < safetyLimit) {
                    textClass = 'text-rose-600';
                    bgBadgeClass = 'bg-rose-50 text-rose-700 border-rose-200 animate-pulse';
                    barClass = 'bg-rose-600';
                    alertLabel = 'Critical Level';
                } else if (units < 40) {
                    textClass = 'text-amber-600';
                    bgBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                    barClass = 'bg-amber-500';
                    alertLabel = 'Low Stock';
                }

                return `
                    <div onclick="selectBloodGroupForm('${group}')" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm cursor-pointer hover:border-rose-400 transition flex flex-col justify-between space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-2xl font-bold ${textClass}">${group}</span>
                                <p class="text-[10px] text-slate-400 mt-0.5">Click to select</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border ${bgBadgeClass}">
                                ${alertLabel}
                            </span>
                        </div>

                        <div>
                            <div class="flex justify-between items-baseline text-xs mb-1">
                                <span class="text-slate-500">Volume</span>
                                <span class="font-bold text-slate-800">${units} <span class="text-[10px] font-normal text-slate-400">Units</span></span>
                            </div>
                            <!-- Simulated Fluid Meter -->
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full ${barClass} transition-all duration-500" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Function: Render transaction logs table
        function renderTransactions() {
            const tbody = document.getElementById('transaction-table');
            const selectedFilter = document.getElementById('filter-type').value;

            const filtered = transactions.filter(tx => {
                return selectedFilter === 'All' || tx.type === selectedFilter;
            });

            tbody.innerHTML = filtered.map(tx => {
                let badgeClass = 'bg-slate-100 text-slate-600';
                if (tx.status === 'Completed') badgeClass = 'bg-emerald-50 text-emerald-700';
                else if (tx.status === 'Pending Testing') badgeClass = 'bg-blue-50 text-blue-700';

                const isDonation = tx.type === 'Donation';

                return `
                    <tr class="hover:bg-slate-50 transition duration-100">
                        <td class="p-4 font-semibold text-slate-800">${tx.person}</td>
                        <td class="p-4">
                            <span class="font-bold text-slate-700">${tx.bloodGroup}</span>
                        </td>
                        <td class="p-4 font-medium">
                            <span class="flex items-center gap-1 text-xs ${isDonation ? 'text-rose-600' : 'text-slate-600'}">
                                <i data-lucide="${isDonation ? 'heart' : 'truck'}" class="w-3.5 h-3.5"></i>
                                ${tx.type}
                            </span>
                        </td>
                        <td class="p-4 font-semibold text-slate-700">${tx.volume} Units</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold ${badgeClass}">
                                ${tx.status}
                            </span>
                        </td>
                        <td class="p-4 text-xs text-slate-400">${tx.date}</td>
                    </tr>
                `;
            }).join('');

            lucide.createIcons();
        }

        // Feature: Auto-fill blood group in form on clicking a card
        function selectBloodGroupForm(group) {
            document.getElementById('input-blood-group').value = group;
        }

        // Form Control: Handle donation vs dispatch interface toggle
        function toggleFormMode(mode) {
            const donationLabel = document.getElementById('label-type-donation');
            const dispatchLabel = document.getElementById('label-type-dispatch');
            const dispatchIcon = document.getElementById('icon-type-dispatch');
            const dispatchText = document.getElementById('text-type-dispatch');
            const personLabel = document.getElementById('form-label-person');
            const personInput = document.getElementById('input-person');

            // Hide previous validation messages
            document.getElementById('form-validation-alert').classList.add('hidden');

            if (mode === 'Donation') {
                donationLabel.className = "border-2 border-rose-500 bg-rose-50/50 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center";
                dispatchLabel.className = "border-2 border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center";
                dispatchIcon.className = "w-5 h-5 text-slate-500 mb-1";
                dispatchText.className = "text-xs font-bold text-slate-600";
                
                personLabel.innerText = "Donor Full Name";
                personInput.placeholder = "e.g. John Doe";
            } else {
                donationLabel.className = "border-2 border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center";
                dispatchLabel.className = "border-2 border-rose-500 bg-rose-50/50 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition text-center";
                dispatchIcon.className = "w-5 h-5 text-rose-600 mb-1";
                dispatchText.className = "text-xs font-bold text-rose-700";

                personLabel.innerText = "Recipient Facility / Hospital";
                personInput.placeholder = "e.g. City General Hospital";
            }
        }

        // Action: Submit Logistics Form directly to MySQL Database
        document.getElementById('logistics-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const txType = document.querySelector('input[name="tx-type"]:checked').value;
            const person = document.getElementById('input-person').value;
            const bloodGroup = document.getElementById('input-blood-group').value;
            const volume = parseInt(document.getElementById('input-volume').value);
            const alertBox = document.getElementById('form-validation-alert');

            alertBox.classList.add('hidden');

            // Inventory Validation Check for Dispatch Outgoings
            if (txType === 'Dispatch') {
                const currentStock = bloodStock[bloodGroup] || 0;
                if (currentStock < volume) {
                    document.getElementById('validation-error-text').innerText = `Error: Insufficient stock of ${bloodGroup}. Only ${currentStock} units available.`;
                    alertBox.classList.remove('hidden');
                    return;
                }
            }

            try {
                const response = await fetch('api.php?action=add_blood_transaction', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        donor_patient_name: person,
                        blood_group: bloodGroup,
                        bags: volume,
                        type: txType,
                        date: SYSTEM_DATE,
                        status: 'Completed'
                    })
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    await loadBloodBankFromDb();
                } else {
                    if (txType === 'Dispatch') {
                        bloodStock[bloodGroup] -= volume;
                    } else {
                        bloodStock[bloodGroup] += volume;
                    }
                    const newTx = {
                        id: Date.now(),
                        person,
                        bloodGroup,
                        type: txType,
                        volume,
                        date: SYSTEM_DATE,
                        status: 'Completed'
                    };
                    transactions.unshift(newTx);
                    saveDatabase();
                    updateKPIs();
                    renderBloodGrid();
                    renderTransactions();
                }
            } catch (err) {
                console.warn('Fallback processing blood transaction:', err);
                if (txType === 'Dispatch') {
                    bloodStock[bloodGroup] -= volume;
                } else {
                    bloodStock[bloodGroup] += volume;
                }
                const newTx = {
                    id: Date.now(),
                    person,
                    bloodGroup,
                    type: txType,
                    volume,
                    date: SYSTEM_DATE,
                    status: 'Completed'
                };
                transactions.unshift(newTx);
                saveDatabase();
                updateKPIs();
                renderBloodGrid();
                renderTransactions();
            }

            // Reset Controls
            document.getElementById('logistics-form').reset();
            // Default select UI reset to Donation styling state
            toggleFormMode('Donation');
        });

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
