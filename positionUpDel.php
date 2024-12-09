<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Positions';

// PHP INCLUDES
include 'dbconn.php';
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize variables
        $position_id = $_POST['position_id'] ?? '';
        $position_name = $_POST['position_name'] ?? '';
        $position_desc = $_POST['position_desc'] ?? '';
        $targetFile = '';

        if (isset($_POST['update'])) {
            // Handle file upload
            if (isset($_FILES["position_image"]) && $_FILES["position_image"]["error"] == 0) {
                $targetDir = "image/";
                $position_image = basename($_FILES["position_image"]["name"]);
                $targetFile = $targetDir . $position_image;

                if (!move_uploaded_file($_FILES["position_image"]["tmp_name"], $targetFile)) {
                    echo "Sorry, there was an error uploading your file.";
                    exit;
                }
            }

            // Check if package exists
            $sqlSel = "SELECT * FROM position WHERE position_id = '$position_id'";
            $querySel = mysqli_query($dbconn, $sqlSel) or die("Error: " . mysqli_error($dbconn));
            $rowSel = mysqli_num_rows($querySel);

            if ($rowSel == 0) {
                echo "Record does not exist.";
            } else {
                // Update package details
                $sqlUpdate = "UPDATE position SET position_name='$position_name', position_desc='$position_desc'";
                if ($targetFile) {
                    $sqlUpdate .= ", position_image='$targetFile'";
                }
                $sqlUpdate .= " WHERE position_id='$position_id'";

                mysqli_query($dbconn, $sqlUpdate) or die("Error: " . mysqli_error($dbconn));
                echo "<center>Data has been updated</center><br>";
            }
        } elseif (isset($_POST['delete'])) {
            // Delete package
            $sqlDelete = "DELETE FROM position WHERE position_id = '$position_id'";
            mysqli_query($dbconn, $sqlDelete) or die("Error: " . mysqli_error($dbconn));
            echo "<center>Data has been deleted</center><br>";
        }
    }
}

// Provide a way back to the main page
echo "<br>";
echo "<div style='width: 80%; margin: 0 auto; text-align: center;'>";
echo "<button class='oval-button' onclick=\"window.location.href='positionView.php'\">Main page</button>";
echo "</div>";
?>
