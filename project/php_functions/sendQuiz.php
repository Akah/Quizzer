<?php
include ('connection.php');
session_start();//starts session for session variables
//gets the 4 hidden values from the HTML form
//checks to make sure they have been set to a value
$answers = (isset($_POST['h0']) ? $_POST['h0'] : null);
$ansTrue = (isset($_POST['h1']) ? $_POST['h1'] : null);
$question = (isset($_POST['h2']) ? $_POST['h2'] : null);
$name = (isset($_POST['h3']) ? $_POST['h3'] : null);
//decodes the posted values
//then adds them into an index of the quiz array
$quiz[0] = json_decode($answers);
$quiz[1] = json_decode($ansTrue);
$quiz[2] = json_decode($question);
//sets the user session variable to 'user'
$user = $_SESSION['user'];
//Generates a storable representation of the quiz array
$quiz = serialize($quiz);
//sql to insert the new array, quiz name and the username into the database
if (isset($quiz) AND isset($name)){
  $sql = "INSERT INTO tblQuiz (quizValue, quizName, userName)
    VALUES ('$quiz', '$name', '$user')";
  $result = mysqli_query($connection, $sql);
  header('location:/home.php');
}else{
  echo 'error';
}
mysqli_close($connection);// closes the connection
?>
