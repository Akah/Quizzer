<?php
session_start();
include 'connection.php';

$user = 'admin';
$arr = [];


$sql =
"SELECT averageScore, quizesCompleted FROM tblUsers WHERE userName = '$user';
SELECT `timer` FROM  `tblUsers` WHERE  `userName` =  '$user';
";

$result = mysqli_query($connection, $sql);
// only for single output data
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $score = $row['averageScore'];
    $total = $row["quizesCompleted"];
    $_SESSION['timer'] = $row['timer'];
  }
}

echo $score;
?>
