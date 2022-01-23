<?php
require_once './config.php';
require_once './functions.php';

//sanitize $_GET array
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$viewerID = $_GET['viewerID'];


// Connect to the database with common function from functions.php
$db = connectDB();
// insert or update viewer
$query = "INSERT INTO viewers (viewerID, viewerLastSeen) VALUES ('$viewerID', NOW()) ON DUPLICATE KEY UPDATE viewerLastSeen = NOW();";

// execute query with mysqli
$result = $db->query($query);
echo $result;
//catch query error 
if (!$result) {
  $message  = 'Invalid query: ' . $db->error . "\n";
  $message .= 'Whole query: ' . $query;
  die($message);
}

//touched record ID
$id=$db->insert_id;
// set the default timezone to Eastern Time
date_default_timezone_set('America/New_York');

$payloadArray = array(
    "id" => $id,
    "viewerID" => $viewerID,
    "viewerLastSeen" => date("Y-m-d H:i:s")
);

sendServiceNowViewer(json_encode($payloadArray));  // from functions.php


// close connection
$db->close();
