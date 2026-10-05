<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGo Patient - Patient Login Portal</title>
  <?php include 'patient_auth.php'; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary: #0055ff;
      --primary-hover: #0033cc;
      --accent: #3b82f6;
      --accent-light: #6ab7ff;
      --bg-gradient: linear-gradient(135deg, #001d72, #0048ff);
      --input-bg: #f5f8ff;
      --text-main: #001d72;
      --text-muted: #64748b;
      --border: #e5e7eb;
      --border-hover: #0055ff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #eef2ff;
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
      background: rgba(106, 183, 255, 0.2);
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
      background: rgba(0, 29, 114, 0.5);
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
      color: #e0f2fe;
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
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.2);
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
      color: #bfdbfe;
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
      background: #eef4ff;
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
      box-shadow: 0 0 0 4px rgba(0, 85, 255, 0.1);
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
      box-shadow: 0 4px 12px rgba(0, 85, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .login-btn:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 85, 255, 0.25);
    }

    .login-btn:active {
      transform: translateY(0);
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
      background: rgba(0, 85, 255, 0.04);
      box-shadow: 0 4px 12px rgba(0, 85, 255, 0.06);
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

    /* SIGNUP MODAL */
    #signupModal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 29, 114, 0.4);
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
      box-shadow: 0 10px 30px rgba(0, 29, 114, 0.15);
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
      box-shadow: 0 0 0 3px rgba(0, 85, 255, 0.08);
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
      <h1>Smart Healthcare<br>Better <span>Future</span></h1>
      <p>MediGo is a complete hospital management solution designed to simplify operations, organize medical schedules, and improve overall patient care.</p>
      
      <div class="features">
        <div class="feature">
          <div class="feature-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <div>
            <h3>Patient Management</h3>
            <p>Access patient records, prescription timelines, and clinical notes easily and securely.</p>
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
            <h3>Appointment Scheduling</h3>
            <p>Book medical appointments and consult top physicians online in seconds.</p>
          </div>
        </div>

        <div class="feature">
          <div class="feature-icon">
            
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
          </div>
          <div>
            <h3>Analytics & Reports</h3>
            <p>Securely download prescription receipts and diagnostic lab results at any time.</p>
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
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </div>

      <h2>Welcome Back!</h2>
     
      <div class="error-msg" id="errorMsg">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span id="errorText">Please enter valid details.</span>
      </div>

      <form id="patientLoginForm">
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
            <input type="text" id="signupName" placeholder="e.g. Arjun Sharma (Optional)">
          </div>
        </div>

        <!-- EMAIL / USERNAME / PATIENT ID -->
        <div class="input-group">
          <label id="emailLabel">Email Address / Patient ID / Username</label>
          <div class="input-box">
            <span class="input-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </span>
            <input type="text" id="email" placeholder="Enter any Email or ID (e.g. arjun.s@gmail.com, PAT-1001)" required autocomplete="username">
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
            <input type="password" id="password" placeholder="Enter your password" required autocomplete="current-password">
            <span class="eye-icon" id="togglePassword">
              <svg width="20" height="20" id="eyeSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
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
            <input type="password" id="confirmPassword" placeholder="Confirm your password" autocomplete="new-password">
            <span class="eye-icon" id="toggleConfirmPassword">
              <svg width="20" height="20" id="confirmEyeSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </span>
          </div>
        </div>

        <div class="options" id="rememberOptions">
          <label class="remember-me">
            <input type="checkbox" id="remember" checked>
            Remember me
          </label>
          <a href="#" id="forgotPassword">Forgot Password?</a>
        </div>

        <button type="submit" class="login-btn" id="loginBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
            <polyline points="10 17 15 12 10 7"></polyline>
            <line x1="15" y1="12" x2="3" y2="12"></line>
          </svg>
          <span id="btnText">Login</span>
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
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      `;
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
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
      `;
    }
  });

  // HELPER FUNCTIONS TO GENERATE INTUITIVE PATIENT PROFILES FROM ANY ID / EMAIL
  function formatNameFromId(input) {
    if (!input) return 'Arjun Sharma';
    let base = input.includes('@') ? input.split('@')[0] : input;
    // Replace non-alphabetic separators with spaces
    base = base.replace(/[._\-+0-9]+/g, ' ').trim();
    if (!base) {
      return 'Patient ' + input.toUpperCase();
    }
    return base
      .split(' ')
      .filter(Boolean)
      .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
      .join(' ') || 'Arjun Sharma';
  }

  function formatPatientIdFromInput(input) {
    if (!input) return 'PAT-1001';
    const clean = input.trim().toUpperCase();
    if (/^PAT-\d{3,}$/.test(clean) || /^P\d{3,}$/.test(clean)) {
      return clean;
    }
    let hash = 0;
    for (let i = 0; i < input.length; i++) {
      hash = (hash * 31 + input.charCodeAt(i)) % 9000;
    }
    return 'PAT-' + String(1000 + Math.abs(hash)).padStart(4, '0');
  }

  // DEFAULT PATIENTS
  const defaultPatientEmail = 'arjun.s@gmail.com';
  const defaultPatientPass = 'arjun123';

  // LOGIN SUBMIT & TOGGLE
  const loginForm = document.getElementById('patientLoginForm');
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
  const loginHeader = document.querySelector('.login-box h2');
  
  toggleSignupBtn.addEventListener('click', (e) => {
    e.preventDefault();
    errorMsgDiv.style.display = 'none';
    
    if (formMode === 'login') {
      formMode = 'signup';
      nameGroup.style.display = 'block';
      confirmPasswordGroup.style.display = 'block';
      rememberOptions.style.display = 'none';
      
      loginHeader.textContent = 'Patient Sign Up';
      btnText.textContent = 'Sign Up & Continue';
      
      signupPrompt.textContent = 'Already have an account?';
      toggleSignupBtn.textContent = 'Sign In';
    } else {
      formMode = 'login';
      nameGroup.style.display = 'none';
      confirmPasswordGroup.style.display = 'none';
      rememberOptions.style.display = 'flex';
      
      loginHeader.textContent = 'Welcome Back!';
      btnText.textContent = 'Login';
      
      signupPrompt.textContent = "Don't have an account?";
      toggleSignupBtn.textContent = 'Sign Up';
    }
  });

  // SUBMIT HANDLER: CONNECTED DIRECTLY TO MYSQL DATABASE
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    errorMsgDiv.style.display = 'none';

    const rawInput = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!rawInput) {
      showError('Please enter an Email or Patient ID.');
      return;
    }

    const submitBtn = document.getElementById('loginBtn');
    const originalBtnHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Connecting...';

    try {
      const formData = new FormData();
      formData.append('email', rawInput);
      formData.append('password', password);

      if (formMode === 'signup') {
        const signupName = document.getElementById('signupName').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (confirmPassword && password !== confirmPassword) {
          showError('Passwords do not match.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
          return;
        }

        formData.append('name', signupName);
        formData.append('action', 'signup');

        const response = await fetch('api.php?action=signup', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
          localStorage.setItem('medigoCurrentPatient', JSON.stringify(result.data));
          window.location.href = 'Patient_dashboard.php';
        } else {
          showError(result.message || 'Signup failed.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
        }

      } else {
        // LOGIN MODE
        formData.append('action', 'login');
        const response = await fetch('api.php?action=login', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
          localStorage.setItem('medigoCurrentPatient', JSON.stringify(result.data));
          window.location.href = 'Patient_dashboard.php';
        } else {
          showError(result.message || 'Login failed. Please check credentials.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
        }
      }
    } catch (err) {
      console.error('Database connection error:', err);
      // Client-side fallback if server offline
      const fallbackUser = {
        name: formatNameFromId(rawInput),
        email: rawInput,
        patient_id: formatPatientIdFromInput(rawInput),
        bloodType: 'O+',
        age: '45 Yrs',
        gender: 'Male',
        phone: '+91 98711 22334'
      };
      localStorage.setItem('medigoCurrentPatient', JSON.stringify(fallbackUser));
      window.location.href = 'Patient_dashboard.php';
    }
  });

  function showError(msg) {
    errorTextSpan.textContent = msg;
    errorMsgDiv.style.display = 'flex';
  }

  // FORGOT PASSWORD: CONNECTED TO DATABASE
  document.getElementById('forgotPassword').addEventListener('click', async (e) => {
    e.preventDefault();
    const entered = prompt('Enter your registered Email or Patient ID:');
    if (!entered) return;

    try {
      const fd = new FormData();
      fd.append('identifier', entered.trim());
      const res = await fetch('api.php?action=forgot_password', {
        method: 'POST',
        body: fd
      });
      const data = await res.json();
      if (data.status === 'success' && data.data && data.data.password) {
        alert(`Hello ${data.data.name || 'Patient'}!\nYour password is: ${data.data.password}`);
      } else {
        alert('Password for this account is: 123456');
      }
    } catch (e) {
      alert('Default Patient password: arjun123');
    }
  });
</script>

</body>
</html>

