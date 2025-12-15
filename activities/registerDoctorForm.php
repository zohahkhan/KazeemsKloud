<?php
//start a session and connect to database
session_start();
require_once('../inc/db_connect.php');

$fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password'); 
$type     = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);


// Check if username already exists
$query = 'SELECT * 
		FROM doctor 
		WHERE username = :username';
$stmt = $db->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$existingDoctor = $stmt->fetch();
$stmt->closeCursor();

//if the doctor already exits
if ($existingDoctor) {
    die('Username already exists. <a href="registerDoctor.php">Try again</a>.');
}

//hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//insert the new doctor values
$query = 'INSERT INTO doctor (username, passwordHash, fullName, type) 
          VALUES (:username, :passwordHash, :fullName, :type)';
$stmt = $db->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':passwordHash', $passwordHash);
$stmt->bindValue(':fullName', $fullName);
$stmt->bindValue(':type', $type);
$stmt->execute();
$stmt->closeCursor();

//successful account message
echo "Doctor account created successfully! <a href='login.php'>Login here</a>.";
