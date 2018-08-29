<!--
Alex Greff
20 Septemeber, 2016
Quiz Results Page
The result screen for completing a quiz
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Results</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/researchedStyles.css">
	</head>
	<body onload="displayUsername()"  style="background-image: url('images/background_9.jpg'); background-size:cover; background-attachment: fixed; padding: 0; margin: 0; 	font-family : 'Lato';">
		<script type="text/javascript">
			function displayUsername(){
				var username = localStorage.getItem("usernameQuiz"); //Get the current user's name
				document.getElementById('thAccount').innerHTML = '<div class="userDisplay">' + username + '</div><div class="style-link"><a href="login.php" class="cmn-t-underline">Logout</a></div>';
			}
		</script>

	<!--Header-->
		<ul align="center">
		  <li style="width: 30%">
		  	<div class="cmn-t-translate-bshadow">
		  		<a href="index.php">Menu</a>
		  	</div>
		  </li>
		  <li style="width: 40%; text-align: center; font-size: 3em">
		  	Results
		  	<br>
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

		<?php //This php block gathers the user's quiz responses and the correct answers
			session_start();
			$time = $_SESSION['time'];
			$username = $_SESSION['username'];

			if(isset($_POST['_submitQuiz']) == false) { //If not finished a quiz
			   	header("Location: index.php"); //Redirect to the homepage
				die();
			}

			$numberOfQuestions = $_POST['_questionAmmount']; //Get ammount of questions answered
			$scoreTotal = $numberOfQuestions; //The denominator
			$score = 0; //The numerator (defaulted at 100%);

			//Instantiate arrays
			$questions = array(); 
			$questionAnswers = array();

			for ($i=1; $i <= $numberOfQuestions; $i++) { //For each of the answered questions
				array_push($questions, strtolower(trim($_POST['_question'.$i]))); //Get user's answers and convert to lowercase
				array_push($questionAnswers, strtolower(trim($_POST['_question'.$i.'_answer']))); //Get official answers and convert to lowercase, just in case
			}
		?>

	<!--Results Area-->
		<div id="content">
			<table border="0" align="center" class="input-list style-1 clearfix">
				<tr>
					<th id="ThTitle" width="500px">
						Your Score:
					</th>
				</tr>
				<tr>
					<td id="TdQuestion">
						<?php
							for ($i=0; $i < $numberOfQuestions; $i++) { 
								if (strpos($questionAnswers[$i], ",")){ //If the answer is a matching question
									$question = '';

									$check = true;
									$x = 0;

									while ($check === true){
										if (isset($_POST['_question'.($i+1).'-'.$x])){
											$question .= $_POST['_question'.($i+1).'-'.$x].',';
											$x++;	
										}
										else {
											$check = false;
										}
									}
									//echo $question;
									$questions[$i] = $question;
									//echo $questions[$i];
								}


								if ($questions[$i] == $questionAnswers[$i]){ //If user got the answer right
									$score++;
									echo '
									Question '.($i+1).': 
									<div style="color:#4CFF00;">
										Correct
									</div>
									<br>
									';
								}
								else {
									echo '
									Question '.($i+1).': 
									<div style="color:red;">
										Incorrect
									</div>
									<br>
									';
								}
							}

							$scoreFinal = ($score/$scoreTotal) * 100;
							$scoreFinal = round($scoreFinal, 0); //Round

							function showTime($time){
								$minutes = padText(round($time / 60, 0, PHP_ROUND_HALF_DOWN)); //Round down
								$seconds = padText($time % 60);

								echo '
									<div style="font-size: 1.3em;">
										<br>
										Time:
										<br>
										<div style="color: #FFF189; font-size: 2em;">
										'.$minutes.':'.$seconds.'
									</div>
								';
							}

							function padText($stuff){
								$stuff = (string)$stuff;
								if (strlen($stuff) < 2){
									return "0".$stuff;
								}
								else {
									return $stuff;
								}
							}

							function getLetterGrade($score){
								if ($score >= 100)
									return 'A++';
								else if ($score >= 90)
									return 'A+';
								else if ($score >= 80)
									return 'A';
								else if ($score >= 70)
									return 'B';
								else if ($score >= 60)
									return 'C';
								else if ($score >= 50)
									return 'D';
								else if ($score >= 40)
									return 'E';
								else if ($score >= 30)
									return 'F';
								else 
									return 'F-';
							}

							if ($scoreFinal >= 100){
								echo '
									<br>
									<div style="color: #4CFF00; font-size: 3em;">
										Perfect Score!
										<br>
										'.getLetterGrade($scoreFinal).'
										<br>
										<br>
										<img src="images/perfectscore.png" width="100px" height="75px">
									</div>
								';
								showTime($time);
							}
							else if ($scoreFinal >= 50){
								echo '
									<div style="color: #4CFF00; font-size: 3em;">
										Final Score:
										<br>
										'.getLetterGrade($scoreFinal).
										'<br>'
										.$score.'/'.$scoreTotal.'='.$scoreFinal.'%
									</div>
								';
								showTime($time);
							}
							
							else {
								echo '
									<br>
									<div style="color: red; font-size: 3em; font-family: "Lato";">
										<img src="images/failure.png" width="200px" height="150px">
										<br>
										'.getLetterGrade($scoreFinal).'
									</div>
								';
								showTime($time);
							}

							//echo 'Username: '.$username;
							$filePath = 'users/'.$username.'_data.txt';
							date_default_timezone_set('America/Toronto');
							$today = getdate(); //Get the date
							$d = $today['mday']; //Day
							$m = $today['mon']; //Month
							$y = $today['year']; //Year

							$hours = $today['hours']; //Time - Convert to EST
							$mins = $today['minutes']; //Minutes

							$data = padText($d)."-".padText($m)."-".padText($y)." ".padText($hours).":".padText($mins).", ".$username.", ".$scoreFinal.", ".$time."\r\n"; //Prepare the data entry
							file_put_contents($filePath, $data, FILE_APPEND); //Write to file (FORMAT: date, username, score, time)
						?>
						
					</td>
				</tr>				
			</table>
		</div>

		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="quiz.php">
							<input type="submit" value="Retry" name='_start'>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>