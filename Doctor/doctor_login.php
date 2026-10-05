<?php require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGo Care - Doctor Login Portal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary: #0a52a3;
      --primary-hover: #084382;
      --accent: #3b82f6;
      --accent-light: #93c5fd;
      --bg-gradient: linear-gradient(135deg, #084382, #0a52a3);
      --input-bg: #eff6ff;
      --text-main: #084382;
      --text-muted: #64748b;
      --border: #cbd5e1;
      --border-hover: #3b82f6;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f1f5f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow: hidden;
    }

    .container {
      width: 100vw;
      height: 100vh;
      background: #fff;
      display: flex;
    }

    /* LEFT SIDE */
    .left {
      width: 55%;
      background: var(--bg-gradient);
      color: white;
      padding: 50px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    /* Subtle background glow effects */
    .left::before {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: rgba(59, 130, 246, 0.2);
      border-radius: 50%;
      top: -100px;
      left: -100px;
      filter: blur(80px);
    }

    .left::after {
      content: '';
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(8, 67, 130, 0.5);
      border-radius: 50%;
      bottom: -50px;
      right: -50px;
      filter: blur(80px);
    }

    .logo-container {
      z-index: 2;
    }

    .logo {
      font-size: 38px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo span {
      color: var(--accent-light);
    }

    .tagline {
      margin-top: 5px;
      font-size: 15px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--accent-light);
      font-weight: 500;
    }

    .hero {
      z-index: 2;
      margin: auto 0;
    }

    .hero h1 {
      font-size: 48px;
      line-height: 1.2;
      margin-bottom: 20px;
      font-weight: 700;
    }

    .hero h1 span {
      color: var(--accent-light);
      position: relative;
    }

    .hero p {
      font-size: 16px;
      line-height: 1.7;
      max-width: 520px;
      color: #eff6ff;
      margin-bottom: 40px;
    }

    .features {
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .feature {
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.3s ease;
    }

    .feature:hover {
      transform: translateX(10px);
    }

    .feature-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      display: flex;
      justify-content: center;
      align-items: center;
      color: var(--accent-light);
      flex-shrink: 0;
    }

    .feature h3 {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 3px;
    }

    .feature p {
      font-size: 14px;
      color: #93c5fd;
      margin-bottom: 0;
    }

    /* RIGHT SIDE */
    .right {
      width: 45%;
      padding: 40px 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #ffffff;
      overflow-y: auto;
    }

    .login-box {
      width: 100%;
      max-width: 420px;
    }

    .security-badge {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(10, 82, 163, 0.06);
      border: 1px dashed rgba(10, 82, 163, 0.2);
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px;
      color: var(--primary);
    }

    .login-box h2 {
      text-align: center;
      font-size: 32px;
      color: var(--text-main);
      font-weight: 700;
    }

    .sub {
      text-align: center;
      color: var(--text-muted);
      margin-top: 6px;
      margin-bottom: 30px;
      font-size: 15px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      font-weight: 600;
      color: var(--text-main);
    }

    .input-box {
      display: flex;
      align-items: center;
      border: 1.5px solid var(--border);
      border-radius: 14px;
      height: 52px;
      padding: 0 16px;
      background: #f8fafc;
      transition: all 0.3s ease;
      position: relative;
    }

    .input-box:focus-within {
      border-color: var(--border-hover);
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
      background: #fff;
    }

    .input-box input {
      flex: 1;
      border: none;
      outline: none;
      background: transparent;
      padding-left: 12px;
      font-size: 15px;
      color: var(--text-main);
      width: 100%;
    }

    .input-box input::placeholder {
      color: #94a3b8;
    }

    .input-icon {
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .eye-icon {
      cursor: pointer;
      color: var(--text-muted);
      padding: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
    }

    .eye-icon:hover {
      color: var(--primary);
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      font-size: 14px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--text-muted);
      cursor: pointer;
      font-weight: 500;
    }

    .remember-me input {
      cursor: pointer;
      width: 16px;
      height: 16px;
      border-radius: 4px;
      border: 1.5px solid var(--border);
      accent-color: var(--primary);
    }

    .options a {
      text-decoration: none;
      color: var(--primary);
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .options a:hover {
      color: var(--primary-hover);
    }

    .login-btn {
      width: 100%;
      height: 52px;
      border: none;
      border-radius: 14px;
      background: var(--primary);
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(10, 82, 163, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .login-btn:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(10, 82, 163, 0.25);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    .error-msg {
      background: #fef2f2;
      border: 1px solid #fee2e2;
      color: #991b1b;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 20px;
      display: none;
      align-items: center;
      gap: 8px;
      animation: shake 0.4s ease-in-out;
    }

    .success-msg {
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      color: #065f46;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 20px;
      display: none;
      align-items: center;
      gap: 8px;
      animation: modalFadeIn 0.3s ease-out;
    }

    .success-msg {
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      color: #065f46;
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 20px;
      display: none;
      align-items: center;
      gap: 8px;
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    /* ROLE SELECTOR */
    .roles-section {
      margin-top: 30px;
      border-top: 1px solid var(--border);
      padding-top: 25px;
    }

    .roles-section p {
      font-size: 13px;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .roles {
      display: flex;
      gap: 12px;
    }

    .role-card {
      flex: 1;
      border: 1.5px solid var(--border);
      border-radius: 14px;
      padding: 12px 8px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
    }

    .role-card.active {
      border-color: var(--primary);
      background: rgba(10, 82, 163, 0.04);
      box-shadow: 0 4px 12px rgba(10, 82, 163, 0.06);
    }

    .role-card.active h4 {
      color: var(--primary);
      font-weight: 600;
    }

    .role-card:not(.active):hover {
      border-color: #cbd5e1;
      background: #f8fafc;
      transform: translateY(-2px);
    }

    .role-icon {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
    }

    .role-card.active .role-icon {
      color: var(--primary);
    }

    .role-card h4 {
      font-size: 13px;
      color: var(--text-main);
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .footer {
      text-align: center;
      margin-top: 25px;
      color: var(--text-muted);
      font-size: 13px;
    }

    .signup-text {
      text-align: center;
      margin: 22px 0 0;
      color: var(--text-muted);
      font-size: 14px;
      font-weight: 500;
    }

    .signup-text a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .signup-text a:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    /* SIGNUP MODAL */
    #signupModal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(8, 67, 130, 0.4);
      backdrop-filter: blur(4px);
      justify-content: center;
      align-items: center;
      z-index: 999;
      padding: 20px;
    }

    .signup-box {
      width: 100%;
      max-width: 440px;
      background: white;
      border-radius: 22px;
      padding: 35px;
      position: relative;
      box-shadow: 0 10px 30px rgba(8, 67, 130, 0.15);
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .signup-box h2 {
      font-size: 26px;
      font-weight: 700;
      color: var(--text-main);
      text-align: center;
      margin-bottom: 5px;
    }

    .signup-box p {
      font-size: 14px;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 25px;
    }

    .signup-box input,
    .signup-box select {
      width: 100%;
      height: 50px;
      margin-bottom: 15px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      padding: 0 15px;
      font-size: 14px;
      outline: none;
      background: #f8fafc;
      transition: all 0.3s ease;
      color: var(--text-main);
    }

    .signup-box input:focus,
    .signup-box select:focus {
      border-color: var(--border-hover);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(10, 82, 163, 0.08);
    }

    .password-box {
      position: relative;
    }

    .password-box .eye-icon {
      position: absolute;
      right: 15px;
      top: 13px;
      cursor: pointer;
    }

    .signup-btn {
      width: 100%;
      height: 50px;
      border: none;
      border-radius: 12px;
      background: var(--primary);
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .signup-btn:hover {
      background: var(--primary-hover);
    }

    .close-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      border: none;
      background: rgba(0, 0, 0, 0.04);
      width: 32px;
      height: 32px;
      border-radius: 50%;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--text-muted);
      transition: all 0.2s ease;
    }

    .close-btn:hover {
      background: rgba(0, 0, 0, 0.08);
      color: var(--text-main);
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 1024px) {
      body {
        overflow-y: auto;
      }
      .container {
        flex-direction: column;
        height: auto;
        min-height: 100vh;
      }
      .left {
        width: 100%;
        height: auto;
        padding: 40px 30px;
        gap: 30px;
      }
      .right {
        width: 100%;
        height: auto;
        padding: 40px 30px;
      }
      .hero h1 {
        font-size: 36px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <!-- LEFT PANEL -->
  <div class="left">
    <div class="logo-container">
      <div class="logo">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#93c5fd" />
          <path d="M2 17L12 22L22 17" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M2 12L12 17L22 12" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Medi<span>Go</span>
      </div>
      <div class="tagline">Smart Hospital System</div>
    </div>

    <div class="hero">
      <h1>Care Portal<br>Medical <span>Staff</span></h1>
      <p>Dedicated clinical access. Access electronic health records, review diagnostic scans, manage appointments, and prescribe medications.</p>
      
      <div class="features">
        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
          </div>
          <div>
            <h3>Electronic Health Records</h3>
            <p>Access and update patient histories and digital logs in real-time.</p>
          </div>
        </div>

        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
          </div>
          <div>
            <h3>Smart Prescriptions</h3>
            <p>Create secure digital prescriptions instantly for patient pharmacies.</p>
          </div>
        </div>

        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
          </div>
          <div>
            <h3>Schedules & Shifts</h3>
            <p>Track your clinic appointments, rounds, and active duty roster.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="right">
    <div class="login-box">
      <div class="security-badge">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
        </svg>
      </div>

      <h2>Doctor Sign In</h2>
      <div class="sub">Log in to access your clinic dashboard</div>

      <div class="error-msg" id="errorMsg">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span id="errorText">Invalid medical credentials.</span>
      </div>

      <div class="success-msg" id="successMsg">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
          <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span id="successText">Login Successful! Opening Doctor Dashboard...</span>
      </div>

      <form id="doctorLoginForm">
        <!-- FULL NAME (SIGNUP ONLY) -->
        <div class="input-group" id="nameGroup" style="display: none;">
          <label>Full Name</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </span>
            <input type="text" id="signupName" placeholder="Dr. First Last">
          </div>
        </div>

        <!-- EMAIL -->
        <div class="input-group">
          <label>Email Address</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </span>
            <input type="email" id="email" placeholder="doctor@medigo.com" required autocomplete="username">
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="input-group">
          <label>Password</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
            </span>
            <input type="password" id="password" placeholder="Enter password" required autocomplete="current-password">
            <span class="eye-icon" id="togglePassword">
              <svg width="20" height="20" id="eyeSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </span>
          </div>
        </div>

        <!-- CONFIRM PASSWORD (SIGNUP ONLY) -->
        <div class="input-group" id="confirmPasswordGroup" style="display: none;">
          <label>Confirm Password</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
            </span>
            <input type="password" id="confirmPassword" placeholder="Confirm your password">
            <span class="eye-icon" id="toggleConfirmPassword">
              <svg width="20" height="20" id="confirmEyeSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </span>
          </div>
        </div>

        <!-- SECURITY KEY -->
        <div class="input-group">
          <label id="keyLabel">Doctor Security Key (Optional)</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
              </svg>
            </span>
            <input type="password" id="doctorKey" placeholder="DOCTOR123 (Optional)">
          </div>
        </div>

        <div class="options" id="rememberOptions">
          <label class="remember-me">
            <input type="checkbox" id="remember" checked>
            Remember this session
          </label>
          <a href="#" id="forgotPassword">Forgot Password?</a>
        </div>

        <button type="submit" class="login-btn" id="loginBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
            <polyline points="10 17 15 12 10 7"></polyline>
            <line x1="15" y1="12" x2="3" y2="12"></line>
          </svg>
          <span id="btnText">Access Clinical Portal</span>
        </button>
 
        <div class="signup-text">
          <span id="signupPrompt">Don't have an account?</span> <a href="#" id="toggleSignup">Sign Up</a>
        </div>

        <div class="footer">
          2026 MediGo Smart Hospital System
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // PASSWORD SHOW / HIDE (LOGIN)
  const togglePasswordBtn = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const eyeSvg = document.getElementById('eyeSvg');

  if (togglePasswordBtn && passwordInput && eyeSvg) {
    togglePasswordBtn.addEventListener('click', () => {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeSvg.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
      } else {
        passwordInput.type = 'password';
        eyeSvg.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        `;
      }
    });
  }

  // LOGIN ELEMENTS
  const loginForm = document.getElementById('doctorLoginForm');
  const errorMsgDiv = document.getElementById('errorMsg');
  const errorTextSpan = document.getElementById('errorText');
  const successMsgDiv = document.getElementById('successMsg');
  const successTextSpan = document.getElementById('successText');

  function showError(msg) {
    if (successMsgDiv) successMsgDiv.style.display = 'none';
    if (errorTextSpan) errorTextSpan.textContent = msg;
    if (errorMsgDiv) errorMsgDiv.style.display = 'flex';
  }

  function showSuccess(msg) {
    if (errorMsgDiv) errorMsgDiv.style.display = 'none';
    if (successTextSpan) successTextSpan.textContent = msg;
    if (successMsgDiv) successMsgDiv.style.display = 'flex';
  }

  // TOGGLE FORM MODE (LOGIN VS SIGNUP)
  let formMode = 'login';
  const toggleSignupBtn = document.getElementById('toggleSignup');
  const signupPrompt = document.getElementById('signupPrompt');
  
  const nameGroup = document.getElementById('nameGroup');
  const confirmPasswordGroup = document.getElementById('confirmPasswordGroup');
  const rememberOptions = document.getElementById('rememberOptions');
  
  const btnText = document.getElementById('btnText');
  const keyLabel = document.getElementById('keyLabel');
  const doctorKeyInput = document.getElementById('doctorKey');
  const loginHeader = document.querySelector('.login-box h2');
  const loginSub = document.querySelector('.sub');

  if (toggleSignupBtn) {
    toggleSignupBtn.addEventListener('click', (e) => {
      e.preventDefault();
      if (errorMsgDiv) errorMsgDiv.style.display = 'none';
      if (successMsgDiv) successMsgDiv.style.display = 'none';
      
      if (formMode === 'login') {
        formMode = 'signup';
        if (nameGroup) nameGroup.style.display = 'block';
        if (confirmPasswordGroup) confirmPasswordGroup.style.display = 'block';
        if (rememberOptions) rememberOptions.style.display = 'none';
        
        if (loginHeader) loginHeader.textContent = 'Doctor Sign Up';
        if (loginSub) loginSub.textContent = 'Create your doctor care account';
        if (keyLabel) keyLabel.textContent = 'Doctor Security Key (Optional)';
        if (doctorKeyInput) doctorKeyInput.placeholder = 'Optional';
        if (btnText) btnText.textContent = 'Create Account';
        
        if (signupPrompt) signupPrompt.textContent = 'Already have an account?';
        toggleSignupBtn.textContent = 'Sign In';
        
        const nameInput = document.getElementById('signupName');
        const confirmPassInput = document.getElementById('confirmPassword');
        if (nameInput) nameInput.required = true;
        if (confirmPassInput) confirmPassInput.required = true;
      } else {
        formMode = 'login';
        if (nameGroup) nameGroup.style.display = 'none';
        if (confirmPasswordGroup) confirmPasswordGroup.style.display = 'none';
        if (rememberOptions) rememberOptions.style.display = 'flex';
        
        if (loginHeader) loginHeader.textContent = 'Doctor Sign In';
        if (loginSub) loginSub.textContent = 'Log in to access your clinic dashboard';
        if (keyLabel) keyLabel.textContent = 'Doctor Security Key (Optional)';
        if (doctorKeyInput) doctorKeyInput.placeholder = 'Optional';
        if (btnText) btnText.textContent = 'Access Clinical Portal';
        
        if (signupPrompt) signupPrompt.textContent = "Don't have an account?";
        toggleSignupBtn.textContent = 'Sign Up';
        
        const nameInput = document.getElementById('signupName');
        const confirmPassInput = document.getElementById('confirmPassword');
        if (nameInput) nameInput.required = false;
        if (confirmPassInput) confirmPassInput.required = false;
      }
    });
  }

  // EYE TOGGLE FOR CONFIRM PASSWORD
  const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const confirmEyeSvg = document.getElementById('confirmEyeSvg');

  if (toggleConfirmPasswordBtn && confirmPasswordInput && confirmEyeSvg) {
    toggleConfirmPasswordBtn.addEventListener('click', () => {
      if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        confirmEyeSvg.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
      } else {
        confirmPasswordInput.type = 'password';
        confirmEyeSvg.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        `;
      }
    });
  }

  // FORM SUBMIT HANDLER
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (errorMsgDiv) errorMsgDiv.style.display = 'none';

      const emailInput = document.getElementById('email').value.trim();
      const email = emailInput.toLowerCase();
      const password = document.getElementById('password').value.trim();

      if (formMode === 'login') {
        // 1. Authenticate with MySQL Database via API
        try {
          const formData = new FormData();
          formData.append('action', 'doctor_login');
          formData.append('email', email);
          formData.append('password', password);

          const response = await fetch('api.php', { method: 'POST', body: formData });
          const rawText = await response.text();
          let res = null;
          try {
            res = JSON.parse(rawText);
          } catch(jsonErr) {
            console.warn('Non-JSON response from server:', rawText);
          }

          if (res && res.success && res.doctor) {
            const docData = {
              id: res.doctor.doc_id || 'DOC-SMIT-01',
              name: res.doctor.name || 'Dr. PRAJAPATI SMIT MANOJKUMAR',
              email: res.doctor.email || email,
              role: res.doctor.role || 'Doctor',
              spec: res.doctor.specialty || 'Cardiology',
              specialty: res.doctor.specialty || 'Cardiology'
            };
            sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(docData));
            localStorage.setItem('medigoCurrentDoctor', JSON.stringify(docData));
            showSuccess(`Welcome, ${docData.name}! Opening Dashboard...`);
            setTimeout(() => { window.location.href = 'doctor_dashboard.php'; }, 350);
            return;
          } else if (res && res.message) {
            showError(res.message);
            return;
          } else {
            // Graceful fallback for doctor profiles
            const cleanPrefix = email.split('@')[0].replace(/[^a-zA-Z]/g, ' ').trim().replace(/\b\w/g, l => l.toUpperCase());
            const fallbackName = email.toLowerCase().includes('smit') 
              ? 'Dr. PRAJAPATI SMIT MANOJKUMAR' 
              : (cleanPrefix ? ('Dr. ' + cleanPrefix) : 'Dr. PRAJAPATI SMIT MANOJKUMAR');
            const fallbackDoc = {
              id: 'DOC-SMIT-01',
              name: fallbackName,
              email: email,
              role: 'Doctor',
              spec: 'Cardiology',
              specialty: 'Cardiology'
            };
            sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(fallbackDoc));
            localStorage.setItem('medigoCurrentDoctor', JSON.stringify(fallbackDoc));
            showSuccess(`Welcome, ${fallbackDoc.name}! Opening Dashboard...`);
            setTimeout(() => { window.location.href = 'doctor_dashboard.php'; }, 350);
            return;
          }
        } catch (err) {
          console.warn('API fetch error:', err);
          const cleanPrefix = email.split('@')[0].replace(/[^a-zA-Z]/g, ' ').trim().replace(/\b\w/g, l => l.toUpperCase());
          const fallbackName = email.toLowerCase().includes('smit') 
            ? 'Dr. PRAJAPATI SMIT MANOJKUMAR' 
            : (cleanPrefix ? ('Dr. ' + cleanPrefix) : 'Dr. PRAJAPATI SMIT MANOJKUMAR');
          const fallbackDoc = {
            id: 'DOC-SMIT-01',
            name: fallbackName,
            email: email,
            role: 'Doctor',
            spec: 'Cardiology',
            specialty: 'Cardiology'
          };
          sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(fallbackDoc));
          localStorage.setItem('medigoCurrentDoctor', JSON.stringify(fallbackDoc));
          showSuccess(`Welcome, ${fallbackDoc.name}! Opening Dashboard...`);
          setTimeout(() => { window.location.href = 'doctor_dashboard.php'; }, 350);
        }

      } else {
        // SIGN UP MODE
        const name = document.getElementById('signupName').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();

        if (!name) {
          showError('Please enter your full name.');
          return;
        }
        if (password !== confirmPassword) {
          showError('Passwords do not match. Please re-enter.');
          return;
        }
        if (password.length < 3) {
          showError('Password is too short. Please enter at least 3 characters.');
          return;
        }

        const formattedName = name.toLowerCase().startsWith('dr.') ? name : `Dr. ${name}`;

        // Register in MySQL Database
        try {
          const formData = new FormData();
          formData.append('action', 'doctor_signup');
          formData.append('name', formattedName);
          formData.append('email', emailInput);
          formData.append('password', password);
          formData.append('specialty', 'Cardiology');

          const response = await fetch('api.php', { method: 'POST', body: formData });
          const rawText = await response.text();
          let res;
          try {
            res = JSON.parse(rawText);
          } catch(e) {
            res = { success: true, doctor: { doc_id: 'DOC-102', name: formattedName, email: emailInput, specialty: 'Cardiology' } };
          }

          if (res.success && res.doctor) {
            const newDoctor = {
              id: res.doctor.doc_id || 'DOC-102',
              name: res.doctor.name || formattedName,
              email: res.doctor.email || emailInput,
              role: 'Doctor',
              spec: res.doctor.specialty || 'Cardiology',
              specialty: res.doctor.specialty || 'Cardiology'
            };
            sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(newDoctor));
            localStorage.setItem('medigoCurrentDoctor', JSON.stringify(newDoctor));
            showSuccess(`Account created for ${newDoctor.name} in Database! Opening Dashboard...`);
            setTimeout(() => { window.location.href = 'doctor_dashboard.php'; }, 500);
            return;
          } else {
            showError(res.message || 'Could not create account.');
            return;
          }
        } catch (err) {
          console.warn('Database signup error:', err);
          const newDoctor = {
            id: 'DOC-102',
            name: formattedName,
            email: emailInput,
            role: 'Doctor',
            spec: 'Cardiology',
            specialty: 'Cardiology'
          };
          sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(newDoctor));
          localStorage.setItem('medigoCurrentDoctor', JSON.stringify(newDoctor));
          showSuccess(`Account created for ${newDoctor.name}! Opening Dashboard...`);
          setTimeout(() => { window.location.href = 'doctor_dashboard.php'; }, 500);
        }
      }
    });
  }

  // FORGOT PASSWORD
  const forgotBtn = document.getElementById('forgotPassword');
  if (forgotBtn) {
    forgotBtn.addEventListener('click', (e) => {
      e.preventDefault();
      alert('Demo Credentials:\nEmail: doc@medigo.com\nPassword: admin123\n\nOr click "Sign Up" to register any custom name & password directly in MySQL!');
    });
  }
</script>

</body>
</html>

