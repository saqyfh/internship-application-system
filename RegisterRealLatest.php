<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the form data
    $fullName = $_POST['fullName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $university = $_POST['university'];
    $program = $_POST['program'];
    $startDate= $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $position = $_POST['position'];
    $resume = $_POST['resume'];
    $cv = $_POST['cv'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO applicants (applicant_name, applicant_email, applicant_phone, applicant_university, applicant_program, applicant_startDate, applicant_endDate, applicant_resume, applicant_cv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $createUsername, $hashedPassword, $firstName, $lastName, $phoneNumber, $childAge, $myGender, $emailAddress);

    if ($stmt->execute()) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');
        
        body {
            background-color: #7AB2B2;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
		
		body{
			text-align: center;
			}
			
			
		img {
			display: block;
			margin-left: auto; 
			margin-right: auto;
			width:700px; 
			height:300px;
			}
			
		table, th, td {
			border: 0px solid black; 
			border-collapse: collapse; 
			text-align: auto;
			vertical-align: center;
			margin-left: auto;
			margin-right: auto;
			
		}
		
		.right{
			text-align: right;
			vertical-align: center;
			}
			
		
		.center{
			margin-left: auto; 
			margin-right: auto; 
			}	
		footer {
		font-size: 15px;
		text-align: center;
		padding: 15px;
		background-color: white;
		color: #4D869C;
		}
		
        .center-text {
			color:white;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-family: 'League Spartan', sans-serif; /* Apply the League Spartan font */
            font-weight: 700; /* Make the text bold */
        }
        table.center {
            border: 15px solid #CDE8E5;
            border-collapse: collapse;
            width: 50%;
            margin: 0 auto;
			font-size: 15px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #EEF7FF;
        }
        tr:nth-child(odd) {
            background-color: white;
        }
        tr:hover {
            background-color: #CDE8E5;
        }
        .oval-button {
            padding: 10px 20px;
            background-color: white;
            color: #7AB2B2;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 25px;
        }
        .oval-button:hover {
            background-color: #4D869C;
			color:white
        }
<style>
    :root{
        --blue:#7ab2b2;
        background:#7ab2b2 ;
    }
    
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        outline: none;
        border: none;
        text-decoration: none;
     
        transition: .2s linear;
    }

    html{
        font-size: 62.5%;
        scroll-behavior: smooth;
        scroll-padding-top: 6rem;
        overflow-x: hidden;
    }

    header{
        position:fixed;
        top: 0; left: 0;right: 0;
        background: #fff;
        padding: 2rem 9%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 1000;
        box-shadow: 0.5rem 0.5rem rgba(14, 58, 78, 0.1) ; 
    }

    header .logo {
        font-size: 3rem;
        color: #4D869C;
        font-weight: bolder;
        margin-right: 5rem;
    }


    header .navbar a{
        font-size: 2.3rem;
        padding: 0 2rem;
        color: #4D869C;
        font-weight: bolder;
    }

    header .navbar a:hover{
        color:var(--black);
    }

    header .icons a{
        font-size: 3rem;
        color: #4D869C;
        margin-left: 3.5rem;
    }
    
    header .icons a:hover{
        color:var(--black);
    }

    header #toggler{
        display: none;
    }

    header .fa-bars{
        font-size: 3rem;
        color: #4D869C;
        border-radius: .5rem;
        padding: .5rem 1.5rem;
        cursor: pointer;
        border: .1rem solid rgba(14, 58, 78, 0.1);
        display: none;
    }

    .packages {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        padding: 3rem 5%;
        background-color: #7AB2B2;
        margin-top: 10rem;
		margin-bottom: 100px; /* Ensure it stays above the footer */

    }

    .package-card {
        background: #f0f8ff;
        border: 0.1rem solid rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        margin: 1.5rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        width: 30rem;
    }

    .package-card i {
        font-size: 10rem;
        color: #4D869C;
        margin-bottom: 1.5rem;
    }

    .package-card h3 {
        font-size: 2rem;
        color:#4D869C;
        margin-bottom: 1rem;
    }

    .package-card p {
        font-size: 1.5rem;
        color: #666;
        margin-bottom: 1.5rem;
    }

    .package-card span {
        font-size: 2rem;
        color: #4D869C;
        display: block;
        margin-bottom: 1.5rem;
    }

    button a {
        color: white;
    }

    .package-card button,
    .packages button {
        background: #4D869C;
        color: #fff;
        border: none;
        padding: 1rem 2rem;
        cursor: pointer;
        border-radius: 0.5rem;
        margin-top: 10rem;
		margin-bottom: 100px; /* Ensure it stays above the footer */
    }

    .package-card button:hover,
    .packages button:hover {
        background: #17272d;
    }

    .buy-now {
        background: #4D869C;
        color: #fff;
        border: none;
        padding: 1.5rem 3rem;
        cursor: pointer;
        border-radius: 0.5rem;
        font-size: 2rem;
        display: block;
        margin: 1.5rem auto 0 auto;
    }

    .buy-now:hover {
        background: #17272d;
    }

    /* media queries */
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
            border-top: 0.1rem solid rgba(0, 0, 0, 0.1);
            clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
            transition: clip-path 0.5s ease-in-out;
        }

        header #toggler:checked ~ .navbar {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }

        header .navbar a {
            margin: 1.5rem;
            padding: 1.5rem;
            background: #fff;
            border: 0.1rem solid rgba(0, 0, 0, 0.1);
            display: block;
        }
    }

    @media (max-width: 450px) {
        html {
            font-size: 50%;
        }
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

    img {
        width: 250px;
        height: 250px;
    }
	
	.dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
			
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-toggle {
        cursor: pointer;
    }
</style>
	
	<script language="javascript">
		function checkEmptyFields()
		{
			var firstName = document.register.firstName.value;
			var lastName = document.register.lastName.value;
			var emailAddress = document.register.emailAddress.value;
			var phoneNumber = document.register.phoneNumber.value;
			var createUsername = document.register.createUsername.value;
			var myGender = document.register.myGender.value;
			var createPassword = document.register.createPassword.value;
			var childAge = document.register.childAge.value;
			var confirmPassword = document.register.confirmPassword.value;
			
			
			if(firstName == "")
			{
				alert("Please enter your first name!");
				return false;
			}
			if(lastName == "")
			{
				alert("Please enter your last name!");
				return false;
			}
			else if(emailAddress.indexOf("@") == -1)
			{
				alert("Please enter your email!");
				return false;
			}
			else if(phoneNumber == "")
			{
				alert("Please enter your phone number!");
				return false;
			}
			else if(createUsername == "")
			{
				alert("Please create your username!");
				return false;
			}
			else if(!document.querySelector('input[name="myGender"]: checked')){
				alert("Please select your gender !");
				return false;
			}
			else if(createPassword == "")
			{
				alert("Please create your password!");
				return false;
			}
			else if(childAge == "")
			{
				alert("Please select your child's Age!");
				return false;
			}
			else if(confirmPassword == "")
			{
				alert("Please confirm your password!");
				return false;
			}
			else if(createPassword !==confirmPassword)
			{
				alert("password did not match");
				return false;
			}
			else
				return true;
		}
	</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

	<title>Login Form Learning Platform</title>
	
	
	
</head>
	<body>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KiddoSmart Website</title>

<!-- font awesome cdn link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<!---header section started -->
<header>
    <!-- toggler part-->
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>

    <a href="#" class="logo">KIDDOSMART</a>

    <nav class="navbar">
        <a href="MainPageKS.php"> HOME</a>
        <a href="aboutLatest.php"> ABOUT</a>
        <a href="packageLatest.php"> PRODUCTS</a>
        <a href="loginFormLatest.php"> LOGIN</a>
    </nav>

    <div class="icons">
        <a href="addToCart.php" class="fa fa-shopping-cart" id="cart-icon"></a>
        <div class="dropdown">
                <a href="#" class="fas fa-user dropdown-toggle"></a>
                <div class="dropdown-content">
                    <a href="logOut.php" style="font-size: 1.4rem;">Log out</a>
                    <a href="editProfile.php" style="font-size: 1.4rem;">Edit Profile</a>
                    <a href="ViewPurchase.php" style="font-size: 1.4rem;">Purchase</a>
                </div>
            </div>
    </div>
</header>
<!-- Hidden message element -->
<div id="message" style="display:none; background-color: #f8d7da; color: #blackS; padding: 20px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 5px;">
    Register First
</div>
	<br><br><br><br><br><br><br><br><br><br>
	
	<title> Registration Page </title>
	<form name = "register" method = "POST" action ="registrationKSLatest.php" autocomplete="off">
	<div class='center-text'>REGISTRATION FORM</div>
		<table class="center">
			</tr>
			
			<tr> 
			
				<td> First Name </td>
				<td> Last Name </td>
				
			</tr>
			
			<tr>
				<td> <input type = "text" name = "firstName" required> </td>
				<td> <input type = "text" name = "lastName" required> </td>
			</tr>
			
			<tr>
				<td> Email Address </td>
				<td> Phone Number </td>
			</tr>
			
			<tr>
				<td> <input type = "text" name = "emailAddress" required> </td>
				<td> <input type = "text" name = "phoneNumber" required> </td> 
			</tr>
			
			<tr>
				<td> Create Username </td>
				<td> Gender </td>
			</tr>
			
			<tr>
				<td> 
					 <input type = "text" name = "createUsername" required> 
				</td>
				
				<td>
					 <input type = "text" name = "myGender" required> 
					 
				</td>
				
			</tr>
			
			<tr> 
				<td>
					Create Password 
				</td>
				
				<td>
					Child Age 
				</td>
				
			</tr>
			
			<tr>
				<td>
					<input type = "password" name="createPassword" minlength="8" required >
				</td>
				
				<td>
					
					 <input type = "text" name = "childAge" required> 
					 
				</td>
					
					
				
			</tr>
		
			<tr>
				<td colspan = "2"> 
					Confirm Password 
				</td>
			</tr>	
			<tr>
				<td colspan ="2">
					<input type = "password" name = "confirmPassword" minlength="8" required> 
				</td>
			</tr>
		</table>
		<br>
		<div style="width: 50%; margin: 0 auto; text-align: right;">
			<button class="oval-button" type="submit" name="Submit" onClick="return checkEmptyFields()">Register</button>
		</div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
	
	<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userIcon = document.getElementById('user-icon');
        const cartIcon = document.getElementById('cart-icon');
        const message = document.getElementById('message');

        userIcon.addEventListener('click', function (event) {
            event.preventDefault();
            showMessage();
        });

        cartIcon.addEventListener('click', function (event) {
            event.preventDefault();
            showMessage();
        });

        function showMessage() {
            message.style.display = 'block';
            setTimeout(function () {
                message.style.display = 'none';
            }, 3000);
        }

        // Close the dropdown if the user clicks outside of it
        window.addEventListener('click', function (event) {
            if (!event.target.matches('.dropdown-toggle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        });
    });
</script>

</body>
<footer>
        &copy; 2023 KiddoSmart-Online Learning Platform
  </footer>


</html>




