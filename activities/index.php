<?php
//starts a session
session_start();

//checks if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

//connects to the database
require_once('../inc/db_connect.php');

//get the baby_id
$baby_id = filter_input(INPUT_GET, 'baby_id', FILTER_VALIDATE_INT);
if ($baby_id === null || $baby_id === false) {
    // query first baby for this user
    $query = 'SELECT babyID
          FROM babies
          WHERE userID = :user_id
          LIMIT 1';
	$statement = $db->prepare($query);
	$statement->bindValue(':user_id', $_SESSION['userID']);
	$statement->execute();
	$firstBaby = $statement->fetch();
	$statement->closeCursor();
	//use the first baby ID or 0 if none exist
    $baby_id = $firstBaby ? $firstBaby['babyID'] : 0;
}

//stores baby ID in session
$_SESSION['babyID'] = $baby_id;

//gets category ID if not already
if (!isset($category_id)) {
    $category_id = filter_input(INPUT_GET, 'category_id', 
            FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = 1;
    }
}

//get categories
$query = 'SELECT * 
		FROM categories
        ORDER BY categoryID';
$statement2 = $db->prepare($query);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

//loop to get name for selected category
foreach($categories as $cat){
if($cat['categoryID'] == $category_id){
   $category_name = $cat['categoryName'];
}
}

//get activities for selected category, joins with baby to get baby name
$queryProducts = 'SELECT a.*, b.babyName
					FROM activities a
					JOIN babies b ON a.babyID = b.babyID
					WHERE a.userID = :user_id
					  AND a.babyID = :baby_id
					  AND a.categoryID = :category_id
					ORDER BY a.activityID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':user_id', $_SESSION['userID']);
$statement3->bindValue(':baby_id', $baby_id);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$activities = $statement3->fetchAll();
$statement3->closeCursor();

//get babies belonging to logged-in user for dropdown to switch between babies
$query = 'SELECT * FROM babies 
			WHERE userID = :user_id 
			ORDER BY babyName';
$statement = $db->prepare($query);
$statement->bindValue(':user_id', $_SESSION['userID']);
$statement->execute();
$babies = $statement->fetchAll();
$statement->closeCursor();

//loads the html 
include('viewActivities.php');

?>