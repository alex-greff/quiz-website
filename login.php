<!--
Alex Greff
20 Septemeber, 2016
Login Page
My login page for this quiz website
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<!--Reference the almighty stylesheet-->
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/researchedStyles.css">
	</head>
	<style>
		
	</style>
	<body style="background-image: url('images/background_9.jpg'); background-size:cover; background-attachment: fixed; padding: 0; margin: 0; 	font-family: 'Lato';">
		<?php
			/*include 'encrypt.php'; //Include encryption php key will always be 69 ;)
			$key = 69; //Encryption key
			$crypt = new encryption($key); //Make the encryption
			*/

			//Initialize Encryptions (if I need to see what's in the file)

			/*
			//Encrypt
			$data = file_get_contents('registeredUsers.txt'); //Get the user data
			$data = $crypt->encrypt($data); //Encrypt
			file_put_contents('registeredUsers.txt', $data); //Save
			*/
			
			/*
			//Decrypt
			$data = file_get_contents('registeredUsers.txt'); //Get the user data
			$data = $crypt->decrypt($data); //Decrypt
			file_put_contents('registeredUsers.txt', $data); //Save
			*/

			//Check and create data files if needed (precautionary)
			$rawUserData = file_get_contents('registeredUsers.txt'); //Get the user data
			//$rawUserData = $crypt->decrypt($rawUserData); //Decrypt

			$users = explode("\r\n", $rawUserData);
			if (count($users) <= 1){ //If the explode didn't work... (not on a windows webserver)
				$users = explode("\n", $rawUserData); //All the users and their passwords
			}

			foreach ($users as $key => $value) { //For each index in the array
				$user = explode("~", $value); //Get the username [0] and password [1]
				$filename = $user[0]."_data.txt";

				if (file_exists("users/".$filename) == false){ //If there is no user file made
					file_put_contents("users/".$filename, ""); //Create an empty user file
				}
			}
		?>

	<!--Header-->
		<ul align="center">
		  <li style="width: 30%">
		  </li>
		  <li style="width: 40%; text-align: center; font-size: 3em">
		  	Quiz By Alex
		  </li>
		  <li style="width: 30%; text-align: left; font-size: 1.2em; font-family: 'LatoThinItalic';" id="thAccount">
		  	
		  </li>
		</ul>

	<!--Login Section-->	
		<form method="POST" action="loginProcess.php">
			<div id="content">
				<table border="0" align="center" class="input-list style-1 clearfix">
					<tr>
						<th id="ThTitle" colspan="2">
							Login
						</th>
					</tr>
					<tr>
						<td width="20%">Username</td>
						<td width="80%">
							<!--Make a list of registered users-->
							<select required name="_username" class="style-list">
								<option value="" disabled selected hidden>username</option>
								<?php
									$data = file_get_contents('registeredUsers.txt'); //Get raw data
									//$data = $crypt->decrypt($data); //Decrypt

									$users = explode("\r\n", $data); //All the users and their passwords
									if (count($users) <= 1){ //If the explode didn't work... (not on a windows webserver)
										$users = explode("\n", $data); //All the users and their passwords
									}

									foreach ($users as $key => $value) { //Users, index name, in this case 0,1,2... but could be "keyName0", "keyName1", "keyName2"..., and then the value at the specified index
										$user = explode("~", $value); //Separate the users and the passwords
										echo "
											<option value='".$user[0]."'>".$user[0]."</option>
										";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input required type="password" placeholder="password" name="_password"></td>
					</tr>
					<tr>
						<td id="TdSubmit" colspan="2">
							<input type="submit" value="Login" name='_login'>
						</td>
					</tr>
				</table>
			</div>
		</form>

	<!--Register Section-->
		<form method="POST" action="loginProcess.php">
			<div id="content">
				<table border="0" align="center" class="input-list style-1 clearfix">
					<tr>
						<th id="ThTitle" colspan="2">
							Register
						</th>
					</tr>
					<tr>
						<td width="20%">Username</td>
						<td width="80%">
							<!--Regular Username Input-->
							<input required type="text" placeholder="username" name="_username">
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input required type="password" placeholder="password" name="_password"></td>
					</tr>
					<tr>
						<td id="TdSubmit" colspan="2">
							<input type="submit" value="Register" name='_register'>
						</td>
					</tr>
				</table>
			</div>
		</form>		
	</body>
</html>