<!--
Alex Greff
20 Septemeber, 2016
Login Processing Page
This is where the login information is processed
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/researchedStyles.css">
	</head>
	<body style="background-image: url('images/background_9.jpg'); background-size:cover; background-attachment: fixed; padding: 0; margin: 0; 	font-family: 'Lato';">
		<script type="text/javascript" src="jquery-3.1.0.min.js"></script> <!--JQuery reference-->

		<script type="text/javascript">
			function loginTrue(){
				localStorage.setItem("loggedInQuiz", 'true');
				//alert('Set Local storage to true: Check: ' + localStorage.getItem('loggedIn'))
			}
			function loginFalse(){
				localStorage.setItem("loggedInQuiz", 'false');
				//alert('Set Local storage to false: Check: ' + localStorage.getItem('loggedIn'))
			}
		</script>

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

		<?php
			function login (){
				/*include 'encrypt.php'; //Include encryption php key will always be 69 ;)
				$key = 69; //Encryption key
				$crypt = new encryption($key); //Make the encryption
				*/

				//Call javascript function defaulting the user as not logged in
				echo '
					<script type="text/javascript">
				   		loginFalse();
				     </script>
				';

				$username = $_POST['_username']; //Get the submitted username
				$password = $_POST['_password']; //Get the submitted password

				$rawUserData = file_get_contents('registeredUsers.txt'); //Get the raw file of all the users and their passwords
				//$rawUserData = $crypt->decrypt($rawUserData); //Decrypt
				$users = explode("\r\n", $rawUserData); //All the users and their passwords

				$checkData = strpos($rawUserData, (string)$username.'~'.(string)$password); //Get a true / false of if the user is in the database/gave correct credentials

				//If something goes wrong... like user/password box is left blank or empty, the special character "~" is in either of them, 
				if ($checkData === false || $username === NULL || $password === NULL || !isset($username) || !isset($password) || empty($username) || empty($password) || strpos($username, "~") !== false || strpos($password, "~") !== false) { 
					//echo (string)$username.'~'.(string)$password.'<br>'.$rawUserData;

					//Display the incorrect username/password notification
					echo '
						<div id="content">
							<form method="POST" action="login.php">
								<table border="0" align="center" class="input-list style-1 clearfix">
									<tr>
										<th id="ThTitle" colspan="2">Incorrect Username or Password</th>
									</tr>
									<tr>
										<td id="TdSubmit" colspan="2" id="TdBottom">
											<input type="submit" value="Retry">
										</td>
									</tr>
								</table>
							</form>
						</div>
					';
					//Set the user to not logged in
					echo '
						<script type="text/javascript">
					    	loginFalse();
					    </script>
					';
				}
				else {
					//Set the user to logged in and set the local storage with the currently logged in user then redirect to index page
					echo '
						<script type="text/javascript">
					    	loginTrue();
					    	localStorage.setItem("usernameQuiz","'.(string)$username.'");
					    	LogAction("LOGIN");
							window.location = "index.php";
					    </script>
					';
				}	
			}

			function register () {
				/*include 'encrypt.php'; //Include encryption php key will always be 69 ;)
				$key = 69; //Encryption key
				$crypt = new encryption($key); //Make the encryption
				*/

				$username = $_POST['_username']; //Get submitted username
				$password = $_POST['_password']; //Get submitted password

				$rawUserData = file_get_contents('registeredUsers.txt'); //Get the raw file of all the usernames thier passwords
				//$rawUserData = $crypt->decrypt($rawUserData); //Decrypt

				//Make sure the username and password fit the credentials (ie not blank, doesn't have "~" character, username doesn't already exist, etc)
				if ($username === NULL || $password === NULL || !isset($username) || !isset($password) || empty($username) || empty($password) || strpos($username, "~") !== false || strpos($password, "~") !== false || strpos($rawUserData, $username) !== false){
					//Display incorrect registration details
					echo '
						<div id="content">
							<form method="POST" action="login.php">
								<table border="0" align="center" class="input-list style-1 clearfix">
									<tr>
										<th id="ThTitle" colspan="2">Incorrect Registration Details</th>
									</tr>
									<tr>
										<td id="TdSubmit" colspan="2" id="TdBottom">
											<input type="submit" value="Retry">
										</td>
									</tr>
								</table>
							</form>
						</div>
					';
				}
				else {
					//Creat the user account
					$entry = "\r\n".$username."~".$password; //Prepare the string to be put in the registered users file
					$rawUserData .= $entry; //Add on the entry to the user data
					//$rawUserData = $crypt->encrypt($rawUserData); //Encrypt

					file_put_contents('registeredUsers.txt',$rawUserData); //Add the user to the file
					file_put_contents('users/'.$username.'_data.txt', ""); //Create an empty data file for the user

					login(); //Log the user in
				}
			}

			if(isset($_POST['_login'])) { //If logging in
			   	login(); //Log in
			} 
			if(isset($_POST['_register'])) { //If registerting
			   	register(); //Register
			}
		?>
	</body>
</html>