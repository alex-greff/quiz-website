<!--
Alex Greff
20 Septemeber, 2016
Leaderboards page
Displays the top ranked quizes
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Leaderboards</title>
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
			Leaderboards  
		  	<br>
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

		<?php //This php block gets the required users' data
			include 'encrypt.php'; //Include encryption php key will always be 69 ;)
			$key = 69; //Encryption key
			$crypt = new encryption($key); //Make the encryption

			$data = file_get_contents('registeredUsers.txt'); //Get the raw user data
			$data = $crypt->decrypt($data); //Decrypt

			$users = array(); //A list of only the usernames
			$listOfQuizes = array(); //A list of all the quizes done

			$usersRaw = explode("\r\n", $data); //All the users and their passwords
			if (count($usersRaw) <= 1){ //If the explode didn't work... (not on a windows webserver)
				$usersRaw = explode("\n", $data); //All the users and their passwords
			}

			$usersRaw = array_map('trim', $usersRaw); //Trim each index in the array

			foreach ($usersRaw as $key => $value) { //Users, index name, in this case 0,1,2... but could be "keyName0", "keyName1", "keyName2"..., and then the value at the specified index
				$user = explode("~", $value); //Separate the users and the passwords
				//Index 0 = usernames
				//Index 1 = passwords
				array_push($users, $user[0]); //Add the user to the user list array

				$path = 'users/'.$user[0].'_data.txt'; //User's file path to their data file
				$quizData = file_get_contents($path); //Get the contents

				$quizes = explode("\r\n", $quizData); //All the quizes of the specific user
				if (count($quizes) <= 1){ //If the explode didn't work... (not on a windows webserver)
					$quizes = explode("\n", $quizData); //All the quizes of the specific user
				}

				foreach ($quizes as $key => $value) { //For each quiz in the list of quizes
					if ($value != ""){ //Make sure it isn't blank
						array_push($listOfQuizes, $value); //Add each one to the big list of quizes	
					}
				}
			}
		?>

	<!--Leaderboard Display section-->
		<div id="content">
			<table border="0" align="center" class="input-list style-1 clearfix" width="800px">
				<tr>
					<td id="TdQuestion">
						<table border='0' cellspacing="0" cellpadding="0" align="center" class="input-list style-1 clearfix" width="100%" style="font-family: 'LatoThin';">
							<tr style="font-size: 1.5em;">
								<td style="border-bottom:1pt solid black;" width="10%" >
									Rank
								</td>
								<td style="border-bottom:1pt solid black;" width="30%">
									Name
								</td>
								<td style="border-bottom:1pt solid black;" width="15%">
									Score
								</td>
								<td style="border-bottom:1pt solid black;" width="15%">
									Time
								</td>
								<td style="border-bottom:1pt solid black;" width="30%">
									Date
								</td>
							</tr>

							<?php //This php block sorts and orders all the user's scores and times and then displays them in a table
								//Initialize arrays
								$listOfUsernames = array();
								$listOfScores = array();
								$listOfTimes = array();
								$listOfDates = array();

								foreach ($listOfQuizes as $key => $value) { //Foreach of the quizes done
									//Index 0 = Date
									//Index 1 = Username
									//Index 2 = Score
									//Index 3 = Time
									$currentQuiz = explode(",", $value); //Get each individual part

									//Add each specific index to their repsective array
									array_push($listOfDates, $currentQuiz[0]); 
									array_push($listOfUsernames, $currentQuiz[1]);
									array_push($listOfScores, $currentQuiz[2]);
									array_push($listOfTimes, $currentQuiz[3]);
								}

								//Sort the scores from greatest to least
								$sorted = false;
								while (false === $sorted) {
								    $sorted = true;
								    for ($i = 0; $i < count($listOfScores)-1; ++$i) {
								        $current = $listOfScores[$i];
								        $next = $listOfScores[$i+1];

								        $currentArr = array($listOfDates[$i], $listOfUsernames[$i], $listOfTimes[$i]);
								        $nextArr = array($listOfDates[$i+1], $listOfUsernames[$i+1], $listOfTimes[$i+1]);

								        if ($next > $current) {
								          	$listOfDates[$i] = $nextArr[0];
								           	$listOfDates[$i+1] = $currentArr[0];

											$listOfUsernames[$i] = $nextArr[1];
								           	$listOfUsernames[$i+1] = $currentArr[1];

								           	$listOfTimes[$i] = $nextArr[2];
								           	$listOfTimes[$i+1] = $currentArr[2];								            	

								            $listOfScores[$i] = $next;
								            $listOfScores[$i+1] = $current;
								            $sorted = false;
								        }
								    }
								}

									
								//Get the index ranges that need to be sorted by times (because there are multiple of the same scores)
								for ($x=100; $x >= 0; $x-=10) { //Go through all the possible scores
									//Initialize
									$min = -1; 
									$max = -1;

									//Initialize
									$firstChosen = false;
									$lastChosen = false;

									for ($i=0; $i < count($listOfScores); $i++) { //
										if ($listOfScores[$i] == $x){ //If the list of scores equals the current percentage
											if ($firstChosen === false){ //If the min hasn't been set yet
												$min = $i; //Set the min
												$firstChosen = true; //Set the no-repeat variable
											}
										}
										if ($listOfScores[$i] != $x && $firstChosen === true){ //If the list overpasses the 
											if ($lastChosen === false){ //If the max hasn't been set yet
												if ($i < count($listOfScores)){ //If its the end of the list
													$max = $i-1; //Set the max minus one
												}
												else { //If not
													$max = $i; //Set the max
												}
												
												$lastChosen = true; //Set the no-repeat variable
											}
										}
									}

									if ($firstChosen === true && $lastChosen === false){ //If the first chosen is set but the last chosen isn't
										$max = $min; //Set max to min
									}
										
									if ($min == $max){ //If the max equals min set to defaults (so it doesn't screw up the sorting later on)
										$min = -2;
										$max = -2;
									}

									//Sort the times
									$sorted = false;
									if ($min >= 0 && $max >= 0){
										//echo "Running- ";
										while (false === $sorted) {
										    $sorted = true;
										    for ($i = $min; $i < $max; ++$i) {
										        $current = $listOfTimes[$i];
										        $next = $listOfTimes[$i+1];

										        $currentArr = array($listOfDates[$i], $listOfUsernames[$i], $listOfScores[$i]);
										        $nextArr = array($listOfDates[$i+1], $listOfUsernames[$i+1], $listOfScores[$i+1]);

										        if ($next < $current) {
										          	$listOfDates[$i] = $nextArr[0];
										           	$listOfDates[$i+1] = $currentArr[0];

													$listOfUsernames[$i] = $nextArr[1];
										           	$listOfUsernames[$i+1] = $currentArr[1];

										           	$listOfScores[$i] = $nextArr[2];
										           	$listOfScores[$i+1] = $currentArr[2];								            	

										            $listOfTimes[$i] = $next;
										            $listOfTimes[$i+1] = $current;
										            $sorted = false;
										        }
										    }
										}
									}
								}
									
									
								//Display everything
								for ($i=0; $i < count($listOfScores); $i++) { 
									//echo $listOfUsernames[$i]." ".$listOfScores[$i]." ".$listOfTimes[$i];
									echo '
										<tr  class="ranking-table">
											<td width="10%">'
												.($i+1).	
											'</td>
											<td width="30%">'
												.$listOfUsernames[$i].
											'</td>
											<td width="15%">'
												.$listOfScores[$i].'%
											</td>
											<td width="15%">'
												.$listOfTimes[$i].' sec
											</td>
											<td width="30%">'
												.$listOfDates[$i].
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
	</body>
</html>