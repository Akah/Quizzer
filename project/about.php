<?php
session_start();
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Quizer: About</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <link rel="stylesheet" type="text/css" href="/styles/home.css"></link>
    <style>
      div.box{
        width: 90%;
        text-align: left;
        overflow: hidden;
      }
      div.box img{
        width: 160px;
        margin: 10px;
      }
      div.source{
        text-align: center;
        float: left;
        font-weight: bold;
      }
      h3{
        margin-left: 10px;
      }
      @media (max-width: 620px) {
        div.source{
          text-align: center;
        }
        div.box img{
          margin-left: 80px;
        }
        div.source p{
          margin-left: 70px;
        }
      }
    </style>
    <link rel="icon" href="images/purple.svg">
  <body>
    <div id="top-bar">
      <img id="logo" src="images/white.svg">
      <img id="menu" src="images/menu.png">
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
        <h3>About Quizzer</h3>
        <p>This site was made partly possible thanks to the hard work of many other projects:</p>
        <div class="source">
          <img src="http://www.chartjs.org/img/chartjs-logo.svg"/>
          <p>Chartjs</p>
        </div>
        <div class="source">
          <img src="https://avatars0.githubusercontent.com/u/70142?v=3&s=400"/>
          <p>jQuery</p>
        </div>
        <div class="source">
          <img src="https://4.bp.blogspot.com/--FUGmtDZIaw/V7bH0eDajdI/AAAAAAAAAGU/eu2qzj8OfRgzHn7FsgvTgFi9A16FfbLRQCK4B/s1600/GF_Logo_for_blog_1.png"/>
          <p>Google fonts</p>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/scripts/main.js"></script>
  </body>
</html>
