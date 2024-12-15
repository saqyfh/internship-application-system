<?php
// Start session
session_start();

$pageTitle = 'Applications';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    // Join application with applicant and department tables to fetch their names
    $sql = "
    SELECT 
        a.app_id, 
        ap.applicant_name, 
        d.department_name, 
        a.app_date, 
        a.app_status
    FROM 
        application a
    JOIN applicant ap ON a.applicant_id = ap.applicant_id
    JOIN department d ON a.department_id = d.department_id
    ";

    
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    $row = mysqli_num_rows($query);

    if ($row == 0) {
        echo "No record found";
    } else {
        // Search bar and Application Details title
        echo '<div class="search-container">
                <div class="center-text">APPLICATION DETAILS INFORMATION</div>
                <div class="search-bar">
                    <input type="text" placeholder="Search..." id="searchInput" onkeyup="searchTable()">
                </div>
              </div>';

        // Table for displaying application details
        echo "<table id='applicantTable'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Name</th>";
        echo "<th>Department</th>";
        echo "<th>Date</th>";
        echo "<th>Status</th>";
        echo "</tr>";

        // Loop through each record and display the results
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>" . $row["app_id"] . "</td>";
            echo "<td>" . $row["applicant_name"] . "</td>";
            echo "<td>" . $row["department_name"] . "</td>";
            echo "<td>" . $row["app_date"] . "</td>";
            echo "<td>" . $row["app_status"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<br>";
        echo "<div style='width: 80%; margin: 0 auto; text-align: right;'>";
        echo "<button class='oval-button' onclick=\"window.location.href='dashboard.php'\">Close</button>";
        echo "</div>";
    }

    $dbconn->close();
} else {
    header('Location: login.php');
    exit();
}
?>

<!-- Style for the page -->
<style>
    .search-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .center-text {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        flex-grow: 1;
    }

    .search-bar input {
        padding: 4px 8px;
        font-size: 14px;
        width: 150px;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-left: 10px;
        height: 30px;
    }

    .search-bar input:focus {
        outline: none;
        border-color: #153448;
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
        background-color: #153448;
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
</style>

<!-- JavaScript to filter table rows based on search input -->
<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("applicantTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { // Skip the header row
            let td = tr[i].getElementsByTagName("td");
            let found = false;

            // Loop through each column to search for the term
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>
