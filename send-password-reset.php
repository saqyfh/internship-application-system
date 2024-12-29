<?php

if (!isset($_POST["admin_email"])) {
    die("Email is required");
}

$email = $_POST["admin_email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha1", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/dbconn.php";

if (!$mysqli) {
    die('Database connection failed');
}

$sql = "UPDATE admin
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE admin_email = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die('Prepare failed: ' . $mysqli->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($stmt->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("kawianshop99@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/AA internapp/internship-application-system/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();
        echo "Message sent, please check your inbox.";

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
} else {
    echo "No account found with that email address.";
}
?>