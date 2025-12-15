<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Kazeems Kloud</title>
    <link rel="stylesheet" type="text/css" href="main1.css" />
</head>

<!-- the body section -->
<body>
<header><h1>Welcome to Kazeems Kloud</h1></header>
<main>
    <h1>We keep track of activities so you dont have to! </h1>
	
	<!-- the form -->
	<form method="get" action=".">
	
	<!-- the category -->
	<input type="hidden" name="category_id" value="<?= $category_id ?>">
    
	<!-- baby dropdown -->
	<label>Select Baby:</label>
    <select name="baby_id" onchange="this.form.submit()">
        <?php foreach ($babies as $baby) : ?>
            <option value="<?= $baby['babyID']; ?>"
                <?= ($baby_id == $baby['babyID']) ? 'selected' : '' ?>>
                <?= $baby['babyName']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>
	
	<aside>
        <!-- display a list of categories -->
        <h2>Select an Activity:</h2>
         <nav>
        <ul>
            <?php foreach ($categories as $category) : ?>
			<!-- the category links back here with the catgeory and baby id -->
            <li><a href=".?category_id=<?php echo $category['categoryID']; ?> &baby_id=<?= $baby_id ?>">
                    <?php echo $category['categoryName']; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>                
    </aside>
	
	<section>
         <!--category name-->
        <h2><?php echo $category_name; ?></h2>
		
		<!-- display a table of activities -->
        <table>
            <tr>
                <th>Activity ID</th>
                <th>Baby ID</th>
				<th>Time</th>
				<th>Description</th>
                <th>Edit</th>
				<th>Delete</th>
            </tr>

            <?php foreach ($activities as $activity) : ?>
            <tr>
                <td><?php echo $activity['activityID']; ?></td>
                <td><?php echo $activity['babyName']; ?></td>
                <td><?php echo $activity['time']; ?></td>
                <td><?php echo $activity['description']; ?></td>
				<!-- goes to updateActivities page -->
				<!-- pass activity ID and category ID -->
                <td><form action = "updateActivitiesForm.php" method="post">
                    <input type="hidden" name="activityID"
                           value="<?php echo $activity['activityID']; ?>">
                    <input type="hidden" name="categoryID"
                           value="<?php echo $activity['categoryID']; ?>">
                    <input type="submit" value="Edit">
					</form>
                </td>
				<!-- goes to deleteActivities page -->
				<!-- pass activity ID -->
				<td><form action="deleteActivity.php" method="post">
					<input type="hidden" name="activityID" 
						   value="<?php echo $activity['activityID']; ?>">
					<input type="submit" value="Delete" 
						   onclick="return confirm('Are you sure you want to delete this activity?');">
				</form></td>

            </tr>
            <?php endforeach; ?>
        </table>
		
		<!-- goes to addActivities page -->		
		<p><a href="addActivityForm.php">Add Activity</a></p>
		<a href="report.php" >View Reports</a>
    </section>
	
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Kazeem's Kloud, Inc.</p>
</footer>

</body>
</html>	