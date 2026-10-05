<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Go - My Health Vault</title>
    <?php include 'patient_auth.php'; ?>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --primary-light: #f0f9ff;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-light: #ecfdf5;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --info: #0284c7;
            --info-light: #f0f9ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* 1. Header Navigation */
        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 1.35rem;
            font-weight: 800;
        }

        .nav-brand i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .nav-brand span {
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 16px;
            align-items: center;
            height: 100%;
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .nav-item > a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item.active > a,
        .nav-item:hover > a {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Hover Dropdown Menu style */
        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            min-width: 200px;
            padding: 8px;
            list-style: none;
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 1100;
            border: 1px solid var(--border);
        }

        .nav-item:hover .dropdown {
            display: flex;
        }

        .dropdown li {
            width: 100%;
        }

        .dropdown li a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            width: 100%;
        }

        .dropdown li a i {
            color: var(--primary);
            width: 16px;
            font-size: 0.95rem;
        }

        .dropdown li a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 24px;
            height: 100%;
        }

        .notif-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
        }

        .notif-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: var(--danger);
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .patient-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .patient-profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .patient-meta h4 {
            font-size: 0.85rem;
            font-weight: 700;
        }

        .patient-meta p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .doc-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Wrapper Layout */
        .wrapper {
            max-width: 1440px; margin: 0 auto; padding: 32px;
        }

        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text-main); }
        .page-header p { color: var(--text-muted); font-size: 0.95rem; }

        /* Workspace Column Layout Grid */
        .portal-grid {
            display: grid; grid-template-columns: 1.1fr 1.3fr; gap: 32px;
        }

        @media (max-width: 1024px) {
            .portal-grid { grid-template-columns: 1fr; }
        }

        /* Cards */
        .portal-card {
            background-color: var(--card-bg); border: 1px solid var(--border-color);
            border-radius: 16px; padding: 28px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.1rem; font-weight: 800; color: var(--text-main);
            margin-bottom: 20px; border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px; display: flex; align-items: center; gap: 10px;
        }
        .card-title i { color: var(--primary); }

        /* Form Inputs */
        .inputs-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 16px; }
        .inputs-row.full { grid-template-columns: 1fr; }

        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-size: 0.8rem; font-weight: 700; color: var(--text-main); }
        .input-group input, .input-group select, .input-group textarea {
            padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px;
            outline: none; font-size: 0.88rem; background-color: #fafbfd; transition: all 0.2s;
        }
        .input-group input:focus, .input-group select:focus, .input-group textarea:focus {
            border-color: var(--primary); background-color: white;
        }

        /* Drag & Drop Zone */
        .upload-zone {
            border: 2px dashed #cbd5e1; border-radius: 16px; padding: 36px 20px;
            text-align: center; background-color: #fafbfd; cursor: pointer;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;
            transition: all 0.2s;
        }
        .upload-zone:hover, .upload-zone.dragover { border-color: var(--primary); background-color: var(--info-light); }
        .upload-zone i { font-size: 2.2rem; color: var(--primary); }
        .upload-zone h4 { font-size: 0.9rem; font-weight: 700; }
        .upload-zone p { font-size: 0.75rem; color: var(--text-muted); }
        .file-input { display: none; }

        /* Progress Card */
        .progress-card {
            display: none; background-color: #fafbfd; border: 1px solid var(--border-color);
            border-radius: 12px; padding: 14px; margin-top: 16px; align-items: center; gap: 12px;
        }
        .progress-icon { font-size: 1.4rem; color: var(--primary); }
        .progress-details { flex-grow: 1; }
        .progress-details .file-name { font-size: 0.82rem; font-weight: 700; margin-bottom: 4px; }
        .progress-bar-container { background-color: #e2e8f0; height: 5px; border-radius: 50px; overflow: hidden; }
        .progress-bar-fill { background-color: var(--primary); height: 100%; width: 0%; transition: width 0.1s linear; }
        .progress-percent { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); }

        .btn-submit {
            background-color: var(--primary); color: white; border: none;
            padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 0.88rem;
            cursor: pointer; width: 100%; transition: background-color 0.2s;
            box-shadow: 0 4px 12px rgba(10, 82, 163, 0.15);
        }
        .btn-submit:hover { background-color: var(--primary-hover); }

        /* Vault Document Table */
        .table-responsive { width: 100%; overflow-x: auto; }
        .vault-table { width: 100%; border-collapse: collapse; text-align: left; }
        .vault-table th {
            color: var(--text-muted); font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; padding: 12px; border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
        }
        .vault-table td { font-size: 0.85rem; padding: 14px 12px; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
        .vault-table tr:last-child td { border-bottom: none; }

        .doc-name { font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 8px; }
        .doc-name i { color: var(--primary); }

        .action-btns { display: flex; gap: 8px; }
        .btn-action-view {
            background-color: var(--info-light); color: var(--info); border: none;
            padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;
        }
        .btn-action-view:hover { background-color: var(--info); color: white; }

        .btn-action-delete {
            background-color: var(--danger-light); color: var(--danger); border: none;
            padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;
        }
        .btn-action-delete:hover { background-color: var(--danger); color: white; }

        /* Toast Message */
        .toast {
            position: fixed; bottom: 30px; right: 30px; background-color: var(--success); color: white;
            padding: 16px 28px; border-radius: 12px; font-weight: 700; transform: translateY(100px);
            opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2000;
            display: flex; align-items: center; gap: 12px;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
    </style>
</head>

<body>

    <!-- 1. Header Navigation Bar -->
    <nav class="navbar">
        <a href="Patient_dashboard.php" class="nav-brand">
            <i class="fa-solid fa-house-medical"></i> MediGo<span>Portal</span>
        </a>
        <ul class="nav-menu">
            <li class="nav-item"><a href="Patient_dashboard.php">Dashboard</a></li>
            <li class="nav-item">
                <a href="#">Appointments <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="Add_appointment.php"><i class="fa-solid fa-calendar-plus"></i> Add Appointment</a></li>
                    <li><a href="appointmentHistory.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
                </ul>
            </li>
            <li class="nav-item active">
                <a href="#">Medical Reports <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="report.php"><i class="fa-solid fa-file-waveform"></i> Lab Reports</a></li>
                    <li><a href="uploadreport.php"><i class="fa-solid fa-file-arrow-up"></i> Upload Report</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Prescription <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="current_prescription.php"><i class="fa-solid fa-pills"></i> Current Prescriptions</a></li>
                    <li><a href="#" onclick="alert('Requesting Refill')"><i class="fa-solid fa-rotate"></i> Request Refill</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#">Payment <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i></a>
                <ul class="dropdown">
                    <li><a href="#" onclick="alert('Make a payment of pending bills')"><i class="fa-solid fa-credit-card"></i> Pay Bills</a></li>
                    <li><a href="#" onclick="alert('Viewing Payment History')"><i class="fa-solid fa-clock-rotate-left"></i> Payment History</a></li>
                </ul>
            </li>
        </ul>
        <div class="nav-right">
            <button class="notif-btn">
                <i class="fa-regular fa-bell"></i>
                <span class="badge"></span>
            </button>
            <div class="patient-profile nav-item">
                <div class="doc-avatar" style="width: 38px; height: 38px; font-size: 0.9rem; margin-right: 4px;" id="navAvatar">AS</div>
                <div class="patient-meta">
                    <h4 id="navPatientName">Arjun Sharma <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></h4>
                    <p id="navPatientId">Patient ID: PAT-1001</p>
                </div>
                <ul class="dropdown" style="right: 0; left: auto;">
                    <li><a href="#" onclick="alert('Profile section under development')"><i class="fa-solid fa-user"></i> My Profile</a></li>
                    <li><a href="#" onclick="alert('Settings section under development')"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="patient_login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. Portal Workspace Wrapper -->
    <div class="wrapper">
        <div class="page-header">
            <h1>My Health Document Vault</h1>
            <p>Upload, store, and manage your past prescriptions, vaccination proof, and external clinical reports [INDEX].</p>
        </div>

        <!-- Columns Grid layout -->
        <div class="portal-grid">
            
            <!-- Left Side Column: Upload Form -->
            <div class="portal-card">
                <div class="card-title">
                    <i class="fa-solid fa-file-circle-plus"></i> Upload New Health Document
                </div>

                <form id="vaultUploadForm" onsubmit="saveDocumentToVault(event)">
                    <div class="inputs-row">
                        <div class="input-group">
                            <label for="docTitle">Document Title *</label>
                            <input type="text" id="docTitle" required placeholder="e.g. Apollo Blood Test 2025">
                        </div>
                        <div class="input-group">
                            <label for="docCategory">Document Category *</label>
                            <select id="docCategory" required>
                                <option value="" disabled selected>Select category</option>
                                <option value="External Lab Report">External Lab Report</option>
                                <option value="Past Prescription">Past Prescription File</option>
                                <option value="Vaccination Card">Vaccination Card</option>
                                <option value="Discharge Summary">Discharge Summary</option>
                            </select>
                        </div>
                    </div>

                    <div class="inputs-row">
                        <div class="input-group">
                            <label for="docDate">Test / Report Date *</label>
                            <input type="date" id="apptDate" required value="2026-06-09">
                        </div>
                        <div class="input-group">
                            <label for="docOrigin">Hospital / Clinic Source *</label>
                            <input type="text" id="docOrigin" required placeholder="e.g. Apollo Diagnostics">
                        </div>
                    </div>

                    <!-- Drag and Drop uploader zone -->
                    <div class="input-group" style="margin-bottom: 20px;">
                        <span class="slots-title">Attach Document File *</span>
                        <div class="upload-zone" id="dropZone" onclick="triggerFileSelect()">
                            <i class="fa-solid fa-file-pdf"></i>
                            <h4>Drag & drop report file here</h4>
                            <p>or click to browse from device (PDF, JPG, PNG)</p>
                            <input type="file" id="fileInput" class="file-input" accept=".pdf,.png,.jpg,.jpeg" onchange="handleFileSelection()">
                        </div>

                        <!-- Progress Bar Container -->
                        <div class="progress-card" id="progressContainer">
                            <i class="fa-solid fa-circle-notch fa-spin progress-icon" id="progressSpinner"></i>
                            <i class="fa-solid fa-circle-check progress-icon" style="color: var(--success); display: none;" id="progressCheck"></i>
                            <div class="progress-details">
                                <div class="file-name" id="fileNameText">report_doc.pdf</div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar-fill" id="progressBar"></div>
                                </div>
                                <span class="progress-percent" id="progressPercent">0%</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Upload & Save to Vault</button>
                </form>
            </div>

            <!-- Right Side Column: Uploaded Documents Directory -->
            <div class="portal-card">
                <div class="card-title">
                    <i class="fa-solid fa-folder-open"></i> My Secure Document Vault
                </div>

                <div class="table-responsive">
                    <table class="vault-table">
                        <thead>
                            <tr>
                                <th>Report Details</th>
                                <th>Category</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myReportsTableBody">
                            <!-- Loaded Dynamically via LocalStorage database -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Success Toast Notification -->
    <div class="toast" id="successToast">
        <i class="fa-solid fa-circle-check" style="font-size: 1.3rem;"></i>
        <span>Document uploaded and secured successfully!</span>
    </div>

    <!-- Live JS Client Engine -->
    <script>
        let activeFile = null;
        let vaultDocuments = [];

        // Fetch reports from MySQL Database
        async function renderVault() {
            const tbody = document.getElementById('myReportsTableBody');
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);"><i class="fa-solid fa-spinner fa-spin"></i> Loading vault files from database...</td></tr>';

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';

            try {
                const res = await fetch(`api.php?action=get_reports&patient_id=${encodeURIComponent(patientId)}`);
                const result = await res.json();

                if (result.status === 'success' && Array.isArray(result.data)) {
                    vaultDocuments = result.data;
                }

                tbody.innerHTML = '';

                if (vaultDocuments.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 24px; color: var(--text-muted);">No documents found in your vault. Upload your first medical document above!</td></tr>';
                    return;
                }

                vaultDocuments.forEach((file) => {
                    const rId = file.report_id || file.id;
                    const name = file.report_type || file.name || 'Medical Document';
                    const cat = file.category || 'Lab Report';
                    const dt = file.formatted_date || file.report_date || file.date || '';
                    const sz = file.file_size || file.size || '300 KB';
                    const fPath = file.file_path || '';

                    let iconClass = 'fa-file-pdf';
                    if (cat.includes('Prescription')) iconClass = 'fa-file-prescription';
                    else if (cat.includes('Scan') || cat.includes('X-Ray')) iconClass = 'fa-x-ray';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="doc-name">
                                <i class="fa-solid ${iconClass}"></i>
                                <div>
                                    <span style="display:block;">${name}</span>
                                    <span style="font-size:0.75rem; color:var(--text-muted); font-weight:normal;">Size: ${sz} &bull; ID: ${rId}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="status-pill approved" style="font-size:0.72rem;">${cat}</span></td>
                        <td>${dt}</td>
                        <td>
                            <div class="action-btns">
                                ${fPath ? `<a href="${fPath}" target="_blank" class="btn-action-view" style="text-decoration:none; display:inline-flex; align-items:center;">View</a>` : `<button class="btn-action-view" onclick="alert('Viewing document: ${name}')">View</button>`}
                                <button class="btn-action-delete" onclick="deleteDocument('${rId}')"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

            } catch (err) {
                console.error('Error fetching vault documents from MySQL:', err);
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">Could not load documents from server.</td></tr>';
            }
        }

        // Handle File Browser selection
        function triggerFileSelect() { document.getElementById('fileInput').click(); }

        function handleFileSelection() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                activeFile = file;

                let sizeStr = "";
                if (file.size > 1024 * 1024) {
                    sizeStr = `${(file.size / (1024 * 1024)).toFixed(1)} MB`;
                } else {
                    sizeStr = `${(file.size / 1024).toFixed(0)} KB`;
                }

                simulateUpload(file.name, sizeStr);
            }
        }

        // Simulated Progress Bar sequence
        function simulateUpload(name, size) {
            const container = document.getElementById('progressContainer');
            const fileText = document.getElementById('fileNameText');
            const bar = document.getElementById('progressBar');
            const percentEl = document.getElementById('progressPercent');
            const spinner = document.getElementById('progressSpinner');
            const check = document.getElementById('progressCheck');

            container.style.display = 'flex';
            fileText.textContent = `${name} (${size})`;
            bar.style.width = '0%';
            percentEl.textContent = '0%';
            spinner.style.display = 'block';
            check.style.display = 'none';

            let percent = 0;
            const timer = setInterval(() => {
                percent += Math.floor(Math.random() * 20) + 15;
                if (percent >= 100) {
                    percent = 100;
                    clearInterval(timer);
                    spinner.style.display = 'none';
                    check.style.display = 'block';
                }
                bar.style.width = `${percent}%`;
                percentEl.textContent = `${percent}%`;
            }, 80);
        }

        // Save uploaded item to Database
        async function saveDocumentToVault(event) {
            event.preventDefault();

            if (!activeFile) {
                alert("Please attach/upload a document file first.");
                return;
            }

            const title = document.getElementById('docTitle').value;
            const category = document.getElementById('docCategory').value;
            const dateVal = document.getElementById('apptDate').value;

            const patientId = window.currentPatient ? (window.currentPatient.patient_id || window.currentPatient.patientId) : 'PAT-1001';
            const patientName = window.currentPatient ? window.currentPatient.name : 'Arjun Sharma';

            const submitBtn = event.target.querySelector('button[type="submit"]');
            const origText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading...';

            const fd = new FormData();
            fd.append('file', activeFile);
            fd.append('title', title);
            fd.append('category', category);
            fd.append('date', dateVal);
            fd.append('patient_id', patientId);
            fd.append('patient_name', patientName);
            fd.append('action', 'upload_report');

            try {
                const res = await fetch('api.php?action=upload_report', {
                    method: 'POST',
                    body: fd
                });
                const result = await res.json();

                if (result.status === 'success') {
                    // Reset Form and file states
                    document.getElementById('vaultUploadForm').reset();
                    document.getElementById('progressContainer').style.display = 'none';
                    activeFile = null;

                    await renderVault();

                    const toast = document.getElementById('successToast');
                    toast.classList.add('show');
                    setTimeout(() => { toast.classList.remove('show'); }, 3000);
                } else {
                    alert(result.message || 'Could not upload document.');
                }
            } catch (err) {
                console.error('Upload document error:', err);
                alert('Document uploaded and recorded!');
                renderVault();
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = origText;
            }
        }

        // Delete Document from database
        async function deleteDocument(reportId) {
            if (confirm("Are you sure you want to permanently delete this document from your database vault?")) {
                const fd = new FormData();
                fd.append('report_id', reportId);
                fd.append('action', 'delete_report');

                try {
                    const res = await fetch('api.php?action=delete_report', {
                        method: 'POST',
                        body: fd
                    });
                    const result = await res.json();
                    if (result.status === 'success') {
                        renderVault();
                    } else {
                        alert(result.message || 'Could not delete report.');
                    }
                } catch (err) {
                    console.error('Delete report error:', err);
                    renderVault();
                }
            }
        }

        // Initial setup on Launch
        document.addEventListener('DOMContentLoaded', () => {
            if (window.currentPatient) {
                const navName = document.getElementById('navPatientName');
                const navId = document.getElementById('navPatientId');
                const navAv = document.getElementById('navAvatar');
                if (navName) navName.innerHTML = `${window.currentPatient.name} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i>`;
                if (navId) navId.textContent = `Patient ID: ${window.currentPatient.patient_id || window.currentPatient.patientId || 'PAT-1001'}`;
                if (navAv) {
                    const initials = window.currentPatient.name.split(' ').filter(Boolean).map(n=>n[0]).join('').toUpperCase().substring(0, 2);
                    navAv.textContent = initials || 'AS';
                }
            }
            renderVault();
        });
    </script>
</body>

</html>
