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
    $dbname = "kiddosmart4";

    $dbconn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    if ($dbconn->connect_error) {
        die("Connection failed: " . $dbconn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user is an admin
    $stmt = $dbconn->prepare("SELECT * FROM admin WHERE adminID = ? AND admin_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['adminID'] = $user['adminID'];
        $_SESSION['user_role'] = 'admin';
        header("Location: dashboard.php");
        exit();
    }

    // If not admin, check if user is a customer
    $stmt = $dbconn->prepare("SELECT * FROM customer WHERE custID = ? AND cust_password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['custID'] = $user['custID'];
        $_SESSION['user_role'] = 'customer';
        header("Location: PackageLatest.php");
        exit();
    }

    // If neither admin nor customer
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
    <link rel="stylesheet" href="login.css">
    <title>Login Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');
        body {
            background-color: #7AB2B2;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .center-text {
            color: white;
            text-align: center;
            font-size: 24px;
            margin-bottom: 0px;
            font-family: 'League Spartan', sans-serif;
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
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            padding: 2rem 9%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        }
        header .logo {
            font-size: 3rem;
            color: #4D869C;
            font-weight: bolder;
        }
        header .navbar a {
            font-size: 2.3rem;
            padding: 0 2rem;
            color: #4D869C;
			font-weight: bolder; //disini aku ubah
        }
        header .icons a {
            font-size: 2.5rem;
            color: #4D869C;
            margin-left: 1.5rem;
        }
        header #toggler {
            display: none;
        }
        header .fa-bars {
            font-size: 3rem;
            border-radius: .5rem;
            padding: .5rem 1.5rem;
            cursor: pointer;
			border: .1rem solid rgba(14, 58, 78, 0.1);
			display: none;
        }
        @media (max-width: 991px) {
            html {
                font-size: 55%;
            }
            header {
                padding: 2rem;
            }
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
                border-top: .1rem solid rgba(0, 0, 0, .1);
                clip-path: polygon(0 0, 100% 0, 0 0);
            }
            header #toggler:checked ~ .navbar {
                clip-path: polygon(0 0, 100% 0, 0 0);
            }
            header .navbar a {
                margin: 1.5rem;
                padding: 1.5rem;
                background: #fff;
                border: .1rem solid rgba(0, 0, 0, .1);
                display: block;
            }
        }
        @media (max-width: 450px) {
            html {
                font-size: 50%;
            }
        }
        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            width: 100%;
        }
        .form-box {
            position: relative;
            width: 400px;
            height: 0px;
            background: transparent;
            border: 2px solid rgba(red, green, blue, alpha);
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .inputbox {
            position: relative;
            margin: 30px 0;
            width: 310px;
            border-bottom: 2px solid silver;
        }
        .inputbox label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: black;
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
            color: black;
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
        .register {
            font-size: 15px;
            color: white;
            text-align: center;
            margin: 25px 0 10px;
        }
        .register p a {
            text-decoration: none;
            color: white;
            font-weight: 600;
        }
        .register p a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 1em;
            background-color: #64C5B1;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer {
            font-size: 15px;
            text-align: center;
            padding: 15px;
            background-color: white;
            color: #4D869C;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>
        <a href="#" class="logo"> KIDDOSMART </a>
        <nav class="navbar">
            <a href="mainPageKS.php">HOME</a>
            <a href="aboutLatest.php">ABOUT</a>
            <a href="PackageLatest.php">PACKAGES</a>
            <a href="aboutLatest.php">CONTACT</a>
        </nav>
        <div class="icons">
            <a href="#" class="fas fa-shopping-cart"></a>
            <a href="#" class="fas fa-user"></a>
        </div>
    </header>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    
    <div class="center-text">LOGIN FORM</div>
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
                <div class="register">
                    <p>Don't have an account? <a href="RegisterReal.php">Register Now</a></p>
                </div>
            </form>
        </div>
    </section>
    <footer>
        &copy; 2023 Kiddosmart. All rights reserved.
    </footer>
</body>
</html>
