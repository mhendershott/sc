<?php

require_once './config.php';
require_once './functions.php';

//connect to local database to update
$db = connectDB(); // from functions.php

//sanitize $_GET array
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$scene = $_GET['scene'];
$streamID = $_GET['streamID'];

// if scene variable is not empty or does not exist
if (!empty($scene) && !empty($streamID)) {

    //record scene to database
    $query = "INSERT INTO player.scene (streamID, nextScene) VALUES ('$streamID','$scene' ) ON DUPLICATE KEY UPDATE nextScene = '$scene'";
    //echo $query;

    $result = $db->query($query);
    if (!$result) {
        // $message  = 'Invalid query: ' . $db->error . "\n";
        // $message .= 'Whole query: ' . $query;
        die($message);
    }
} else {
    // query database for next scene
    $query = "SELECT * FROM player.scene WHERE streamID = '$streamID'";
   
    $result = $db->query($query);
    if (!$result) {
        $message  = 'Invalid query: ' . $db->error . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
    $row = $result->fetch_assoc();
// echo the row as json string
    $jsonString= json_encode($row);
    echo $jsonString;

}




