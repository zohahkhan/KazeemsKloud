<?php
//starting a new session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Doctor</title>
	<link rel="stylesheet" type="text/css" href="main1.css">
</head>
<body>

<h1>Register Doctor</h1>
<!-- doctor registering form -->
<form method="post" action="registerDoctorForm.php">
    <label>Full Name:</label><br>
    <input type="text" name="fullName" required><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br>

    <label>Type / Specialty:</label><br>
    <input type="text" name="type"><br>

    <button type="submit">Create Doctor Account</button>
</form>

<br>
<a href="login.php">Back to Login</a>

</body>
</html>
