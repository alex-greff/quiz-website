<!--
Alex Greff
20 Septemeber, 2016
Log Time
This script is called by ajax saves a time value in SESSION
so it can be accessed on different pages
-->
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php //This php script just logs the time to _SESSION
			session_start();
			$time = $_POST['_time']; 
			$_SESSION['time'] = $time;
		?>
	</body>
</html>