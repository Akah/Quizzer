<!DOCTYPE html>
<?php
//for session variables
session_start();
//connection to sql server
include 'php_functions/connection.php';
//end connection
$user = $_GET['user'];
if ($user != $_SESSION['user']){
	header("Location:/404.html");
}
//$_SESSION['quizes'] stores the relevant quiz names.
if($_SESSION['timer']==1){
	$check = 'checked';
}else{
	$check = '';
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quizzer</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <link rel="stylesheet" type="text/css" href="/styles/settings.css"></link>
    <link rel="icon" href="images/purple">
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
        <li class="item"><a href="settings.php">settings</a></li>
        <li class="item"><a href="about.php">about</a></li>
        <li id="out"><a href="/php_functions/logout.php">sign  out</a></li>
      </ul>
    </div>
    <div id="main">
			<div class="box">
				<form id="delete" action="php_functions/deleteQuiz.php" method="POST">
					<p>Delete quizes</p>
					<?php
						for ($i = 0; $i < count($_SESSION['quizes']);$i++){
							echo '<div class="data"><p class="quiz">'.$_SESSION['quizes'][$i].'</p>
								<input class="check" type="checkbox" name="checks[]" value="'.$_SESSION['ID'][$i].'"/></div>';
						}
					?>
					<input type="submit" value="delete quizes">
				</form>
			</div>
			<div class="box">
				<form id="Timer" action="php_functions/sendTimer.php" method="POST">
					<p>Quiz timer</p>
					<div class="data">
						<p class="quiz">Timer on?</p>
						<input <?php echo $check; ?> class="check" type="checkbox" name="timer">
					</div>
					<input type="submit">
				</form>
			</div>
			<div class="box">
					<form id="rm-profile" action="php_functions/deleteUser.php" method="POST">
						<p>Delete account?</p>
						<p class="quiz">Remove account: <?php echo $user;?></p>
						<input class="check" type="checkbox" name="del-profile"/>
						<input type="submit">
					</form>
			</div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/scripts/main.js"></script>
  </body>
</html>
