<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Departments';

// PHP INCLUDES
include 'dbconn.php';
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize variables
        $department_id = $_POST['department_id'] ?? '';
        $department_name = $_POST['department_name'] ?? '';
        $department_desc = $_POST['department_desc'] ?? '';
        $targetFile = '';

        if (isset($_POST['update'])) {
            // Handle file upload
            if (isset($_FILES["department_image"]) && $_FILES["department_image"]["error"] == 0) {
                $targetDir = "image/";
                $department_image = basename($_FILES["department_image"]["name"]);
                $targetFile = $targetDir . $department_image;

                if (!move_uploaded_file($_FILES["department_image"]["tmp_name"], $targetFile)) {
                    echo "Sorry, there was an error uploading your file.";
                    exit;
                }
            }

            // Check if package exists
            $sqlSel = "SELECT * FROM department WHERE department_id = '$department_id'";
            $querySel = mysqli_query($dbconn, $sqlSel) or die("Error: " . mysqli_error($dbconn));
            $rowSel = mysqli_num_rows($querySel);

            if ($rowSel == 0) {
                echo "Record does not exist.";
            } else {
                // Update package details
                $sqlUpdate = "UPDATE department SET department_name='$department_name', department_desc='$department_desc'";
                if ($targetFile) {
                    $sqlUpdate .= ", department_image='$targetFile'";
                }
                $sqlUpdate .= " WHERE department_id='$department_id'";

                mysqli_query($dbconn, $sqlUpdate) or die("Error: " . mysqli_error($dbconn));
                echo "<center>Data has been updated</center><br>";
            }
        } elseif (isset($_POST['delete'])) {
            // Delete package
            $sqlDelete = "DELETE FROM department WHERE department_id = '$department_id'";
            mysqli_query($dbconn, $sqlDelete) or die("Error: " . mysqli_error($dbconn));
            echo "<center>Data has been deleted</center><br>";
        }
    }
}

// Provide a way back to the main page
echo "<br>";
echo "<div style='width: 80%; margin: 0 auto; text-align: center;'>";
echo "<button class='oval-button' onclick=\"window.location.href='departmentView.php'\">Main page</button>";
echo "</div>";
?>
