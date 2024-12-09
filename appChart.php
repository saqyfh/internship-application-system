<?php
// Start session
session_start();

$pageTitle = 'Applicants';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    // Fetch initial data for the chart
    $sql = "SELECT app_status, COUNT(*) AS count FROM application GROUP BY app_status";
    $result = $dbconn->query($sql);
    $data = [
        "Pending" => 0,
        "Approved" => 0,
        "Rejected" => 0
    ];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[$row['app_status']] = $row['count'];
        }
    }
    $dbconn->close();
    $dataJSON = json_encode(array_values($data));
    $labelsJSON = json_encode(array_keys($data));
} else {
    header('Location: login.php');
    exit();
}

?>
<title><?php echo isset($pageTitle) ? $pageTitle : "Default Title"; ?></title>

<!-- Style for the page -->
<style>
    .search-container {
        display: flex;
        justify-content: space-between; /* Aligns the elements */
        align-items: center; /* Vertically centers the elements */
        margin-bottom: 20px; /* Space below the search bar and text */
    }

    .center-text {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center; /* Ensures it's centered */
        flex-grow: 1; /* Ensures the text takes as much space as possible */
    }

    .search-bar input {
        padding: 4px 8px;  /* Reduced padding to make the search bar smaller */
        font-size: 14px;
        width: 150px; /* Adjust width for small search bar */
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-left: 10px; /* Space between text and search bar */
        height: 30px; /* Reduced height */
    }

    .search-bar input:focus {
        outline: none;
        border-color: #4CAF50; /* Border color when focused */
    }
    #content {
    margin-left: 200px; /* Match sidebar width */
    padding-top: 70px;  /* Space for navbar */
    width: calc(100% - 250px); /* Ensure content fits the remaining space */
}

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 7px 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    td {
        color: #333;
        font-size: 13px;
    }

    td:last-child {
        color: #4CAF50;
        font-weight: bold;
    }

    /* Dashboard container */
    .dashboard-container {
            max-width: 40%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Chart area */
        .chart-container {
            text-align: center;
            margin: 20px 0;
        }

        canvas {
            max-width: 100%;
            height: auto;
        }

        /* Filters styling */
        .filter-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .filter-container label {
            margin: 0 10px;
            font-weight: bold;
        }

        .filter-container select {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .filter-container select:focus {
            border-color: #007bff;
            outline: none;
        }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- JavaScript to filter table rows based on search input -->
<body>
    
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
                    backgroundColor: ['#FFCC00', '#28A745', '#DC3545'],
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
</body>
</html>

