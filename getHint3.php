<?php
// (A) ERROR REPORTING LEVEL
error_reporting(E_ALL & ~E_NOTICE); // ALL EXCEPT NOTICES

// (B) ERROR LOG
ini_set("log_errors", 1); // SAVE ERROR TO LOG FILE
ini_set("error_log", __DIR__ . DIRECTORY_SEPARATOR . "error.log"); // LOG FILE

// (C) DISPLAY ERROR MESSAGES
ini_set("display_errors", 1);

// get the q,r parameter from the get URL
$q = $_REQUEST['TeamNumber'] ?? null;
$r = $_REQUEST['ScoringPeriod'] ?? null;

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

$big_array = array();
$returned_set = $db->query('SELECT * FROM scores WHERE owner = "' . $q . '" and scoringPeriod="' . $r . '"');
while ($row = $returned_set->fetchArray(MYSQLI_ASSOC)) {
    array_push($big_array, $row);
    print_r("Size of big_array is: " . count($big_array));
    // print_r($row["firstName"]."\n");
}

$htmlTable = ''; // Variable to store the HTML table

function array_to_table($table)
{
    global $htmlTable;

    $htmlTable .= "<table>";

    // Check if $table is not null and has at least one element
    if (!empty($table) && is_array($table)) {
        // Table header
        foreach (array_keys($table[0]) as $header) {
            $htmlTable .= "<th>" . $header . "</th>";
        }
        // Table body
        $body = array_slice($table, 1, null, true);
        foreach ($body as $row) {
            $htmlTable .= "<tr>";
            foreach ($row as $cell) {
                $htmlTable .= "<td>" . $cell . "</td>";
            }
            $htmlTable .= "</tr>";
        }
    } else {
        $htmlTable .= "<tr><td colspan='100'>No data available</td></tr>";
    }
    $htmlTable .= "</table>";
}

array_to_table($big_array);

// Echo the HTML table
echo $htmlTable;
?>
