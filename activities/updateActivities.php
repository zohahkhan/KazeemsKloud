<?php
//fetch inputs
$activityID = filter_input(INPUT_POST, 'activityID', FILTER_VALIDATE_INT);
$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);
$babyID = filter_input(INPUT_POST, 'babyID', FILTER_VALIDATE_INT);
$userID = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
$time = filter_input(INPUT_POST, 'time');
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

//validate inputs
if ($activityID === null || $activityID === false || 
        $babyID === null || $babyID === false || 
		$userID === null || $userID === false ||
		$time === null || $time === false) {
		//error message if anything is wrong 
    $error = "Invalid product data. Check all fields and try again.";
    echo $error;
}
//connects to database
else {
    require_once('../inc/db_connect.php');

//update query
	 $query = 'UPDATE activities
                 SET categoryID = :categoryID, babyID = :babyID, 
				 userID =:userID, time =:time, description =:description
				 WHERE activityID =:activityID';
				 
    $statement = $db->prepare($query);
	$statement->bindValue(':activityID', $activityID);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':babyID', $babyID);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':time', $time);
	$statement->bindValue(':description', $description);
	
    $statement->execute();
    $statement->closeCursor();
     
	//set category ID so index has right category
	$category_id = $categoryID;
	
    // Display the activities List page
	echo "Update successful!";
    include('index.php');
}	 
?>