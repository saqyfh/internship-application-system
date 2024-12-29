<?php
include 'Session.php';

$session = new Session();
$session->logout();
$msg = $session->msg();

// Redirect to login page or home page after logout
header("Location: login.php");
exit;
?>
