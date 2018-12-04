<?php 
	require_once 'functions.php';
	require 'config.php';

	if(isset($_GET['error'])) {
		echo "<p class='error'>".$_GET['error']."</p>";
	}

	if($_POST) {

		$user = new user();

		if(isset($_POST['username'])&&!empty($_POST['username']))
			$user->username = $_POST['username'];
		else {
			header('Location: register.php?error=username cant be empty');
		}
		if(isset($_POST['email'])&&!empty($_POST['email']))
			$user->email = $_POST['email'];
		else {
			header('Location: register.php?error=password cant be empty');
		}
		if(isset($_POST['pass'])&&!empty($_POST['pass']))
			$user->pass = sha1($_POST['pass']);
		else {
			header('Location: register.php?error=email cant be empty');
		}

		$state = $user->insert();

		if($state) {
			//echo "success";
			header('Location: login.php');
		}
		else {
			header('Location: register.php?error=failed to create user');
		}
	}

?>




<!DOCTYPE html>
<html>
<head>
	<title>Registeration</title>
	<style type="text/css">
		.error {
			background-color: pink;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid red;
		}
		.message {
			background-color: lightblue;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid blue;
		}
	</style>
</head>
<body>
	<form method="post" action="register.php">
		<table>
			<tr>
				<td>
					<label for="username">Username:</label> 
				</td>
				<td>
					<input type="text" name="username">
				</td>
			</tr>
			<tr>
				<td>
					<label for="email">Email:</label> 
				</td>
				<td>
					<input type="text" name="email">
				</td>
			</tr>
			<tr>
				<td>
					<label for="pass">Password:</label> 
				</td>
				<td>
					<input type="password" name="pass">
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<input type="submit" name="submit" value="Register">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
