<?php
// Get the activity ID
$activityID = filter_input(INPUT_POST, 'activityID', FILTER_VALIDATE_INT);

//error if missing or invalid
if ($activityID === null || $activityID === false) {
    echo "Invalid activity ID.";
    exit;
}

//connect to the database
require('../inc/db_connect.php');

//deletes the query with that activity ID
$query = 'DELETE FROM activities
          WHERE activityID = :activityID';
$statement = $db->prepare($query);
$statement->bindValue(':activityID', $activityID);
$statement->execute();
$statement->closeCursor();

//back to the activity list index
include('index.php');
