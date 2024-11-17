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
    
            echo "The file " . htmlspecialchars(basename($_FILES["cvFile"]["name"])) . " has been submitted successfully!";
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo "Invalid file type. Please upload a PDF, DOC, or DOCX file.";
    }
    
    $stmt->close();
    $conn->close();
  }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Internship Application</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <style>
:root {
  --bg-color: #ffffff;
  --text-color: #000000;
  --nav-bg-color: #64C5B1;
}

[data-theme="dark"] {
  --bg-color: #121212;
  --text-color: #ffffff;
  --nav-bg-color: #333333;
}

body {
  background-color: var(--bg-color);
  color: var(--text-color);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.navbar {
  background-color: var(--nav-bg-color);
}

.form-box {
  background-color: var(--bg-color);
  padding: 50px; /* Increased padding for more space around the form */
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 10000px; /* Increased max-width for a larger form */
}

.form-box h2 {
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  color: var(--text-color);
}

.form-control, .form-control-file {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--text-color);
  border-radius: 4px;
  color: var(--text-color);
  background: none;
}

.toggle-theme {
  cursor: pointer;
  font-size: 20px;
}


  </style>
</head>
<body data-theme="light">
  <nav class="navbar navbar-expand-lg navbar-light border-bottom">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <span class="toggle-theme" onclick="toggleTheme()">🌙</span>
        </li>
      </ul>
    </div>
  </nav>
  <div class="d-flex" id="wrapper">
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <section>
                        <div class="form-box">
                            <div class="form-value">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <h2>Apply for Internship</h2>
                                    <div class="form-group">
                                        <label for="studentName">Your Name</label>
                                        <input type="text" class="form-control" id="studentName" name="studentName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvFile">Upload CV (PDF, Word)</label>
                                        <input type="file" class="form-control-file" id="cvFile" name="cvFile" accept=".pdf,.doc,.docx" required>
                                    </div>
                                    <input type="hidden" name="jobID" value="1">
                                    <button type="submit" class="btn btn-primary">Submit Application</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function toggleTheme() {
      const body = document.body;
      const currentTheme = body.getAttribute('data-theme');
      body.setAttribute('data-theme', currentTheme === 'light' ? 'dark' : 'light');
    }
  </script>
</body>
</html>