<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "";
    $dbname = "interndb";

    $dbconn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    if ($dbconn->connect_error) {
        die("Connection failed: " . $dbconn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user is an admin
    $stmt = $dbconn->prepare("SELECT * FROM admin WHERE admin_id = ? AND admin_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['admin_id'] = $user['admin_id'];
        $_SESSION['user_role'] = 'admin';
        header("Location: dashboard.php");
        exit();
    }
    
    $error_message = "Invalid username or password";

    $stmt->close();
    $dbconn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="login.css">
    <title>Login Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');
        body {
            background-color: transparent;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .center-text {
            color: white;
            text-align: center;
            font-size: 24px;
            margin-bottom: 0px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 700;
        }
        table.center {
            margin-left: auto;
            margin-right: auto;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
            transition: .2s linear;
        }
        html {
            font-size: 62.5%;
            scroll-behavior: smooth;
            scroll-padding-top: 6rem;
            overflow-x: hidden;
            transform: scale(1);
            transform-origin: top left;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;

        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 1.3rem 9%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        }
        header .navbar {
            display: flex;
            gap: 2rem;
        }
        header .logo img {
            font-size: 3rem;
            color: black;
            font-weight: bolder;
            width: 75%;
            height: 45%;
        }
        header .navbar a {
            font-family: 'Verdana', 'Roboto';
            font-size: 2.3rem;
            padding: 0 2rem;
            color: black;
			font-weight: lighter;
        }

        header .fa-bars {
            font-size: 3rem;
            border-radius: .5rem;
            padding: .5rem 1.5rem;
            cursor: pointer;
			border: .1rem solid rgba(14, 58, 78, 0.1);
			display: none;
        }
        
        @media (max-width: 768px) {
            header .fa-bars {
                display: block;
            }
            header .navbar {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #eee;
                border-top: 1rem solid rgba(0, 0, 0, .1);
                clip-path: polygon(0 0, 100% 0, 0 0);
            }
            header #toggler:checked ~ .navbar {
                clip-path: polygon(0 0, 100% 0, 0 0);
            }
            header .navbar a {
                margin: 1rem;
                padding: 1rem;
                background: #fff;
                border: .1rem solid rgba(0, 0, 0, .1);
                display: block;
            }
        }
        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            width: 100%;
        }
        .inputbox {
            position: relative;
            margin: 20px 0;
            width: 310px;
            border-bottom: 2px solid silver;
        }
        .inputbox label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: white;
            font-size: 15px;
            pointer-events: none;
            transition: .5s;
        }
        input:focus ~ label,
        input:valid ~ label {
            top: -5px;
        }
        .inputbox input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 15px;
            padding: 0 35px 0 5px;
            color: white;
        }
        .inputbox ion-icon {
            position: absolute;
            right: 8px;
            color: white;
            font-size: 1.2em;
            top: 20px;
        }
        button {
            width: 100%;
            height: 40px;
            border-radius: 40px;
            background: white;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            color: #4D869C;
        }
        button:hover {
            background-color: #4D869C;
            color: white;
        }
        .forgot {
            font-size: 15px;
            color: white;
            text-align: center;
            margin: 25px 0 10px;
        }
        .forgot p a {
            text-decoration: none;
            color: white;
            font-weight: 600;
        }
        .forgot p a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 120%;
        }
        .bg {
            height: 100vh; /* Full height */
            background-image: url('./background.png'); /* Local file reference */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="bg">
    <header>
        <a href="#" class="logo"><img src= "logo.png" alt="logo alain"> </a>
        <nav class="navbar">
            <a href="#">Services</a>
            <a href="#">Solutions</a>
            <a href="#">Training</a>
            <a href="#">About</a>
        </nav>
    </header>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="center-text">Login</div>
    <section>
        
        <div class="form-box">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="inputbox">
                    <input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required="required">
                    <label for="username">Username</label>
                </div>
                <div class="inputbox">
                    <input type="password" name="password" required="required">
                    <label for="password">Password</label>
                </div>
                <button type="submit">Login</button>
                <?php if ($error_message): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="forgot">
                    <p>Forgot Password? <a href="RegisterReal.php"></a></p>
                </div>
            </form>
        </div>
    </section>
</div>
</body>
</html>
