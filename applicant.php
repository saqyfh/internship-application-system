<?php
// Start session
session_start();

// PHP INCLUDES
include 'dbconn.php';
include 'functions.php';
include 'header.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
    include 'navbar.php';

    // Check if applicant_id is set in the query string
    if (isset($_GET['applicant_id'])) {
        $applicant_id = intval($_GET['applicant_id']);

        // Fetch applicant details from the database
        $sql = "SELECT 
            a.*, 
            u.uni_name, 
            p.program_name, 
            d.department_name 
        FROM 
            applicant a
        LEFT JOIN 
            university u ON a.uni_id = u.uni_id
        LEFT JOIN 
            program p ON a.program_id = p.program_id
        LEFT JOIN 
            department d ON a.department_id = d.department_id
        WHERE 
            a.applicant_id = $applicant_id";

        $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
        $row = mysqli_fetch_assoc($query);

        if ($row) {
            $resume = '/uploads/resumes/' . $row['applicant_resume'];
            $cv = '/uploads/cvs/' . $row['applicant_cv'];

            echo '<div class="details-container">';
            echo '<h2>Applicant Details</h2>';
            echo '<div class="details-grid">';
            
            // Left Side
            echo '<div class="details-left">';
            echo '<p><strong>FULL NAME:</strong> ' . htmlspecialchars($row['applicant_name']) . '</p>';
            echo '<p><strong>IC NUMBER:</strong> ' . htmlspecialchars($row['applicant_ic']) . '</p>';
            echo '<p><strong>PHONE NUMBER:</strong> ' . htmlspecialchars($row['applicant_phoneNum']) . '</p>';
            echo '<p><strong>EMAIL:</strong> ' . htmlspecialchars($row['applicant_email']) . '</p>';
            echo '<p><strong>UNIVERSITY:</strong> ' . htmlspecialchars($row['uni_name']) . '</p>';
            // Display Resume
            echo '<div class="form-group">';
            $resume = $row['applicant_resume'];
            $resumeExtension = pathinfo($resume, PATHINFO_EXTENSION);
            echo '<p><strong>RESUME:</strong><br>';
            if (strtolower($resumeExtension) == 'pdf') {
                echo "<embed src='$resume' width='300' height='300' type='application/pdf'>";
                echo "<br><a href='".$resume."' target='_blank'>View</a>";
            } else {
                echo "<img src='$resume' alt='Resume' width='100%'>";
            }
            echo "</p>";
            echo "</div>";
            echo '</div>';

            // Right Side
            echo '<div class="details-right">';
            echo '<p><strong>START DATE:</strong> ' . htmlspecialchars($row['applicant_start']) . '</p>';
            echo '<p><strong>END DATE:</strong> ' . htmlspecialchars($row['applicant_end']) . '</p>';
            echo '<p><strong>DEPARTMENT:</strong> ' . htmlspecialchars($row['department_name']) . '</p>';
            echo '<p><strong>PROGRAM:</strong> ' . htmlspecialchars($row['program_name']) . '</p>';
            echo '<p><br>'.'</p>';

            // Display CV
            echo '<div class="form-group">';
            $cv = $row['applicant_cv'];
            $cvExtension = pathinfo($cv, PATHINFO_EXTENSION);
            echo '<p><strong>CV:</strong><br>';
            if (strtolower($cvExtension) == 'pdf') {
                echo "<embed src='$cv' width='300' height='300' type='application/pdf'>";
                echo "<br><a href='".$cv."' target='_blank'>View</a>";
            } else {
                echo "<img src='$cv' alt='CV' width='100%'>";
            }
            echo "</p>";
            echo "</div>";

            echo '</div>';

// Buttons for Approve and Reject
echo "<form method='post'>";
echo "<button type='submit' name='approve' class='action-btn approve'><span class='icon'>✔</span> Approve</button>";
echo "<button type='submit' name='reject' class='action-btn reject'><span class='icon'>✖</span> Reject</button>";
echo "</form>";
echo "<button onclick='history.back()' class='back-btn'>Back</button>";
echo '</div>';

// Handle button actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        // Update status in the database
        $updateStatus = "UPDATE application SET app_status = 'Approved' WHERE applicant_id = $applicant_id";
        if (mysqli_query($dbconn, $updateStatus)) {
            // Send approval email
            $to = $row['applicant_email'];
            $subject = "Application Approved";
            $message = "Dear " . htmlspecialchars($row['applicant_name']) . ",\n\nYour application has been approved. We look forward to welcoming you.\n\nBest regards,\nHR Team";
            $headers = "From: ksaqifah58@gmail.com";

            if (mail($to, $subject, $message, $headers)) {
                echo "<p>Email sent to " . htmlspecialchars($to) . ".</p>";
            } else {
                echo "<p>Error sending email.</p>";
            }
        } else {
            echo "<p>Error updating status: " . mysqli_error($dbconn) . "</p>";
        }
    } elseif (isset($_POST['reject'])) {
        // Update status in the database
        $updateStatus = "UPDATE application SET app_status = 'Rejected' WHERE applicant_id = $applicant_id";
        if (mysqli_query($dbconn, $updateStatus)) {
            echo "<p>Application rejected successfully.</p>";
        } else {
            echo "<p>Error updating status: " . mysqli_error($dbconn) . "</p>";
        }
    }
}
} else {
echo "<p>Applicant not found.</p>";
}
} else {
echo "<p>Invalid applicant ID.</p>";
}

    $dbconn->close();
} else {
    header('Location: login.php');
    exit();
}
?>

<!-- Updated CSS -->
<style>
    body{
        background-color: transparent;
    }

    .details-container {
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        margin-top: 100px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        text-align: center;
    }

    h2 {
        color: #153448;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .details-left, .details-right {
        text-align: left;
    }

    .buttons-container {
        margin-top: 10px;
        text-align: center;
        position: center;
    }

    .back-btn, .action-btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        color: white;
        text-align: center;
    }

    .back-btn {
        background-color: #153448;
    }

    .back-btn:hover {
        background-color: #59C1BD;
    }

    .approve {
        background-color: #28a745;
    }

    .approve:hover {
        background-color: #218838;
    }

    .reject {
        background-color: #dc3545;
    }

    .reject:hover {
        background-color: #c82333;
    }

    .icon {
        margin-right: 5px;
    }
</style>
