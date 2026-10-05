<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Resolve active doctor from PHP session or browser cookies
$current_doc_id = $_SESSION['doctor_id'] ?? ($_COOKIE['medigo_doctor_id'] ?? '');
$current_doc_name = $_SESSION['doctor_name'] ?? ($_COOKIE['medigo_doctor_name'] ?? '');
$current_doc_email = $_SESSION['doctor_email'] ?? ($_COOKIE['medigo_doctor_email'] ?? '');
$current_doc_spec = $_SESSION['doctor_specialty'] ?? ($_COOKIE['medigo_doctor_specialty'] ?? 'Cardiology');

if (empty($current_doc_name) && !empty($conn) && !empty($current_doc_id)) {
    $clean_id = mysqli_real_escape_string($conn, $current_doc_id);
    $res = @mysqli_query($conn, "SELECT * FROM `doctors` WHERE `doctor_id` = '$clean_id' OR `doc_id` = '$clean_id' LIMIT 1");
    if ($res && ($d = mysqli_fetch_assoc($res))) {
        $current_doc_name = $d['name'];
        $current_doc_spec = $d['specialty'] ?? $d['department'] ?? 'Cardiology';
        $current_doc_email = $d['email'] ?? '';
    }
}

if (empty($current_doc_name)) {
    $current_doc_name = 'Dr. PRAJAPATI SMIT MANOJKUMAR';
    $current_doc_id = 'DOC-SMIT-01';
    $current_doc_spec = 'Cardiology';
    $current_doc_email = 'smit@gmail.com';
}

