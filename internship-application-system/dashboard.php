<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Dashboard';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
echo "functions.php included successfully.\n";
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['adminID']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    ?>

    <script type="text/javascript">
        var vertical_menu = document.getElementById("vertical-menu");
        var current = vertical_menu.getElementsByClassName("active_link");
        if (current.length > 0) {
            current[0].classList.remove("active_link");
        }
        vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";
    </script>
	
    <!-- TOP 4 CARDS -->
	<div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-green ">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3">
                            <i class="fa fa-users fa-4x"></i>
                        </div>
                        <div class="col-sm-9 text-right">
                         					 
                            <div>Total Customers</div>
							<div>
						
						 <?php
						include("dbconn.php");
						$sql = "SELECT * FROM customer";
						$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
						$row = mysqli_num_rows($query);
						
						$sql = "SELECT COUNT(custID) FROM customer";
						$result = mysqli_query($dbconn,$sql);
						$row = mysqli_fetch_array($result);
						echo $row[0];
		
						?>
						</div>	
                        </div>
                    </div>
                </div>
                <a href="ViewCustDetailsInfo.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3">
                            <i class="fas fa-user fa-4x"></i>
                        </div>
                        <div class="col-sm-9 text-right">
                            
                            <div>Total Admin</div>
							<div>
						
						 <?php
						include("dbconn.php");
						$sql = "SELECT * FROM admin";
						$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
						$row = mysqli_num_rows($query);
						
						$sql = "SELECT COUNT(adminID) FROM admin";
						$result = mysqli_query($dbconn,$sql);
						$row = mysqli_fetch_array($result);
						echo $row[0];
		
						?>
						</div>	
                        </div>
                    </div>
                </div>
                <a href="viewAdminDetailsInfo.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class=" col-sm-6 col-lg-3">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3">
                            <i class="far fa-calendar-alt fa-4x"></i>
                        </div>
                        <div class="col-sm-9 text-right">
                            
                            <div>Total Package</div>
							<div>
						
						 <?php
						include("dbconn.php");
						$sql = "SELECT * FROM package";
						$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
						$row = mysqli_num_rows($query);
						
						$sql = "SELECT COUNT(packageID) FROM package";
						$result = mysqli_query($dbconn,$sql);
						$row = mysqli_fetch_array($result);
						echo $row[0];
		
						?>
						</div>
                        </div>
                    </div>
                </div>
                <a href="PackageManagementLatest.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class=" col-sm-6 col-lg-3">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3">
                            <i class="fas fa-shopping-cart fa-4x"></i>
                        </div>
                        <div class="col-sm-9 text-right">
                            
                            <div>Total Orders</div>
							<div>
						
						 <?php
						include("dbconn.php");
						$sql = "SELECT * FROM orderpackage";
						$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
						$row = mysqli_num_rows($query);
						
						$sql = "SELECT COUNT(orderID) FROM orderpackage";
						$result = mysqli_query($dbconn,$sql);
						$row = mysqli_fetch_array($result);
						echo $row[0];
		
						?>
						</div>
                        </div>
                    </div>
                </div>
				
				
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
	
	<div>
	<?php
    include("dbconn.php");
    $sql = "SELECT * FROM customer";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    $row = mysqli_num_rows($query);

    if ($row == 0) {
        echo "No record found";
    } else {
        echo "<div class='center-text'>CUSTOMER DETAILS INFORMATION</div>";
        echo "<table>";
        echo "<tr>";
        echo "<th>User ID</th>";
        echo "<th>Password</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Phone Number</th>";
        echo "<th>Age</th>";
        echo "<th>Gender</th>";
        echo "<th>Email</th>";
        echo "<th>Options</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>".$row["custID"]."</td>";
            echo "<td>".$row["cust_password"]."</td>";
            echo "<td>".$row["cust_firstName"]."</td>";
            echo "<td>".$row["cust_lastName"]."</td>";
            echo "<td>".$row["cust_phoneNum"]."</td>";
            echo "<td>".$row["cust_age"]."</td>";
            echo "<td>".$row["cust_gender"]."</td>";
            echo "<td>".$row["cust_email"]."</td>";
            echo "<td><a href='detAttCust.php?c_id=".$row["custID"]."'>Edit</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        
    }
?>
</div>

    

    <?php
	
} else {
    header('Location: loginFormLatest.php');
    exit();
}
?>

