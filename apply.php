<?php
// Database connection
$dbconn = mysqli_connect("localhost", "root", "", "interndb");

if (!$dbconn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $applicant_name = mysqli_real_escape_string($dbconn, $_POST['applicant_name']);
    $applicant_ic = mysqli_real_escape_string($dbconn, $_POST['applicant_ic']);
    $applicant_email = mysqli_real_escape_string($dbconn, $_POST['applicant_email']);
    $applicant_phoneNum = mysqli_real_escape_string($dbconn, $_POST['applicant_phoneNum']);
    $applicant_start = mysqli_real_escape_string($dbconn, $_POST['applicant_start']);
    $applicant_end = mysqli_real_escape_string($dbconn, $_POST['applicant_end']);
    $admin_id = mysqli_real_escape_string($dbconn, $_POST['admin_id']);
    $uni_id = mysqli_real_escape_string($dbconn, $_POST['uni_id']);
    $program_id = mysqli_real_escape_string($dbconn, $_POST['program_id']);
    $department_id = mysqli_real_escape_string($dbconn, $_POST['department_id']);


    // Handle file uploads
    $resume_path = '';
    $cv_path = '';

    if (isset($_FILES['applicant_resume']) && $_FILES['applicant_resume']['error'] === UPLOAD_ERR_OK) {
        $resume_path = 'uploads/' . basename($_FILES['applicant_resume']['name']);
        move_uploaded_file($_FILES['applicant_resume']['tmp_name'], $resume_path);
    }

    if (isset($_FILES['applicant_cv']) && $_FILES['applicant_cv']['error'] === UPLOAD_ERR_OK) {
        $cv_path = 'uploads/' . basename($_FILES['applicant_cv']['name']);
        move_uploaded_file($_FILES['applicant_cv']['tmp_name'], $cv_path);
    }

    // Fetch a default admin_id
$adminQuery = "SELECT admin_id FROM admin LIMIT 1";
$adminResult = mysqli_query($dbconn, $adminQuery);

if ($adminResult && mysqli_num_rows($adminResult) > 0) {
    $adminRow = mysqli_fetch_assoc($adminResult);
    $admin_id = $adminRow['admin_id'];
} else {
    die("Error: No admin exists in the database.");
}

// Insert applicant data
$sqlInsert = "INSERT INTO applicant 
(applicant_name, applicant_ic, applicant_email, applicant_phoneNum, applicant_start, applicant_end, applicant_resume, applicant_cv, admin_id, uni_id, program_id, department_id) 
VALUES 
('$applicant_name', '$applicant_ic', '$applicant_email', '$applicant_phoneNum', '$applicant_start', '$applicant_end', '$resume_path', '$cv_path', '$admin_id', '$uni_id', '$program_id', '$department_id')";


    if (mysqli_query($dbconn, $sqlInsert)) {
        // Get the last inserted applicant ID
        $applicant_id = mysqli_insert_id($dbconn);

        // Example: Assuming you want to use the first admin from the admin table
        $adminResult = mysqli_query($dbconn, "SELECT admin_id FROM admin LIMIT 1");
        if ($adminResult && mysqli_num_rows($adminResult) > 0) {
            $adminRow = mysqli_fetch_assoc($adminResult);
            $admin_id = $adminRow['admin_id'];
        } else {
            // Handle the case where no admin exists
            $admin_id = null; // or handle error
        }

        // Insert into the application table
        $sqlApplication = "INSERT INTO application (applicant_id, department_id, app_date, app_status) 
                           VALUES ('$applicant_id', '$department_id', NOW(), 'pending')";

        if (mysqli_query($dbconn, $sqlApplication)) {
            echo "<div class='center-text'>Your application has been submitted successfully!</div>";
        } else {
            echo "<div class='center-text'>Error inserting into application table: " . mysqli_error($dbconn) . "</div>";
        }
    } else {
        echo "<div class='center-text'>Error inserting into applicant table: " . mysqli_error($dbconn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Internship | AL AiN IT CONSULTANTS</title>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            font-family: Verdana, Geneva, Tahoma, sans-serif;
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
            width: 70%;
            height: 40%;
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

        .container {
            width: 100%;
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two equal columns */
            gap: 20px;
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: flex-start;; /* Ensures clean spacing between label and input */
        }

        .form-group label {
            width: 40%;
            font-size: 14px;
            color: #555;
            align-items: right;
            text-align: left
            margin-right: 10px;
        }

        .form-group input,
        .form-group select {
            width: 55%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input[type="file"] {
            padding: 0;
        }

        .button {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            background-color: #153448;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #59C1BD;
        }
    </style>
</head>
<body>
<header>
        <a href="#" class="logo"><img src= "logo.png" alt="logo alain"> </a>
        <nav class="navbar">
            <a href="#">Services</a>
            <a href="#">Solutions</a>
            <a href="#">Training</a>
            <a href="#">About</a>
        </nav>
</header>
<br><br><br><br><br><br>
    <div class="container">
        <h1>INTERNSHIP APPLICATION</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <!-- Left side -->
                <div>
                    <div class="form-group">
                        <label for="applicant_name">Full Name:</label>
                        <input type="text" name="applicant_name" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="applicant_ic">IC Number:</label>
                        <input type="text" name="applicant_ic" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="applicant_phoneNum">Phone Number:</label>
                        <input type="text" name="applicant_phoneNum" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="applicant_email">Email Address:</label>
                        <input type="email" name="applicant_email" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="uni_id">University:</label>
                        <select name="uni_id" required>
                            <!-- Populate dynamically -->
                            <?php
                            $query = "SELECT uni_id, uni_name FROM university";
                            $result = mysqli_query($dbconn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['uni_id'] . "'>" . $row['uni_name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No universities available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="program_id">Program:</label>
                        <select name="program_id" required>
                            <!-- Populate dynamically -->
                            <?php
                            $query = "SELECT program_id, program_name FROM program";
                            $result = mysqli_query($dbconn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['program_id'] . "'>" . $row['program_name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No program available</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Right side -->
                <div>
                    <div class="form-group">
                        <label>Start Date:</label>
                        <input type="date" name="applicant_start" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>End Date:</label>
                        <input type="date" name="applicant_end" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="department_id">Department:</label>
                        <select name="department_id" required>
                            <!-- Populate dynamically -->
                            <?php
                            $query = "SELECT department_id, department_name FROM department";
                            $result = mysqli_query($dbconn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['department_id'] . "'>" . $row['department_name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No departments available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Resume (PDF):</label>
                        <input type="file" name="applicant_resume" accept=".pdf" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Cover Letter(PDF):</label>
                        <input type="file" name="applicant_cv" accept=".pdf">
                    </div>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn">Apply</button>
            </div>
        </form>
    </div>
</body>
</html>
