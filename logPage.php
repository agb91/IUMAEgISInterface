<?php
	include('PHP/loginFunctions.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html>
	<head>
		<title>gAn web interface</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <script src="JS/jquery.js"></script>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="CSS/logPage.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <script src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body class="indexGeneral">
		<div class="container">
			<h2 class="form-signin-heading">Insert AEgIS experiment's password</h2>
			<form action="" method="post" class="form-signin">
				<label for="inputPassword" class="sr-only">Password</label>
				<input id="password" name="password" placeholder="**********" type="password" class="form-control">
				<br>
				<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value=" Login "> Login </button>
				<!--<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>-->
			</form>
		</div> <!-- /container -->

		<!--<div id="main">
			<h1>Login, insert the AEgIS password</h1>
			<div id="login">
				<form action="" method="post">
					<label>Password :</label>
					<input id="password" name="password" placeholder="**********" type="password">
					<input name="submit" type="submit" value=" Login ">
				</form>
			</div>
		</div>-->
	</body>
</html>