$current_doctor = [
    'id' => $current_doc_id ?: 'DOC-SMIT-01',
    'doctor_id' => $current_doc_id ?: 'DOC-SMIT-01',
    'doc_id' => $current_doc_id ?: 'DOC-SMIT-01',
    'name' => $current_doc_name,
    'email' => $current_doc_email,
    'role' => 'Doctor',
    'spec' => $current_doc_spec,
    'specialty' => $current_doc_spec,
    'department' => $current_doc_spec
];
?>
<script>
(function() {
    let currentDoctor = null;
    let isLoginPage = false;

    try {
        const path = window.location.pathname.toLowerCase();
        isLoginPage = path.includes('doctor_login.php') || path.includes('login');
        
        let stored = sessionStorage.getItem('medigoCurrentDoctor') || localStorage.getItem('medigoCurrentDoctor');
        if (stored && stored !== 'undefined' && stored !== 'null') {
            currentDoctor = JSON.parse(stored);
        }
    } catch (e) {
        console.error('Failed to parse doctor session:', e);
    }

    if (isLoginPage) {
        return;
    }

    // If no active session found in browser storage, initialize from PHP active doctor
    if (!currentDoctor || !currentDoctor.name) {
        currentDoctor = <?php echo json_encode($current_doctor); ?>;
        try {
            sessionStorage.setItem('medigoCurrentDoctor', JSON.stringify(currentDoctor));
            localStorage.setItem('medigoCurrentDoctor', JSON.stringify(currentDoctor));
        } catch(e){}
    }

    // Keep cookies synchronized so PHP backend always knows the active doctor
    try {
        const cId = currentDoctor.id || currentDoctor.doc_id || currentDoctor.doctor_id || 'DOC-SMIT-01';
        const cName = currentDoctor.name || 'Dr. PRAJAPATI SMIT MANOJKUMAR';
        const cEmail = currentDoctor.email || '';
        const cSpec = currentDoctor.specialty || currentDoctor.spec || 'Cardiology';

        document.cookie = "medigo_doctor_id=" + encodeURIComponent(cId) + "; path=/; max-age=2592000";
        document.cookie = "medigo_doctor_name=" + encodeURIComponent(cName) + "; path=/; max-age=2592000";
        document.cookie = "medigo_doctor_email=" + encodeURIComponent(cEmail) + "; path=/; max-age=2592000";
        document.cookie = "medigo_doctor_specialty=" + encodeURIComponent(cSpec) + "; path=/; max-age=2592000";
    } catch(e){}

    // Make logged in doctor globally accessible everywhere in window
    window.currentDoctor = currentDoctor;

    // Expose global logout function
    window.logout = function() {
        if (confirm("Confirm session logout and return to login?")) {
            try { sessionStorage.removeItem('medigoCurrentDoctor'); } catch(e){}
            try { localStorage.removeItem('medigoCurrentDoctor'); } catch(e){}
            document.cookie = "medigo_doctor_id=; path=/; max-age=0";
            document.cookie = "medigo_doctor_name=; path=/; max-age=0";
            document.cookie = "medigo_doctor_email=; path=/; max-age=0";
            document.cookie = "medigo_doctor_specialty=; path=/; max-age=0";
            window.location.replace("doctor_login.php");
        }
    };

    // Master function to update all doctor UI elements across all pages
    function updateUI() {
        try {
            if (!currentDoctor || !currentDoctor.name) return;

            const rawName = currentDoctor.name.trim();
            const displayDocName = rawName.startsWith('Dr.') ? rawName : `Dr. ${rawName}`;
            const cleanDocName = rawName.replace(/^Dr\.\s*/i, '');
            const docSpec = currentDoctor.spec || currentDoctor.specialty || 'Cardiology';
            const docId = currentDoctor.id || currentDoctor.doc_id || currentDoctor.doctor_id || 'DOC-SMIT-01';

            // 1. Update navbar user-info
            const userNames = document.querySelectorAll('.user-info .name, .header-user .name, #navbarDoctorName');
            userNames.forEach(el => {
                el.textContent = displayDocName;
            });

            const userSpecs = document.querySelectorAll('.user-info .spec, .header-user .spec, #navbarDoctorSpec');
            userSpecs.forEach(el => {
                el.textContent = docSpec;
            });

            // 2. Update welcome banner greeting
            const welcomeHeaders = document.querySelectorAll('.welcome-left h1, .welcome-row h1, .dashboard-hero h1');
            welcomeHeaders.forEach(header => {
                header.innerHTML = `Welcome Back, ${displayDocName}`;
            });

            // 3. Update profile hero & form inputs if present (Profile_settings.php)
            const heroName = document.getElementById('heroName');
            if (heroName) heroName.textContent = displayDocName;

            const heroSpec = document.getElementById('heroSpec');
            if (heroSpec) heroSpec.textContent = docSpec;

            const heroDocId = document.getElementById('heroDocId');
            if (heroDocId) heroDocId.textContent = docId;

            const heroAvatar = document.getElementById('heroAvatar');
            if (heroAvatar) {
                const initials = cleanDocName.split(' ').filter(Boolean).map(n => n[0]).join('').substring(0, 2).toUpperCase();
                heroAvatar.textContent = initials || 'DR';
            }

            // 4. Update signature preview elements
            const sigEl = document.querySelector('.sig-font, #sigPreviewText');
            if (sigEl) {
                sigEl.textContent = displayDocName;
            }
            
            const sigNameEls = document.querySelectorAll('.signature-card span, .doc-signature .sig-title, .doc-signature .sig-line, .signature .sig-name, #previewSigName, #previewDocName');
            sigNameEls.forEach(el => {
                el.textContent = displayDocName;
            });

            const sigDocSpecs = document.querySelectorAll('.doc-signature .sig-sub, .signature .sig-sub, #previewDocSpec');
            sigDocSpecs.forEach(el => {
                el.textContent = `${docSpec} • Medigo Hospital`;
            });

            // 5. Update dropdown/select elements (Add_newentery.php, Add_patientreport.php, etc.)
            const docSelects = document.querySelectorAll('select#doctorName, select#assignedDoctor, select#doctor_name, select#doctor');
            docSelects.forEach(select => {
                let found = false;
                Array.from(select.options).forEach(opt => {
                    const optClean = opt.value.replace(/^Dr\.\s*/i, '').trim().toLowerCase();
                    if (optClean === cleanDocName.toLowerCase() || opt.value.trim().toLowerCase() === displayDocName.toLowerCase()) {
                        opt.selected = true;
                        found = true;
                    }
                });
                if (!found) {
                    const newOpt = document.createElement('option');
                    newOpt.value = displayDocName;
                    newOpt.textContent = displayDocName;
                    newOpt.selected = true;
                    select.insertBefore(newOpt, select.firstChild);
                }
            });

            const docIdInputs = document.querySelectorAll('input#doctorId, input#doctor_id, input#docId');
            docIdInputs.forEach(input => {
                input.value = docId;
            });

            // 6. Track active patient from URL parameters if present
            try {
                const urlParams = new URLSearchParams(window.location.search);
                const pParam = urlParams.get('id') || urlParams.get('patient') || urlParams.get('patientId') || urlParams.get('patient_id');
                if (pParam) {
                    sessionStorage.setItem('medigoCurrentPatientId', pParam);
                }
                const pNameParam = urlParams.get('name') || urlParams.get('patientName');
                if (pNameParam) {
                    sessionStorage.setItem('medigoCurrentPatientName', pNameParam);
                }
            } catch(e){}

            // 7. Update all Patient History links
            try {
                const activePatientId = sessionStorage.getItem('medigoCurrentPatientId') || sessionStorage.getItem('medigoCurrentPatientName');
                if (activePatientId) {
                    const histLinks = document.querySelectorAll('a[href="patienthistory.php"], a[href^="patienthistory.php"]');
                    histLinks.forEach(link => {
                        link.href = `patienthistory.php?id=${encodeURIComponent(activePatientId)}`;
                    });
                }
            } catch(e){}

        } catch (error) {
            console.error('Error updating doctor auth UI:', error);
        }
    }

    // Run UI update on DOM content loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateUI);
    } else {
        updateUI();
    }
})();
</script>
