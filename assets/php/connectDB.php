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
$sql = "SELECT * FROM melbmap where suburb = UPPER('$var_value')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    //output data of each row
    while($row = $result->fetch_assoc()) {
        $postcode = $row["postcode"];
        $sql = "SELECT * FROM crimemap where postcode = '$postcode' and year = 2015";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $crReport = $row["report"];
                echo  $crReport;
            }
        } else {
            echo "0";
        }
    }
} else {
    echo "0";
}
$conn->close();
?>