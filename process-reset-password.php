<?php
$password = $_POST['admin_password'];
$password_confirmation = $_POST['password_confirmation'];

$token = $_POST["token"];

$token_hash = hash("sha1", $token);
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$mysqli = require __DIR__ . "/dbconn.php";

$sql = "SELECT * FROM admin
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$admin = $result->fetch_assoc();

if ($admin === null) {
    die("token not found");
}

if (strtotime($admin["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["admin_password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["admin_password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["admin_password"])) {
    die("Password must contain at least one number");
}

if ($_POST["admin_password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// Debug line - remove after testing
error_log("Generated new password hash: " . $password_hash);

$sql = "UPDATE admin
        SET admin_password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE admin_id = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt->bind_param("ss", $password_hash, $admin["admin_id"])) {
    error_log("Failed to bind parameters: " . $stmt->error);
    die("An error occurred while resetting your password");
}

if (!$stmt->execute()) {
    error_log("Failed to update password: " . $stmt->error);
    die("An error occurred while resetting your password");
}

header("Location: login.php?reset=success");
exit();