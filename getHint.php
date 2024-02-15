<?php
// Array with names
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";

// get the q parameter from URL
$q = $_REQUEST["q"];
//$r = $_GET["ScoringPeriod"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
//echo $hint === "" ? "no suggestion" : $hint;



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
$returned_set = $db->query('SELECT * FROM scores WHERE owner = "'.$q.'" and scoringPeriod="68"');
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