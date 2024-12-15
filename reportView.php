<?php
// Start session
session_start();

$pageTitle = 'Reports';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';
    
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Internship Reports</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .summary { display: flex; gap: 20px; }
            .summary div { background: #153448; color: white; padding: 20px; border-radius: 5px; flex: 1; text-align: center; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            table th { background: #153448; color: white; }
            .export-btn { background: #153448; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
            .export-btn:hover { background: #1e4963; }
            .container {
                max-width: 1200px; /* Set a maximum width */
                margin: 0 auto; /* Center the container */
                padding: 0 20px; /* Add padding for spacing */
            }

        </style>
    </head>
    <body>

    <h1>Internship Applications Report</h1>
    <p>Summary for: <strong>December 2024</strong></p>

    <div class="summary">
        <div>
            <h2>125</h2>
            <p>Total Applications</p>
        </div>
        <div>
            <h2>85</h2>
            <p>Approved Applications</p>
        </div>
        <div>
            <h2>25</h2>
            <p>Pending Applications</p>
        </div>
        <div>
            <h2>15</h2>
            <p>Rejected Applications</p>
        </div>
    </div>

    <h2>Application Details</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Status</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>IT</td>
                <td>Approved</td>
                <td>01/12/2024</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jane Smith</td>
                <td>Finance</td>
                <td>Pending</td>
                <td>03/12/2024</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Alex Tan</td>
                <td>Marketing</td>
                <td>Rejected</td>
                <td>05/12/2024</td>
            </tr>
        </tbody>
    </table>

    <button class="export-btn">Export Report</button>

    </body>
    </html>
<?php
    }
    $dbconn->close();
