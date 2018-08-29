<!--
Alex Greff
20 Septemeber, 2016
Log username
This is called by ajax via a javascript function. It essentially just
saves the user's name to a SESSION variable so it can be accessed in any php page
-->
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php //This script logs the username to _SESSION
			session_start();
			$username = $_POST['_username']; 
			$_SESSION['username'] = $username;
		?>
	</body>
</html>