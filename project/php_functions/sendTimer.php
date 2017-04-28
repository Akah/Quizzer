<?php
session_start();
include 'connection.php';
$user =  $_SESSION['user'];
// if timer check box was checked, timer = 1
// if not then timer = 0
if(isset($_POST['timer'])){
  $timer=1; // if set = true
}else{
  $timer=0; // else = false
}
echo "timer: ".$timer."</br>";
$sql = "UPDATE  `tblUsers` SET  `timer` =  '".$timer."' WHERE  `tblUsers`.`userName` =  '".$user."';";
//echo sql statement
echo "sql ".$sql."</br>";
if (mysqli_query($connection, $sql)) {
  // show value of timer
  echo "timer changed successfully to ".$timer;
} else {
  // show error
  echo "Error handling data: ".mysqli_error($connection);
}
// return to home
header('Location:/home.php');
?>
