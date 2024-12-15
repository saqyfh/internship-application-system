<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Departments';

// PHP INCLUDES
include 'dbconn.php';
include 'functions.php';
include 'header.php';
include 'navbar.php';

$department_id = $_GET['department_id'];
$sqlSel = "SELECT * FROM department WHERE department_id = '$department_id'";
$querySel = mysqli_query($dbconn, $sqlSel) or die("Error: " . mysqli_error($dbconn));
$department = mysqli_fetch_assoc($querySel);

// Handle the form submission (Update or Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $department_desc = $_POST['department_desc'];
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

        // Update the department
        $sqlUpdate = "UPDATE department SET department_name='$department_name', department_desc='$department_desc'";
        if ($targetFile) {
            $sqlUpdate .= ", department_image='$targetFile'";
        }
        $sqlUpdate .= " WHERE department_id='$department_id'";

        if (mysqli_query($dbconn, $sqlUpdate)) {
            // Data updated successfully
            $message = "Data has been updated";
            $redirectUrl = "departmentView.php";
        } else {
            // Error updating
            $message = "Error updating data";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the department
        $sqlDelete = "DELETE FROM department WHERE department_id = '$department_id'";
        if (mysqli_query($dbconn, $sqlDelete)) {
            // Data deleted successfully
            $message = "Data has been deleted";
            $redirectUrl = "departmentView.php";
        } else {
            // Error deleting
            $message = "Error deleting data";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Department</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        .center-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #153448;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #333;
        }
        td:last-child {
            color: #153448;
            font-weight: bold;
        }
        .oval-button {
            padding: 10px 20px;
            background-color: #153448;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
        }
        .oval-button:hover {
            background-color: #59C1BD;
        }

        /* Image Popup */
        #imagePopup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #popupImage {
            max-width: 100%;
            max-height: 90vh;
        }
        #popupContainer {
            position: relative;
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #153448;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<br><br>
<!-- Title above the form -->
<div class="center-text">
    UPDATE/DELETE DEPARTMENT
</div>

<!-- The Update/Delete Form -->
<form action="departmentUpdate.php?department_id=<?php echo $department_id; ?>" method="post" enctype="multipart/form-data">
    <table border="0">
        <tr>
            <td>No</td>
            <td>:</td>
            <td><input type="text" name="department_id" value="<?php echo $department['department_id']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td><input type="text" name="department_name" value="<?php echo $department['department_name']; ?>"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>:</td>
            <td><input type="text" name="department_desc" value="<?php echo $department['department_desc']; ?>"></td>
        </tr>
        <tr>
            <td>Image</td>
            <td>:</td>
            <td>
                <?php if (!empty($department['department_image'])): ?>
                    <img src="<?php echo htmlspecialchars($department['department_image']); ?>" alt="Image Preview" style="width: 100px; height: 100px; cursor: pointer;" onclick="openPopup('<?php echo htmlspecialchars($position['position_image']); ?>')">
                    <br>
                <?php else: ?>
                    <p>No image uploaded.</p>
                <?php endif; ?>
                <input type="file" name="department_image">
            </td>
        </tr>
    </table>

    <br>
    <div style="width: 80%; margin: 0 auto; text-align: right;">
        <button class="oval-button" type="submit" name="update">Update</button>
        <button class="oval-button" type="submit" name="delete">Delete</button>
    </div>
</form>

<!-- Image Popup -->
<div id="imagePopup">
    <div id="popupContainer">
        <img id="popupImage" src="" alt="Image Preview">
        <br>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>
    function openPopup(imageUrl) {
        document.getElementById('popupImage').src = imageUrl;
        document.getElementById('imagePopup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('imagePopup').style.display = 'none';
        document.getElementById('popupImage').src = '';
    }

    // Check if there's a success message to show the popup
    <?php if (isset($message)): ?>
        alert("<?php echo $message; ?>");
        window.location.href = "<?php echo $redirectUrl; ?>";
    <?php endif; ?>
</script>

</body>
</html>
