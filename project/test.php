<!DOCTYPE html>
<?php
session_start();
if(!$_SESSION['user']){
  header("Location: /index.php");
}
$_SESSION["timeout"] = time();
//if 100 seconds have passed since creating session delete it.
if(time() - $_SESSION["timeout"] > 100){ 
    unset($_SESSION["timeout"]);
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>EHC Language</title>
    <link rel="stylesheet" type="text/css" href="style.css"></link>
    <link rel="icon" href="images/purple">
  <body>
    <div id="top-bar">
      <img id="logo" src="images/white.svg">
      <img id="menu" src="images/menu.png">
      <p id="name"><?php echo $_SESSION['user'];?></p>
      <!--favicon: http://www.elliotthudsoncollege.ac.uk/wp-content/uploads/2015/04/favicon-Tiny-png.png-->
    </div>
    <div id="menu-box">
      <ul>
        <li class="item"><a href="quiz-home.html">home</a></li>
        <li class="sub">quizzes
          <ul>
            <li class="item"><a href="quiz-tmpl.html">template</a></li>
            <li class="item"><a href="german.html">german vocab</a></li>
            <li class="item">random</li>
            <li class="item"><a href="quiz-form.php">write new quiz</a></li>
          </ul>
        </li>
        <li class="item"><a href="#">scores</a></li>
        <li class="item"><a href="#">account</a></li>
        <li id="out"><a href="/php_functions/logout.php">sign  out</a></li>   
        
      </ul>
    </div>
    <div id="main">
      <p>welcome</p>
      <p>bienvinue</p>
      <p>wilkommen</p>
      <p>добро пожаловать</p>
      <img src="">
    </div>
    <div id="footer">
      <a href="#"><p>help</p></a>
      <a href="#"><p>info</p></a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>