<!DOCTYPE html>
<?php
session_start();
$quizID = $_GET['id'];
$_SESSION['ID'] = $quizID;
include 'php_functions/connection.php';
$user = $_SESSION['user'];

$sql = "SELECT quizValue, userName FROM `tblQuiz` WHERE quizID = '$quizID'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $quiz = $row["quizValue"];
		$quizUser = $row["userName"];
  }
} else {
  echo "0 results";
}
//block user from not owned quiz
if ($quizUser != $user){
	header("Location: /404.html");
}

$quizArray = unserialize($quiz);
$answer = $quizArray[0];
$ansTrue = $quizArray[1];
$question = $quizArray[2];

// shuffle code:
$count = count($question);
$order = range(1, $count);
for($i=0;$i<count($answer);$i++){
	shuffle($answer[$i]);// shuffles each sub array for the length of the array
}
shuffle($order);
array_multisort($order, $question, $ansTrue);// shuffles both by the same

if($_SESSION['timer']==1){
	$timer = '<script> var timerOn = true;</script>';
	echo "worked";
}else{
	$timer = '<script> var timerOn = false;</script>';
	echo "failed";
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quizzer</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <link rel="icon" href="images/purple.svg">
  </head>
  <body onload="write()">
    <div id="top-bar">
      <img id="logo" src="images/white.svg">
      <img id="menu" src="images/menu.png">
      <p id="name"><?php echo $_SESSION['user'];?></p>
    </div>
    <div id="menu-box">
      <ul>
        <li class="item"><a href="home.php">home</a></li>
        <li class="sub">quizzes
          <ul>
						<?php
						for ($i=0;$i<count($_SESSION["ID"]);$i++){
							$id[$i]=$_SESSION["ID"][$i];
						}
						if($id=='undefined'){
							echo '<li class="item>no quizes</li>';
							$id=0;
						}else{
							for ($i = 0; $i < count($_SESSION['quizes']);$i++){
									echo '<li class="item"><a href="quizzer.php?id='.$id[$i].'">'.$_SESSION['quizes'][$i].'</a></li>';
							}
						}
						?>
						<li><a href="form.php">new quiz</a></li>
          </ul>
        </li>
        <li class="item"><?php echo '<a href="settings.php?user='.$user.'">settings</a>';?></li>
        <li class="item"><a href="about.php">about</a></li>
        <li id="out"><a href="/php_functions/logout.php">sign  out</a></li>
      </ul>
    </div>
    <div id="main">
      <div id="question">
        <p>loading question</p>
      </div>
      <div id="answers">
        <div class="answer" id="ans0" >...</div><!-- onclick="click0-3()"-->
        <div class="answer" id="ans1" >...</div>
        <div class="answer" id="ans2" >...</div>
        <div class="answer" id="ans3" >...</div>
        <div id="score-bar"></div>
        <div id="question-no"></div>
				<div><p id="timer"></p></div>
      </div>
      <div>
        <div><button class="function-button" id="next-button" onclick="next()">next</button></div>
        <form id="quiz" action="php_functions/send.php" method="POST">
	    		<input id="submit-score" class="butt" type="submit" value="send"/>
        </form>
        <div><p id="result"></p></div>
      </div>
    </div>
		<?php echo $timer;?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>
			var question=[
				<?php
					for($i=0;$i<count($question);$i++){
						echo json_encode($question[$i]).',';
					}
				?>
			];
			var answer=[
				<?php
					for($i=0;$i<count($answer);$i++){
						echo json_encode($answer[$i]).',';
					}
				?>
			];
			var ansTrue=[
				<?php
					for($i=0;$i<count($ansTrue);$i++){
						echo json_encode($ansTrue[$i]).',';
					}
				?>
			];
			console.log(question);
			console.log(answer);
			console.log(ansTrue);
		</script><!-- php array to js array, enables to br run through loader.js-->
    <script src="scripts/loader.js"></script>
    <script src="scripts/main.js"></script>
  </body>
</html>
