<?php
//read DB deatail from file
$db_temp = file_get_contents("../info/dbInfo.txt");
$db_info = explode(";",$db_temp);
$servername = $db_info[0];
$username = $db_info[1];
$password = $db_info[2];
$dbname = $db_info[3];
//Using GET
$var_value = $_GET['suburb'];
if ($var_value == ""){
    $var_value = "Melbourne";
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//generate crime report
$sql_cr = "SELECT a.year, sum(a.report) as crime
        FROM crimemap a, melbmap b
        where b.suburb = UPPER('$var_value') AND a.postcode = b.postcode
        AND a.year BETWEEN 2012 AND 2015
        GROUP BY a.year";

$result = $conn->query($sql_cr);
$crimeRate = "";
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $crReport = $row["crime"]."/";
        $crimeRate =$crimeRate . $crReport;
    }
}else{
    $crimeRate = "0/0/0/0";
    }
$crimeRate  = $crimeRate . "#";

//generate population density report
$sql_pd = "SELECT a.year, ROUND(a.population / b.area) as popdensity
        FROM popdensity a, suburbarea b
        where a.suburb = b.suburb AND UPPER(a.suburb) LIKE UPPER('$var_value')
        GROUP BY a.year";

$result = $conn->query($sql_pd);
$popDensity = "";
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $pdReport = $row["popdensity"]."/";
        $popDensity =$popDensity . $pdReport;
    }
}else{
    $popDensity = "0/0/0/0";
}
$popDensity  = $popDensity . "#";


//generate price(buy) report
$sql_pBuy = "SELECT year, buy
        FROM housebuy
        where suburb LIKE UPPER('$var_value')";

$result = $conn->query($sql_pBuy);
$pBuy = "";
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $buyReport = $row["buy"]."/";
        $pBuy =$pBuy . $buyReport;
    }
}else{
    $pBuy = "0/0/0/0";
}
$pBuy  = $pBuy . "#";


echo $crimeRate . $popDensity. $pBuy;
$conn->close();
?>