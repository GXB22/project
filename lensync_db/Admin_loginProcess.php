<?php
include "db.php";

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

$sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){
    header("Location: Admin_Dashboard.php");
        exit();
}else{
    header("Location: Admin_Login.php?error=1");
        exit();
}
?>

