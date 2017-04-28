<?php
include 'connection.php';

$username = $_POST['userName'];//post value to new array name
$password = $_POST['userPass'];//post value to new array name

//convert username to camel case
$username = ucwords(strtolower($username));
//sql
$sql = "INSERT INTO tblUsers (userName, userPass) VALUES ('$username', '$password')";
$result = mysqli_query($connection, $sql);

header("Location: /index.php");
?>