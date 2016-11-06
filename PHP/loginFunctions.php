<?php
	session_start(); // Starting Session
	//echo "I'm checking..";
	if (isset($_POST['submit'])) 
	{
		if (empty($_POST['password'])) 
		{
			echo "Password is invalid";
		}
		else
		{
			$password=$_POST['password'];
			$realPassword = "GetHbar!16";
			
			if (strcmp($password, $realPassword) == 0) 
			{
				$_SESSION['logged']="logged"; // Initializing Session
				echo "session now : " . $_SESSION['logged'];
				header("location: index.php"); // Redirecting To Home Page
				//echo "all is ok";
			}
			else 
			{
				echo "<div class='error'> <h1> This Password is not valid </h1></div><br><br>";
			}
			
		}
	}
?>