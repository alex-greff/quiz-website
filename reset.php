<!--
Alex Greff
20 Septemeber, 2016
Reset Page
This page resets all the user's data
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Reset</title>
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
		  	Reset
		  	<br>
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

	<!--Reset Notification Area-->
		<div id="content">
			<table border="0" align="center" class="input-list style-1 clearfix">
				<tr>
					<th id="ThTitle" width="500px">
						<?php
							session_start();
							$username = $_SESSION['username'];
							$file = "users/".$username."_data.txt";

							if(isset($_POST['_reset'])) { //If this page was accessed by a button (not by typing in the link)
								file_put_contents($file, ""); //Reset the data file

								echo "Data has been reset";		
							}
							else { //If not accessed by the reset button
								echo "Error, your data has not been reset";
							}
						?>
						
					</th>
				</tr>
			</table>
		</div>

	<!--Menu Button Area-->
		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="index.php">
							<input type="submit" value="Menu" name='_index'>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>