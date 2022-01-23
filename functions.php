<?php
require_once('./config.php');

debug("Debugging is on");
//debug function

 function debug($message) {
     if (DEBUG) {
         $message = date("Y-m-d H:i:s") . ": $message";

         $file = fopen("./debug.txt", "a");
         fwrite($file, $message . "\n");
         fclose($file);
     }
    }
     

function connectDB()
{

    $dbhost = $GLOBALS['dbhost'];
    $dbuser = $GLOBALS['dbuser'];
    $dbpass = $GLOBALS['dbpass'];
    $dbname = $GLOBALS['dbname'];

    //connect to local database with mysqli to update with variable values
    try {
        $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        return $db;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}

//send json payload to service now REST Api
function sendServiceNowViewer($payload)
{
    //I don't know why I had to double declare this to get global user/pass working, 
    // but it's late and I'm tired

    // Access Required Globals
    $SNusername = $GLOBALS['SNusername'];
    $SNpassword = $GLOBALS['SNpassword'];

    $username = $SNusername;
    $password = $SNpassword;
    $url = $GLOBALS['SNurl'];
    $apiPath = $GLOBALS['SNApiPath'];
    $commandPath = $GLOBALS['SNViewerPath'];

    //build url from config variables
    $url = $GLOBALS['SNurl'] . $GLOBALS['SNApiPath'] . $GLOBALS['SNViewerPath'];
    echo $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $result = curl_exec($ch);
    curl_close($ch);
    echo "SNCall:" . $result;
    return $result;
    var_dump($GLOBALS);
}


// function to build array of payload
function buildPayload($command, $param, $viewerID, $externalID)
{
    $payload = array(
        "command" => $command,
        "param" => $param,
        "viewerID" => $viewerID,
        "externalID" => $externalID
    );

    echo json_encode($payload);
    return json_encode($payload);
}


// function to build array of payload
function viewerPayload($lastSeen, $viewerID, $externalID)
{
    $payload = array(
        "lastSeen" => $lastSeen,
        "viewerID" => $viewerID,
        "externalID" => $externalID
    );

    echo json_encode($payload);
    return json_encode($payload);
}



//function to write command to database for each viewer in array
function writeViewerCommands($command, $param)
{
    $viewers = getViewers();

    writeCommand($command, $param, $viewers);
    // foreach ($viewers as $viewer) {
    //     writeCommand($viewer, $command, $param);
    // }
}

// function to get viewerID from database and populate array
function getViewers()
{
    $viewers = array();
    $db = connectDB();
    $query = "SELECT viewerID FROM player.viewers";
    $result = $db->query($query);
    if (!$result) {
        $message  = 'Invalid query: ' . $db->error . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
    while ($row = $result->fetch_assoc()) {
        array_push($viewers, $row['viewerID']);
    }   
    debug($viewers);
    return $viewers;
    $db->close();
}

// function to write command to database
function writeCommand($command, $param, $viewers)
{

    // builde command query with all viewers
    $query = "INSERT INTO player.commandQueue (command, param, viewerID) VALUES ";
    foreach ($viewers as $viewer) {
        $query .= "('$command', '$param', '$viewer'),";
    }
    $query = rtrim($query, ",");

    //connect to local database to update
    $db = connectDB(); // from functions.php

    // insert or update viewer
   // $query = "INSERT INTO player.commandQueue (command, param, viewerID) VALUES ('$command', '$param', '$viewer')";

    // execute query with mysqli
    $result = $db->query($query);

    $externalID = $db->insert_id;
    if (SN_INTEGRATION) {sendServiceNowCommand(buildPayload($command, $param, $viewer, $externalID));}


    //catch query error 
    if (!$result) {
        $message  = 'Invalid query: ' . $db->error . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    // close connection
    $db->close();
}


//send json payload to service now REST Api
function sendServiceNowCommand($payload)
{
    //I don't know why I had to double declare this to get global user/pass working, 
    // but it's late and I'm tired

    // Access Required Globals
    $SNusername = $GLOBALS['SNusername'];
    $SNpassword = $GLOBALS['SNpassword'];

    $username = $SNusername;
    $password = $SNpassword;
    $url = $GLOBALS['SNurl'];
    $apiPath = $GLOBALS['SNApiPath'];
    $commandPath = $GLOBALS['SNcommandPath'];

    //build url from config variables
    $url = $url . $apiPath . $commandPath;

    //$url = 'https://dev66519.service-now.com/api/x_72920_overlay_co/overlaycommander';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
    return $result;
}
