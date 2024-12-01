<?php
// Start session
session_start();

// Set page title
$pageTitle = 'Department';

// PHP INCLUDES
include 'dbconn.php';
echo "Including functions.php...\n";
include 'functions.php';
include 'header.php';
include 'navbar.php';


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<!-- home section starts -->
<section class="addPosition" id="addPosition">
        <form action="positionAddProcess.php" method="POST" enctype="multipart/form-data" onsubmit="showPopup()">
            <table class="center">
            <div class='center-text'>ADD NEW DEPARTMENT</div>
                <tr>
                    <td><p>Department Name</p></td>
                    <td>:</td>
                    <td><input type="text" name="position_name"><br></td>
                </tr>
                <tr>
                    <td><p>Position Description </p></td>
                    <td>:</td>
                    <td><input type="text" name="position_desc"><br></td>
                </tr>
                <tr>
                    <td><p>Position Image </p></td>
                    <td>:</td>
                    <td><input type="file" name="position_image" id="position_image" accept="image/*" required><br></td>
                </tr>            
            </table> 
            
            <div class="button-container">
                <button class='oval-button' type="submit" name="submit">Add</button>
            </div>
        </form>
    </section>
</body>
</html>
<?php
    echo "<style>     

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        .td h5 {
            font-size: 13px;
            background-color:#4CAF50;
        }

        .center-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #333;
        }
        td:last-child {
            color: #4CAF50;
            font-weight: bold;
        }
    </style>";
?>