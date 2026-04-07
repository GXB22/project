<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<link rel="stylesheet" href=".//css/Admin_Login.css">

</head>

<body>

<div class="header">
<h1>WELCOME ADMIN</h1>
</div>

<div class="container">

<div class="login-box">

<?php
if(isset($_GET['error'])){
    echo "<p class='error'>Invalid username or password</p>";
}
?>

<form method="POST" action="Admin_loginProcess.php">

<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>

<div class="password-box">

    <input type="password" id="password" name="password" required>

    <span onclick="togglePassword()" class="eye">👁</span>

</div>

<button type="submit">Login</button>

</form>

<script src="Admin_Login.js"></script>

</body>
</html>