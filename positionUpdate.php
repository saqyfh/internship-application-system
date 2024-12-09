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

$position_id = $_GET['position_id'];
$sqlSel = "SELECT * FROM position WHERE position_id = '$position_id'";
$querySel = mysqli_query($dbconn, $sqlSel) or die("Error: " . mysqli_error($dbconn));
$position = mysqli_fetch_assoc($querySel);

// Handle the form submission (Update or Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position_id = $_POST['position_id'];
    $position_name = $_POST['position_name'];
    $position_desc = $_POST['position_desc'];
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

        // Update the position
        $sqlUpdate = "UPDATE position SET position_name='$position_name', position_desc='$position_desc'";
        if ($targetFile) {
            $sqlUpdate .= ", position_image='$targetFile'";
        }
        $sqlUpdate .= " WHERE position_id='$position_id'";

        if (mysqli_query($dbconn, $sqlUpdate)) {
            // Data updated successfully
            $message = "Data has been updated";
            $redirectUrl = "positionView.php";
        } else {
            // Error updating
            $message = "Error updating data";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the position
        $sqlDelete = "DELETE FROM position WHERE position_id = '$position_id'";
        if (mysqli_query($dbconn, $sqlDelete)) {
            // Data deleted successfully
            $message = "Data has been deleted";
            $redirectUrl = "positionView.php";
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
    <title>Update Position</title>
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
            background-color: #4CAF50;
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
            color: #4CAF50;
            font-weight: bold;
        }
        .oval-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
        }
        .oval-button:hover {
            background-color: #45a049;
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
            background-color: #4CAF50;
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
    UPDATE/DELETE POSITION
</div>

<!-- The Update/Delete Form -->
<form action="positionUpdate.php?position_id=<?php echo $position_id; ?>" method="post" enctype="multipart/form-data">
    <table border="0">
        <tr>
            <td>No</td>
            <td>:</td>
            <td><input type="text" name="position_id" value="<?php echo $position['position_id']; ?>" readonly></td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td><input type="text" name="position_name" value="<?php echo $position['position_name']; ?>"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>:</td>
            <td><input type="text" name="position_desc" value="<?php echo $position['position_desc']; ?>"></td>
        </tr>
        <tr>
            <td>Image</td>
            <td>:</td>
            <td>
                <?php if (!empty($position['position_image'])): ?>
                    <img src="<?php echo htmlspecialchars($position['position_image']); ?>" alt="Image Preview" style="width: 100px; height: 100px; cursor: pointer;" onclick="openPopup('<?php echo htmlspecialchars($position['position_image']); ?>')">
                    <br>
                <?php else: ?>
                    <p>No image uploaded.</p>
                <?php endif; ?>
                <input type="file" name="position_image">
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
