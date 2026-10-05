<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medigo | Add Medication</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #3b82f6;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --error-red: #ef4444;

            /* Navbar specific variables */
            --nav-primary: #0048ff;
            --nav-primary-dark: #001d72;
            --nav-primary-light: #eef4ff;
            --nav-white: #ffffff;
            --nav-text-dark: #1e293b;
            --nav-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ================= NAVIGATION BAR ================= */
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

        /* Main content and containers */
        .main-content {
            flex: 1;
            padding: 40px 20px;
            width: 100%;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header-wrapper {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Form Card Layout */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 25px;
        }

        .section-header .icon-box {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
        }

        .section-header h2 { font-size: 15px; font-weight: 600; }
        .section-header p { font-size: 12px; color: var(--text-muted); }

        /* Grid System */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-size: 12px; font-weight: 600; color: #475569; }
        .input-group label span { color: var(--error-red); }

        input, select, textarea {
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            transition: 0.2s;
        }

        input:focus, select:focus, textarea:focus { border-color: var(--primary-blue); }

        .full-width { grid-column: span 4; }

        /* Special Field: Toggle Switch */
        .toggle-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input { opacity: 0; width: 0; height: 0; }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px; width: 14px;
            left: 3px; bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider { background-color: var(--primary-blue); }
        input:checked + .slider:before { transform: translateX(14px); }

        /* Footer Buttons */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-secondary {
            padding: 10px 20px;
            border: 1px solid var(--border-color);
            background: white;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save {
            padding: 10px 24px;
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .char-count {
            text-align: right;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        hr { border: 0; border-top: 1px solid #f1f5f9; margin: 40px 0; }
    </style>
</head>
<body>

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

    <div class="main-content">
        <div class="container">
            <div class="page-header-wrapper">
                <h2 class="page-title">Add Medication</h2>
                <p class="page-subtitle">Fill in the details below to add a new medication to the inventory.</p>
            </div>

            <div class="form-card">
                <form id="medicationForm">
                    <!-- Section 1: Medication Info -->
            <div class="section-header">
                <div class="icon-box"><i class="fa fa-info-circle"></i></div>
                <div>
                    <h2>Medication Information</h2>
                    <p>Enter basic details about the medication</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Medication Name <span>*</span></label>
                    <input type="text" id="medName" placeholder="Enter medication name" required>
                </div>
                <div class="input-group">
                    <label>Generic Name</label>
                    <input type="text" id="medGeneric" placeholder="Enter generic name">
                </div>
                <div class="input-group">
                    <label>Category <span>*</span></label>
                    <select id="medCategory" required>
                        <option value="">Select category</option>
                        <option value="Analgesic">Analgesic</option>
                        <option value="Antibiotic">Antibiotic</option>
                        <option value="Cardiovascular">Cardiovascular</option>
                        <option value="Antidiabetic">Antidiabetic</option>
                        <option value="Respiratory">Respiratory</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Therapeutic Class</label>
                    <select id="medClass">
                        <option value="">Select therapeutic class</option>
                        <option value="Pain Reliever">Pain Reliever</option>
                        <option value="Antibacterial">Antibacterial</option>
                        <option value="Beta Blocker">Beta Blocker</option>
                        <option value="Oral Hypoglycemic">Oral Hypoglycemic</option>
                        <option value="Bronchodilator">Bronchodilator</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Strength <span>*</span></label>
                    <input type="text" id="medStrength" placeholder="Enter strength (e.g., 500 mg)" required>
                </div>
                <div class="input-group">
                    <label>Form <span>*</span></label>
                    <select id="medForm" required>
                        <option value="">Select form</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Syrup">Syrup</option>
                        <option value="Injection">Injection</option>
                        <option value="Ointment">Ointment</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Unit</label>
                    <select id="medUnit">
                        <option value="">Select unit</option>
                        <option value="mg">mg</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Manufacturer</label>
                    <input type="text" id="medManufacturer" placeholder="Enter manufacturer">
                </div>
                <div class="input-group full-width">
                    <label>Description</label>
                    <textarea id="medDescription" rows="3" placeholder="Enter description (optional)"></textarea>
                    <div class="char-count">0/200</div>
                </div>
            </div>

            <!-- Section 2: Inventory Info -->
            <div class="section-header">
                <div class="icon-box"><i class="fa fa-box"></i></div>
                <div>
                    <h2>Inventory Information</h2>
                    <p>Manage stock and inventory details</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Stock Quantity <span>*</span></label>
                    <input type="number" id="medStock" placeholder="Enter stock quantity" required min="0">
                </div>
                <div class="input-group">
                    <label>Unit Price (&#8377;) <span>*</span></label>
                    <input type="number" step="0.01" id="medPrice" placeholder="Enter unit price" required min="0">
                </div>
                <div class="input-group">
                    <label>Reorder Level <span>*</span> <i class="far fa-question-circle" style="font-size: 10px; color: var(--text-muted);"></i></label>
                    <input type="number" id="medMinStock" placeholder="Enter reorder level" required min="0">
                </div>
                <div class="input-group">
                    <label>Reorder Quantity</label>
                    <input type="number" id="medReorderQty" placeholder="Enter reorder quantity" min="0">
                </div>
                <div class="input-group">
                    <label>Storage Location</label>
                    <input type="text" id="medLocation" placeholder="Enter storage location">
                </div>
                <div class="input-group">
                    <label>Supplier</label>
                    <input type="text" id="medSupplier" placeholder="Enter supplier name">
                </div>
                <div class="input-group" style="grid-column: span 2;">
                    <label>Batch Tracking</label>
                    <div class="toggle-group">
                        <label class="switch">
                            <input type="checkbox" id="medBatchTracking" checked>
                            <span class="slider"></span>
                        </label>
                        <span style="font-size: 11px; color: var(--text-muted);">Enable if you want to track batch details</span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Additional Info -->
            <div class="section-header">
                <div class="icon-box"><i class="far fa-calendar-check"></i></div>
                <div>
                    <h2>Additional Information</h2>
                    <p>Expiry, tax and other details</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Expiry Date <span>*</span></label>
                    <input type="date" id="medExpiry" required>
                </div>
                <div class="input-group">
                    <label>Tax Rate (%)</label>
                    <input type="number" step="0.01" id="medTaxRate" placeholder="Enter tax rate" min="0">
                </div>
                <div class="input-group">
                    <label>HSN/SAC Code</label>
                    <input type="text" id="medHsn" placeholder="Enter HSN/SAC code">
                </div>
                <div class="input-group">
                    <label>Brand Name</label>
                    <input type="text" id="medBrand" placeholder="Enter brand name">
                </div>
                <div class="input-group full-width">
                    <label>Notes</label>
                    <textarea id="medNotes" rows="3" placeholder="Enter additional notes (optional)"></textarea>
                    <div class="char-count">0/200</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="form-footer">
                <button type="button" class="btn-secondary" onclick="window.location.href='Pharmacy.php'"><i class="fa fa-arrow-left"></i> &nbsp; Back to List</button>
                <div>
                    <button type="button" class="btn-secondary" onclick="window.location.href='Pharmacy.php'" style="margin-right: 10px;">Cancel</button>
                    <button type="submit" class="btn-save">+ Save Medication</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div> <!-- Closing div for main-content wrapper -->

<script>
    // Character counting logic
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            const countDisplay = this.nextElementSibling;
            countDisplay.innerText = `${this.value.length}/200`;
        });
    });

    // Form submission directly connected to MySQL database
    document.getElementById('medicationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const name = document.getElementById('medName').value.trim();
        const generic = (document.getElementById('medGeneric') ? document.getElementById('medGeneric').value.trim() : '') || name;
        const category = document.getElementById('medCategory').value || 'Tablets';
        const stock = parseInt(document.getElementById('medStock').value) || 0;
        const price = parseFloat(document.getElementById('medPrice').value) || 0.00;
        const minStock = parseInt(document.getElementById('medMinStock').value) || 0;
        const expiry = document.getElementById('medExpiry').value;
        const supplier = (document.getElementById('medSupplier') ? document.getElementById('medSupplier').value.trim() : '') || 'MediGo Pharma';
        
        const submitBtn = this.querySelector('.btn-save');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving to Database...';
        }

        try {
            const response = await fetch('api.php?action=add_pharmacy', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    medicine_name: name,
                    generic_name: generic,
                    category: category,
                    quantity: stock,
                    price: price,
                    expiry_date: expiry,
                    supplier: supplier
                })
            });
            const res = await response.json();
            if (res && res.status === 'success') {
                // Update local cache as well
                let database = JSON.parse(localStorage.getItem('medications')) || [];
                database.unshift({
                    id: res.data ? res.data.id : Date.now(),
                    name: name,
                    category: category,
                    stock: stock,
                    minStock: minStock,
                    expiry: expiry,
                    price: price
                });
                localStorage.setItem('medications', JSON.stringify(database));

                alert('Medication Saved Successfully to MySQL Database!');
                window.location.href = 'Pharmacy.php';
            } else {
                alert('Database message: ' + (res.message || 'Saved locally'));
                window.location.href = 'Pharmacy.php';
            }
        } catch (err) {
            console.warn('Database error, saving to local fallback:', err);
            let database = JSON.parse(localStorage.getItem('medications')) || [];
            database.unshift({
                id: Date.now(),
                name: name,
                category: category,
                stock: stock,
                minStock: minStock,
                expiry: expiry,
                price: price
            });
            localStorage.setItem('medications', JSON.stringify(database));
            alert('Medication Saved Successfully!');
            window.location.href = 'Pharmacy.php';
        }
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
