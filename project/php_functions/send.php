<?php
session_start();
include ('connection.php');
// creates a timestamp from the current date.
$date = date_create();
$time = date_timestamp_get($date);

$newscore = $_COOKIE["score"];
$username = $_SESSION["user"];
$quizID = $_SESSION["ID"];

$sql = "UPDATE `tblUsers` SET averageScore = ((quizesCompleted*averageScore)+$newscore)/(quizesCompleted+1),
quizesCompleted = quizesCompleted+1 WHERE userName = '$username'";
$sql2= "UPDATE `tblQuiz` SET lastTry = '$time' WHERE quizID = '$quizID'";
$sql3= "INSERT INTO `Attempts`(`quizID`, `userName`, `score`) VALUES ('$quizID','$username','$newscore')";
$sql4= "UPDATE `tblQuiz` SET avScore = ((completed*avScore)+'$newscore')/(completed+1), completed = completed+1 WHERE quizID = '$quizID'";
//function to do many both update queries
function update($query,$con){
  if (mysqli_query($con, $query)) {
  } else {
      echo "Error while trying to updating: ".mysqli_error($con);
  }
}

update($sql,$connection);
update($sql2,$connection);
update($sql4,$connection);
$sendAttempt = mysqli_query($connection, $sql3);

mysqli_close($connection);
header('location: /home.php');
?>
