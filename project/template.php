<!DOCTYPE html>
<?php
//for session variables
session_start();
//connection to sql server
include 'php_functions/connection.php';
//end connection
mysqli_close($connection);
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quizzer</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <link rel="stylesheet" type="text/css" href="/styles/home.css"></link>
    <link rel="icon" href="images/purple">
		<link rel="icon" href="images/purple">
  <body>
    <div id="top-bar">
      <img id="logo" src="images/white.svg">
      <img class="badge" id="menu" src="images/menu.png">
      <img class="badge" src="images/account.svg">
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
        <li class="item"><a href="settings.php">settings</a></li>
        <li class="item"><a href="about.php">about</a></li>
        <li id="out"><a href="/php_functions/logout.php">sign  out</a></li>   
      </ul>
    </div>
    <div id="main">
      <!-- content goes here -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/scripts/main.js"></script>
    </script>
  </body>
</html>