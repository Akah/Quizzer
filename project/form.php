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
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="/styles/style.css"></link>
    <style>
      input.q{
        width:67%;
				max-width:300px;
      }
      input.t{
        width: 60%;
				max-width:275px;
      }
      input.r{
        width: 20px;
        height: 20px;
      }
      input.s{
        width: 120px;
      }
      button{
        width: 120px;
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
      <form id="quiz" action="php_functions/sendQuiz.php" method="POST">
        <input class="q" id="name" type="text" name="name"/>
        <p>Question</p>
        <input class="q" id="q" type="text"/><br/>
        <p>Options</p>
        <input class="t" id="t0" type="text"/><input class="r" id="r0" type="radio" name="true" /><br/>
        <input class="t" id="t1" type="text"/><input class="r" id="r1" type="radio" name="true" /><br/>
        <input class="t" id="t2" type="text"/><input class="r" id="r2" type="radio" name="true" /><br/>
        <input class="t" id="t3" type="text"/><input class="r" id="r3" type="radio" name="true" /><br/>
        <input id ="h0" name ="h0" type="hidden" value=""/>
        <input id ="h1" name ="h1" type="hidden" value=""/>
        <input id ="h2" name ="h2" type="hidden" value=""/>
        <input id ="h3" name ="h3" type="hidden" value=""/>
        <input class="s" type="submit"/>
      </form>
      <button onclick="add()">Add Question</button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--<script src="/scripts/quiz_template.js">//must be before loader.js</script>-->
    <script src="/scripts/main.js"></script>
    <script>
      //arrays for the quiz, out of function so that they are not reset
        var answers=[];
        var ansTrue=[];
        var question=[];
        function add(){
  				var array = [];//temp array to add questions into before answers array
          question.push(document.getElementById("q").value);//(q for question)
          for(i=0;i<4;i++){//loop to add the 4 possible answers (t for text box)
            array.push(document.getElementById("t"+i).value);
          }
  				answers.push(array);// pushes the temp array into answers array (in one index)
          for(i=0;i<4;i++){
            if(document.getElementById("r"+i).checked){//(r for radio button)
              ansTrue.push(document.getElementById("t"+i).value);
            }
          }

          //next 3 lines convert the arrays into JSON strings
          //then sets the hidden inputs to those values
          document.getElementById('h0').value = JSON.stringify(answers);
          document.getElementById('h1').value = JSON.stringify(ansTrue);
          document.getElementById('h2').value = JSON.stringify(question);
          //sets 4th hidden input to the name of the quiz
  				document.getElementById('h3').value = $('#name').val();
          console.log(JSON.stringify(answers));
          console.log(JSON.stringify(ansTrue));
          console.log(JSON.stringify(question));
  				document.getElementById("quiz").reset();
  				document.getElementById('name').value = document.getElementById('h3').value;
  				//^bodge: gets around problem of not having a name of quiz because of line 114
        }
    </script>
  </body>
</html>
