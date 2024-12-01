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

    $sql = "SELECT * FROM applicant";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    $row = mysqli_num_rows($query);

    $result = $dbconn->query($sql);
    if ($row == 0) {
        echo "No record found";
    } else {
        // Search bar and Application Details title
        echo '<div class="search-container">
                <div class="center-text">APPLICANTS DETAILS INFORMATION</div>
                <div class="search-bar">
                    <input type="text" placeholder="Search..." id="searchInput" onkeyup="searchTable()">
                </div>
              </div>';

        // Table for displaying applicant details
        echo "<table id='applicantTable'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Phone No</th>";
        echo "<th>University</th>";
        echo "<th>Start </th>";
        echo "<th>End</th>";
        echo "<th> Status</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>" . $row["applicant_id"] . "</td>";
            echo "<td>" . $row["applicant_name"] . "</td>";
            echo "<td>" . $row["applicant_email"] . "</td>";
            echo "<td>" . $row["applicant_phoneNum"] . "</td>";
            echo "<td>" . $row["uni_id"] . "</td>";
            echo "<td>" . $row["applicant_start"] . "</td>";
            echo "<td>" . $row["applicant_end"] . "</td>";
            echo "<td class='center-td'>
                <a href='applicant.php?applicant_id=" . $row["applicant_id"] . "' class='edit-btn'>
                    <i class='fas fa-eye'></i>
                </a>
                </td>";
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
