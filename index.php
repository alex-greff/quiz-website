<!--
Alex Greff
06 October, 2016
Index page
My Porfolio Index Page
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Quiz By Alex G</title>
		<!--Reference the almighty stylesheet-->
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/researchedStyles.css">
	</head>
	<style>
		
	</style>
	<body onload='displayUsername();' style="background-image: url('images/background_9.jpg'); background-size:cover; background-attachment: fixed; padding: 0; margin: 0; 	font-family: 'Lato';">

		<script type="text/javascript" src='loggedInCheck.js'></script>
		<script type="text/javascript" src="jquery-3.1.0.min.js"></script> <!--JQuery reference-->
		<!--<script type="text/javascript" src='inputInhibiter.js'></script> -->

		<SCRIPT LANGUAGE="JavaScript">
			function LogAction(linkName) { //Called when someone clicks on a link
				var username = localStorage.getItem("usernameQuiz"); //Get the current user's name
				$.ajax({ //Use JQuery Ajax to run a php script on the server giving detials of who clicked the link
				  type: 'post', 
				  url: 'linkLog.php', 
				  data: {_name: String(username), _link: String(linkName)} //Specify the data sent to the php script with _POST
				});
				return true; //Let the link continue 
			    //return false; //Cancel the link
			}
		</SCRIPT>

		<script type="text/javascript">
			function displayUsername(){
				var username = localStorage.getItem("usernameQuiz"); //Get the current user's name
				document.getElementById('thAccount').innerHTML = '<div class="userDisplay">' + username + '</div><div class="style-link"><a href="login.php" class="cmn-t-underline">Logout</a></div>';
				logUsername(username); //Log the username to _SESSION
			}
		</script>


		<SCRIPT LANGUAGE="JavaScript">
			function logUsername(username) { //Sets the _SESSION['username'] value to the current user
				$.ajax({ //Use JQuery Ajax to run a php script on the server
				  type: 'post', 
				  url: 'sessionLogUsername.php', 
				  data: {_username: username} //Specify the data sent to the php script with _POST
				});
			}
		</SCRIPT>

	<!--Header-->
		<ul align="center">
		  <li style="width: 30%">
		  	<!--<div class="cmn-t-translate-bshadow">
		  		<a href="#">Back</a>
		  	</div>-->
		  </li>
		  <li style="width: 40%; text-align: center; font-size: 3em">
		  	Homepage
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

	<!--Start Quiz Section-->
		<div id="content">
			<table border="0" align="center" class="input-list style-startButton clearfix" style="width: 40%;">
				<tr>
					<th id="ThTitle" colspan="1">
						Welcome!
					</th>
				</tr>
				<tr>
					<td>
						This quiz covers a bit of every topic discussed in all three years of the Computer Science course. This includes topics learned in Grade 10, 11, and 12, although, I have only included what we have learned so far this year.
						<br>
						<br>
						There are some questions that we may not have explicitly learned so feel free to Google to your heart's content. However, your time is recorded so be wary.
					</td>
				</tr>
				<tr>
					<td id="TdStart" colspan="2">
						<form method="POST" action="quiz.php">
							<input type="submit" value="Start Quiz" name='_start'>
						</form>
					</td>
				</tr>
			</table>
		</div>

	<!--Navigation Section-->
		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<th id="ThTitle" colspan="1">
						Navigate
					</th>
				</tr>
				<tr>
					<td>
						View your progress and the progress of others below. Achieve better scores and times to climb the ranks of the leaderboard and become the best!
					</td>
				</tr>
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="account.php">
							<input type="submit" value="View Account" name='_account'>
						</form>
					</td>
				</tr>
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="leaderboards.php">
							<input type="submit" value="Leaderboards" name='_leaderboards'>
						</form>
					</td>
				</tr>
			</table>
		</div>


		<div id="content">
			<table border="0" align="center" class="input-list style-buttons clearfix" style="width: 40%;">
				<tr>
					<td id="TdButtons" colspan="1">
						<form method="POST" action="sourcecode_presentation">
							<input type="submit" value="Source Code" name='_sourcecode'>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>