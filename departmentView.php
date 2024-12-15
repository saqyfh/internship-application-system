<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Departments';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    $sql = "SELECT * FROM department";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    $row = mysqli_num_rows($query);
    $result = $dbconn->query($sql);
    if ($row == 0) {
        echo "No record found";
    } else {
        echo '<div class="search-container">
                    <div class="center-text">DEPARTMENTS DETAILS INFORMATION</div>
                    <div class="search-bar">
                        <input type="text" placeholder="Search..." id="searchInput" onkeyup="searchTable()">
                    </div>
              </div>';

        echo "<table id='departmentTable'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>Name</th>";
        echo "<th>Description</th>";
        echo "<th>Image</th>";
        echo "<th>Options</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>".$row["department_id"]."</td>";
            echo "<td>".$row["department_name"]."</td>";
            echo "<td>".$row["department_desc"]."</td>";
            echo "<td><img src='".$row["department_image"]."' alt='Image' style='width: 100px; height: 100px; object-fit: cover;'></td>";
            echo "<td class='center-td'>
                <a href='departmentUpdate.php?department_id=" . $row["department_id"] . "' class='edit-btn'>
                    <i class='fas fa-edit'></i>
                </a>
                </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        echo "<div style='width: 80%; margin: 0 auto; text-align: right;'>";
        echo "<button class='oval-button'> <a href='departmentAdd.php' style='color:#fff;'>+ Add</a></button>";  
        echo "<button class='oval-button'  > <a href='dashboard.php' style='color:#fff;'>Close</a></button>"; 
        echo "</div>";
    }

    $dbconn->close();
?>

<!-- Additional CSS for the page -->
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
        margin-top: 70px;
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
        border-color: #4CAF50;
    }

    table {
        width: 96%;
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

    .oval-button a {
        text-decoration: none;
        color: white;
    }

    /* Center the button in the table cell */
    .center-td {
        text-align: center;
    }

    /* Style for the edit button */
    .edit-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 30px;
        color: #06adef;
        cursor: pointer;
        font-size: 16px;
    }

    .edit-btn:hover {
        color: #153448;
    }

    .edit-btn i {
        font-size: 16px;
    }
</style>

<!-- Add Font Awesome for the Edit icon -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<?php
} else {
    header('Location: login.php');
    exit();
}
?>

<!-- JavaScript for search functionality -->
<script>
    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("departmentTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            let found = false;

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
