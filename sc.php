<?php
require_once './config.php';
require_once './functions.php';

// sanitize $_GET array
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$command = $_GET['command'];
$param = $_GET['param'];



// Process the "play" command
// If the command is "play" and the param is not empty, then queue the command to play the file
if ($command == "play" && !empty($param)) {
    writeViewerCommands($command, $param);
}

if ($command == "video" && !empty($param)) {
    writeViewerCommands($command, $param);
}




