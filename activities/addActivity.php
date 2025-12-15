<?php
//sets the time zone to ESt
date_default_timezone_set('America/New_York');

//fetch inputs
$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);
$babyID = filter_input(INPUT_POST, 'babyID', FILTER_VALIDATE_INT);
$userID = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
//this gets the the date and time in the sql format 
$time = date("Y-m-d H:i:s");

//validate inputs
if ($babyID === null || $babyID === false || 
	$userID === null || $userID === false) {
    $error = "Invalid product data. Check all fields and try again.";
    echo $error;
}
//connect to a database
else {
    require_once('../inc/db_connect.php');

//insert activities into the database  
$query = 'INSERT INTO activities
			 (categoryID, babyID, userID, time, description)
		  VALUES
			 (:categoryID, :babyID, :userID, :time, :description)';
$statement = $db->prepare($query);
$statement->bindValue(':categoryID', $categoryID);
$statement->bindValue(':babyID', $babyID);
$statement->bindValue(':userID', $userID);
$statement->bindValue(':time', $time);
$statement->bindValue(':description', $description);
$statement->execute();
$statement->closeCursor();

// Display the Activity List page
include('index.php');
}
?>