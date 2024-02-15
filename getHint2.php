<?php


// get the q,r parameter from the get URL
$q = $_REQUEST["q"];
$r = $_REQUEST["r"];


class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('/Users/pfrape/Desktop/FRAPE/Scraper/acup.db');
    }
}

$db = new MyDB();
if(!$db)
{
    echo $db->lastErrorMsg();
}

$big_array = array();
$returned_set = $db->query('SELECT * FROM scores WHERE owner = "'.$q.'" and scoringPeriod="'.$r.'"');
while ($row = $returned_set->fetchArray(MYSQLI_ASSOC)){
	array_push($big_array,$row);
	#print_r("Size of big_array is: ".count($big_array));
	#print_r($row["firstName"]."\n");
}

function array_to_table($table) 
{   
    echo "<table>";

    // Table header
    foreach (array_keys($table[0]) as $header) {
      echo "<th>".$header."</th>";
    }

    // Table body
    $body = array_slice( $table, 1, null, true);
    foreach ($body as $row) {
      echo "<tr>";
        foreach ($row as $cell) {
          echo "<td>".$cell."</td>";
        } 
      echo "</tr>";
    }     
  echo "</table>";
}

array_to_table($big_array);

?>    