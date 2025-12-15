<?php
//checks how the page was accessed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//connects to the database
    require('../inc/db_connect.php');
	//gets the user input 
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);

    // hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // insert new user
    $query = "INSERT INTO users (username, passwordHash, fullName)
              VALUES (:username, :passwordHash, :fullName)";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':passwordHash', $passwordHash);
    $stmt->bindValue(':fullName', $fullName);
    $stmt->execute();

	//confirm the account is created for the user
    echo "Account created! <a href='login.php'>Login here</a>";
    exit;
}?>

<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
</head>
   
   <!-- Registration Form -->
<form method="post">
    <label>Full Name:</label>
	<input type="text" name="fullName"><br>
	
    <label>Username:</label>
	<input type="text" name="username"><br>
	
    <label>Password:</label>
	<input type="password" name="password"><br>
	
    <input type="submit" value="Register">
</form>
</html>