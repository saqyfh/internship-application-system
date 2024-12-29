<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Forgot Password</h1>

    <form method="post" action="send-password-reset.php">

        <label for="admin_email">Email</label>
        <input type="email" name="admin_email" id="admin_email" required>

        <button>Send</button>

    </form>

</body>
</html>