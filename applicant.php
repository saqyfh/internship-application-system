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
            u.uni_name 
        FROM 
            applicant a
        LEFT JOIN 
            university u 
        ON 
            a.uni_id = u.uni_id
        WHERE 
            a.applicant_id = $applicant_id";

        $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
        $row = mysqli_fetch_assoc($query);

        if ($row) {
            $resume = '/upload/resumes/' . $row['applicant_resume'];
            $cv = '/upload/cvs/' . $row['applicant_cv'];

            // Display applicant details
            echo "<div class='details-container'>";
            echo "<h2>Applicant Details</h2>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['applicant_name']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row['applicant_email']) . "</p>";
            echo "<p><strong>Phone No:</strong> " . htmlspecialchars($row['applicant_phoneNum']) . "</p>";
            echo "<p><strong>University:</strong> " . htmlspecialchars($row['uni_name']) . "</p>";
            echo "<p><strong>Start Date:</strong> " . htmlspecialchars($row['applicant_start']) . "</p>";
            echo "<p><strong>End Date:</strong> " . htmlspecialchars($row['applicant_end']) . "</p>";
            // Display Resume
            $resume = $row['applicant_resume'];
            $resumeExtension = pathinfo($resume, PATHINFO_EXTENSION);
            echo "<p><strong>Resume:</strong><br>";
            if (strtolower($resumeExtension) == 'pdf') {
                echo "<embed src='$resume' width='100%' height='400px' type='application/pdf'>";
                echo "<br><a href='".$resume."' target='_blank'>View</a>";
            } else {
                echo "<img src='$resume' alt='Resume' width='100%'>";
            }
            echo "</p>";

            // Display CV
            $cv = $row['applicant_cv'];
            $cvExtension = pathinfo($cv, PATHINFO_EXTENSION);
            echo "<p><strong>CV:</strong><br>";
            $applicant_cv = $row["applicant_cv"];
                $fileExtension = pathinfo($applicant_cv, PATHINFO_EXTENSION);
                if (strtolower($fileExtension) == 'pdf') {
                    echo "<td>";
                    echo "<embed src='".$applicant_cv."' width='100' height='100' type='application/pdf'>";
                    echo "<br><a href='".$applicant_cv."' target='_blank'>View</a>";
                    echo "</td>";
                } else {
                    echo "<td><img src='".$applicant_cv."' alt='Cover Letter' width='100'></td>";
                }
                echo "</p>";

                 // Buttons for Approve and Reject
                echo "<form method='post'>";
                echo "<button type='submit' name='approve' class='action-btn approve'><span class='icon'>✔</span> Approve</button>";
                echo "<button type='submit' name='reject' class='action-btn reject'><span class='icon'>✖</span> Reject</button>";
                echo "</form>";


            echo "<button onclick='history.back()' class='back-btn'>Back</button>";
            echo "</div>";

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
                        $headers = "From: hr@company.com";

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
                        echo "<p>Applicant rejected successfully.</p>";
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

<!-- Style for the page -->
<style>
    .details-container {
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        margin-top: 100px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-size: 16px;
    }

    h2 {
        text-align: center;
        color: #4CAF50;
    }

    p {
        margin: 10px 0;
        line-height: 1.6;
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
        background-color: #4CAF50;
    }

    .back-btn:hover {
        background-color: #45a049;
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

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin: 10px 5px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 14px;
        color: white;
        text-align: center;
        gap: 8px; /* Space between icon and text */
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
        font-size: 16px; /* Adjust icon size */
    }
</style>
