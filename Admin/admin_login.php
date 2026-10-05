<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGo Shield - Admin Login Portal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary: #1e3a8a;
      --primary-hover: #172554;
      --accent: #3b82f6;
      --accent-light: #93c5fd;
      --bg-gradient: linear-gradient(135deg, #0f172a, #1e3a8a);
      --input-bg: #f8fafc;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
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
      background: rgba(30, 58, 138, 0.5);
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
      color: #cbd5e1;
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
      color: #94a3b8;
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
      background: rgba(30, 58, 138, 0.06);
      border: 1px dashed rgba(30, 58, 138, 0.2);
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
      background: var(--input-bg);
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
      color: var(--accent);
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .options a:hover {
      color: var(--primary);
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
      box-shadow: 0 4px 12px rgba(30, 58, 138, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .login-btn:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(30, 58, 138, 0.25);
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
      background: rgba(30, 58, 138, 0.04);
      box-shadow: 0 4px 12px rgba(30, 58, 138, 0.06);
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
      background: rgba(30, 58, 138, 0.4);
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
      box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
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
      box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.08);
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
      <h1>Shield Portal<br>System <span>Admin</span></h1>
      <p>Authorized access only. As an administrator, you have full control over databases, system configurations, and staff oversight.</p>
      
      <div class="features">
        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <div>
            <h3>User Access Controls</h3>
            <p>Assign credentials and manage dashboard privileges.</p>
          </div>
        </div>

        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
          </div>
          <div>
            <h3>Enterprise Security</h3>
            <p>Ensure network encryption and complete HIPAA compliance.</p>
          </div>
        </div>

        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="20" x2="18" y2="10"></line>
              <line x1="12" y1="20" x2="12" y2="4"></line>
              <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
          </div>
          <div>
            <h3>Infrastructure Auditing</h3>
            <p>Monitor uptime records and hospital system analytics.</p>
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
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
        </svg>
      </div>

      <h2>Admin Sign In</h2>
      <div class="sub">Log in to your administrative dashboard</div>

      <div class="error-msg" id="errorMsg">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span id="errorText">Invalid administrative credentials.</span>
      </div>

      <form id="adminLoginForm">
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
            <input type="text" id="signupName" placeholder="Enter Full Name (e.g. Smit Patel)">
          </div>
        </div>

        <!-- EMAIL / USERNAME / ID -->
        <div class="input-group">
          <label id="emailLabel">Admin ID / Name / Email</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </span>
            <input type="text" id="email" placeholder="Enter any Name, ID or Email" required>
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
            <input type="password" id="password" placeholder="Enter password" required>
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
            <input type="password" id="confirmPassword" placeholder="Confirm password">
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
          <label id="keyLabel">Admin Security Key</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
              </svg>
            </span>
            <input type="password" id="adminKey" placeholder="Enter key (Optional)">
          </div>
        </div>

        <div class="options" id="rememberOptions">
          <label class="remember-me">
            <input type="checkbox" id="remember">
            Remember this device
          </label>
          <a href="#" id="forgotPassword">Forgot Password?</a>
        </div>

        <button type="submit" class="login-btn" id="loginBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
            <polyline points="10 17 15 12 10 7"></polyline>
            <line x1="15" y1="12" x2="3" y2="12"></line>
          </svg>
          <span id="btnText">Secure Admin Login</span>
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

  // DEFAULT CREDENTIALS
  const defaultAdminEmail = 'admin@medigo.com';
  const defaultAdminPass = 'admin123';
  const correctAdminKey = 'ADMIN123';

  // LOAD REMEMBERED EMAIL
  try {
    const rememberedEmail = localStorage.getItem('medigoRememberAdmin');
    if (rememberedEmail) {
      document.getElementById('email').value = rememberedEmail;
      document.getElementById('remember').checked = true;
    }
  } catch (e) {
    console.error(e);
  }

  // LOGIN SUBMIT & TOGGLE
  const loginForm = document.getElementById('adminLoginForm');
  const errorMsgDiv = document.getElementById('errorMsg');
  const errorTextSpan = document.getElementById('errorText');

  // TOGGLE FORM MODE (LOGIN VS SIGNUP)
  let formMode = 'login';
  const toggleSignupBtn = document.getElementById('toggleSignup');
  const signupPrompt = document.getElementById('signupPrompt');
  
  const nameGroup = document.getElementById('nameGroup');
  const confirmPasswordGroup = document.getElementById('confirmPasswordGroup');
  const rememberOptions = document.getElementById('rememberOptions');
  
  const btnText = document.getElementById('btnText');
  const keyLabel = document.getElementById('keyLabel');
  const adminKeyInput = document.getElementById('adminKey');
  const emailLabel = document.getElementById('emailLabel');
  const emailInput = document.getElementById('email');
  const loginHeader = document.querySelector('.login-box h2');
  const loginSub = document.querySelector('.sub');

  toggleSignupBtn.addEventListener('click', (e) => {
    e.preventDefault();
    errorMsgDiv.style.display = 'none';
    
    if (formMode === 'login') {
      formMode = 'signup';
      nameGroup.style.display = 'block';
      confirmPasswordGroup.style.display = 'block';
      rememberOptions.style.display = 'none';
      
      loginHeader.textContent = 'Admin Sign Up';
      loginSub.textContent = 'Create your administrator account with any name & ID';
      emailLabel.textContent = 'Admin ID / Email / Username';
      emailInput.placeholder = 'Enter any ID (e.g. smit, admin2, or email)';
      keyLabel.textContent = 'Admin Signup Key';
      adminKeyInput.placeholder = 'Enter Admin Signup Key (Optional)';
      btnText.textContent = 'Sign Up & Login';
      
      signupPrompt.textContent = 'Already have an account?';
      toggleSignupBtn.textContent = 'Sign In';
      
      document.getElementById('signupName').required = true;
      document.getElementById('confirmPassword').required = true;
    } else {
      formMode = 'login';
      nameGroup.style.display = 'none';
      confirmPasswordGroup.style.display = 'none';
      rememberOptions.style.display = 'flex';
      
      loginHeader.textContent = 'Admin Sign In';
      loginSub.textContent = 'Log in with any admin name, ID or email';
      emailLabel.textContent = 'Admin ID / Name / Email';
      emailInput.placeholder = 'Enter any Name, Email or ID';
      keyLabel.textContent = 'Admin Security Key';
      adminKeyInput.placeholder = 'Enter key (Optional)';
      btnText.textContent = 'Secure Admin Login';
      
      signupPrompt.textContent = "Don't have an account?";
      toggleSignupBtn.textContent = 'Sign Up';
      
      document.getElementById('signupName').required = false;
      document.getElementById('confirmPassword').required = false;
    }
  });

  // EYE TOGGLE FOR CONFIRM PASSWORD
  const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const confirmEyeSvg = document.getElementById('confirmEyeSvg');

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

  // SUBMIT HANDLER - CONNECTED TO MYSQL DATABASE (XAMPP)
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    errorMsgDiv.style.display = 'none';

    const rawInput = document.getElementById('email').value.trim();
    const userOrEmail = rawInput.toLowerCase();
    const password = document.getElementById('password').value;
    const inputKey = document.getElementById('adminKey').value.trim();

    if (!rawInput) {
      showError('Please enter your Admin Name, ID or Email.');
      return;
    }
    if (!password) {
      showError('Please enter your password.');
      return;
    }

    if (formMode === 'login') {
      // 1. Try MySQL Database Authentication via api.php
      try {
        const response = await fetch('api.php?action=admin_login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ userOrEmail: rawInput, password: password })
        });

        const result = await response.json();
        if (result && result.status === 'success') {
          let cleanAdminName = result.data?.name || '';
          if (!cleanAdminName || cleanAdminName.includes('@')) {
            const rawPart = (cleanAdminName || rawInput).split('@')[0];
            cleanAdminName = rawPart.replace(/[._\-+0-9]+/g, ' ').trim();
            cleanAdminName = cleanAdminName.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()).join(' ');
          }
          const adminObj = {
            id: result.data?.id,
            name: cleanAdminName || 'Admin',
            email: result.data?.email || rawInput,
            role: result.data?.role || 'Admin'
          };

          if (document.getElementById('remember').checked) {
            localStorage.setItem('medigoRememberAdmin', rawInput);
          } else {
            localStorage.removeItem('medigoRememberAdmin');
          }

          localStorage.setItem('medigoCurrentAdmin', JSON.stringify(adminObj));
          window.location.href = 'admin_dashboard.php';
          return;
        } else if (result && result.message) {
          showError(result.message);
          return;
        }
      } catch (err) {
        console.warn('MySQL API unreachable or offline, using fallback auth:', err);
      }

      // Fallback local auth if API call fails
      let fallbackName = rawInput;
      if (fallbackName.includes('@')) {
        const rawPart = fallbackName.split('@')[0];
        fallbackName = rawPart.replace(/[._\-+0-9]+/g, ' ').trim();
        fallbackName = fallbackName.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()).join(' ');
      } else {
        fallbackName = rawInput.charAt(0).toUpperCase() + rawInput.slice(1);
      }

      const defaultAdmin = {
        name: fallbackName || 'Admin',
        email: rawInput,
        role: 'Admin'
      };
      if (document.getElementById('remember').checked) {
        localStorage.setItem('medigoRememberAdmin', rawInput);
      }
      localStorage.setItem('medigoCurrentAdmin', JSON.stringify(defaultAdmin));
      window.location.href = 'admin_dashboard.php';

    } else {
      // SIGN UP MODE
      const name = document.getElementById('signupName').value.trim() || rawInput;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (!name) {
        showError('Please enter your full name.');
        return;
      }

      if (password !== confirmPassword) {
        showError('Passwords do not match.');
        return;
      }

      // 1. Try MySQL Database Registration via api.php
      try {
        const response = await fetch('api.php?action=admin_signup', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            name: name,
            email: rawInput,
            password: password,
            security_key: inputKey
          })
        });

        const result = await response.json();
        if (result && result.status === 'success') {
          const adminObj = result.data || {
            name: name,
            email: rawInput,
            role: 'Admin'
          };

          if (document.getElementById('remember').checked) {
            localStorage.setItem('medigoRememberAdmin', rawInput);
          }

          localStorage.setItem('medigoCurrentAdmin', JSON.stringify(adminObj));
          alert('Admin account saved to MySQL database successfully! Redirecting...');
          window.location.href = 'admin_dashboard.php';
          return;
        } else if (result && result.message) {
          showError(result.message);
          return;
        }
      } catch (err) {
        console.warn('MySQL API unreachable or offline during signup:', err);
      }

      // Fallback
      const newAdmin = {
        name: name,
        email: rawInput,
        password: password,
        role: 'Admin'
      };
      localStorage.setItem('medigoCurrentAdmin', JSON.stringify(newAdmin));
      alert('Admin account created successfully! Redirecting...');
      window.location.href = 'admin_dashboard.php';
    }
  });

  function showError(msg) {
    errorTextSpan.textContent = msg;
    errorMsgDiv.style.display = 'flex';
  }

  // FORGOT PASSWORD
  document.getElementById('forgotPassword').addEventListener('click', (e) => {
    e.preventDefault();
    const emailInputVal = prompt('Enter your registered admin Name, ID or Email:');
    if (!emailInputVal) return;

    const query = emailInputVal.trim().toLowerCase();

    let storedUsers = [];
    try {
      const parsed = localStorage.getItem('medigoUsers');
      if (parsed && parsed !== 'undefined' && parsed !== 'null') {
        storedUsers = JSON.parse(parsed) || [];
      }
    } catch (err) {
      console.error('Failed to parse medigoUsers for forgot password:', err);
    }

    const adminUser = storedUsers.find(u => {
      const uEmail = (u.email || '').trim().toLowerCase();
      const uName = (u.name || '').trim().toLowerCase();
      return (uEmail === query || uName === query);
    });

    if (adminUser) {
      alert('Your administrator password is: ' + adminUser.password);
    } else if (query === 'admin@medigo.com' || query === 'admin' || query === 'admin@admin.com') {
      alert('Default administrator credentials:\nEmail/ID: admin@medigo.com (or admin)\nPassword: ' + defaultAdminPass);
    } else {
      alert('Account not found. You can log in directly with any ID & password.');
    }
  });
</script>

</body>
</html>

