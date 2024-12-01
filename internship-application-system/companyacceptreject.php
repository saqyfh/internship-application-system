<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
   
    <title>Company Dashboard</title>

    <style>
        h1 {
            text-align: center;
            font-size: 2.5em;
            font-weight: bold;
            padding-top: 1em;
        }
    </style>

</head>

<body>
    <nav class="navbar header-nav navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
           

            <ul class="nav justify-content-end">

            <li class="nav-item">
                <a class="nav-link" href="leave_history.php" style="color:black;">View Application History</a>
            </li>

            </ul>
            
    </nav>

    <h1>Student Job Application</h1>

    <div class="mycontainer">

            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <th>#</th>
                    <th>Student</th>
                    <th>Application Date</th>
                    <th>Student CV</th>
                    <th>Actions</th>

                </thead>
                <tbody>
                        <!-- loading all leave applications from database -->

                        
<?php  

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = mysqli_query($conn,"SELECT * FROM jobapplications WHERE status='Pending'");

if($query){
    $numrow = mysqli_num_rows($query);

    if($numrow!=0){
        $cnt=1;


        while($row = mysqli_fetch_assoc($query)){
            $datetime1 = new DateTime();

          
            echo "<tr>
                    <td>$cnt</td>
                    <td>{$row['studentname']}</td>
                    <td>{$datetime1->format('Y/m/d')}</td>
                    <td><a href='uploads/" . htmlspecialchars($row['CVfile']) . "' download='" . htmlspecialchars($row['CVfile']) . "'>" . htmlspecialchars($row['CVfile']) . "</a></td>                                 
                    <td><a href=\"updateStatusAccept.php?applicationID={$row['applicationID']}&CVfile={$row['CVfile']}\"><button class='btn-success btn-sm' >Accept</button></a>
                    <a href=\"updateStatusReject.php?applicationID={$row['applicationID']}&CVfile={$row['CVfile']}\"><button class='btn-danger btn-sm' >Reject</button></a></td>
                  </tr>";  
            $cnt++;       
        }
    }
} else {
    echo "Query Error : " . "SELECT * FROM jobapplications WHERE status='Pending'" . "<br>" . mysqli_error($conn);
}
?>
                    
                </tbody>
            </table>
    </div>

</body>

</html>