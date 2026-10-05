<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Inventory Dashboard</title>
    <!-- Tailwind CSS for clean layout/styling -->
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
                    <a href="Appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="Pharmacy.php" class="active"><i class="fa-solid fa-pills"></i> Pharmacy</a>
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
                <div class="bg-emerald-600 text-white p-2.5 rounded-xl">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">PharmaStock</h1>
                    <p class="text-sm text-gray-500 mt-1">Live Pharmacy Inventory Management &bull; System Date: <span id="live-date">June 1, 2026</span></p>
                </div>
            </div>
            <button onclick="window.location.href='Add_pharmacy.php'" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition duration-150 flex items-center gap-2 shadow-md shadow-emerald-100">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Medication
            </button>
        </div>

        <!-- Inventory KPI Widgets -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total unique products -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Products</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1" id="stat-total-skus">0</h3>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider">Low Stock</p>
                    <h3 class="text-2xl font-bold text-amber-700 mt-1" id="stat-low-stock">0</h3>
                </div>
                <div class="bg-amber-50 text-amber-600 p-3 rounded-xl">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Out of Stock -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-red-500 uppercase tracking-wider">Out of Stock</p>
                    <h3 class="text-2xl font-bold text-red-700 mt-1" id="stat-out-stock">0</h3>
                </div>
                <div class="bg-red-50 text-red-600 p-3 rounded-xl">
                    <i data-lucide="x-circle" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Expiring/Expired Alerts -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Expiring / Expired</p>
                    <h3 class="text-2xl font-bold text-purple-700 mt-1" id="stat-expiring">0</h3>
                </div>
                <div class="bg-purple-50 text-purple-600 p-3 rounded-xl">
                    <i data-lucide="hourglass" class="w-6 h-6"></i>
                </div>
            </div>
        </section>

        <!-- Filters & Search Controls -->
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Search field -->
            <div class="relative w-full md:w-80">
                <input type="text" id="search-input" oninput="renderInventory()" placeholder="Search medicine name, category..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
            </div>

            <!-- Categories and stock filters -->
            <div class="flex items-center space-x-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <select id="filter-category" onchange="renderInventory()" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="All">All Categories</option>
                    <option value="Analgesic">Analgesics</option>
                    <option value="Antibiotic">Antibiotics</option>
                    <option value="Cardiovascular">Cardiovascular</option>
                    <option value="Antidiabetic">Antidiabetic</option>
                    <option value="Respiratory">Respiratory</option>
                </select>

                <select id="filter-stock-level" onchange="renderInventory()" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="All">All Stock Levels</option>
                    <option value="InStock">In Stock</option>
                    <option value="LowStock">Low Stock Only</option>
                    <option value="OutOfStock">Out of Stock Only</option>
                    <option value="Expired">Expired / Expiring Soon</option>
                </select>
            </div>
        </div>

        <!-- Inventory List Table Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase text-gray-500 tracking-wider">
                            <th class="p-4">Medication Name</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Stock Qty</th>
                            <th class="p-4">Unit Price (&#8377;)</th>
                            <th class="p-4">Expiry Date</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Quick Restock</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-table-body" class="divide-y divide-gray-100 text-sm">
                        <!-- Loaded dynamically via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Table empty state view -->
            <div id="table-empty-state" class="hidden py-16 text-center">
                <div class="bg-gray-100 text-gray-400 p-3 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="package-search" class="w-6 h-6"></i>
                </div>
                <h4 class="text-base font-semibold text-gray-900">No Medications Found</h4>
                <p class="text-xs text-gray-500 max-w-xs mx-auto mt-1">Adjust your filters, search terms, or add a new medication profile to get started.</p>
            </div>
        </div>

    </main>

    <!-- Modal Form overlay for adding new medicine -->
    <div id="add-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-emerald-600 p-4 text-white flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i data-lucide="pill" class="w-5 h-5"></i>
                    <h3 class="font-bold">Add New Medication</h3>
                </div>
                <button onclick="toggleModal(false)" class="text-white hover:bg-emerald-700 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="add-med-form" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Medication Name</label>
                    <input type="text" id="add-name" required placeholder="e.g. Amoxicillin 500mg" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Category</label>
                        <select id="add-category" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="Analgesic">Analgesic</option>
                            <option value="Antibiotic">Antibiotic</option>
                            <option value="Cardiovascular">Cardiovascular</option>
                            <option value="Antidiabetic">Antidiabetic</option>
                            <option value="Respiratory">Respiratory</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Unit Price (&#8377;)</label>
                        <input type="number" id="add-price" step="0.01" required placeholder="e.g. 150.00" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Initial Stock</label>
                        <input type="number" id="add-stock" required placeholder="e.g. 100" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Min Threshold</label>
                        <input type="number" id="add-min" required placeholder="e.g. 20" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Expiration Date</label>
                    <input type="date" id="add-expiry" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="pt-2 flex justify-end space-x-2">
                    <button type="button" onclick="toggleModal(false)" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Management Script -->
    <script>
        // System baseline date
        const SYSTEM_DATE = new Date('2026-06-01');

        const defaultDatabase = [
            { id: 1, name: "Paracetamol 500mg", category: "Analgesic", stock: 120, minStock: 50, expiry: "2027-12-01", price: 2.50 },
            { id: 2, name: "Amoxicillin 250mg", category: "Antibiotic", stock: 35, minStock: 40, expiry: "2026-06-25", price: 8.90 },
            { id: 3, name: "Metformin 850mg", category: "Antidiabetic", stock: 0, minStock: 30, expiry: "2026-11-20", price: 12.00 },
            { id: 4, name: "Atorvastatin 20mg", category: "Cardiovascular", stock: 200, minStock: 60, expiry: "2028-03-15", price: 15.30 },
            { id: 5, name: "Ibuprofen 400mg", category: "Analgesic", stock: 15, minStock: 30, expiry: "2026-05-10", price: 4.20 }
        ];

        // Initialized Data Store
        let database = JSON.parse(localStorage.getItem('medications')) || defaultDatabase;

        function saveDatabase() {
            localStorage.setItem('medications', JSON.stringify(database));
        }

        window.addEventListener('DOMContentLoaded', async () => {
            lucide.createIcons();
            const dateDisplayOpts = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('live-date').innerText = SYSTEM_DATE.toLocaleDateString('en-US', dateDisplayOpts);

            await loadPharmacyFromDb();
        });

        // Load live medications directly from MySQL Database via api.php
        async function loadPharmacyFromDb() {
            try {
                const response = await fetch('api.php?action=get_pharmacy');
                const result = await response.json();
                if (result && result.status === 'success' && result.data && result.data.length > 0) {
                    database = result.data.map(m => ({
                        id: parseInt(m.id),
                        name: m.medicine_name,
                        category: m.category || 'General',
                        stock: parseInt(m.quantity) || 0,
                        minStock: 30,
                        expiry: m.expiry_date || '2027-12-31',
                        price: parseFloat(m.price) || 0.00
                    }));
                    saveDatabase();
                }
            } catch (err) {
                console.warn('Using local fallback for pharmacy medications:', err);
            }
            updateKPIs();
            renderInventory();
        }

        // Function: Calculate Expiring and Low stock levels
        function getExpiryStatus(expiryStr) {
            const expiryDate = new Date(expiryStr);
            const timeDiff = expiryDate.getTime() - SYSTEM_DATE.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (daysDiff < 0) {
                return 'Expired';
            } else if (daysDiff <= 30) {
                return 'ExpiringSoon';
            }
            return 'Safe';
        }

        // Function: Calculate Metrics Summary for KPIs
        function updateKPIs() {
            const totalSKUs = database.length;
            const lowStock = database.filter(item => item.stock <= item.minStock && item.stock > 0).length;
            const outStock = database.filter(item => item.stock === 0).length;
            const expiringAlerts = database.filter(item => {
                const status = getExpiryStatus(item.expiry);
                return status === 'Expired' || status === 'ExpiringSoon';
            }).length;

            document.getElementById('stat-total-skus').innerText = totalSKUs;
            document.getElementById('stat-low-stock').innerText = lowStock;
            document.getElementById('stat-out-stock').innerText = outStock;
            document.getElementById('stat-expiring').innerText = expiringAlerts;
        }

        // Function: Render list based on search filters
        function renderInventory() {
            const tableBody = document.getElementById('inventory-table-body');
            const emptyState = document.getElementById('table-empty-state');
            
            const searchValue = document.getElementById('search-input').value.toLowerCase();
            const categoryValue = document.getElementById('filter-category').value;
            const stockLevelValue = document.getElementById('filter-stock-level').value;

            // Filtration logic
            const filteredData = database.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchValue) || item.category.toLowerCase().includes(searchValue);
                const matchesCategory = categoryValue === 'All' || item.category === categoryValue;
                
                let matchesStock = true;
                if (stockLevelValue === 'InStock') {
                    matchesStock = item.stock > 0;
                } else if (stockLevelValue === 'LowStock') {
                    matchesStock = item.stock <= item.minStock && item.stock > 0;
                } else if (stockLevelValue === 'OutOfStock') {
                    matchesStock = item.stock === 0;
                } else if (stockLevelValue === 'Expired') {
                    const expiryState = getExpiryStatus(item.expiry);
                    matchesStock = expiryState === 'Expired' || expiryState === 'ExpiringSoon';
                }

                return matchesSearch && matchesCategory && matchesStock;
            });

            // Handle clean rendering for Empty result scenarios
            if (filteredData.length === 0) {
                tableBody.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');

            tableBody.innerHTML = filteredData.map(item => {
                // Formatting Stock Badge Elements
                let stockBadge = '';
                if (item.stock === 0) {
                    stockBadge = `<span class="bg-red-50 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">Out of Stock</span>`;
                } else if (item.stock <= item.minStock) {
                    stockBadge = `<span class="bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">Low Stock (${item.stock})</span>`;
                } else {
                    stockBadge = `<span class="bg-green-50 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">Healthy (${item.stock})</span>`;
                }

                // Expiry status indicator logic
                const expiryStatus = getExpiryStatus(item.expiry);
                let expiryDisplay = '';
                if (expiryStatus === 'Expired') {
                    expiryDisplay = `<div class="text-red-600 font-semibold flex items-center gap-1">${item.expiry} <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded">Expired</span></div>`;
                } else if (expiryStatus === 'ExpiringSoon') {
                    expiryDisplay = `<div class="text-amber-600 font-semibold flex items-center gap-1">${item.expiry} <span class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.2 rounded">Soon</span></div>`;
                } else {
                    expiryDisplay = `<div class="text-gray-600">${item.expiry}</div>`;
                }

                return `
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-4 font-semibold text-gray-900">${item.name}</td>
                        <td class="p-4 text-gray-600">${item.category}</td>
                        <td class="p-4">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-gray-800">${item.stock}</span>
                                <span class="text-xs text-gray-400">/ ${item.minStock} min</span>
                            </div>
                        </td>
                        <td class="p-4 font-medium text-gray-700">&#8377;${item.price.toFixed(2)}</td>
                        <td class="p-4 text-xs">${expiryDisplay}</td>
                        <td class="p-4">${stockBadge}</td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end items-center space-x-1">
                                <button onclick="adjustStock(${item.id}, -10)" class="p-1 border border-gray-200 rounded text-gray-500 hover:bg-gray-100 transition" title="Deduct 10 units">
                                    -10
                                </button>
                                <button onclick="adjustStock(${item.id}, 10)" class="p-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded hover:bg-emerald-100 transition font-semibold" title="Add 10 units">
                                    +10
                                </button>
                                <button onclick="removeMedication(${item.id})" class="p-1 text-gray-300 hover:text-red-500 rounded transition ml-2" title="Delete record">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            // Reload dynamically loaded table icons
            lucide.createIcons();
        }

        // Action: Quick Stock adjusting logic with MySQL sync
        async function adjustStock(id, amount) {
            const med = database.find(item => item.id === id);
            if (med) {
                med.stock = Math.max(0, med.stock + amount); // Prevents sub-zero levels
                saveDatabase();
                updateKPIs();
                renderInventory();

                try {
                    await fetch('api.php?action=update_pharmacy_stock', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id, add_quantity: amount })
                    });
                } catch (e) {
                    console.warn('Error syncing stock adjustment to MySQL:', e);
                }
            }
        }

        // Action: Remove medication records from MySQL
        async function removeMedication(id) {
            if (confirm("Are you sure you want to remove this medication from database registries?")) {
                database = database.filter(item => item.id !== id);
                saveDatabase();
                updateKPIs();
                renderInventory();

                try {
                    await fetch('api.php?action=delete_pharmacy', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: id })
                    });
                } catch (e) {
                    console.warn('Error deleting pharmacy record from MySQL:', e);
                }
            }
        }

        // Modal Form Toggle Controller
        function toggleModal(show) {
            const modal = document.getElementById('add-modal');
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.getElementById('add-med-form').reset();
            }
        }

        // Action: Process Add Medication Form Submit directly into MySQL database
        document.getElementById('add-med-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const name = document.getElementById('add-name').value;
            const category = document.getElementById('add-category').value;
            const price = parseFloat(document.getElementById('add-price').value);
            const stock = parseInt(document.getElementById('add-stock').value);
            const minStock = parseInt(document.getElementById('add-min').value);
            const expiry = document.getElementById('add-expiry').value;

            try {
                const response = await fetch('api.php?action=add_pharmacy', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        medicine_name: name,
                        category: category,
                        price: price,
                        quantity: stock,
                        expiry_date: expiry,
                        supplier: 'MediGo Pharma'
                    })
                });
                const res = await response.json();
                if (res && res.status === 'success') {
                    await loadPharmacyFromDb();
                } else {
                    const newMedicine = {
                        id: Date.now(),
                        name,
                        category,
                        price,
                        stock,
                        minStock,
                        expiry
                    };
                    database.unshift(newMedicine);
                    saveDatabase();
                    updateKPIs();
                    renderInventory();
                }
            } catch (err) {
                console.warn('Fallback adding medication:', err);
                const newMedicine = {
                    id: Date.now(),
                    name,
                    category,
                    price,
                    stock,
                    minStock,
                    expiry
                };
                database.unshift(newMedicine);
                saveDatabase();
                updateKPIs();
                renderInventory();
            }

            toggleModal(false);
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
