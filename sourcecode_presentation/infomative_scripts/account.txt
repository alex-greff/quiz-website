<!--
Alex Greff
20 Septemeber, 2016
Account page
Displays the user's personal account info
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Account</title>
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
			Account  
		  	<br>
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

		<?php //This php block gets the current user's data and calculates stats with it
			session_start(); //Start session
			$username = $_SESSION['username']; //Get the logged in user

			$filePath = "users/".$username."_data.txt"; //File path to user's data file
			$quizesRaw = file_get_contents($filePath); //A list of all the quizes done
			$listOfQuizes = array();

			$quizes = explode("\r\n", $quizesRaw);
			if (count($quizes) <= 1){ //If the explode didn't work... (not on a windows webserver)
				$quizes = explode("\n", $quizesRaw); //All the users and their passwords
			}
			foreach ($quizes as $key => $value) { //For each quiz in the list of quizes
				if ($value != ""){ //Make sure it isn't blank
					array_push($listOfQuizes, $value); //Add each one to the big list of quizes	
				}
			}
			
			//Initialize variables
			$quizCount = count($listOfQuizes);
			$bestScore = 0;
			$bestTime = 0;
			$averageScore = 0;
			$averageTime = 0;
			$worstScore = 0;
			$worstTime = 0;

			foreach ($listOfQuizes as $key => $value) { //Foreach quiz done by user
				//Index 0 = date
				//Index 1 = name
				//Index 2 = score
				//Index 3 = time
				$quizComponents = explode(",", $value); //Split the array up into individual secions

				if (array_key_exists(2, $quizComponents) && array_key_exists(3, $quizComponents)) { //Check if these exist
					//Initialize best/worst scores
					if ($key == 0){
						$bestScore = $quizComponents[2];
						$bestTime = $quizComponents[3];

						$worstScore = $quizComponents[2];
						$worstTime = $quizComponents[3];
					}

					//Add the averages up
					$averageScore += $quizComponents[2];
					$averageTime += $quizComponents[3];

					//Update best/worst scores
					if ($bestScore < $quizComponents[2]){
						$bestScore = $quizComponents[2];
					}
					if ($bestTime < $quizComponents[3]){
						$bestTime = $quizComponents[3];
					}
					if ($worstScore > $quizComponents[2]){
						$worstScore = $quizComponents[2];
					}
					if ($worstTime > $quizComponents[3]) {
						$worstTime = $quizComponents[3];
					}
				}
			}
			//Finish up calculating averages
			if ($quizCount > 0){ //Make sure it doesn't divide by zero
				$averageScore /= $quizCount;
				$averageTime /= $quizCount;
			}

			//Round
			$averageScore = round($averageScore);
			$averageTime = round($averageTime);
		?>

	<!--Display General Stats Section-->
		<div id="content">
			<table border="0" cellspacing="0" cellpadding="0" align="center" class="input-list style-1 clearfix" width="800px" style="font-family: 'LatoThin';">
				<tr>
					<th id="ThTitle" style="padding-bottom: 50px">
						Statistics
					</th>
				</tr>
				<tr>
					<td id="TdQuestion">
						Quizes Done: 
						<br>
						<?php echo "<p style='color: #4CFF00; font-size: 1.2em;'>".$quizCount."</p>"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Best Score: 
						<br>
						<?php echo "<p style='color: #4CFF00; font-size: 1.2em;'>".$bestScore."%</p>"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Best Time: 
						<br>
						<?php echo "<p style='color: #4CFF00; font-size: 1.2em;'>".$bestTime." sec</p>"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Average Score: 
						<br>
						<?php echo "<p style='color: #4CFF00; font-size: 1.2em;'>".$averageScore."%</p>"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Average Time: 
						<br>
						<?php echo "<p style='color: #4CFF00; font-size: 1.2em;'>".$averageTime." sec</p>"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Worst Score: 
						<br>
						<?php echo "<p style='color: red; font-size: 1.2em;'>".$worstScore."%"; ?>
					</td>
				</tr>
				<tr>
					<td id="TdQuestion">
						Worst Time: 
						<br>
						<?php echo "<p style='color: red; font-size: 1.2em;'>".$worstTime." sec"; ?>
					</td>
				</tr>			
			</table>
		</div>

	<!--Display User Quizes Section-->
		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<th id="ThTitle" colspan="1">
						Completed quizes
					</th>
				</tr>
				<tr>
					<td id="TdQuestion">
						<table border='0' cellspacing="0" cellpadding="0" align="center" class="input-list style-1 clearfix" width="100%" style="font-family: 'LatoThin';">
							<tr style="font-size: 1.5em;">
								<td style="border-bottom:1pt solid black;" width="10%" >
									Number
								</td>
								<td style="border-bottom:1pt solid black;" width="30%">
									Score
								</td>
								<td style="border-bottom:1pt solid black;" width="30%">
									Time
								</td>
								<td style="border-bottom:1pt solid black;" width="30%">
									Date
								</td>
							</tr>
							<?php

								//Display everything
								for ($i=0; $i < count($listOfQuizes); $i++) {
									//Index 0 = date
									//Index 1 = name
									//Index 2 = score
									//Index 3 = time
									$quizComponents = explode(",", $listOfQuizes[$i]); //Split the array up

									echo '
										<tr  class="ranking-table">
											<td width="10%">'
												.($i+1).	
											'</td>
											<td width="30%">'
												.$quizComponents[2].'%
											</td>
											<td width="30%">'
												.$quizComponents[3].' sec
											</td>
											<td width="30%">'
												.$quizComponents[0].
											'</td>		
										</tr>
									';
								}
							?>
						</table>
					</td>
				</tr>
			</table>
		</div>

	<!--Reset Data Section-->
		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<th id="ThTitle" colspan="1">
						Reset all Data
					</th>
				</tr>
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="reset.php">
							<input type="submit" value="Reset" name='_reset'>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>