<?php
//start session and connect to database
session_start();
require('../inc/db_connect.php');

//form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	
    // get user
    $query = "SELECT * 
			FROM users 
			WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

	//verifies the password
    if ($user && password_verify($password, $user['passwordHash'])) {
        // store user info in session
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit;
    } else {
        echo "Invalid login";
    }
	
//query 
$query = "SELECT * 
		FROM doctor 
		WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$doctor = $stmt->fetch();
$stmt->closeCursor();

if ($doctor && password_verify($password, $doctor['passwordHash'])) {
	// Doctor login
	$_SESSION['doctorID'] = $doctor['doctorID'];
	$_SESSION['userType'] = 'doctor';

	header("Location: report.php");
	exit;
} else {
	echo "Invalid login";
}}?>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
</head>

<form method="post">
    <label>Username:</label>
	<input type="text" name="username"><br>
	
    <label>Password:</label>
	<input type="password" name="password"><br>
	
    <input type="submit" value="Login">
	<p>New user? <a href="register.php">Create an account</a>
	
	<!-- Link for registering -->
	<p>Are you a doctor? <a href="registerDoctor.php">Register here</a></p>
	</p>
</form>
</html>