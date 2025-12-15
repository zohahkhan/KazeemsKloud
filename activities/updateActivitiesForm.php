<?php
//connect to a database
require('../inc/db_connect.php');
//get the activityID
$activityID = filter_input(INPUT_POST, 'activityID', FILTER_VALIDATE_INT);

if($activityID == null || $activityID === false){
	$error = "Error";
	echo $error;
	exit();}

//query for activities
$queryProducts = 'SELECT * FROM activities
                  WHERE activityID = :activityID';
                   
$statement1 = $db->prepare($queryProducts);
$statement1->bindValue(':activityID', $activityID);
$statement1->execute();
$activity = $statement1->fetch();
$statement1->closeCursor();
?>

<!DOCTYPE html>
<html>

<!-- head section -->
<head>
    <title>Kazeems Kloud</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
</head>

<!-- body section -->
<body>
    <header><h1>Kazeems Kloud</h1></header>

    <main>
		<!-- update activities form  -->
          <form action="updateActivities.php" method="post"
              id="update_activities_form">

            <label>Baby ID:</label>
            <input type="text" name="babyID" value="<?php echo $activity["babyID"];?>" ><br>

            <label>User ID:</label>
            <input type="text" name="userID" value="<?php echo $activity["userID"];?>"><br>

            <label>Time:</label>
            <input type="text" name="time" value="<?php echo $activity["time"];?>"><br>

			<label>Description:</label>
            <input type="text" name="description" value="<?php echo $activity["description"];?>"><br>
			
			<input type="hidden" name="activityID" value="<?php echo $activity["activityID"];?>" ><br>
			
			<input type="hidden" name="categoryID" value="<?php echo $activity['categoryID']; ?>">

            <label>&nbsp;</label>
            <input type="submit" value="Update Activity"><br>
           </form>
		   
		   <!-- link to return to activities page -->
           <p><a href="index.php?category_id=<?php echo $activity['categoryID']; ?>">Back to Activities List</a></p>
	</main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Kazeem's Kloud, Inc.</p>
    </footer>
</body>
</html>	