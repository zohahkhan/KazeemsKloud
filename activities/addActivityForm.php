<?php
//connect to database
require('../inc/db_connect.php');

//query to get the categories
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Kazeem's Kloud</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Kazeem's Kloud</h1></header>
    <main>
	    <!-- form to submit activity data-->
        <h1>Add an Activity</h1>
        <form action="addActivity.php" method="post"
              id="add_activity_form">
			
			<!-- dropdown:-->
            <label>Activity:</label>
            <select name="categoryID">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select><br>

			<!-- input fields -->
            <label>Baby ID:</label>
            <input type="text" name="babyID"><br>

            <label>User ID:</label>
            <input type="text" name="userID"><br>
			
			<label>Description:</label>
            <input type="text" name="description"><br>
			
            <label>&nbsp;</label>
            <input type="submit" value="Add Activity Log"><br>
        </form>
		<!-- link back to homepage -->
        <p><a href="index.php">View Activities List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Kazeem's Kloud, Inc.</p>
    </footer>
</body>
</html>