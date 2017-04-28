<?php
session_start();
include 'connection.php';
$quizName = $_SESSION['quizes'];
$quizID = $_SESSION['ID'];
$data = $_POST['checks'];
echo print_r($data);

$sql = array();
if(empty($data)){
  echo("no quizes clicked <br>");
}else{
  $j = count($data);
  echo("you clicked ".$j." quiz(es) <br>");
  for($i=0; $i < $j; $i++){
    array_push(
      $sql,
      "DELETE FROM `Attempts` WHERE `quizID` =".$data[$i].";",
      "DELETE FROM `tblQuiz` WHERE `quizID` =".$data[$i].";"
    );
    echo "DELETE FROM `tblQuiz` WHERE `quizID` =".$data[$i].";<br>";//debug to show the resultant sql statements
  }
}
echo print_r($sql).'<br>';

function del($con,$query){
  if (mysqli_query($con, $query)) {
      echo "Record deleted successfully";
  } else {
      echo "Error deleting record: ".mysqli_error($con);
  }
}
for ($i=0;$i<count($sql);$i++){// runs for the length of the array
  del($connection,$sql[$i]);
}
header('location:/home.php');
?>
