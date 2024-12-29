<?php
// Start output buffering
ob_start();

session_start();
require_once __DIR__ . '/vendor/autoload.php';
include 'dbconn.php';
include 'functions.php';

// Add this near the top of your file, after database connection
$alterTable = "ALTER TABLE application ADD COLUMN IF NOT EXISTS meeting_scheduled BOOLEAN DEFAULT FALSE";
mysqli_query($dbconn, $alterTable);

// Check session first
if (!isset($_SESSION['admin_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Now include files that might have output
include 'header.php';
include 'navbar.php';

// TEST IF THE SESSION HAS BEEN CREATED BEFORE
if (isset($_SESSION['admin_id']) && $_SESSION['user_role'] === 'admin') {
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
        // First check if meeting was already scheduled
        $checkMeeting = "SELECT app_status, meeting_scheduled FROM application WHERE applicant_id = $applicant_id";
        $result = mysqli_query($dbconn, $checkMeeting);
        $application = mysqli_fetch_assoc($result);

        if ($application && $application['meeting_scheduled']) {
            echo "<p class='error'>Meeting has already been scheduled for this application.</p>";
        } else {
            // Update status in the database
            $updateStatus = "UPDATE application SET app_status = 'Approved', meeting_scheduled = TRUE WHERE applicant_id = $applicant_id";
            if (mysqli_query($dbconn, $updateStatus)) {
                try {
                    // Create Google Calendar event
                    $client = getGoogleClient();
                    $eventDetails = createCalendarEvent($client, $row);
                    
                    // Prepare email with calendar link
                    $to = $row['applicant_email'];
                    $subject = "Application Update - Screening Interview Scheduled";
                    $message = "Dear " . htmlspecialchars($row['applicant_name']) . ",\n\n";
                    $message .= "We are pleased to inform you that your internship application has been shortlisted.\n\n";
                    $message .= "We have scheduled a screening interview:\n\n";
                    
                    if ($eventDetails) {
                        $message .= "Interview Details:\n";
                        $message .= "Date: " . $eventDetails['meetingDate'] . "\n";
                        $message .= "Time: " . $eventDetails['meetingTime'] . "\n";
                        $message .= "Google Meet Link: " . $eventDetails['meetLink'] . "\n\n";
                        $message .= "Calendar Event: " . $eventDetails['eventLink'] . "\n\n";
                    }
                    
                    $message .= "Please ensure you join the interview on time using the Google Meet link provided above.\n\n";
                    $message .= "Best regards,\nHR Team";
                    
                    $headers = "From: ksaqifah58@gmail.com";

                    if (mail($to, $subject, $message, $headers)) {
                        echo "<p class='success'>Application approved and meeting scheduled successfully.</p>";
                    } else {
                        echo "<p class='error'>Error sending email.</p>";
                    }
                } catch (Exception $e) {
                    // If there's an error, reset the meeting_scheduled flag
                    mysqli_query($dbconn, "UPDATE application SET meeting_scheduled = FALSE WHERE applicant_id = $applicant_id");
                    echo "<p class='error'>Error with calendar/meet integration: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p class='error'>Error updating status: " . mysqli_error($dbconn) . "</p>";
            }
        }
    } elseif (isset($_POST['reject'])) {
        try {
            // First try to cancel any scheduled meetings
            $client = getGoogleClient();
            $meetingCancelled = cancelCalendarEvents($client, $row['applicant_email']);
            
            // Update status in the database
            $updateStatus = "UPDATE application SET app_status = 'Rejected', meeting_scheduled = FALSE WHERE applicant_id = $applicant_id";
            if (mysqli_query($dbconn, $updateStatus)) {
                // Send rejection email
                $to = $row['applicant_email'];
                $subject = "Application Status Update";
                $message = "Dear " . htmlspecialchars($row['applicant_name']) . ",\n\n";
                $message .= "Thank you for your interest in our internship program. After careful consideration, we regret to inform you that we will not be proceeding with your application at this time.\n\n";
                $message .= "We appreciate your time and wish you the best in your future endeavors.\n\n";
                $message .= "Best regards,\nHR Team";
                
                $headers = "From: ksaqifah58@gmail.com";
                
                if (mail($to, $subject, $message, $headers)) {
                    echo "<p class='success'>Application rejected and notification sent successfully.</p>";
                    if ($meetingCancelled) {
                        echo "<p class='success'>Previously scheduled interview has been cancelled.</p>";
                    }
                } else {
                    echo "<p class='error'>Application rejected but error sending email notification.</p>";
                }
            } else {
                echo "<p class='error'>Error updating status: " . mysqli_error($dbconn) . "</p>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>Error processing rejection: " . $e->getMessage() . "</p>";
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
}

// Add this function after session_start()
function getGoogleClient() {
    $client = new \Google_Client();
    $credentialsPath = __DIR__ . '/credentials/internapp-credentials.json';
    if (!file_exists($credentialsPath)) {
        throw new \Exception('Google credentials file not found at: ' . $credentialsPath);
    }
    
    $client->setAuthConfig($credentialsPath);
    $client->addScope(\Google_Service_Calendar::CALENDAR);
    $client->setAccessType('offline');
    // Make sure this matches EXACTLY with what you put in Google Cloud Console
    $client->setRedirectUri('http://localhost/AA%20internapp/internship-application-system/oauth2callback.php');
    
    // Load previously authorized token
    $tokenPath = __DIR__ . '/token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        } else {
            header('Location: oauth2callback.php');
            exit;
        }
    }
    
    return $client;
}

// Add this function to create calendar event
function createCalendarEvent($client, $applicantData) {
    $service = new \Google_Service_Calendar($client);
    
    // Set meeting time to 3 days from now at 10 AM
    $startDate = new DateTime();
    $startDate->modify('+3 days');
    
    // Check if the date falls on weekend and adjust accordingly
    $dayOfWeek = $startDate->format('N'); // 1 (Monday) to 7 (Sunday)
    if ($dayOfWeek == 6) { // Saturday
        $startDate->modify('+2 days'); // Move to Monday
    } elseif ($dayOfWeek == 7) { // Sunday
        $startDate->modify('+1 day'); // Move to Monday
    }
    
    $startDate->setTime(10, 0); // Set to 10:00 AM
    $endDate = clone $startDate;
    $endDate->modify('+2 hours');

    $event = new \Google_Service_Calendar_Event([
        'summary' => 'Internship Screening Interview: ' . $applicantData['applicant_name'],
        'description' => "Screening Interview for " . $applicantData['applicant_name'] . 
                        "\nFrom: " . $applicantData['uni_name'] . 
                        "\nDepartment: " . $applicantData['department_name'] . 
                        "\n\nThis is your internship screening interview.",
        'start' => array(
            'dateTime' => $startDate->format('Y-m-d\TH:i:sP'),
            'timeZone' => 'Asia/Kuala_Lumpur',
        ),
        'end' => array(
            'dateTime' => $endDate->format('Y-m-d\TH:i:sP'),
            'timeZone' => 'Asia/Kuala_Lumpur',
        ),
        'conferenceData' => [
            'createRequest' => [
                'requestId' => uniqid(),
                'conferenceSolutionKey' => [
                    'type' => 'hangoutsMeet'
                ]
            ]
        ],
        'attendees' => [
            ['email' => $applicantData['applicant_email']]
        ]
    ]);

    $calendarId = 'primary';
    try {
        $event = $service->events->insert(
            $calendarId, 
            $event, 
            ['conferenceDataVersion' => 1]
        );
        return [
            'eventLink' => $event->htmlLink,
            'meetLink' => $event->hangoutLink,
            'meetingDate' => $startDate->format('Y-m-d'), // Add meeting date to return values
            'meetingTime' => '10:00 AM'
        ];
    } catch (Exception $e) {
        return false;
    }
}

// Add this new function to cancel calendar events
function cancelCalendarEvents($client, $applicantEmail) {
    $service = new \Google_Service_Calendar($client);
    $calendarId = 'primary';
    
    try {
        // Search for events with the applicant's email
        $events = $service->events->listEvents($calendarId, [
            'q' => $applicantEmail,
            'timeMin' => date('c')
        ]);

        foreach ($events->getItems() as $event) {
            // Check if this is an interview event for this applicant
            if (strpos($event->getSummary(), 'Internship Screening Interview') !== false) {
                $service->events->delete($calendarId, $event->getId());
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
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
