<?php
//connection: servername, username, password, database name
$connection = mysqli_connect("localhost", "root", "", "Quizzer");
if(!$connection){//if not connected then end connection and show error
  die("connection failed: ".mysqli_connect_error());
}
?>
