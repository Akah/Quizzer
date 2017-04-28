<?php
session_start();
include 'connection.php';
$user = $_SESSION['user'];

if(isset($_POST['del-profile'])){

  echo $_POST['del-profile'];
  $sql = array();
  array_push(
    $sql,
    "DELETE FROM `Attempts` WHERE `userName` ='".$user."';",
    "DELETE FROM `tblQuiz` WHERE `userName` ='".$user."';",
    "DELETE FROM `tblUsers` WHERE `userName`='".$user."';"
  );

  echo print_r($sql)."<br>";
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
}
session_destroy();
header('Location: /index.php');
?>
