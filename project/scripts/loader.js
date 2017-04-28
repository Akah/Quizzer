var count = 0; //each iteration, 0 being question one. increased after each question answered
var given; //the value set to the chosen answer
var wrong = []; //list of wrong answers
var correct = []; //list of correct answers
var valid; // checks if answer is valid
var block = false; //blocks answer being checked

if(timerOn===true){
	var time = 0; //value of the timer clock
	var setTime = setInterval(timer, 1000);
	$('#timer').text("0");
}

$(document).ready(function() {
	$('#submit-score').hide();
});

function write() { //writes the values into html
	$('div.answer').css('background-color', '#333'); //change background colour
	document.getElementById("question-no").innerHTML = "<p>" + (count + 1) + "</p>";
	$('div#score-bar').css('width', (count + 1) * (85 / question.length) + '%'); // calculates the increase in the bar length per question
	document.getElementById("result").innerHTML = ""; //hides result
	document.getElementById("question").innerHTML = "<p>" + question[count] + "</p>"; //the question

	for (i = 0; i < answer[count].length; i++) { //loop to write every answer for question number [count]
		//switch
		$('div#ans' + i).html(answer[count][i]);
	}

	if (block === false) { //sets the 'next' button to grey and unusable
		$('button#next-button').css({
			'background-color': '#95a5a6',
			'color': 'black'
		}).attr('onclick', '');
	}
}

function next() { //click of next button do this:
	block = false;
	count = count + 1; //increments count value
	if(timerOn===true){
		setTime = setInterval(timer, 1000);//resets interval
		time = 0;// resets the question timer
	}
	if (answer[count] === undefined) { //if count loop finished then do:
		document.getElementById("question").innerHTML = "<p>quiz complete</p>";
		document.getElementById("answers").style.display = "none"; //removes answer buttons
		document.getElementById("question-no").innerHTML = ""; //removes the question number
		//gives percentage score
		document.getElementById("result").innerHTML = "wrong answers: <br>" + wrong + "<br>" + ((correct.length / question.length) * 100) + "%";
		console.log((correct.length / question.length) * 100);
		document.cookie = "score" + "=" + (correct.length / question.length) * 100 + ";"
		console.log("cookie= " + document.cookie);
		$('#next-button').html("restart").attr('onclick', 'restart()').css('margin', '0'); //changes the click function to restart the quiz
		//^prints wrong answers + a percentage score
		$('#submit-score').attr('onclick', '').show();
	} else {
		write();
	}
}

function restart() {
	document.location.reload(false);
}

function check() { //runs check of whether answer is true or false
	if (block === false) {
		if (given === ansTrue[count]) { //correct
			document.getElementById("result").innerHTML = "Correct";
			correct.push(ansTrue[count]); // adds answer to correct list
			valid = true;
		} else { //wrong answer
			document.getElementById("result").innerHTML = "Wrong: <br>" + "correct = " + ansTrue[count];
			wrong.push(ansTrue[count] + " - " + question[count] + "<br>"); // adds to incorrect answer array
			valid = false;
		}
		block = true; //bodge to stop multi answers
		$('button#next-button').css({
			'background-color': '#333',
			'color': 'white'
		}).attr('onclick', 'next()');
	}
}

// click each button (0 being first button) to change "given" value ********** check for cleaner method for writing
function timeOut(){
	given = null;
	check();
	$('.answer').css('background-color', '#f44336');
	clearInterval(setTime);
}

$('.answer').click(function(event){
	var number = $(event.target).text();
	if(block === false){
		given = number;
		check();
		resultColour(this.id);
		clearInterval(setTime);
	}
});

function timer() {
	time++;
	document.getElementById("timer").innerHTML = time;
  if(time>=10){
		time = "you ran out of time";
    timeOut();
  }
}

function resultColour(x) {
	if (valid === true) {
		$('.answer').css('background-color', '#95a5a6');
		$('#'+x).css('background-color', '#4CAF50');//chosen answer
	} else {
		$('.answer').css('background-color', '#95a5a6');
		$('#'+x).css('background-color', '#f44336');//chosen answer
	}
}
//#FF5722 orange
//#4CAF50 green
//#3F51B5 blue
//#95a5a6 grey
//#f44336 red
