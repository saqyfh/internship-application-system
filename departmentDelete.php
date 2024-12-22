<?php
include 'dbconn.php';

$department_id = $_GET['department_id'];
$sql = "UPDATE department SET deleted = 1 WHERE department_id = $department_id";

if (mysqli_query($dbconn, $sql)) {
    echo "Record marked as deleted successfully";
} else {
    echo "Error: " . mysqli_error($dbconn);
}

mysqli_close($dbconn);
header("Location: departmentView.php");
?>