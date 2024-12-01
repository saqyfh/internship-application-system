<?php
// Database connection
$dbconn = mysqli_connect("localhost", "root", "", "intern_app");

if (!$dbconn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $applicant_name = mysqli_real_escape_string($dbconn, $_POST['applicant_name']);
    $applicant_email = mysqli_real_escape_string($dbconn, $_POST['applicant_email']);
    $applicant_phoneNum = mysqli_real_escape_string($dbconn, $_POST['applicant_phoneNum']);
    $applicant_start = mysqli_real_escape_string($dbconn, $_POST['applicant_start']);
    $applicant_end = mysqli_real_escape_string($dbconn, $_POST['applicant_end']);
    $uni_id = mysqli_real_escape_string($dbconn, $_POST['uni_id']);
    $position_id = mysqli_real_escape_string($dbconn, $_POST['position_id']);

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

    // Insert applicant data into applicant table
    $sqlInsert = "INSERT INTO applicant 
        (applicant_name, applicant_email, applicant_phoneNum, applicant_start, applicant_end, applicant_resume, applicant_cv, uni_id, position_id) 
        VALUES 
        ('$applicant_name', '$applicant_email', '$applicant_phoneNum', '$applicant_start', '$applicant_end', '$resume_path', '$cv_path', '$uni_id', '$position_id')";

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
        $sqlApplication = "INSERT INTO application (applicant_id, position_id, app_date, app_status) 
                           VALUES ('$applicant_id', '$position_id', NOW(), 'pending')";

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
    <title>Apply for Internship</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap');
        body {
            background-color: transparent;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .center-text {
            color: #333;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-family: 'League Spartan', sans-serif;
            font-weight: 700;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input, button, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1 class="center-text">Internship Application</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="applicant_name">Full Name:</label>
        <input type="text" name="applicant_name" required>

        <label for="applicant_email">Email:</label>
        <input type="email" name="applicant_email" required>

        <label for="applicant_phoneNum">Phone Number:</label>
        <input type="text" name="applicant_phoneNum" required>

        <label for="applicant_start">Start Date:</label>
        <input type="date" name="applicant_start" required>

        <label for="applicant_end">End Date:</label>
        <input type="date" name="applicant_end" required>

        <label for="applicant_resume">Resume (PDF):</label>
        <input type="file" name="applicant_resume" accept=".pdf" required>

        <label for="applicant_cv">Cover Letter (PDF):</label>
        <input type="file" name="applicant_cv" accept=".pdf">

        <!-- University Dropdown -->
        <label for="uni_id">University:</label>
        <select name="uni_id" required>
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

        <!-- Position Dropdown -->
        <label for="position_id">Position:</label>
        <select name="position_id" required>
            <?php
            $query = "SELECT position_id, position_name FROM position";
            $result = mysqli_query($dbconn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['position_id'] . "'>" . $row['position_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No positions available</option>";
            }
            ?>
        </select>

        <button type="submit">Apply</button>
    </form>

</body>
</html>
