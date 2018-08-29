<!--
Alex Greff
20 Septemeber, 2016
Quiz Page
The quiz page
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Quiz</title>
		<!--Reference the almighty stylesheet-->
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/researchedStyles.css">
	</head>
	<style>
		
	</style>
	<body onload="displayUsername()"  style="background-image: url('images/background_9.jpg'); background-size:cover; background-attachment: fixed; padding: 0; margin: 0; 	font-family: 'Lato';">
		<script type="text/javascript" src="jquery-3.1.0.min.js"></script> <!--JQuery reference-->

		<script type="text/javascript">
			function displayUsername(){
				var username = localStorage.getItem("usernameQuiz"); //Get the current user's name
				document.getElementById('thAccount').innerHTML = '<div class="userDisplay">' + username + '</div><div class="style-link"><a href="login.php" class="cmn-t-underline">Logout</a></div>';
			}
			
	        var totalSeconds = 0;
	        setInterval(setTime, 1000); //Run set time every one second

	        function setTime() {
	            ++totalSeconds; //Increment total seconds
	            var timerDiv = document.getElementById("timer"); //Get timer location
	            timerDiv.innerHTML =  checkTime(pad(parseInt(totalSeconds/60)) + ": " + pad(totalSeconds%60)); //Calculate and show timer
	            
	            logTime(totalSeconds); //Log time to _SESSION
	        }

	        function pad(val)
	        {
	            var valString = val + "";
	            if(valString.length < 2)
	            {
	                return "0" + valString;
	            }
	            else
	            {
	                return valString;
	            }
	        }
	        function checkTime(i) {
			    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
			    return i;
			}
		</script>

		<SCRIPT LANGUAGE="JavaScript">
			function logTime(time) { //Sets the current time to a _SESSION vairable
				$.ajax({ //Use JQuery Ajax to run a php script on the server
				  type: 'post', 
				  url: 'sessionLogTime.php', 
				  data: {_time: time} //Specify the data sent to the php script with _POST
				});
			}
		</SCRIPT>

		<?php

			function createRadioBox($questionIndex, $questionText, $questionSubText, $radioTexts, $imageUrl) {
				//Start table
				echo '
					<div id="content">
						<table border="0" align="center" class="input-list style-1 clearfix">
							<tr>
								<th id="ThTitle" width="450px">
									Question '.$questionIndex.'
								</th>
							</tr>
							<tr>
								<td id="TdQuestion">
									<input type="hidden" name="_question'.$questionIndex.'" value="_blank">

									'.$questionText.'
				';					
									if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				//Continue generating the question
				echo '						
								</td>
							</tr>
							<tr>
								<td id="TdQuestion2">
									'.$questionSubText.'
								</td>
							</tr>
				';
				foreach ($radioTexts as $index => $text) { //Create each radio option
					echo '		
						<tr>
							<td>
								<div class="radio">
									<input type="radio" name="_question'.$questionIndex.'" id="option'.$questionIndex.$index.'" class="style-radio" value="'.$index.'">
									<label for="option'.$questionIndex.$index.'" class="style-radioLabel">'.$text.'</label>
								</div>
							</td>
						</tr>
					';
				}
				//End table
				echo ' 
						</table>
					</div>
				';
			}

			function createCheckBox($questionIndex, $questionText, $questionSubText, $checkBoxTexts, $imageUrl){ //NOT USING CHECKBOXES AT THE MOMENT
				echo '
				<div id="content">
					<table border="0" align="center" class="input-list style-1 clearfix">
						<tr>
							<th id="ThTitle" width="450px">
								Question '.$questionIndex.'
							</th>
						</tr>
						<tr>
							<td id="TdQuestion">
								<input type="hidden" name="_question'.$questionIndex.'" value="_blank">
								'.$questionText.'
				';
								if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				//Continue generating the question
				echo '				
							</td>
						</tr>
						<tr>
							<td id="TdQuestion2">
								'.$questionSubText.'
							</td>
						</tr>
				';
				foreach ($checkBoxTexts as $index => $text) { //Create each checkbox option
					echo '
						<tr>
							<td>
								<div class="checkbox">
									<input type="checkbox" name="_question'.$questionIndex.'[]" id="option'.$questionIndex.$index.'" class="style-radio" value="'.$index.'">
									<label for="option'.$questionIndex.$index.'" class="style-radioLabel">'.$text.'</label>
									<br>
								</div>
							</td>
						</tr>
					';
				}
				echo '
					</table>
				</div>
				';
			}

			function createTrueFalse ($questionIndex, $questionText, $questionSubText, $imageUrl) {
				echo '
					<div id="content">
						<table border="0" align="center" class="input-list style-1 clearfix">
							<tr>
								<th id="ThTitle" width="450px">
									Question '.$questionIndex.'
								</th>
							</tr>
							<tr>
								<td id="TdQuestion">
									<input type="hidden" name="_question'.$questionIndex.'" value="_blank">
									'.$questionText.'
					';
									if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				echo '
								</td>
							</tr>
							<tr>
								<td id="TdQuestion2">
									'.$questionSubText.'
								</td>
							</tr>
							<tr>
								<td>
									<div class="radio">
										<input type="radio" name="_question'.$questionIndex.'" id="question'.$questionIndex.'true" class="style-radio" value="true">
										<label for="question'.$questionIndex.'true" class="style-radioLabel">True</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="radio">
										<input type="radio" name="_question'.$questionIndex.'" id="question'.$questionIndex.'false" class="style-radio" value="false">
										<label for="question'.$questionIndex.'false" class="style-radioLabel">False</label>
									</div>
								</td>
							</tr>
						</table>
					</div>
				';
			}

			function createTextInput ($questionIndex, $questionText, $questionSubText, $imageUrl) {
				echo '
					<div id="content">
						<table border="0" align="center" class="input-list style-1 clearfix">
							<tr>
								<th id="ThTitle" width="450px">
									Question '.$questionIndex.'
								</th>
							</tr>
							<tr>
								<td id="TdQuestion">
									<input type="hidden" name="_question'.$questionIndex.'" value="_blank">
									'.$questionText.'
					';
									if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				echo '
								</td>
							</tr>
							<tr>
								<td id="TdQuestion2">
									'.$questionSubText.'
								</td>
							</tr>
							<tr>
								<td>
									<div style="text-align:center;">
										<input style="width: 500px; height: 50px;" type="text" placeholder="Answer (a word)" name="_question'.$questionIndex.'">
									</div>
								</td>
							</tr>
						</table>
					</div>
				';
			}

			function createNumberInput ($questionIndex, $questionText, $questionSubText, $imageUrl) {
				echo '
					<div id="content">
						<table border="0" align="center" class="input-list style-1 clearfix">
							<tr>
								<th id="ThTitle" width="450px">
									Question '.$questionIndex.'
								</th>
							</tr>
							<tr>
								<td id="TdQuestion">
									<input type="hidden" name="_question'.$questionIndex.'" value="_blank">
									'.$questionText.'
					';
									if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				echo '
								</td>
							</tr>
							<tr>
								<td id="TdQuestion2">
									'.$questionSubText.'
								</td>
							</tr>
							<tr>
								<td>
									<div style="text-align:center;">
										<input style="width: 500px; height: 50px;" type="number" placeholder="Answer (a number)" name="_question'.$questionIndex.'">
									</div>
								</td>
							</tr>
						</table>
					</div>
				';
			}

			function createMatching ($questionIndex, $questionText, $questionSubText, $matchingBoxTexts, $imageUrl) {
				echo '
					<div id="content">
						<table border="0" align="center" class="input-list style-1 clearfix">
							<tr>
								<th id="ThTitle" width="450px">
									Question '.$questionIndex.'
								</th>
							</tr>
							<tr>
								<td id="TdQuestion">
									<input type="hidden" name="_question'.$questionIndex.'" value="_blank">
									'.$questionText.'
					';
									if(empty($imageUrl) == false){ //If a url for an image is specified
										echo '
											<br>
											<img style="padding-top: 20px;" src="'.$imageUrl.'" width="250px" height="150px">
										';
									}
				echo '
								</td>
							</tr>
							<tr>
								<td id="TdQuestion2">
									'.$questionSubText.'
								</td>
							</tr>
				';
				foreach ($matchingBoxTexts as $index => $text) { //Create each checkbox option
					echo '
						<tr>
							<td>
								<div class="checkbox">
									<input style="width: 500px; height: 50px;" type="text" placeholder="'.($index+1).'" name="_question'.$questionIndex.'-'.$index.'">
								</div>
							</td>
						</tr>
					';
				}
				echo '
					</table>
				</div>
				';
			}
		?>

	<!--Header-->
		<ul align="center">
		  <li style="width: 30%">
		  	<div class="cmn-t-translate-bshadow">
		  		<a href="index.php">Menu</a>
		  	</div>
		  </li>
		  <li style="width: 40%; text-align: center; font-size: 3em">
		  	Quiz
		  	<br>
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

	<!--Footer-->
		<form method="POST" action="quizResults.php">
			<div style="position: fixed; z-index: 99999; bottom: 0px; left: 0; width: 100%; height: 100px; background: linear-gradient(to bottom right, rgba(32,193,193,0.5), rgba(54,184,233,0.5));background-size: cover; box-shadow: 0px 0px 20px #5E5E5E;">
				<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 100%;">
					<tr>
						<td>
							<div id="timer" style="text-align:center; font-family: 'LatoHeavy'; font-size: 1.2em; padding-top: 10px;">
								<!--Timer is inserted here by code-->
							</div>
						</td>
					<tr>
					<tr>
						<td>
							<form method="POST" action="account.php">
								<div style="text-align:center;">
									<input style="width: 100px; height: 50px;" type="submit" value="Submit" name='_submitQuiz'>
								</div>
							</form>
						</td>
					</tr>
				</table>
			</div>

			<?php
				//Create all the questions
				//Create a radio question with an image
				//createRadioBox(1, 'What is the question?', array('Nothing', 'Something', 'Either', 'All of the Above'), 'images/questions/template.jpg'); 

				//Create a radio question without an image
				//createRadioBox(1, 'What is the question?', array('Nothing', 'Something', 'Either', 'All of the Above'),''); 

			//NOT USING CHECKBOXES ATM
				//Create a radio question with an image
				//createCheckBox(2, 'What is the question?', array('Nothing', 'Something', 'Either', 'All of the Above'), 'images/questions/template.jpg'); 

				//Create a checkbox question without an image
				//createCheckBox(1, 'What is the question?', array('Nothing', 'Something', 'Either', 'All of the Above'), ''); 

				//Create a true false question with an image
				//createTrueFalse (3, 'Is this the answer?', 'images/questions/template.jpg'); 

				//Create a true false question without an image
				//createTrueFalse (3, 'Is this the answer?', ''); 

				//Create a true false question with an image
				//createTextInput (4, 'Is this the answer?', 'images/questions/template.jpg'); 

				//Create a true false question without an image
				//createTextInput (4, 'Is this the answer?', ''); 

				//Create a true false question with an image
				//createNumberInput (5, 'Is this the answer?', 'images/questions/template.jpg'); 

				//Create a true false question without an image
				//createNumberInput (5, 'Is this the answer?', ''); 


				function setAnswer ($questionNum, $index) { //Sets an answer to a post index
					//$_POST['question'.$questionNum.'_answer'] = $index; //Set a post variable to the answer
					echo '
						<input type="hidden" name="_question'.$questionNum.'_answer" value="'.$index.'">
					';

					//$test = $_POST['question'.$questionNum.'_answer'];
					//print("Added to post: ".$test);
				}

				//A pool of all the questions
				$questionPool = array(
				  	0 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'In this for loop, how many times does it iterate?', '', array('0', '10', '9', '5'),'images/questions/0.png');

				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	1 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'In this while loop, it will iterate ____ times?', '', array('1', '0', '10', '2'), 'images/questions/1.png'); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	2 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the best way to address Mr. Kirnic?', '', array('King Kirnic', 'King Kirnoc', 'Yo Dude', 'Kirn'), ''); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	3 => function($questionNumber) {
				  		createTrueFalse($questionNumber, 'Is this the correct way to write a for loop in Visual Basic?', '','images/questions/3.png'); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	4 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'What is the name of the conditional loop that checks the conditions at the end?', '', ''); 

				  		$answer = 'do'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	5 => function($questionNumber) {
				  		createNumberInput ($questionNumber, 'What is the value of x in the following c# code?', '', 'images/questions/5.png'); 

				  		$answer = '5'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	6 => function($questionNumber) {
				  		createTrueFalse ($questionNumber, 'This statement will evaluate to ____', '', 'images/questions/6.png'); 
				  		
				  		$answer = 'false'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	7 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the correct way to comment code in Visual Basic?','', array('//', '&#60!-- --&#62;', '/&#42; &#42;/', "'"), ''); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	8 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'How is a php section started?', '', ''); 

				  		$answer = '<?php'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	9 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'What character defines a php variable?', '', ''); 

				  		$answer = '$'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	10 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What value of x will evaluate this statement to true?','', array('2', '5', 'All of the Above', 'None of the Above'), 'images/questions/10.png'); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	11 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the correct way to declare a variable in Visual Basic?','', array('int x = 0', 'x = 0', 'Dim x integer = 3', 'Dim x As Integer'), ''); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	12 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'In Visual Studio, what is the proper naming prefix of a label box?', '', ''); 

				  		$answer = 'lbl'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	13 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'In Visual Studio, what is the proper naming prefix of a text box?', '', ''); 

				  		$answer = 'txt'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	14 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'How are message boxes shown in Visual Basic?','', array('Message.Show("string")', 'MessageBpx("string")', 'MessageBox.Show("string");', 'MessageBox.Show("string")'), ''); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	15 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the division operator in most programming languages?','', array('%', '&#92;', '&#47;', '*'), ''); 
				  		
				  		$answer = '2'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	16 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What devices are input devices?','', array('Mouse, Keyboard, Joystick', 'Mouse, Keyboard, Speakers', 'Speakers, Screen, Printer', 'Mouse, Speakers, Joystick'), ''); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	17 => function($questionNumber) {
				  		createTrueFalse ($questionNumber, 'Is secondary memory faster than primary memory?', '', ''); 
				  		
				  		$answer = 'false'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	18 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What types of programs are system programs?','', array('Word Processors', 'Web Browsers', 'Operating Systems', 'Game Programs'), ''); 
				  		
				  		$answer = '2'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	19 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the decimal value of 11111010?','', array('254', '246', '220', '250'), ''); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	20 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the decimal value of 00001101?','', array('22', '13', '19', '27'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	21 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is decimal 255 in binary?','', array('11111111', '11111110', '01111111', '11111100'), ''); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	22 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is decimal 192 in binary?','', array('11010010', '11000000', '11001001', '10001100'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	23 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'How many bits are in a byte?','', array('6', '8', '10', '4'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	24 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What tag defines an HTML page as HTML 5.0','', array('&#60;!DOCTYPE html&#62;', '&#60;DOCTYPE html&#62;', '&#60;!DOCTYPE !html&#62;', '&#60;!DOCTYPE&#62;'), ''); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	25 => function($questionNumber) {
				  		createTrueFalse ($questionNumber, 'Does JavaScript run on the client side?', '', ''); 
				  		
				  		$answer = 'true'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	26 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is php run on?','', array('Client Side', 'Server Side', 'All of the Above', 'None of the Above'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	27 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What does this flow chart shape represent?','', array('Start/End', 'Input/Output', 'Processing', 'Descision'), 'images/questions/27.png'); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	28 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What kind of line is used to show the direction of login in a flowchart?','', array('Solid Line', 'Solid Arrow Line', 'Dotted Line', 'Dotted Arrow Line'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	29 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What will this function return?','', array('x+5', '5', 'x', 'None of the Above'), 'images/questions/29.png'); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	30 => function($questionNumber) {
				  		createTextInput ($questionNumber, 'What is the return type of this function?', '', 'images/questions/30.png'); 

				  		$answer = 'string'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	31 => function($questionNumber) {
				  		createNumberInput ($questionNumber, 'What is the return value of this recursive function if p(8) is called?', '', 'images/questions/31.png'); 

				  		$answer = '4'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	32 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What does this flow chart shape represent?','', array('Start/End', 'Input/Output', 'Descision', 'Processing'), 'images/questions/32.png'); 
				  		
				  		$answer = '3'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	33 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the return value of this recursive function if p(18,24) is called?','', array('4', '3', '6', '7'), 'images/questions/33.png'); 
				  		
				  		$answer = '2'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	34 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'Which function is not a string function?','', array('ToLower()', 'Replace(x,y)', 'Sum(x,y)', 'Trim()'), ''); 
				  		
				  		$answer = '2'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	35 => function($questionNumber) {
				  		createRadioBox($questionNumber, 'What is the lowest index of an array?','', array('1', '0', '1', 'None of the Above'), ''); 
				  		
				  		$answer = '1'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	36 => function($questionNumber) {
				  		createRadioBox($questionNumber, "To change the name of a page's tab what tag is used, directly?",'', array('Title', 'Tab', 'Head', 'Html'), ''); 
				  		
				  		$answer = '0'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	37 => function($questionNumber) {
				  		createMatching ($questionNumber, 'Match the following terms with their definitions.', '', array('1','2','3'), 'images/questions/37.png'); 

				  		$answer = 'b,a,c,'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				   	38 => function($questionNumber) {
				  		createMatching ($questionNumber, 'Match the words that best describe the terms.', '', array('1','2','3'), 'images/questions/38.png'); 

				  		$answer = 'b,c,a,'; //The index that is correct
				  		setAnswer($questionNumber, $answer); //Set the correct answer in post
				   	},
				);

				$numberOfQuestions = 10; //Default ammount of questions

				if (count($questionPool) <= $numberOfQuestions){ //If the pool is smaller than the default number of questions. Then set question ammount to
					echo '
							<input type="hidden" name="_questionAmmount" value="'.count($questionPool).'">
					';
					$numberOfQuestions = count($questionPool);
				}
				else { //Set ammount to 10
					echo '
							<input type="hidden" name="_questionAmmount" value="'.$numberOfQuestions.'">
					';
				}

				//Generate the questions				
				$usedQuestions = array();

				for ($i=0; $i < $numberOfQuestions; $i++) { //10 times default
					$random = NULL; //Initialize random variable

					do {
						$random = rand(0, count($questionPool) - 1); //Get a random number between 0 and the question pool lengh - 1

						if (count($usedQuestions) >= count($questionPool)) { //If all the questions have been taken
							die; //End (to avoid an infinite loop)
						}
					} while (in_array($random, $usedQuestions) == true); //While the index of the question has already been used keep trying

					array_push($usedQuestions, $random); //Add the random to the array of used questions

					call_user_func($questionPool[$random], $i+1); //Generate the question on screen
				}


				/*$numberOfQuestions = 1;
				echo '<input type="hidden" name="_questionAmmount" value="'.$numberOfQuestions.'">';
				call_user_func($questionPool[37], 1); //Generate the question on screen*/
			?>	
		</form>
	</body>
</html>