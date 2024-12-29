<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

use Google\Client as Google_Client;
use Google\Service\Calendar as Google_Service_Calendar;

$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/credentials/internapp-credentials.json');
// Use URL encoded redirect URI
$client->setRedirectUri('http://localhost/AA%20internapp/internship-application-system/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!empty($token['error'])) {
        header('Location: applicant.php');
        exit;
    }
    file_put_contents('token.json', json_encode($token));
    header('Location: applicant.php');
    exit;
}

// filepath: /c:/xampp/htdocs/AA internapp/internship-application-system/applicant.php
function getGoogleClient() {
    // ...existing code...
    $client->setRedirectUri('http://localhost/AA internapp/internship-application-system/oauth2callback.php');
    // ...existing code...
}
