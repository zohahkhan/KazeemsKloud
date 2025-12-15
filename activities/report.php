<?php
//start a session
session_start();

//login page
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

//connect to the database
require_once('../inc/db_connect.php');

//gets the baby and user ids
$userID = $_SESSION['userID']; 

//check for babyID in session
if (isset($_SESSION['babyID'])) {
    $babyID = $_SESSION['babyID'];
} else {
    $babyID = null; //deault to null if not set
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = null;
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
} else {
    $date = null;
}

//initializing variables
$startDate = null;
$endDate = null;
$summary = [];
$activities = [];

if ($type && $date && $babyID) {
    //gets the date range
    if ($type === 'week') {
        $startDate = date('Y-m-d 00:00:00', strtotime('monday this week', strtotime($date)));
        $endDate   = date('Y-m-d 23:59:59', strtotime('sunday this week', strtotime($date)));}

    if ($type === 'month') {
        $startDate = date('Y-m-01 00:00:00', strtotime($date));
        $endDate   = date('Y-m-t 23:59:59', strtotime($date));}

	//summary data 
    $summaryQuery = "SELECT 
						c.categoryName,
						COUNT(*) AS total
					FROM activities a
					JOIN categories c ON a.categoryID = c.categoryID
					WHERE a.babyID = :babyID
						AND a.userID = :userID
						AND a.time BETWEEN :start AND :end
					GROUP BY c.categoryName
					ORDER BY c.categoryName";

    $stmt = $db->prepare($summaryQuery);
    $stmt->bindValue(':babyID', $babyID);
    $stmt->bindValue(':userID', $userID);
    $stmt->bindValue(':start', $startDate);
    $stmt->bindValue(':end', $endDate);
    $stmt->execute();
    $summary = $stmt->fetchAll();
    $stmt->closeCursor();

	//activity details data
    $activityQuery = "SELECT 
						a.activityID,
						c.categoryName,
						a.description,
						a.time
					FROM activities a
					JOIN categories c ON a.categoryID = c.categoryID
					WHERE a.babyID = :babyID
						AND a.userID = :userID
						AND a.time BETWEEN :start AND :end
					ORDER BY a.time";

    $stmt = $db->prepare($activityQuery);
    $stmt->bindValue(':babyID', $babyID);
    $stmt->bindValue(':userID', $userID);
    $stmt->bindValue(':start', $startDate);
    $stmt->bindValue(':end', $endDate);
    $stmt->execute();
    $activities = $stmt->fetchAll();
    $stmt->closeCursor();
}

include('reportForm.php');
