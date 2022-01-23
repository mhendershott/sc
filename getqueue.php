<?php
require_once './config.php';
require_once './functions.php';
//sanitize $_GET array
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$viewerID = $_GET['viewerID'];

//get commands with viewerID from database
$db = connectDB(); 
$query = "SELECT * FROM player.commandQueue WHERE viewerID = '$viewerID' order by id asc";
$result = $db->query($query);

// put all commands into array
$commands = array();
if (!$result) {
    $message  = 'Invalid query: ' . $db->error . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
} else {
    while ($row = $result->fetch_assoc()) {
        array_push($commands, $row);
    }
}

//store $result as JSON object
$json = json_encode($commands);
echo($json);
 //close connection
$db->close();


