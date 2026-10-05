<?php
// Redirect to the Admin Dashboard.
// If the user is authenticated, they will see the dashboard.
// If they are not, the dashboard's javascript will redirect them to admin_login.php.
header("Location: admin_dashboard.php");
exit;
?>
