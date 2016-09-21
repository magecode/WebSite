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

$prFlag = $_GET['prFlag'];
$crFlag = $_GET['crFlag'];
$popFlag = $_GET['popFlag'];
$suburb = $_GET['suburb'];

$result = "";

$output = "";

if($prFlag !== "0"){
    $sql_cr ="
            select b.buy, b.lvl from melbmap a, housebuy b
            WHERE a.suburb = UPPER('$suburb') AND a.suburb = b.suburb AND b.year =2015";
    $result = $conn->query($sql_cr);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $prFigure = $row["buy"] . ",";
            $prLevel = $row["lvl"] . "&";
            $output = $output . "pr," . $prFigure . $prLevel;
        }
    }
}

if($popFlag !== "0"){
    $sql_cr = "
                select b.population, b.area, b.popdensity, b.lvl
                from melbmap a, popdensity b
                where a.suburb = UPPER('$suburb')
                and a.suburb = b.suburb
                and b.year = 2015";
    $result = $conn->query($sql_cr);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $popFigure = $row["population"] . ",";
            $popArea = $row["area"] . ",";
            $popDensity = $row["popdensity"] . ",";
            $popLv = $row["lvl"] . "&";
            $output = $output . "pop," . $popFigure . $popArea . $popDensity . $popLv;
        }
    }
}

if($crFlag !== "0"){
    $sql_cr = "
                select b.report, b.lvl
                from melbmap a, crimemap b
                where a.suburb = UPPER('$suburb')
                and a.postcode = b.postcode
                and b.year = 2015";

    $result = $conn->query($sql_cr);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $crFigure = $row["report"] . ",";
            $crLv = $row["lvl"] . "&";
            $output = $output . "cr," . $crFigure . $crLv;
        }
    }
}

/*
echo"<script>
alert(". $output .");
</script>";*/


echo $output;
$conn->close();
?>