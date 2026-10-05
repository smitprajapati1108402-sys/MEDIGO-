<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGo Admin Dashboard</title>
  <script>
    // Session Security Check: Redirect to login if not authenticated
    if (!localStorage.getItem('medigoCurrentAdmin')) {
      window.location.href = 'admin_login.php';
    }
  </script>

  <!-- Fonts & Icon Libraries -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- ChartJS for Interactive Data Visualization -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* ================= DESIGN VARIABLES & TOKENS ================= */
    :root {
      --primary: #0048ff;
      --primary-dark: #001d72;
      --primary-light: #eef4ff;
      --success: #00c853;
      --warning: #ff9800;
      --danger: #ff4d4d;
      --border-color: #e2e8f0;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --white: #ffffff;
      --bg-body: #f8fafc;
      --card-shadow: 0 4px 20px rgba(0, 29, 114, 0.04);
      --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ================= RESET & GENERAL LAYOUT ================= */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: var(--bg-body);
      color: var(--text-dark);
      line-height: 1.5;
      overflow-x: hidden;
    }

    .container {
      padding: 30px;
      max-width: 1440px;
      margin: 0 auto;
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

    .logo {
      font-size: 28px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
      letter-spacing: -0.5px;
    }

    .logo span {
      color: #6ab7ff;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 15px;
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

    /* ================= CONTENT CONTAINER SYSTEM ================= */
    .content-section {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }

    .content-section.active {
      display: block;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Common Section Container Elements */
    .panel-card {
      background: var(--white);
      padding: 30px;
      border-radius: 20px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(0, 0, 0, 0.03);
      margin-bottom: 25px;
    }

    .section-header-title {
      color: var(--primary-dark);
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* ================= 1. HOME SECTION COMPOSITIONS ================= */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      background: var(--white);
      padding: 20px 30px;
      border-radius: 20px;
      box-shadow: var(--card-shadow);
    }

    .welcome-info h1 {
      font-size: 24px;
      color: var(--primary-dark);
      font-weight: 700;
    }

    .welcome-info p {
      color: var(--text-muted);
      font-size: 14px;
    }

    .live-timer {
      text-align: right;
      background: var(--primary-light);
      padding: 10px 20px;
      border-radius: 12px;
      border-left: 4px solid var(--primary);
    }

    .live-timer .clock {
      font-size: 18px;
      font-weight: 700;
      color: var(--primary-dark);
    }

    .live-timer .date {
      font-size: 12px;
      color: var(--text-muted);
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--white);
      border-radius: 24px;
      padding: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      box-shadow: 0 10px 25px rgba(0, 72, 255, 0.15);
    }

    .hero-content {
      max-width: 60%;
    }

    .hero-welcome {
      background: rgba(255, 255, 255, 0.15);
      padding: 6px 15px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 600;
    }

    .hero h1 {
      font-size: 32px;
      margin-top: 15px;
      font-weight: 700;
    }

    .hero p {
      font-size: 15px;
      opacity: 0.9;
      margin-bottom: 25px;
    }

    .hero-buttons {
      display: flex;
      gap: 15px;
    }

    .hero-buttons .btn-primary {
      background: var(--white);
      color: var(--primary);
      border: none;
      padding: 12px 25px;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }

    .hero-buttons .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    .hero-buttons .btn-secondary {
      background: transparent;
      border: 2px solid var(--white);
      color: var(--white);
      padding: 12px 25px;
      border-radius: 10px;
      cursor: pointer;
      transition: var(--transition);
    }

    .hero-buttons .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .hero-image img {
      width: 180px;
    }

    /* Dashboard Statistics Grid */
    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: var(--white);
      padding: 25px;
      border-radius: 20px;
      text-align: left;
      position: relative;
      overflow: hidden;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      border: 1px solid rgba(0, 72, 255, 0.03);
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 72, 255, 0.08);
    }

    .stat-icon {
      position: absolute;
      right: 20px;
      top: 20px;
      font-size: 24px;
      background: var(--primary-light);
      color: var(--primary);
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
    }

    .stat-card.revenue .stat-icon {
      background: #fff3e0;
      color: var(--warning);
    }

    .stat-card.appointments .stat-icon {
      background: #e8f5e9;
      color: var(--success);
    }

    .stat-card.doctors .stat-icon {
      background: #e1f5fe;
      color: #0288d1;
    }

    .stat-card p {
      color: var(--text-muted);
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 5px;
    }

    .stat-card h2 {
      color: var(--primary-dark);
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .trend-badge {
      display: inline-flex;
      align-items: center;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 8px;
    }

    .trend-badge.up {
      background: #e8f5e9;
      color: var(--success);
    }

    .trend-badge.info {
      background: #e1f5fe;
      color: #0288d1;
    }

    /* Real-Time Live Widget Panel Grid */
    .realtime-grid {
      display: grid;
      grid-template-columns: 1.5fr 1.2fr;
      gap: 25px;
    }

    .widget-card {
      background: var(--white);
      padding: 25px;
      border-radius: 20px;
      box-shadow: var(--card-shadow);
    }

    .widget-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      border-bottom: 1px solid var(--primary-light);
      padding-bottom: 12px;
    }

    .widget-title h3 {
      color: var(--primary-dark);
      font-size: 17px;
      font-weight: 600;
    }

    .live-indicator {
      width: 8px;
      height: 8px;
      background-color: var(--success);
      border-radius: 50%;
      display: inline-block;
      animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 200, 83, 0.7);
      }

      70% {
        transform: scale(1);
        box-shadow: 0 0 0 8px rgba(0, 200, 83, 0);
      }

      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 200, 83, 0);
      }
    }

    .occupancy-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .occupancy-info {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      font-weight: 500;
    }

    .progress-track {
      width: 100%;
      height: 8px;
      background: var(--primary-light);
      border-radius: 5px;
      overflow: hidden;
      margin-top: 5px;
    }

    .progress-fill {
      height: 100%;
      border-radius: 5px;
      transition: width 1s ease-in-out;
    }

    /* Activity Feed */
    .activity-feed {
      height: 250px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .activity-item {
      display: flex;
      padding: 10px 14px;
      border-radius: 10px;
      background: #f8fafc;
      border-left: 4px solid var(--primary);
      animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .activity-item.success {
      border-left-color: var(--success);
    }

    .activity-item.warning {
      border-left-color: var(--warning);
    }

    .activity-item.danger {
      border-left-color: var(--danger);
    }

    .activity-text {
      font-size: 13px;
      font-weight: 500;
    }

    .activity-time {
      font-size: 11px;
      color: var(--text-muted);
    }

    /* ================= MODERN DATA TABLES (Doctors, Patients, Logs) ================= */
    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .table-search {
      position: relative;
    }

    .table-search input {
      padding: 10px 15px 10px 40px;
      border-radius: 10px;
      border: 1px solid var(--border-color);
      width: 250px;
      outline: none;
      font-size: 14px;
    }

    .table-search i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th {
      background-color: var(--primary-light);
      color: var(--primary-dark);
      font-weight: 600;
      text-align: left;
      padding: 14px 18px;
    }

    .data-table td {
      padding: 14px 18px;
      border-bottom: 1px solid var(--border-color);
      font-size: 14px;
    }

    .data-table tr:hover {
      background-color: rgba(238, 244, 255, 0.4);
    }

    .status-badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      display: inline-block;
    }

    .status-badge.available {
      background: #e8f5e9;
      color: var(--success);
    }

    .status-badge.busy {
      background: #fff3e0;
      color: var(--warning);
    }

    .status-badge.onleave {
      background: #ffebee;
      color: var(--danger);
    }

    /* Buttons & Inputs */
    .action-btn {
      background: var(--primary);
      color: var(--white);
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
    }

    .action-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
    }

    /* ================= 2. PHARMACY SECTION ================= */
    .pharmacy-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .pharmacy-card {
      background: var(--white);
      padding: 20px;
      border-radius: 15px;
      border: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--card-shadow);
    }

    .pharmacy-details h4 {
      font-size: 16px;
      color: var(--primary-dark);
    }

    .pharmacy-details p {
      font-size: 13px;
      color: var(--text-muted);
    }

    .stock-indicator {
      padding: 8px 12px;
      border-radius: 8px;
      font-weight: 700;
    }

    .stock-indicator.high {
      background: #e8f5e9;
      color: var(--success);
    }

    .stock-indicator.low {
      background: #ffebee;
      color: var(--danger);
    }

    /* ================= 3. BLOOD BANK SECTION ================= */
    .blood-bank-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .blood-bag {
      background: var(--white);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: var(--card-shadow);
      position: relative;
      overflow: hidden;
    }

    .blood-bag::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 77, 77, 0.15);
      transition: height 1s;
    }

    .blood-bag.fill-80::before {
      height: 80%;
    }

    .blood-bag.fill-60::before {
      height: 60%;
    }

    .blood-bag.fill-40::before {
      height: 40%;
    }

    .blood-bag.fill-20::before {
      height: 20%;
    }

    .blood-type {
      font-size: 28px;
      font-weight: 700;
      color: var(--danger);
      margin-bottom: 5px;
    }

    .blood-volume {
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 600;
    }

    /* ================= 4. SETTINGS SECTION ================= */
    .settings-grid {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 30px;
    }

    .settings-nav {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .settings-nav-btn {
      background: none;
      border: none;
      padding: 12px 18px;
      text-align: left;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-muted);
    }

    .settings-nav-btn:hover,
    .settings-nav-btn.active {
      background: var(--primary-light);
      color: var(--primary);
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-dark);
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: 1px solid var(--border-color);
      outline: none;
      font-size: 14px;
    }

    /* ================= 5. ABOUT SECTION ================= */
    .about-hero {
      text-align: center;
      padding: 40px 20px;
      background: var(--primary-light);
      border-radius: 20px;
      margin-bottom: 30px;
    }

    .about-hero h2 {
      font-size: 28px;
      color: var(--primary-dark);
      margin-bottom: 10px;
    }

    .about-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
    }

    .vision-card {
      background: var(--white);
      padding: 25px;
      border-radius: 15px;
      box-shadow: var(--card-shadow);
      border-left: 5px solid var(--primary);
    }

    /* ================= RESPONSIVE MEDIA QUERIES ================= */
    @media(max-width: 991px) {
      .navbar {
        padding: 15px 25px;
      }

      .mobile-toggle {
        display: block;
      }

      .nav-links {
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

      .nav-links.active {
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

      .hero {
        flex-direction: column;
        text-align: center;
        gap: 30px;
      }

      .hero-content {
        max-width: 100%;
      }

      .realtime-grid {
        grid-template-columns: 1fr;
      }

      .settings-grid {
        grid-template-columns: 1fr;
      }

      .about-grid {
        grid-template-columns: 1fr;
      }
    }
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
      <a href="#" class="nav-item-link active" onclick="showSection('homeSection', this)">Home</a>

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

      <a href="contact.php" class="nav-item-link">Contact</a>
      <a href="#" onclick="logout()"
        style="color: hsla(0, 100%, 65%, 0.979); font-weight: bold; margin-left: 10px;">Logout </a>
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

  <div class="container">

    <!-- ================= 1. HOME SECTION (ACTIVE BY DEFAULT) ================= -->
    <div id="homeSection" class="content-section active">
      <div class="dashboard-header">
        <div class="welcome-info">
          <h1 id="welcomeAdminName">Welcome Back, Admin</h1>
          <p>Operational data is live and connected.</p>
        </div>
        <div class="live-timer">
          <div class="clock" id="liveClock">00:00:00 AM</div>
          <div class="date" id="liveDate">Loading date...</div>
        </div>
      </div>

      <section class="hero">
        <div class="hero-content">
          <span class="hero-welcome"> Cloud Synchronized Management Panel</span>
          <h1>Smart Hospital Management System</h1>
          <p>Manage Patients, Doctors, Scheduled Shifts, Hospital Records, and Inventories in one centralized cloud
            database.</p>
          <div class="hero-buttons">
            <button class="btn-primary" onclick="window.location.href='patientmanagement.php'"> Register
              Patient</button>
            <button class="btn-secondary" onclick="showSection('reportsSection')"> Financial Charts</button>
          </div>
        </div>
        <div class="hero-image">
          <img src="https://cdn-icons-png.flaticon.com/512/2967/2967350.png" alt="Medical Illustration">
        </div>
      </section>

      <!-- Stat Dashboard Cards Grid -->
      <div class="stats">
        <div class="stat-card" onclick="window.location.href='patientmanagement.php'" style="cursor: pointer;">
          <span class="stat-icon"><i class="fa-solid fa-hospital-user"></i></span>
          <p>Total Patients</p>
          <h2 class="counter" id="totalPatientsCounter" data-target="3">0</h2>
          <span class="trend-badge up" id="totalPatientsSubtitle"><i class="fa-solid fa-arrow-trend-up"></i> 3
            Admitted</span>
        </div>

        <div class="stat-card doctors" onclick="window.location.href='doctormanagement.php'" style="cursor: pointer;">
          <span class="stat-icon"><i class="fa-solid fa-user-doctor"></i></span>
          <p>Active Doctors</p>
          <h2 class="counter" id="activeDoctorsCounter" data-target="4">0</h2>
          <span class="trend-badge info" id="activeDoctorsSubtitle"><i class="fa-solid fa-circle-check"></i> 3 Active
            Duty</span>
        </div>

        <div class="stat-card appointments" onclick="window.location.href='Appointment.php'" style="cursor: pointer;">
          <span class="stat-icon"><i class="fa-regular fa-calendar-check"></i></span>
          <p>Appointments</p>
          <h2 class="counter" id="totalAppointmentsCounter" data-target="4">0</h2>
          <span class="trend-badge up" id="totalAppointmentsSubtitle"><i class="fa-solid fa-arrow-trend-up"></i> Live Scheduled</span>
        </div>

        <div class="stat-card revenue" onclick="showSection('reportsSection')" style="cursor: pointer;">
          <span class="stat-icon"><i class="fa-solid fa-indian-rupee-sign"></i></span>
          <p>Total Revenue</p>
          <h2>&#8377;<span class="counter" data-target="12">0</span>L</h2>
          <span class="trend-badge up"><i class="fa-solid fa-arrow-trend-up"></i> +8% Overall</span>
        </div>
      </div>

      <!-- Live Performance Visual Widgets -->
      <div class="realtime-grid">
        <div class="widget-card">
          <div class="widget-title">
            <h3><i class="fa-solid fa-hospital"></i> Live Bed Occupancy Status</h3>
            <span class="live-indicator"></span>
          </div>
          <div class="occupancy-list">
            <div class="occupancy-info">
              <span>Intensive Care Unit (ICU)</span>
              <span>17/20 Beds Used (85%)</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" style="width: 85%; background: var(--danger);"></div>
            </div>

            <div class="occupancy-info" style="margin-top: 15px;">
              <span>Emergency Ward</span>
              <span>12/30 Beds Used (40%)</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" style="width: 40%; background: var(--warning);"></div>
            </div>

            <div class="occupancy-info" style="margin-top: 15px;">
              <span>General Ward Block</span>
              <span>110/120 Beds Used (91%)</span>
            </div>
            <div class="progress-track">
              <div class="progress-fill" style="width: 91%; background: var(--primary);"></div>
            </div>
          </div>
        </div>

        <div class="widget-card">
          <div class="widget-title">
            <h3><i class="fa-solid fa-wave-square"></i> Real-time Activity Ticker</h3>
            <span class="live-indicator" style="background: var(--primary);"></span>
          </div>
          <div class="activity-feed" id="liveActivityFeed">
            <div class="activity-item success">
              <div class="activity-text">Dr. Raj Patel checked into Cardiology Unit 1</div>
              <div class="activity-time">Just Now</div>
            </div>
            <div class="activity-item">
              <div class="activity-text">New patient registered: Arjun Sharma (Hypertension)</div>
              <div class="activity-time">5 mins ago</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= 2. DOCTORS SECTION ================= -->
    <div id="doctorsSection" class="content-section">
      <div class="panel-card">
        <div class="table-header">
          <h2 class="section-header-title"><i class="fa-solid fa-user-md"></i> Doctors Management</h2>
          <div class="table-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search Doctor..." id="doctorSearch" onkeyup="filterDoctors()">
          </div>
        </div>
        <table class="data-table" id="doctorsTable">
          <thead>
            <tr>
              <th>Doctor Name</th>
              <th>Department</th>
              <th>Status</th>
              <th>Experience</th>
            </tr>
          </thead>
          <tbody id="dashboardDoctorsTableBody">
            <!-- Dynamic rows will be inserted here via Javascript -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- ================= 3. PATIENTS SECTION ================= -->
    <div id="patientsSection" class="content-section">
      <div class="panel-card">
        <div class="table-header">
          <h2 class="section-header-title"><i class="fa-solid fa-procedures"></i> Patients Directory</h2>
          <button class="action-btn" onclick="window.location.href='patientmanagement.php'"><i
              class="fa-solid fa-plus"></i> New
            Patient</button>
        </div>
        <table class="data-table">
          <thead>
            <tr>
              <th>Patient Name</th>
              <th>Assigned Disease</th>
              <th>Condition Level</th>
            </tr>
          </thead>
          <tbody id="dashboardPatientsTableBody">
            <!-- Dynamic rows will be inserted here via Javascript -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- ================= 4. APPOINTMENTS SECTION ================= -->
    <div id="appointmentsSection" class="content-section">
      <div class="panel-card">
        <div class="table-header">
          <h2 class="section-header-title"><i class="fa-solid fa-calendar-check"></i> Scheduled Consultations</h2>
          <button class="action-btn" onclick="window.location.href='Appointment.php'"><i
              class="fa-solid fa-calendar-plus"></i> View All Appointments</button>
        </div>
        <div class="activity-feed" id="dashboardAppointmentsFeed">
          <div class="activity-item success">
            <div>
              <h4 style="margin:0; font-weight: 600;">Arjun Sharma (Cardiology)</h4>
              <span class="activity-time">Scheduled for 10:00 AM with Dr. Raj Patel</span>
            </div>
          </div>
          <div class="activity-item" style="border-left-color: var(--primary);">
            <div>
              <h4 style="margin:0; font-weight: 600;">Priya Verma (Neurology Consultation)</h4>
              <span class="activity-time">Scheduled for 02:30 PM with Dr. Jane Smith</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= 5. PHARMACY SECTION ================= -->
    <div id="pharmacySection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-pills"></i> Pharmacy Stock Management</h2>
        <div class="pharmacy-grid">
          <div class="pharmacy-card">
            <div class="pharmacy-details">
              <h4>Paracetamol 650mg</h4>
              <p>Type: Analgesic / Tablet</p>
            </div>
            <span class="stock-indicator high">12,450 Qty</span>
          </div>
          <div class="pharmacy-card">
            <div class="pharmacy-details">
              <h4>Amoxicillin 500mg</h4>
              <p>Type: Antibiotic</p>
            </div>
            <span class="stock-indicator low">420 Qty (Low)</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= 6. BLOOD BANK SECTION ================= -->
    <div id="bloodBankSection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-droplet"></i> Central Blood Bank Reserves</h2>
        <div class="blood-bank-grid">
          <div class="blood-bag fill-80">
            <div class="blood-type">A+</div>
            <div class="blood-volume">4.5 Liters</div>
          </div>
          <div class="blood-bag fill-60">
            <div class="blood-type">O+</div>
            <div class="blood-volume">3.2 Liters</div>
          </div>
          <div class="blood-bag fill-20">
            <div class="blood-type">B-</div>
            <div class="blood-volume">1.1 Liters</div>
          </div>
          <div class="blood-bag fill-40">
            <div class="blood-type">AB+</div>
            <div class="blood-volume">2.4 Liters</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= 7. REPORTS SECTION ================= -->
    <div id="reportsSection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-chart-bar"></i> Hospital Performance Analytics</h2>
        <div class="chart-card">
          <canvas id="analyticsChart"></canvas>
        </div>
      </div>
    </div>

    <!-- ================= 8. MEDICAL RECORDS ================= -->
    <div id="medicalRecordsSection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-folder-open"></i> Secure Digital Patient Logs</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>Log ID</th>
              <th>Patient Name</th>
              <th>Department Group</th>
              <th>Admission Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>#MGO-98122</td>
              <td>Amit Shah</td>
              <td>Orthopedic Review</td>
              <td>Jan 12, 2026</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ================= 9. SETTINGS SECTION ================= -->
    <div id="settingsSection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-sliders"></i> Admin System Settings</h2>
        <div class="settings-grid">
          <div class="settings-nav">
            <button class="settings-nav-btn active">General Settings</button>
            <button class="settings-nav-btn">Access Credentials</button>
          </div>
          <div class="settings-form">
            <div class="form-group">
              <label>Hospital Brand Display Title</label>
              <input type="text" value="MediGo Hospital Systems">
            </div>
            <div class="form-group">
              <label>Emergency Contact Route</label>
              <input type="text" value="+91-108">
            </div>
            <button class="action-btn" onclick="alert('Configuration Settings Saved')">Save Configurations</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= 10. ABOUT SECTION ================= -->
    <div id="aboutSection" class="content-section">
      <div class="about-hero">
        <h2>MediGo Hospital Solutions</h2>
        <p>Building high-performing interfaces for seamless healthcare workflow operations.</p>
      </div>
      <div class="about-grid">
        <div class="vision-card">
          <h3>Our Core Mission</h3>
          <p>To reduce clinic management overhead by delivering fast, cloud-based data tracking frameworks.</p>
        </div>
        <div class="vision-card">
          <h3>Our Strategic Vision</h3>
          <p>Implementing real-time medical updates across hospital systems globally.</p>
        </div>
      </div>
    </div>

    <!-- ================= 11. CONTACT SECTION ================= -->
    <div id="contactSection" class="content-section">
      <div class="panel-card">
        <h2 class="section-header-title"><i class="fa-solid fa-address-book"></i> Operational Technical Support</h2>
        <p>Need support or custom database integration?</p>
        <div style="margin-top: 20px;">
          <p><b>Technical Support Hotline:</b> +91 98765 43210</p>
          <p><b>Developer Support Mail:</b> devops@medigo.com</p>
        </div>
      </div>
    </div>

  </div>

  <!-- ================= JAVASCRIPT LOGIC ================= -->
  <script>
    // Toggle mobile menu visibility
    function toggleMobileMenu() {
      const menu = document.getElementById('navLinks');
      menu.classList.toggle('active');
    }

    // Global variable keeping track of active sections
    let activeChartInstance = null;

    // Routing layout transitions
    function showSection(sectionId, element = null) {
      // Hide all sections
      const sections = document.querySelectorAll('.content-section');
      sections.forEach(section => {
        section.classList.remove('active');
      });

      // Show selected section
      const targetSection = document.getElementById(sectionId);
      if (targetSection) {
        targetSection.classList.add('active');
      }

      // Handle active class highlighting in nav
      const navLinks = document.querySelectorAll('.nav-item-link, .nav-btn');
      navLinks.forEach(link => {
        link.classList.remove('active');
      });

      if (element) {
        element.classList.add('active');
      } else {
        // If routing was done through dropdown, highlight parent dropdown
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(drop => {
          if (drop.querySelector('.dropdown-content').contains(document.querySelector(`#${sectionId}`))) {
            drop.classList.add('active');
          }
        });
      }

      // Dynamic initialization for specific content sections
      if (sectionId === 'homeSection') {
        animateStatCounters();
      } else if (sectionId === 'reportsSection') {
        initChart();
      }

      // Close dropdowns upon routing link
      closeAllDropdowns();

      // Close mobile navigation drawer if open
      document.getElementById('navLinks').classList.remove('active');
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
        localStorage.removeItem('medigoCurrentAdmin');
        window.location.href = "admin_login.php";
      }
    }

    // Real-Time System Clock Function
    function updateSystemClock() {
      const clock = document.getElementById('liveClock');
      const dateStr = document.getElementById('liveDate');
      if (!clock || !dateStr) return;

      const now = new Date();

      let hours = now.getHours();
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');
      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12;

      clock.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;

      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      dateStr.textContent = now.toLocaleDateString('en-US', options);
    }
    setInterval(updateSystemClock, 1000);
    updateSystemClock();

    // Stat Counter Increment Animation
    function animateStatCounters() {
      const counters = document.querySelectorAll('.counter');
      counters.forEach(counter => {
        counter.innerText = '0';
        const target = +counter.getAttribute('data-target');
        const update = () => {
          const count = +counter.innerText;
          const speed = target / 35;
          if (count < target) {
            counter.innerText = Math.ceil(count + speed);
            setTimeout(update, 20);
          } else {
            counter.innerText = target;
          }
        };
        update();
      });
    }
    async function renderDashboardDoctors() {
      const defaultDoctors = [
        { id: 1, name: "Dr. Raj Patel", specialization: "Cardiology", email: "doctor@medigo.com", status: "Active", experience: "12+ Years" },
        { id: 2, name: "Dr. Jane Smith", specialization: "Neurology", email: "jane.smith@medigo.com", status: "Active", experience: "15+ Years" },
        { id: 3, name: "Dr. Robert Chen", specialization: "Pediatrics", email: "robert.chen@medigo.com", status: "Active", experience: "8+ Years" },
        { id: 4, name: "Dr. Marcus Vance", specialization: "Emergency Medicine", email: "marcus.v@medigo.com", status: "Active", experience: "10+ Years" }
      ];

      let doctors = defaultDoctors;
      try {
        const response = await fetch('api.php?action=get_doctors');
        const res = await response.json();
        if (res && res.status === 'success' && res.data && res.data.length > 0) {
          doctors = res.data.map(d => ({
            name: d.name,
            specialization: d.specialty || d.department,
            status: d.status || 'Active',
            experience: d.experience || '5+ Years'
          }));
        }
      } catch (err) {
        console.warn('Using local fallback for dashboard doctors:', err);
      }

      // Update the active doctors counter
      const activeCount = doctors.filter(d => d.status === 'Active' || d.status === 'Available').length;
      const totalCount = doctors.length;

      const activeCounterEl = document.getElementById('activeDoctorsCounter');
      if (activeCounterEl) {
        activeCounterEl.setAttribute('data-target', totalCount);
      }
      const activeSubtitleEl = document.getElementById('activeDoctorsSubtitle');
      if (activeSubtitleEl) {
        activeSubtitleEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${activeCount} Active Duty`;
      }

      const tbody = document.getElementById('dashboardDoctorsTableBody');
      if (tbody) {
        tbody.innerHTML = '';
        doctors.forEach(doc => {
          const statusClass = (doc.status === 'Active' || doc.status === 'Available') ? 'available' : 'onleave';
          const statusText = (doc.status === 'Active' || doc.status === 'Available') ? 'Available' : 'On Leave';

          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><b>${doc.name}</b></td>
            <td>${doc.specialization}</td>
            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
            <td>${doc.experience || '5 Years'}</td>
          `;
          tbody.appendChild(tr);
        });
      }
      animateStatCounters();
    }

    async function renderDashboardPatients() {
      const defaultPatients = [
        { id: 101, name: "Arjun Sharma", disease: "Hypertension", condition: "Stable" },
        { id: 102, name: "Priya Verma", disease: "Migraine", condition: "Critical" },
        { id: 103, name: "Rohan Gupta", disease: "Seasonal Flu", condition: "Stable" }
      ];

      let patients = defaultPatients;
      try {
        const response = await fetch('api.php?action=get_patients');
        const res = await response.json();
        if (res && res.status === 'success' && res.data && res.data.length > 0) {
          patients = res.data.map(p => ({
            name: p.name,
            disease: p.disease || 'General',
            condition: p.status === 'Discharged' ? 'Stable' : 'Admitted'
          }));
        }
      } catch (err) {
        console.warn('Using local fallback for dashboard patients:', err);
      }

      const totalCount = patients.length;

      const totalCounterEl = document.getElementById('totalPatientsCounter');
      if (totalCounterEl) {
        totalCounterEl.setAttribute('data-target', totalCount);
      }
      const totalSubtitleEl = document.getElementById('totalPatientsSubtitle');
      if (totalSubtitleEl) {
        totalSubtitleEl.innerHTML = `<i class="fa-solid fa-procedures"></i> ${totalCount} Registered`;
      }

      const tbody = document.getElementById('dashboardPatientsTableBody');
      if (tbody) {
        tbody.innerHTML = '';
        patients.forEach(pat => {
          let badgeClass = 'available';
          if (pat.condition === 'Serious' || pat.condition === 'Admitted') badgeClass = 'busy';
          if (pat.condition === 'Critical') badgeClass = 'onleave';

          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td><b>${pat.name}</b></td>
            <td>${pat.disease}</td>
            <td><span class="status-badge ${badgeClass}">${pat.condition}</span></td>
          `;
          tbody.appendChild(tr);
        });
      }
      animateStatCounters();
    }

    async function renderDashboardStats() {
      try {
        const response = await fetch('api.php?action=get_dashboard_stats');
        const res = await response.json();
        if (res && res.status === 'success' && res.data) {
          const appCounterEl = document.getElementById('totalAppointmentsCounter');
          if (appCounterEl) {
            appCounterEl.setAttribute('data-target', res.data.total_appointments || 4);
          }
          const appSubEl = document.getElementById('totalAppointmentsSubtitle');
          if (appSubEl) {
            appSubEl.innerHTML = `<i class="fa-solid fa-calendar-check"></i> ${res.data.total_appointments || 4} Scheduled`;
          }
        }
      } catch (err) {
        console.warn('Dashboard stats fallback:', err);
      }
      animateStatCounters();
    }

    async function renderDashboardAppointments() {
      const feed = document.getElementById('dashboardAppointmentsFeed');
      if (!feed) return;

      try {
        const response = await fetch('api.php?action=get_appointments');
        const res = await response.json();
        if (res && res.status === 'success' && res.data && res.data.length > 0) {
          feed.innerHTML = '';
          res.data.slice(0, 5).forEach(app => {
            const isConfirmed = app.status === 'Confirmed';
            const item = document.createElement('div');
            item.className = `activity-item ${isConfirmed ? 'success' : ''}`;
            if (!isConfirmed) item.style.borderLeftColor = 'var(--primary)';
            item.innerHTML = `
              <div>
                <h4 style="margin:0; font-weight: 600;">${app.patient_name} (${app.department || 'General'})</h4>
                <span class="activity-time">Scheduled for ${app.appointment_time} with ${app.doctor_name}</span>
              </div>
            `;
            feed.appendChild(item);
          });
        }
      } catch (err) {
        console.warn('Appointments feed fallback:', err);
      }
    }

    renderDashboardDoctors();
    renderDashboardPatients();
    renderDashboardStats();
    renderDashboardAppointments();

    // Display admin name dynamically
    const currentAdminStr = localStorage.getItem('medigoCurrentAdmin');
    if (currentAdminStr) {
      try {
        const adminObj = JSON.parse(currentAdminStr);
        if (adminObj && adminObj.name) {
          let displayName = adminObj.name;
          if (displayName.includes('@')) {
            const rawPart = displayName.split('@')[0];
            displayName = rawPart.replace(/[._\-+0-9]+/g, ' ').trim();
            displayName = displayName.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()).join(' ');
            adminObj.name = displayName;
            try { localStorage.setItem('medigoCurrentAdmin', JSON.stringify(adminObj)); } catch(e){}
          }
          const welcomeEl = document.getElementById('welcomeAdminName');
          if (welcomeEl) {
            welcomeEl.textContent = `Welcome Back, ${displayName || 'Admin'}`;
          }
        }
      } catch (e) {
        console.error("Error parsing current admin info:", e);
      }
    }

    // Check query parameters to show active section on page load
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section');
    if (section) {
      let navElement = null;
      const links = document.querySelectorAll('.nav-item-link');
      links.forEach(link => {
        if (link.getAttribute('onclick') && link.getAttribute('onclick').includes(section)) {
          navElement = link;
        }
      });
      showSection(section, navElement);
    }


    // Simulated logs added dynamically on runtime interval
    const systemLogsList = [
      { text: "Pharmacy Log: Reordered Antibiotic Amoxicillin stocks", type: "success" },
      { text: "Admin Access: Configuration setting file updated", type: "warning" },
      { text: "Blood Reserve Update: A+ bag safely indexed", type: "success" },
      { text: "Appointment Log: Patient Dr. Priya shift modified", type: "normal" }
    ];

    function injectSystemActivity() {
      const feed = document.getElementById('liveActivityFeed');
      if (!feed) return;

      const randomIndex = Math.floor(Math.random() * systemLogsList.length);
      const selectedLog = systemLogsList[randomIndex];

      const wrapper = document.createElement('div');
      wrapper.className = `activity-item ${selectedLog.type !== 'normal' ? selectedLog.type : ''}`;
      wrapper.innerHTML = `
    <div class="activity-details">
      <div class="activity-text">${selectedLog.text}</div>
      <div class="activity-time">Just Now</div>
    </div>
  `;

      feed.insertBefore(wrapper, feed.firstChild);
      if (feed.children.length > 5) {
        feed.removeChild(feed.lastChild);
      }
    }
    setInterval(injectSystemActivity, 9000);

    // Simple table filtering engine
    function filterDoctors() {
      const query = document.getElementById('doctorSearch').value.toLowerCase();
      const rows = document.querySelectorAll('#doctorsTable tbody tr');
      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    }

    // Chart.js implementation details
    function initChart() {
      const ctx = document.getElementById('analyticsChart');
      if (!ctx) return;

      if (activeChartInstance) {
        activeChartInstance.destroy();
      }

      activeChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
          datasets: [
            {
              label: 'Total Admissions',
              data: [150, 280, 320, 450, 520, 700, 820],
              borderColor: '#0048ff',
              backgroundColor: 'rgba(0, 72, 255, 0.08)',
              fill: true,
              tension: 0.4
            },
            {
              label: 'In-Patient Revenue (\u20b9K)',
              data: [50, 80, 120, 150, 190, 240, 300],
              borderColor: '#ff9800',
              backgroundColor: 'rgba(255, 152, 0, 0.08)',
              fill: true,
              tension: 0.4
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top' }
          }
        }
      });
    }
  </script>

</body>

</html>
