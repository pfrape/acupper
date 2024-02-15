<?php


// // Establish a connection to the database (replace these values with your database credentials)
// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "acup";

// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/Users/pfrape/Desktop/FRAPE/Scraper/acup.db');
    }
}

$db = new MyDB();
if (!$db) {
    echo $db->lastErrorMsg();
}


// Get player name and scoring period from the POST data
$playerName = $_POST['playerName'];
$scoringPeriod = $_POST['scoringPeriod'];
$endScoringPeriod = $_POST['endScoringPeriod'];

// Validate and sanitize user input (you may need a more robust validation based on your application's requirements)
// $playerName = mysqli_real_escape_string($conn, $playerName);
// $scoringPeriod = mysqli_real_escape_string($conn, $scoringPeriod);

$big_array = array();
$returned_set = $db->query('SELECT * FROM scores WHERE owner = "' . $playerName . '" and scoringPeriod between"' . $scoringPeriod . '"and "'.$endScoringPeriod.'"         ');
while ($row = $returned_set->fetchArray(MYSQLI_ASSOC)) {
    array_push($big_array, $row);
    //print_r("Size of big_array is: " . count($big_array));
    // print_r($row["firstName"]."\n");
}

echo json_encode($big_array);

// Query to retrieve scoring data for the specified player and scoring period from the database
// $sql = "SELECT * FROM player_scoring WHERE owner = '$playerName' AND scoringperiod = '$scoringPeriod'";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Output data as a JSON array
//     $data = array();
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }
//     echo json_encode($data);
// } else {
//     echo json_encode(array('error' => 'No data found for player: ' . $playerName . ' in scoring period: ' . $scoringPeriod));
// }

// $conn->close();
?>
