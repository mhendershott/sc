
<?php
//Note: this script should be run from cron with a change directory command before the script
//Example command: 
// */1 * * * * cd /var/www/html/sc/ && /usr/bin/php /var/www/html/sc/cleanupViewers.php >> /tmp/cronjob.log 2>&1
require_once './config.php';
require_once './functions.php';

//connect to local database to update
$db = connectDB(); // from functions.php

//get expired viewers
$expiredViewers = array();
$query = "SELECT viewerID FROM player.viewers WHERE viewerLastSeen < NOW() - INTERVAL 5 MINUTE";
$result = $db->query($query);

// put all expired viewers into array
if (!$result) {
    $message  = 'Invalid query: ' . $db->error . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
} else {
    while ($row = $result->fetch_assoc()) {
        array_push($expiredViewers, $row['viewerID']);
    }
}

// build mysql query OR statement for expired viewers
$expiredViewersQuery = "";
foreach ($expiredViewers as $viewer) {
    $expiredViewersQuery .= "OR viewerID = '$viewer' ";
}


// delete expired viewers
$query = "delete FROM player.viewers WHERE viewerID = '' $expiredViewersQuery";
// execute query with mysqli
$result = $db->query($query);

//catch query error 
if (!$result) {
  $message  = 'Invalid query: ' . $db->error . "\n";
  $message .= 'Whole query: ' . $query;
  die($message);
}

//delete commands for expierd viewers
$query = "delete FROM player.commandQueue WHERE viewerID = '' $expiredViewersQuery";
// execute query with mysqli
$result = $db->query($query);

//catch query error
if (!$result) {
    $message  = 'Invalid query: ' . $db->error . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


//echo "Cleanup complete at " . date("Y-m-d H:i:s");


