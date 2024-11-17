<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$applicationID = $_GET['applicationID'];
$CVfile = $_GET['CVfile'];

$add_to_db = mysqli_query($conn,"UPDATE jobapplications SET status='Rejected' WHERE applicationID='".$applicationID."' AND CVfile='".$CVfile."'");
	
			if($add_to_db){	
			  echo "Saved!!";
			  header("Location: companyacceptreject.php");
			}
			else{
			  echo "Query Error : " . "UPDATE jobapplications SET status='Rejected' WHERE applicationID='".$applicationID."' AND CVfile='".$CVfile."'" . "<br>" . mysqli_error($conn);
			}
	

	ini_set('display_errors', true);
	error_reporting(E_ALL);  
		 
?>

