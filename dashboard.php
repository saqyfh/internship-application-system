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
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

// Get current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Fetch initial data for the chart
$sql = "SELECT app_status, COUNT(*) AS count FROM application GROUP BY app_status";


$result = $dbconn->query($sql);

// Default data for statuses
$data = [
    "Pending" => 0,
    "Approved" => 0,
    "Rejected" => 0
];

// Populate data array with database results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['app_status']] = $row['count'];
    }
}

$dbconn->close();

// Convert data to JSON format for Chart.js
$dataJSON = json_encode(array_values($data)); // Only the values
$labelsJSON = json_encode(array_keys($data)); // Status labels

?>

<script type="text/javascript">
    var vertical_menu = document.getElementById("vertical-menu");
    var current = vertical_menu.getElementsByClassName("active_link");
    if (current.length > 0) {
        current[0].classList.remove("active_link");
    }
    vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";
</script>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

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
                        <div>Total Applicants</div>
                        <div>
                            <?php
                            include("dbconn.php");
                            $sql = "SELECT * FROM applicant";
                            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
                            $row = mysqli_num_rows($query);

                            $sql = "SELECT COUNT(applicant_id) FROM applicant";
                            $result = mysqli_query($dbconn,$sql);
                            $row = mysqli_fetch_array($result);
                            echo $row[0];        
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
            <a href="appView.php">
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
                        <div>Total Departments</div>
                        <div>
                            <?php
                            include("dbconn.php");
                            $sql = "SELECT * FROM department";
                            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
                            $row = mysqli_num_rows($query);

                            $sql = "SELECT COUNT(department_id) FROM department";
                            $result = mysqli_query($dbconn,$sql);
                            $row = mysqli_fetch_array($result);
                            echo $row[0];
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
            <a href="departmentView.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div>Joining This Month</div>
                        <div>
                            <?php
                            include("dbconn.php");
                            $sql = "SELECT * FROM department";
                            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
                            $row = mysqli_num_rows($query);

                            $sql = "SELECT COUNT(department_id) FROM department";
                            $result = mysqli_query($dbconn,$sql);
                            $row = mysqli_fetch_array($result);
                            echo $row[0];
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
            <a href="appJoin.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                    <div class="col-sm-9 text-right">
                        <div>Current Active</div>
                        <div>
                            <?php
                            include("dbconn.php");
                            $sql = "SELECT * FROM department";
                            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
                            $row = mysqli_num_rows($query);

                            $sql = "SELECT COUNT(department_id) FROM department";
                            $result = mysqli_query($dbconn,$sql);
                            $row = mysqli_fetch_array($result);
                            echo $row[0];
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
            <a href="appActive.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="dashboard-container">
        <div class="filter-container">
            <label for="filterMonth">Month:</label>
            <select id="filterMonth" onchange="updateChart()">
                <option value="">All</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date("F", mktime(0, 0, 0, $i, 10));
                    echo "<option value='$i'>$monthName</option>";
                }
                ?>
            </select>

            <label for="filterYear">Year:</label>
            <select id="filterYear" onchange="updateChart()">
                <option value="">All</option>
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>

        <div class="chart-container">
            <canvas id="statusPieChart"></canvas>
        </div>
    </div>

    <script>
        // Function to fetch data based on selected filters
        function updateChart() {
            const month = document.getElementById("filterMonth").value;
            const year = document.getElementById("filterYear").value;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", `get_chart_data.php?month=${month}&year=${year}`, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    const labels = response.labels;
                    const data = response.data;

                    statusPieChart.data.labels = labels;
                    statusPieChart.data.datasets[0].data = data;
                    statusPieChart.update();
                }
            };
            xhr.send();
        }

        // Initial chart creation
        const ctx = document.getElementById('statusPieChart').getContext('2d');
        const statusPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo $labelsJSON; ?>,
                datasets: [{
                    label: 'Applications Status',
                    data: <?php echo $dataJSON; ?>,
                    backgroundColor: ['#0072B2', '#009E73', '#E69F00'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>

    <style>

        .dashboard-container {
            width: 35%;
            height: auto;
            position: center;
            border-radius: 10px;
        }

        .filter-container {
            position: center;
        }

<?php
} else {
    header('Location: loginFormLatest.php');
    exit();
}
?>