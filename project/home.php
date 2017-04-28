<!DOCTYPE html>
<?php
session_start();
//connection to sql server
include 'php_functions/connection.php';

if(!$_SESSION['user']){
  header("Location: /index.php");
}
$_SESSION["timeout"] = time();
//if 100 seconds have passed since creating session delete it.
if(time() - $_SESSION["timeout"] > 100){
    unset($_SESSION["timeout"]);
}
$user = $_SESSION['user'];
// get the score value from the user table via query


$sql = "SELECT averageScore, quizesCompleted, timer FROM tblUsers WHERE userName = '$user'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0) {//if not empty
  while($row = mysqli_fetch_assoc($result)) {
    $score = $row["averageScore"];
    $total = $row["quizesCompleted"];
    $timer = $row["timer"];
	}
}
$_SESSION['timer'] = $timer;
if($timer==1){
  $timerMessage = "Quiz timer: on";
}else{
  $timerMessage = "Quiz timer: off";
}

$score = round($score,1);//round the answer to 1dp

//gets local time in hour, outputs greeting.
date_default_timezone_set('Europe/London');
if(idate('H') < 12){//capital H for 24 hr
  //if before 12 => morning
  $greet = 'Good Morning';
}else if(idate('H') > 17){
  //after 5pm => evening
  $greet = 'Good Evening';
}else{//else = > 12 but < 5pm
  $greet = 'Good Afternoon';
}

// Don't think this is needed but leaving as comment until bug found.

$sql = "SELECT `quizName`FROM `tblQuiz`WHERE `userName` = '$user'";
// takes multiple values from the table and adds them into one array
$result = mysqli_query($connection,$sql);
$arr = array();
while ($row = mysqli_fetch_array($result)) {
	$arr2 = array();
	foreach ($row as $val) $arr2[] = $val;
	$arr[] = $arr2;
}
$_SESSION['quizes'] = array_column($arr, 0);
if($_SESSION['quizes']==null){
  //sets escape value
	$_SESSION['quizes'][0] = "you have no quizes";
}

$sql = "SELECT `quizID` FROM `tblQuiz` WHERE `userName` = '$user'";
// takes multiple values from the table and adds them into one array
$result = mysqli_query($connection,$sql);
$arr = array();
while ($row = mysqli_fetch_array($result)) {
	$arr2 = array();
	foreach ($row as $val) $arr2[] = $val;
	$arr[] = $arr2;
}
$_SESSION['ID'] = array_column($arr, 0);
if($_SESSION['ID']==null){
  //sets escape value
	$_SESSION['ID'][0] = "";
}



$sql5 = "SELECT `timer` FROM  `tblUsers` WHERE  `userName` =  '$user'";
$result = mysqli_query($connection, $sql5);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $_SESSION['timer'] = $row['timer'];
	}
}else{
  $_SESSION['timer'] = 0;
}

$sql = "SELECT `quizID`, `score` FROM `Attempts` WHERE `userName` = '$user'";
// must be from attempts as there may be repeated IDs
$result = mysqli_query($connection, $sql);
$attempt=[];
$scores=[];
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
		array_push($attempt, $row['quizID']);
		array_push($scores, round($row['score'],1));
	}
}
$names=[];
for($i=0;$i<count($attempt);$i++){
	$sql = "SELECT `quizName` FROM `tblQuiz` WHERE `quizID` = '$attempt[$i]'";
	$result = mysqli_query($connection, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			array_push($names, $row['quizName']);
		}
	}
}
for($i=0;$i<count($names);$i++){// shortens the names to fit their parent box(max 17)
  $names[$i] = mb_strimwidth($names[$i], 0, 17, "...");
}
mysqli_close($connection);
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quizzer</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <link rel="stylesheet" type="text/css" href="/styles/home.css"></link>
    <link rel="icon" href="images/purple.svg">
  <body>
    <div id="top-bar">
      <img id="logo" src="images/white.svg">
      <img class="badge" id="menu" src="images/menu.png">
      <img class="badge" src="images/account.svg">
      <p id="name"><?php echo $user;?></p>
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
						if($id==null){
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
      <div class = "container">
          <div class="box"><p class="default"><?php echo $greet;?></p></div>
          <div id="average-score" class="box">
            <p>Average Score <?php echo $score;?>%</p>
            <canvas id="avScore" width="100" height="100"></canvas>
          </div>
          <div class="box">
            <p class="default">Quizzes completed: <?php echo $total;?></p>
          </div>
          <div class="box">
            <p class="default">Recent quizzes:</p>
  						<?php
  						if(count($names)>=5){//only shows 5 values
  							echo '<ol>';
  							for ($i=count($names)-1;$i>count($names)-6;$i--){
  								echo '<li><a href="quizzer.php?id='.$attempt[$i].'">'.$names[$i].'</a>: '.$scores[$i].'%</li>';
  							}
  							echo '</ol>';
  						}else if(count($names)>0){//if >5 & >0 show all
  							echo '<ol>';
  							for ($i=count($names)-1;$i>0;$i--){
  								echo '<li><a href="quizzer.php?id='.$attempt[$i].'">'.$names[$i].'</a>: '.$scores[$i].'%</li>';
  							}
  							echo '</ol>';
  						}else{// show none
  							echo '<p>No quiz completed yet<p>';
  						}
  						?>
          </div>
          <div class="box">
            <p class="default"><?php echo$timerMessage;?></p>
          </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="/scripts/main.js"></script>
    <script>
    $(document).ready(function(){
      $(".masonry").masonry("resize");
    });

    $('.container').masonry({
      itemSelector: '.box',
      columnWidth: 0,
    });

    //pie script
    var correct = parseInt("<?php print($score)?>");// gets user score from php
    var wrong = 100-correct;// calculates size of wrong slice from 100(%)
    var ctx = document.getElementById("avScore");// required from the pie docs
    var avScore = new Chart(ctx, {//object with JSON format
      type: 'pie',
      data: {
        labels: ["correct", "wrong"],// titles for pie slices
        datasets: [{
          label: 'average score',
          data: [correct,wrong],
          backgroundColor: [//red and green colours for correct and wrong
            'rgb(76, 175, 80)',
            'rgb(244, 67, 54)',
          ],
          borderColor: [
            'rgba(255,255,255,255)',//white border
          ],
          borderWidth: 2,//comma incase I add data and forget it later
        }]
      }
    });
    //line graph of actual scores. (maybe just last 20?)
    var ctx = document.getElementById('line');
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        datasets: [{
        label: 'Scatter Dataset',
        data: [{
          x: -10,
          y: 100
        }, {
          x: 0,
          y: 66.7
        }, {
          x: 10,
          y: 75
        }]
          }]
      },
      options: {
        scales: {
          xAxes: [{
            type: 'linear',
            position: 'bottom'
          }]
        }
      }
    });
    </script>
  </body>
</html>
