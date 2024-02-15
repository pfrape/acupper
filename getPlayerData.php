<?php

// (A) ERROR REPORTING LEVEL
error_reporting(E_ALL & ~E_NOTICE); // ALL EXCEPT NOTICES

// (B) ERROR LOG
ini_set("log_errors", 1); // SAVE ERROR TO LOG FILE
ini_set("error_log", __DIR__ . DIRECTORY_SEPARATOR . "error.log"); // LOG FILE

// (C) DISPLAY ERROR MESSAGES
ini_set("display_errors", 1);



// Establish a connection to the database (replace these values with your database credentials)
$servername = "localhost";
$username = "";
$password = "";
$dbname = "acup.db";

// class MyDB extends SQLite3
// {
//     function __construct()
//     {
//         $this->open('/Users/pfrape/Desktop/FRAPE/Scraper/acup.db');
//     }
// }

// $conn = new MyDB();
// if (!$conn) {
//     echo $conn->lastErrorMsg();
// }

$conn = new mysqli($servername, $username, $password, $dbname);

Check the connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

// Get JSON data from the POST body
$jsonData = json_decode(file_get_contents('php://input'), true);

// Validate and sanitize user input (you may need a more robust validation based on your application's requirements)
$playerName = mysqli_real_escape_string($conn, $jsonData['playerName']);
$scoringPeriod = mysqli_real_escape_string($conn, $jsonData['scoringPeriod']);

//$playerName = $jsonData['playerName'];
//$scoringPeriod = $jsonData['scoringPeriod'];

// Query to retrieve scoring data for the specified player and scoring period from the database
$sql = "SELECT * FROM scores WHERE owner = '$playerName' AND scoringPeriod = '$scoringPeriod'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as a JSON array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'No data found for player: ' . $playerName . ' in scoring period: ' . $scoringPeriod));
}

$conn->close();
?>
