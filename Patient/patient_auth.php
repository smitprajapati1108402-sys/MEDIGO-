<?php
// Include database connection
require_once __DIR__ . '/db.php';

$sessionPatientJson = 'null';
if (isset($_SESSION['medigo_patient']) && !empty($_SESSION['medigo_patient'])) {
    $sessionPatientJson = json_encode($_SESSION['medigo_patient']);
}
?>
<script>
(function() {
    let currentPatient = <?php echo $sessionPatientJson; ?>;
    let isLoginPage = false;

    try {
        isLoginPage = window.location.pathname.includes('patient_login.php');
        
        if (!currentPatient) {
            const stored = localStorage.getItem('medigoCurrentPatient');
            if (stored && stored !== 'undefined' && stored !== 'null') {
                currentPatient = JSON.parse(stored);
            }
        } else {
            // Keep localStorage in sync with PHP session
            localStorage.setItem('medigoCurrentPatient', JSON.stringify(currentPatient));
        }
    } catch (e) {
        console.error('Failed to parse patient session:', e);
        localStorage.removeItem('medigoCurrentPatient');
    }

    if (isLoginPage) {
        // Clear active session when visiting login page
        localStorage.removeItem('medigoCurrentPatient');
        return;
    }

    // Auth check for protected pages
    if (!currentPatient) {
        document.documentElement.style.display = 'none';
        window.location.href = 'patient_login.php';
        return;
    }

    // Make logged in patient globally accessible
    window.currentPatient = currentPatient;

    // Common UI updater for header and user info
    function updateUI() {
        try {
            // Initials (avatar)
            const docAvatars = document.querySelectorAll('.patient-profile .doc-avatar, .profile-avatar-large');
            if (docAvatars.length > 0 && currentPatient && currentPatient.name) {
                const initials = currentPatient.name
                    .split(' ')
                    .filter(Boolean)
                    .map(n => n[0])
                    .join('')
                    .toUpperCase()
                    .substring(0, 2);
                docAvatars.forEach(avatar => {
                    avatar.textContent = initials || 'PT';
                });
            }

            // Full Name in dropdown/profile
            const nameEls = document.querySelectorAll('.patient-profile .patient-meta h4, .profile-title h3');
            if (nameEls.length > 0 && currentPatient && currentPatient.name) {
                nameEls.forEach(el => {
                    if (el.tagName === 'H3' || el.closest('.profile-summary-card')) {
                        el.textContent = currentPatient.name;
                    } else {
                        el.innerHTML = `${currentPatient.name} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i>`;
                    }
                });
            }

            // Patient ID
            const idEl = document.querySelector('.patient-profile .patient-meta p');
            if (idEl && currentPatient) {
                idEl.textContent = `Patient ID: ${currentPatient.patient_id || currentPatient.patientId || 'PAT-1001'}`;
            }
            
            const profileIdEl = document.querySelector('.profile-title p');
            if (profileIdEl && currentPatient) {
                profileIdEl.innerHTML = `PATIENT ID: <strong style="color: var(--primary);">${currentPatient.patient_id || currentPatient.patientId || 'PAT-1001'}</strong>`;
            }

            // Setup Logout listener
            const logoutLinks = document.querySelectorAll('a[href="patient_login.php"], a.logout-btn');
            logoutLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    localStorage.removeItem('medigoCurrentPatient');
                    fetch('api.php?action=logout').catch(()=>{});
                });
            });
        } catch (error) {
            console.error('Error updating auth UI:', error);
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
