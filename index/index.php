<?php
session_start();

if (!isset($_SESSION["authorised"])) {
    die('{"status":"error","code":"10006"}');
    // Code 10006 Restricted
}
if (!$_SESSION["approved"]) {
    die('{"status":"error","code":"10007"}');
    // Code 10007 Access with a non-approved account
}
if (!$_SESSION["admin"]) {
    die('{"status":"error","code":"10008"}');
    // Code 10008 Access with a non-admin account
}

function getLogs($conn) { // Check if an account already exists
    $sql = "SELECT * FROM acars WHERE visible=1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $output = "[";
        while($row = $result->fetch_assoc()) {
            $output = $output . '{"aircraft":"'.$row["aircraft"].'","logid":"'.$row["logid"].'","airline":"'.$row["airline"].'","origin":"'.$row["origin"].'","destination":"'.$row["destination"].'","altitude":"'.$row["altitude"].'","route":"'.$row["route"].'","userid":"'.$row["userid"].'","start_time":"'.$row["start_time"].'","callsign":"'.$row["callsign"].'","distance":"'.$row["distance"].'","departure":"'.$row["departure"].'","arrival":"'.$row["arrival"].'","flightnumber":"'.$row["flightnumber"].'","arrivalgate":"'.$row["arrivalgate"].'","departuregate":"'.$row["departuregate"].'","visible":true},';
        }
        $output = substr($output, 0, -1);
        $output = $output . "]";
        echo $output;
    } else {
        die('{"status":"error","code":"10009"}');
    // Code 10009 No results
    }
}

$servername = "localhost";
$username = "flyify";
$password = "Fly1fy7!*";
$dbname = "flyify";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('{"status":"error","code":"10002"}');
    // Code 10002 means database connection failed
}

getLogs($conn);