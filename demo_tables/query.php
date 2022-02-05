<?php

//Api to query mysql database and return JSON data
//

// set page headers to json type
header('Content-Type: application/json');

// Web Server Configuration
$dbuser = "playerdb";
$dbpass = "bigbeefyman";
$dbname = "demo_db";
$dbhost = "localhost";
//sanitize $_POST
//$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

//get comma separated field list from POST fields value if it is defined

// if (isset($_POST['fields'])) {
//     $fields = $_POST['fields'];
//     echo $fields;
// } else {
//     $fields = "*";
// }




//connect to demo database
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$query = "SELECT $fields FROM demo_db.user_data";

try {
    $result = $db->query($query);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


