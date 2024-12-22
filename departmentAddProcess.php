<?php
include('dbconn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_name = $_POST['department_name'];
    $department_desc = $_POST['department_desc'];

    // Handle file upload
    $targetDir = "image/"; // Directory where you want to store the uploaded images
    $targetFile = $targetDir . basename($_FILES["department_image"]["name"]); // Get the name of the uploaded file

    // Try to upload the file
    if (move_uploaded_file($_FILES["department_image"]["tmp_name"], $targetFile)) {
        echo "The file " . htmlspecialchars(basename($_FILES["department_image"]["name"])) . " has been uploaded.";


        // Check connection
        if ($dbconn->connect_error) {
            die("Connection failed: " . $dbconn->connect_error);
        }

        // Insert into database
        $sql = "INSERT INTO department (department_name, department_desc, department_image) VALUES (?, ?, ?)";
        $stmt = $dbconn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $dbconn->error);
        }
        $stmt->bind_param("sss", $department_name, $department_desc, $targetFile);
        if ($stmt->execute()) {
            header('Location: departmentView.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $dbconn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>