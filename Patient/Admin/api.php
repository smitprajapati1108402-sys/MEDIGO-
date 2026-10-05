<?php
// ==============================================================================
// MediGo Hospital Management System - Master Unified Admin Database REST API
// Seamlessly Synchronized with Doctor and Patient Modules
// ==============================================================================

define('API_REQUEST', true);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once __DIR__ . '/db.php';

// Get JSON body payload if sent as application/json
$rawJson = file_get_contents('php://input');
$postData = [];
if (!empty($rawJson)) {
    $decoded = json_decode($rawJson, true);
    if (is_array($decoded)) {
        $postData = $decoded;
    }
}
$requestData = array_merge($_POST, $postData);

$action = isset($_GET['action']) ? trim($_GET['action']) : (isset($requestData['action']) ? trim($requestData['action']) : '');

function sendJson($status, $message, $data = null) {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

switch ($action) {

    // =========================================================================
    // 1. ADMIN AUTHENTICATION (LOGIN & SIGNUP)
    // =========================================================================
    case 'admin_login':
        $userOrEmail = isset($requestData['userOrEmail']) ? trim($requestData['userOrEmail']) : '';
        $password = isset($requestData['password']) ? $requestData['password'] : '';

        if (empty($userOrEmail) || empty($password)) {
            sendJson('error', 'Please enter both Username/Email and Password.');
        }

        $safeUser = sanitize($conn, $userOrEmail);

        $query = "SELECT * FROM `admins` WHERE LOWER(`email`) = LOWER('$safeUser') OR LOWER(`name`) = LOWER('$safeUser') LIMIT 1";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if ($admin['password'] === $password || (password_verify($password, $admin['password']))) {
                unset($admin['password']);

                // Ensure clean display name (not email address)
                if (empty($admin['name']) || strpos($admin['name'], '@') !== false) {
                    $docCheck = $conn->query("SELECT `name` FROM `doctors` WHERE LOWER(`email`) = LOWER('$safeUser') LIMIT 1");
                    if ($docCheck && ($docRow = $docCheck->fetch_assoc()) && !empty($docRow['name'])) {
                        $admin['name'] = trim(preg_replace('/^Dr\.\s*/i', '', $docRow['name']));
                    } else {
                        $namePart = explode('@', $admin['email'] ?: $userOrEmail)[0];
                        $admin['name'] = ucwords(trim(preg_replace('/[._\-+0-9]+/', ' ', $namePart)));
                    }
                    if (empty($admin['name'])) $admin['name'] = 'Admin';
                    $cleanName = sanitize($conn, $admin['name']);
                    $adminId = (int)$admin['id'];
                    $conn->query("UPDATE `admins` SET `name` = '$cleanName' WHERE `id` = $adminId");
                }

                sendJson('success', 'Login successful!', $admin);
            } else {
                sendJson('error', 'Invalid password for this admin account.');
            }
        } else {
            // Auto register admin account if not found
            $docCheck = $conn->query("SELECT `name` FROM `doctors` WHERE LOWER(`email`) = LOWER('$safeUser') LIMIT 1");
            if ($docCheck && ($docRow = $docCheck->fetch_assoc()) && !empty($docRow['name'])) {
                $formattedName = trim(preg_replace('/^Dr\.\s*/i', '', $docRow['name']));
            } else {
                $namePart = explode('@', $userOrEmail)[0];
                $formattedName = ucwords(trim(preg_replace('/[._\-+0-9]+/', ' ', $namePart)));
                if (empty($formattedName)) $formattedName = 'Admin';
            }

            $safeFormattedName = sanitize($conn, $formattedName);
            $insertQuery = "INSERT INTO `admins` (`name`, `email`, `password`, `role`) VALUES ('$safeFormattedName', '$safeUser', '$password', 'Admin')";
            if ($conn->query($insertQuery)) {
                $newAdminId = $conn->insert_id;
                $newAdmin = [
                    'id' => $newAdminId,
                    'name' => $formattedName,
                    'email' => $userOrEmail,
                    'role' => 'Admin'
                ];
                sendJson('success', 'Account created and logged in successfully!', $newAdmin);
            } else {
                sendJson('error', 'Failed to initialize admin user: ' . $conn->error);
            }
        }
        break;

    case 'admin_signup':
        $name = isset($requestData['name']) ? trim($requestData['name']) : '';
        $email = isset($requestData['email']) ? trim($requestData['email']) : '';
        $password = isset($requestData['password']) ? $requestData['password'] : '';
        $key = isset($requestData['security_key']) ? trim($requestData['security_key']) : '';

        if (empty($name) || empty($email) || empty($password)) {
            sendJson('error', 'All fields (Name, Email/ID, Password) are required.');
        }

        $safeName = sanitize($conn, $name);
        $safeEmail = sanitize($conn, $email);
        $safeKey = sanitize($conn, $key);

        $check = $conn->query("SELECT id FROM `admins` WHERE LOWER(`email`) = LOWER('$safeEmail') LIMIT 1");
        if ($check && $check->num_rows > 0) {
            $conn->query("UPDATE `admins` SET `name` = '$safeName', `password` = '$password', `security_key` = '$safeKey' WHERE LOWER(`email`) = LOWER('$safeEmail')");
            $admin = [
                'name' => $name,
                'email' => $email,
                'role' => 'Admin'
            ];
            sendJson('success', 'Admin account updated and logged in!', $admin);
        } else {
            $insert = $conn->query("INSERT INTO `admins` (`name`, `email`, `password`, `role`, `security_key`) VALUES ('$safeName', '$safeEmail', '$password', 'Admin', '$safeKey')");
            if ($insert) {
                $admin = [
                    'id' => $conn->insert_id,
                    'name' => $name,
                    'email' => $email,
                    'role' => 'Admin'
                ];
                sendJson('success', 'Admin account created successfully!', $admin);
            } else {
                sendJson('error', 'Registration error: ' . $conn->error);
            }
        }
        break;

    // =========================================================================
    // 2. HOSPITAL INFORMATION & DIRECTORY
    // =========================================================================
    case 'get_hospital_info':
        $res = $conn->query("SELECT * FROM `hospital_info` ORDER BY id ASC LIMIT 1");
        $info = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : [];
        
        $deptRes = $conn->query("SELECT * FROM `departments` ORDER BY id ASC");
        $departments = [];
        if ($deptRes) {
            while ($row = $deptRes->fetch_assoc()) {
                $departments[] = $row;
            }
        }

        $noticesRes = $conn->query("SELECT * FROM `broadcasts` ORDER BY id DESC LIMIT 20");
        $broadcasts = [];
        if ($noticesRes) {
            while ($row = $noticesRes->fetch_assoc()) {
                $broadcasts[] = $row;
            }
        }

        sendJson('success', 'Hospital Info retrieved', [
            'info' => $info,
            'departments' => $departments,
            'broadcasts' => $broadcasts
        ]);
        break;

    case 'add_broadcast':
        $priority = isset($requestData['priority']) ? sanitize($conn, $requestData['priority']) : 'info';
        $message = isset($requestData['message']) ? sanitize($conn, $requestData['message']) : '';
        $time = date('h:i A');

        if (empty($message)) {
            sendJson('error', 'Message cannot be empty.');
        }

        $res = $conn->query("INSERT INTO `broadcasts` (`priority`, `message`, `time`) VALUES ('$priority', '$message', '$time')");
        if ($res) {
            sendJson('success', 'Broadcast notice added!', ['id' => $conn->insert_id, 'priority' => $priority, 'message' => $message, 'time' => $time]);
        } else {
            sendJson('error', 'Database error: ' . $conn->error);
        }
        break;

    // =========================================================================
    // 3. DOCTORS MANAGEMENT (Unified)
    // =========================================================================
    case 'get_doctors':
        $res = $conn->query("SELECT * FROM `doctors` ORDER BY id DESC");
        $doctors = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $row['doctor_id'] = $row['doctor_id'] ?: $row['doc_id'];
                $row['doc_id'] = $row['doctor_id'];
                $doctors[] = $row;
            }
        }
        sendJson('success', 'Doctors list retrieved', $doctors);
        break;

    case 'add_doctor':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        $name = isset($requestData['name']) ? sanitize($conn, $requestData['name']) : '';
        $dept = isset($requestData['department']) ? sanitize($conn, $requestData['department']) : '';
        $specialty = isset($requestData['specialty']) ? sanitize($conn, $requestData['specialty']) : (!empty($dept) ? $dept : 'General Medicine');
        if (empty($dept)) {
            $dept = $specialty;
        }
        $exp = isset($requestData['experience']) ? sanitize($conn, $requestData['experience']) : '5+ Years';
        $email = isset($requestData['email']) ? sanitize($conn, $requestData['email']) : '';
        $phone = isset($requestData['phone']) ? sanitize($conn, $requestData['phone']) : '+91 98765 43210';
        $timing = isset($requestData['timing']) ? sanitize($conn, $requestData['timing']) : '09:00 AM - 05:00 PM';
        $fee = isset($requestData['fee']) ? floatval($requestData['fee']) : 500.00;
        $status = isset($requestData['status']) ? sanitize($conn, $requestData['status']) : 'Available';
        $password = isset($requestData['password']) ? sanitize($conn, $requestData['password']) : 'doctor123';

        if (empty($name)) {
            sendJson('error', 'Doctor name is required.');
        }

        if (empty($email)) {
            $cleanName = strtolower(preg_replace('/[^a-z0-9]/', '', $name));
            $email = $cleanName . '@medigo.com';
        }

        if ($id > 0) {
            $sql = "UPDATE `doctors` SET 
                    `name` = '$name', 
                    `department` = '$dept', 
                    `specialty` = '$specialty', 
                    `experience` = '$exp', 
                    `email` = '$email', 
                    `phone` = '$phone', 
                    `timing` = '$timing', 
                    `fee` = $fee, 
                    `status` = '$status' 
                    WHERE `id` = $id";
            if ($conn->query($sql)) {
                sendJson('success', 'Doctor details updated successfully across all modules!', ['id' => $id]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        } else {
            $docId = !empty($requestData['doctor_id']) ? sanitize($conn, $requestData['doctor_id']) : '';
            if (empty($docId)) {
                $docId = 'DOC-' . rand(105, 9999);
            }
            $checkDoc = $conn->query("SELECT id FROM `doctors` WHERE `doctor_id` = '$docId'");
            if ($checkDoc && $checkDoc->num_rows > 0) {
                $docId = 'DOC-' . rand(10000, 99999);
            }

            $sql = "INSERT INTO `doctors` (`doctor_id`, `doc_id`, `name`, `department`, `specialty`, `experience`, `email`, `password`, `role`, `phone`, `timing`, `fee`, `status`) 
                    VALUES ('$docId', '$docId', '$name', '$dept', '$specialty', '$exp', '$email', '$password', 'Doctor', '$phone', '$timing', $fee, '$status')";

            if ($conn->query($sql)) {
                sendJson('success', 'Doctor added successfully and can now log into Doctor portal!', ['id' => $conn->insert_id, 'doctor_id' => $docId]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        }
        break;

    case 'delete_doctor':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        $docId = isset($requestData['doctor_id']) ? sanitize($conn, $requestData['doctor_id']) : '';

        if ($id > 0) {
            $conn->query("DELETE FROM `doctors` WHERE id = $id");
        } else if (!empty($docId)) {
            $conn->query("DELETE FROM `doctors` WHERE doctor_id = '$docId' OR doc_id = '$docId'");
        }
        sendJson('success', 'Doctor removed successfully.');
        break;

    // =========================================================================
    // 4. PATIENTS MANAGEMENT (Unified)
    // =========================================================================
    case 'get_patients':
        $res = $conn->query("SELECT * FROM `patients` ORDER BY id DESC");
        $patients = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                if (empty($row['name']) && !empty($row['patient_name'])) {
                    $row['name'] = $row['patient_name'];
                }
                $row['blood_group'] = $row['blood_group'] ?: ($row['blood'] ?? 'O+');
                $patients[] = $row;
            }
        }
        sendJson('success', 'Patients list retrieved', $patients);
        break;

    case 'add_patient':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        $patId = !empty($requestData['patient_id']) ? sanitize($conn, $requestData['patient_id']) : 'PAT-' . rand(1000, 9999);
        $name = isset($requestData['name']) ? sanitize($conn, $requestData['name']) : '';
        if (empty($name) && isset($requestData['patient_name'])) {
            $name = sanitize($conn, $requestData['patient_name']);
        }
        $age = isset($requestData['age']) ? sanitize($conn, $requestData['age']) : '35';
        $gender = isset($requestData['gender']) ? sanitize($conn, $requestData['gender']) : 'Male';
        $blood = isset($requestData['blood_group']) ? sanitize($conn, $requestData['blood_group']) : (isset($requestData['blood']) ? sanitize($conn, $requestData['blood']) : 'O+');
        $phone = isset($requestData['phone']) ? sanitize($conn, $requestData['phone']) : '+91 98711 22334';
        $email = isset($requestData['email']) ? sanitize($conn, $requestData['email']) : '';
        $address = isset($requestData['address']) ? sanitize($conn, $requestData['address']) : 'Ahmedabad, Gujarat';
        $doctor = isset($requestData['doctor_assigned']) ? sanitize($conn, $requestData['doctor_assigned']) : 'Dr. Raj Patel';
        $disease = isset($requestData['disease']) ? sanitize($conn, $requestData['disease']) : 'General Health';
        $admDate = !empty($requestData['admission_date']) ? sanitize($conn, $requestData['admission_date']) : date('Y-m-d');
        $status = isset($requestData['status']) ? sanitize($conn, $requestData['status']) : 'Admitted';
        $password = isset($requestData['password']) ? sanitize($conn, $requestData['password']) : '123456';

        if (empty($name)) {
            sendJson('error', 'Patient name is required.');
        }

        if (empty($email)) {
            $cleanName = strtolower(preg_replace('/[^a-z0-9]/', '', $name));
            $email = $cleanName . '@gmail.com';
        }

        if ($id > 0) {
            $sql = "UPDATE `patients` SET 
                    `name` = '$name', 
                    `age` = '$age', 
                    `gender` = '$gender', 
                    `blood_group` = '$blood', 
                    `blood` = '$blood', 
                    `phone` = '$phone', 
                    `email` = '$email', 
                    `address` = '$address', 
                    `doctor_assigned` = '$doctor', 
                    `disease` = '$disease', 
                    `admission_date` = '$admDate', 
                    `status` = '$status' 
                    WHERE `id` = $id";
            if ($conn->query($sql)) {
                sendJson('success', 'Patient updated successfully in database!', ['id' => $id, 'patient_id' => $patId]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        } else {
            $sql = "INSERT INTO `patients` (`patient_id`, `name`, `email`, `password`, `age`, `gender`, `blood_group`, `blood`, `phone`, `address`, `doctor_assigned`, `disease`, `admission_date`, `last_visit`, `status`) 
                    VALUES ('$patId', '$name', '$email', '$password', '$age', '$gender', '$blood', '$blood', '$phone', '$address', '$doctor', '$disease', '$admDate', 'Today', '$status')";

            if ($conn->query($sql)) {
                $newPatId = $conn->insert_id;
                $conn->query("INSERT INTO `patient_vitals` (`patient_id`, `patient_name`, `heart_rate`, `bp`, `blood_sugar`, `bmi`) VALUES ('$patId', '$name', 72, '120/80', 98, 22.4)");
                sendJson('success', 'Patient registered and synced with Doctor & Patient portals!', ['id' => $newPatId, 'patient_id' => $patId]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        }
        break;

    case 'delete_patient':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        $patId = isset($requestData['patient_id']) ? sanitize($conn, $requestData['patient_id']) : '';

        if ($id > 0) {
            $conn->query("DELETE FROM `patients` WHERE id = $id");
        } else if (!empty($patId)) {
            $conn->query("DELETE FROM `patients` WHERE patient_id = '$patId'");
        }
        sendJson('success', 'Patient removed successfully.');
        break;

    // =========================================================================
    // 5. APPOINTMENTS MANAGEMENT (Unified)
    // =========================================================================
    case 'get_appointments':
        $res = $conn->query("SELECT * FROM `appointments` ORDER BY appointment_date ASC, id DESC");
        $appointments = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $row['apt_id'] = $row['apt_id'] ?: ($row['appointment_id'] ?: ('APT-' . $row['id']));
                $row['appointment_id'] = $row['apt_id'];
                $row['phone'] = $row['phone'] ?: ($row['patient_phone'] ?? '');
                $appointments[] = $row;
            }
        }
        sendJson('success', 'Appointments retrieved', $appointments);
        break;

    case 'add_appointment':
        $patient = isset($requestData['patient_name']) ? sanitize($conn, $requestData['patient_name']) : '';
        $doctor = isset($requestData['doctor_name']) ? sanitize($conn, $requestData['doctor_name']) : '';
        $dept = isset($requestData['department']) ? sanitize($conn, $requestData['department']) : 'General Medicine';
        $phone = isset($requestData['phone']) ? sanitize($conn, $requestData['phone']) : '+91 98765 43210';
        $date = !empty($requestData['appointment_date']) ? sanitize($conn, $requestData['appointment_date']) : date('Y-m-d');
        $time = !empty($requestData['appointment_time']) ? sanitize($conn, $requestData['appointment_time']) : '10:00 AM';
        $reason = isset($requestData['reason']) ? sanitize($conn, $requestData['reason']) : 'General Consultation';
        $status = isset($requestData['status']) ? sanitize($conn, $requestData['status']) : 'Confirmed';

        if (empty($patient) || empty($doctor)) {
            sendJson('error', 'Patient and Doctor names are required.');
        }

        $aptId = 'APT-' . rand(1000, 9999);

        $sql = "INSERT INTO `appointments` (`apt_id`, `appointment_id`, `doctor_id`, `doctor_name`, `patient_id`, `patient_name`, `department`, `phone`, `patient_phone`, `appointment_date`, `appointment_time`, `type`, `method`, `reason`, `symptoms`, `status`)
                VALUES ('$aptId', '$aptId', 'DOC-101', '$doctor', 'PAT-1001', '$patient', '$dept', '$phone', '$phone', '$date', '$time', 'Regular Checkup', 'Offline', '$reason', '$reason', '$status')";

        if ($conn->query($sql)) {
            sendJson('success', 'Appointment booked and synced across Doctor & Patient portals!', ['id' => $conn->insert_id, 'apt_id' => $aptId]);
        } else {
            sendJson('error', 'Database error: ' . $conn->error);
        }
        break;

    case 'update_appointment_status':
        $id = isset($requestData['id']) ? sanitize($conn, $requestData['id']) : (isset($requestData['apt_id']) ? sanitize($conn, $requestData['apt_id']) : '');
        $status = isset($requestData['status']) ? sanitize($conn, $requestData['status']) : 'Confirmed';
        if (!empty($id)) {
            $conn->query("UPDATE `appointments` SET `status` = '$status' WHERE `id` = '$id' OR `apt_id` = '$id' OR `appointment_id` = '$id'");
            sendJson('success', 'Appointment status updated to ' . $status . ' across all portals');
        } else {
            sendJson('error', 'Valid appointment ID required.');
        }
        break;

    case 'delete_appointment':
        $id = isset($requestData['id']) ? sanitize($conn, $requestData['id']) : '';
        if (!empty($id)) {
            $conn->query("DELETE FROM `appointments` WHERE `id` = '$id' OR `apt_id` = '$id' OR `appointment_id` = '$id'");
            sendJson('success', 'Appointment removed.');
        } else {
            sendJson('error', 'Valid appointment ID required.');
        }
        break;

    // =========================================================================
    // 6. MEDICAL REPORTS & PRESCRIPTIONS
    // =========================================================================
    case 'get_medical_reports':
    case 'get_reports':
        $res = $conn->query("SELECT * FROM `patient_reports` ORDER BY report_date DESC, id DESC");
        $reports = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $row['formatted_date'] = date('d M Y', strtotime($row['report_date']));
                $reports[] = $row;
            }
        }
        sendJson('success', 'Medical reports retrieved', $reports);
        break;

    case 'get_prescriptions':
        $res = $conn->query("SELECT * FROM `prescriptions` ORDER BY prescription_date DESC, id DESC");
        $prescriptions = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $prescriptions[] = $row;
            }
        }
        sendJson('success', 'Prescriptions retrieved', $prescriptions);
        break;

    // =========================================================================
    // 7. BLOOD BANK INVENTORY & TRANSACTIONS
    // =========================================================================
    case 'get_blood_stock':
        $res = $conn->query("SELECT * FROM `blood_bank` ORDER BY blood_group ASC");
        $stock = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $stock[] = $row;
            }
        }

        $tRes = $conn->query("SELECT * FROM `blood_transactions` ORDER BY id DESC LIMIT 50");
        $transactions = [];
        if ($tRes) {
            while ($row = $tRes->fetch_assoc()) {
                $transactions[] = $row;
            }
        }

        sendJson('success', 'Blood bank data retrieved', [
            'stock' => $stock,
            'transactions' => $transactions
        ]);
        break;

    case 'add_blood_transaction':
        $person = isset($requestData['donor_patient_name']) ? sanitize($conn, $requestData['donor_patient_name']) : (isset($requestData['person']) ? sanitize($conn, $requestData['person']) : '');
        $bg = isset($requestData['blood_group']) ? sanitize($conn, $requestData['blood_group']) : '';
        $bags = isset($requestData['bags']) ? intval($requestData['bags']) : 1;
        $type = isset($requestData['type']) ? sanitize($conn, $requestData['type']) : 'Donation';
        $contact = isset($requestData['contact']) ? sanitize($conn, $requestData['contact']) : '';
        $date = !empty($requestData['date']) ? sanitize($conn, $requestData['date']) : date('Y-m-d');
        $status = isset($requestData['status']) ? sanitize($conn, $requestData['status']) : 'Completed';

        if (empty($person) || empty($bg)) {
            sendJson('error', 'Person/Donor name and blood group are required.');
        }

        $sql = "INSERT INTO `blood_transactions` (`donor_patient_name`, `blood_group`, `bags`, `type`, `contact`, `date`, `status`)
                VALUES ('$person', '$bg', $bags, '$type', '$contact', '$date', '$status')";

        if ($conn->query($sql)) {
            if ($type === 'Donation') {
                $conn->query("UPDATE `blood_bank` SET `bags_available` = `bags_available` + $bags WHERE `blood_group` = '$bg'");
            } else if ($type === 'Dispatch') {
                $conn->query("UPDATE `blood_bank` SET `bags_available` = GREATEST(0, `bags_available` - $bags) WHERE `blood_group` = '$bg'");
            }
            sendJson('success', 'Blood transaction processed successfully!', ['id' => $conn->insert_id]);
        } else {
            sendJson('error', 'Database error: ' . $conn->error);
        }
        break;

    case 'update_blood_stock':
        $bg = isset($requestData['blood_group']) ? sanitize($conn, $requestData['blood_group']) : '';
        $bags = isset($requestData['bags_available']) ? intval($requestData['bags_available']) : 0;
        if (!empty($bg)) {
            $status = $bags >= 20 ? 'Sufficient' : ($bags > 5 ? 'Moderate' : 'Critical');
            $conn->query("UPDATE `blood_bank` SET `bags_available` = $bags, `status` = '$status' WHERE `blood_group` = '$bg'");
            sendJson('success', 'Blood stock updated');
        } else {
            sendJson('error', 'Blood group required');
        }
        break;

    // =========================================================================
    // 8. PHARMACY INVENTORY
    // =========================================================================
    case 'get_pharmacy':
        $res = $conn->query("SELECT * FROM `pharmacy` ORDER BY id DESC");
        $meds = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $meds[] = $row;
            }
        }
        sendJson('success', 'Pharmacy inventory retrieved', $meds);
        break;

    case 'add_pharmacy':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        $name = isset($requestData['medicine_name']) ? sanitize($conn, $requestData['medicine_name']) : (isset($requestData['name']) ? sanitize($conn, $requestData['name']) : '');
        $generic = isset($requestData['generic_name']) ? sanitize($conn, $requestData['generic_name']) : (isset($requestData['generic']) ? sanitize($conn, $requestData['generic']) : '');
        $cat = isset($requestData['category']) ? sanitize($conn, $requestData['category']) : 'Tablets';
        $batch = isset($requestData['batch_no']) ? sanitize($conn, $requestData['batch_no']) : ('BAT-' . rand(100, 999));
        $qty = isset($requestData['quantity']) ? intval($requestData['quantity']) : 0;
        $price = isset($requestData['price']) ? floatval($requestData['price']) : 0.00;
        $expiry = !empty($requestData['expiry_date']) ? sanitize($conn, $requestData['expiry_date']) : date('Y-m-d', strtotime('+1 year'));
        $supplier = isset($requestData['supplier']) ? sanitize($conn, $requestData['supplier']) : 'MediGo Pharma';
        $status = $qty > 20 ? 'In Stock' : ($qty > 0 ? 'Low Stock' : 'Out of Stock');

        if (empty($name)) {
            sendJson('error', 'Medicine name is required.');
        }

        if ($id > 0) {
            $sql = "UPDATE `pharmacy` SET 
                    `medicine_name` = '$name', 
                    `generic_name` = '$generic', 
                    `category` = '$cat', 
                    `batch_no` = '$batch', 
                    `quantity` = $qty, 
                    `price` = $price, 
                    `expiry_date` = '$expiry', 
                    `supplier` = '$supplier', 
                    `status` = '$status' 
                    WHERE `id` = $id";
            if ($conn->query($sql)) {
                sendJson('success', 'Medication updated successfully in database!', ['id' => $id]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        } else {
            $sql = "INSERT INTO `pharmacy` (`medicine_name`, `generic_name`, `category`, `batch_no`, `quantity`, `price`, `expiry_date`, `supplier`, `status`)
                    VALUES ('$name', '$generic', '$cat', '$batch', $qty, $price, '$expiry', '$supplier', '$status')";
            if ($conn->query($sql)) {
                sendJson('success', 'Medication added to inventory database!', ['id' => $conn->insert_id]);
            } else {
                sendJson('error', 'Database error: ' . $conn->error);
            }
        }
        break;

    case 'delete_pharmacy':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        if ($id > 0) {
            $conn->query("DELETE FROM `pharmacy` WHERE `id` = $id");
            sendJson('success', 'Medication removed from database.');
        } else {
            sendJson('error', 'Medicine ID required');
        }
        break;

    // =========================================================================
    // 9. CONTACTS / ENQUIRIES
    // =========================================================================
    case 'get_contacts':
        $res = $conn->query("SELECT * FROM `contacts` ORDER BY id DESC");
        $contacts = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $contacts[] = $row;
            }
        }
        sendJson('success', 'Contacts list retrieved', $contacts);
        break;

    case 'add_contact':
        $name = isset($requestData['name']) ? sanitize($conn, $requestData['name']) : '';
        $email = isset($requestData['email']) ? sanitize($conn, $requestData['email']) : '';
        $phone = isset($requestData['phone']) ? sanitize($conn, $requestData['phone']) : '';
        $subject = isset($requestData['subject']) ? sanitize($conn, $requestData['subject']) : 'General Enquiry';
        $message = isset($requestData['message']) ? sanitize($conn, $requestData['message']) : '';

        if (empty($name) || empty($message)) {
            sendJson('error', 'Name and message are required.');
        }

        $sql = "INSERT INTO `contacts` (`name`, `email`, `phone`, `subject`, `message`, `status`) 
                VALUES ('$name', '$email', '$phone', '$subject', '$message', 'New')";

        if ($conn->query($sql)) {
            sendJson('success', 'Message saved successfully in database!', ['id' => $conn->insert_id]);
        } else {
            sendJson('error', 'Database error: ' . $conn->error);
        }
        break;

    case 'delete_contact':
        $id = isset($requestData['id']) ? intval($requestData['id']) : 0;
        if ($id > 0) {
            $conn->query("DELETE FROM `contacts` WHERE `id` = $id");
            sendJson('success', 'Contact removed from database.');
        } else {
            sendJson('error', 'Contact ID required');
        }
        break;

    // =========================================================================
    // 10. DASHBOARD SUMMARY STATS (Real-time live cross-module stats)
    // =========================================================================
    case 'get_dashboard_stats':
        $docCount = $conn->query("SELECT COUNT(*) as c FROM `doctors`")->fetch_assoc()['c'] ?? 0;
        $patCount = $conn->query("SELECT COUNT(*) as c FROM `patients`")->fetch_assoc()['c'] ?? 0;
        $appCount = $conn->query("SELECT COUNT(*) as c FROM `appointments`")->fetch_assoc()['c'] ?? 0;
        $bloodBags = $conn->query("SELECT SUM(bags_available) as c FROM `blood_bank`")->fetch_assoc()['c'] ?? 0;
        $medCount = $conn->query("SELECT COUNT(*) as c FROM `pharmacy`")->fetch_assoc()['c'] ?? 0;

        sendJson('success', 'Dashboard stats retrieved', [
            'total_doctors' => intval($docCount),
            'total_patients' => intval($patCount),
            'total_appointments' => intval($appCount),
            'blood_bags_available' => intval($bloodBags),
            'total_medicines' => intval($medCount)
        ]);
        break;

    default:
        sendJson('error', 'Invalid API Action specified: ' . htmlspecialchars($action));
        break;
}
?>
