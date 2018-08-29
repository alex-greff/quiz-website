var loggedStatus = localStorage.getItem("loggedInQuiz"); //Get if the user is logged in
var username = localStorage.getItem("usernameQuiz"); //Get the user's name

//alert("Status Index: " + loggedStatus);

if (loggedStatus != 'true'){ //If not logged in
	window.location = "login.php"; //Redirect to the login screen
}

