<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            margin-bottom: 20px;
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
        }
        
        table {
            border: 15px solid #CDE8E5;
            border-collapse: collapse;
            width: 80%;
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
            color: white;
        }
        
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            outline: none; border: none;
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
            top: 0; left: 0; right: 0;
            background: #fff;
            padding: 2rem 9%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
        }
        
        header .logo {
            font-size: 3rem;
            color: #4D869C;
            font-weight: bolder;
        }
        
        header .logo span {
            color: #4D869C;
        }
        
        header .navbar a {
            font-size: 2rem;
            padding: 0 1.5rem;
            color: #4D869C;
        }
        
        header .navbar a:hover {
            color: #4D869;
        }
        
        header .icons a {
            font-size: 2.5rem;
            color: #4D869C;
            margin-left: 1.5rem;
        }
        
        header .icons a:hover {
            color: #4D869;
        }
        
        header #toggler {
            display: none;
        }
        
        header .fa-bars {
            font-size: 3rem;
            border-radius: .5rem;
            padding: .5rem 1.5rem;
            cursor: pointer;
        }

        button {
            font-size: 17px;
            color: white;
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
                border-top: .1rem solid rgba(0,0,0,.1);
                clip-path: polygon(0 0, 100% 0, 0 0);
            }
            
            header #toggler:checked ~ .navbar {
                clip-path: (0 0, 100% 0, 0 0);
            }
            
            header .navbar a {
                margin: 1.5rem;
                padding: 1.5rem;
                background: #fff;
                border: .1rem solid rgba(0,0,0,.1);
                display: block; 
            }
        }

        @media (max-width: 450px) {
            html {
                font-size: 50%;
            }
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
		
    <!-- header section starts -->

    <header>
	
		<input type="checkbox" name="" id="toggler">
		<label for="toggler" class="fas fa-bars"></label>

         <a href="#" class="logo"> KIDDOSMART <span> </span></a>

         <nav class="navbar">

            <a href="MainPageKS.php">HOME</a>
            <a href="aboutLatest.php">ABOUT</a>
            <a href="packageLatest.php">PRODUCTS</a>
            <a href="loginFormLatest.php">LOGIN</a>

         </nav>

         <div class="icons">

            
            <a href="addToCart.php" class="fas fa-shopping-cart"></a>
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
    <!-- header section ends -->

</body>
</html>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php
	include("dbconn.php");
	
	$firstName = $_REQUEST['firstName'];
	$lastName = $_REQUEST['lastName']; 
	$emailAddress = $_REQUEST['emailAddress']; 
	$phoneNumber = $_REQUEST['phoneNumber'];
	$username = $_REQUEST['createUsername']; 
	$myGender = $_REQUEST['myGender'];
	$createPassword = $_REQUEST['createPassword'];
	$childAge = $_REQUEST['childAge'];
	$confirmPassword = $_REQUEST['confirmPassword'];
	
	// Hash the password
    $hashedPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
	
	// Check if the username already exists
	$sqlCheck = "SELECT * FROM customer WHERE custID = '".$username."'";
	$result = mysqli_query($dbconn, $sqlCheck);

	if (mysqli_num_rows($result) > 0) {
		// Username already exists
		echo "<script>alert('Error: Username already exists. Please choose a different username.'); window.location.href='RegisterRealLatest.php';</script>";
	} else {
		// Username does not exist, proceed with insertion
		$sqlInsert = "INSERT INTO customer (custID, cust_password, cust_firstName, cust_lastName, cust_phoneNum, cust_age, cust_gender, cust_email)
		VALUES ('".$username."','" . $hashedPassword . "', '" . $firstName . "','" . $lastName . "', '" . $phoneNumber . "', " . $childAge ." , '" . $myGender . "', '" . $emailAddress . "')";
		
		if (mysqli_query($dbconn, $sqlInsert)) {
			echo "<div class='center-text'>The following information has been recorded in our database :</div>";
			echo "<table class='center' border='1' cellspacing='0' cellpadding='5'>";
			echo "<tr><th>Field</th><th>Value</th></tr>";
			echo "<tr><td>First Name</td><td>" . $firstName . "</td></tr>";
			echo "<tr><td>Last Name</td><td>" . $lastName . "</td></tr>";
			echo "<tr><td>Email Address</td><td>" . $emailAddress . "</td></tr>";
			echo "<tr><td>Phone Number</td><td>" . $phoneNumber . "</td></tr>";
			echo "<tr><td>Username</td><td>" . $username . "</td></tr>";
			echo "<tr><td>Gender</td><td>" . $myGender . "</td></tr>";
			echo "<tr><td>Password</td><td>(hidden for security)</td></tr>";
			echo "<tr><td>Child's Age</td><td>" . $childAge . "</td></tr>";
			echo "</table>";
			
			echo "<div style='width: 80%; margin: 0 auto; text-align: right;'>";
			echo "<button class='oval-button' onclick=\"window.location.href='loginFormLatest.php'\">Login</button>";
			echo "</div>";
		} else {
			echo "<div class='center-text'>Error: " . mysqli_error($dbconn) . "</div>";
		}
	}

	mysqli_close($dbconn);
?>
