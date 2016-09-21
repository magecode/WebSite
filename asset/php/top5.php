<?php
//read DB deatail from file
$db_temp = file_get_contents("../info/dbInfo.txt");
$db_info = explode(";",$db_temp);
$servername = $db_info[0];
$username = $db_info[1];
$password = $db_info[2];
$dbname = $db_info[3];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//generate top5 list

$prWeight = $_GET['prWeight'];
$crWeight = $_GET['crWeight'];
$popWeight = $_GET['popWeight'];

$sql_cr = "
    SELECT DISTINCT a.suburb, b.lvl, c.lvl, d.lvl, ((b.lvl*'$prWeight') + (c.lvl*'$popWeight') + (d.lvl*'$crWeight')) as score
    FROM melbmap a, housebuy b, popdensity c, crimemap d
    WHERE a.suburb = b.suburb AND b.suburb = c.suburb AND d.postcode = a.postcode
    AND b.year = c.year AND c.year = d.year AND d.year = 2015
    ORDER BY ((b.lvl*0.5)  + (c.lvl*0.3) + (d.lvl*0.2)) DESC";

$result = $conn->query($sql_cr);
$suburbs = [];
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $suburbs[] = $row["suburb"];
        //$suburbs =$suburbs . $suburb;
    }
}else{
    $suburbs = "No result";
    }

$result = "";

for($x = 0; $x <= 4; $x ++){
    $result = $result . $suburbs[$x] . "<br>";
}

echo $result;
$conn->close();
?>