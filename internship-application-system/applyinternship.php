<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Retrieve student information
    $studentName = htmlspecialchars($_POST['studentName']);
    $jobID = htmlspecialchars($_POST['jobID']);
    $status = "Pending";
    
    // File upload handling
    $targetDir = "uploads/";
    $cvFileName = basename($_FILES["cvFile"]["name"]);
    $targetFilePath = $targetDir . $cvFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Check if the file is a valid type
    if (in_array($fileType, array("pdf", "doc", "docx"))) {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["cvFile"]["tmp_name"], $targetFilePath)) {
            // Insert the application into the database using prepared statements
            $stmt = $conn->prepare("INSERT INTO jobapplications (studentname, jobID, CVfile, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $studentName, $jobID, $cvFileName, $status);
            $stmt->execute();
    
            $message = "The file " . htmlspecialchars(basename($_FILES["cvFile"]["name"])) . " has been submitted successfully!";
        } else {
            $message = "There was an error uploading your file.";
        }
    } else {
        $message = "Invalid file type. Please upload a PDF, DOC, or DOCX file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Internship</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            transition: background-color 0.3s, color 0.3s;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            transition: background-color 0.3s, color 0.3s;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: none;
            animation: fadeInOut 3s forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }

        .dark-mode {
            background-color: #333;
            color: #fff;
        }

        .dark-mode .container {
            background-color: rgba(68, 68, 68, 0.9);
            color: #fff;
        }

        .toggle-switch {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            margin-right: 20px;
        }

        .progress {
            display: none;
            margin-top: 20px;
        }
    </style>
    <script>
        function validateForm() {
            var jobID = document.forms["applyForm"]["jobID"].value;
            var file = document.forms["applyForm"]["cvFile"].value;
            if (name == "" || jobID == "" || file == "") {
                alert("All fields must be filled out");
                return false;
            }
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });

        function showProgressBar() {
            document.querySelector('.progress').style.display = 'block';
        }

        function showAlert(message) {
            var alertBox = document.querySelector('.alert');
            alertBox.textContent = message;
            alertBox.style.display = 'block';
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }

        <?php if (isset($message)) { ?>
        document.addEventListener('DOMContentLoaded', (event) => {
            showAlert("<?php echo $message; ?>");
        });
        <?php } ?>
    </script>
</head>
<body>
    <div class="toggle-switch">
        <button class="btn btn-secondary" onclick="toggleDarkMode()">Toggle Dark Mode</button>
    </div>
    <div class="alert alert-info"></div>
    <div class="container">
        <h2>Apply for Internship</h2>
        <form name="applyForm" action="applyinternship.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm(); showProgressBar();">
            <div class="form-group">
                <label for="studentName">Student Name:</label>
                <input type="text" class="form-control" id="studentName" name="studentName" aria-describedby="studentNameHelp" required>
                <small id="studentNameHelp" class="form-text text-muted">Enter your full name.</small>
            </div>
            <div class="form-group">
                <label for="jobID">Job ID:</label>
                <input type="text" class="form-control" id="jobID" name="jobID" aria-describedby="jobIDHelp" required>
                <small id="jobIDHelp" class="form-text text-muted">Enter the job ID you are applying for.</small>
            </div>
            <div class="form-group">
                <label for="cvFile">Upload CV:</label>
                <input type="file" class="form-control-file" id="cvFile" name="cvFile" aria-describedby="cvFileHelp" required>
                <small id="cvFileHelp" class="form-text text-muted">Upload your CV in PDF, DOC, or DOCX format.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

