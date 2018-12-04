<?php 
	require_once 'functions.php';
	session_start();

	if(isset($_GET['error'])) {
		echo "<p class='error'>".$_GET['error']."</p>";
	}
	if(isset($_GET['message'])) {
		echo "<p class='message'>".$_GET['message']."</p>";
	}

	if(isset($_SESSION['loggeduser'])||isset($_COOKIES['username'])) {
		if(isset($_COOKIES['username'])) {
			$usr = new user();
			$user = $user->selectbyname($_COOKIES['username']);
			$_SESSION['loggeduser'] = $user;
		} 
		else {
			$user = $_SESSION['loggeduser'];
		}
		if($user->username === "admin") {
			header('Location: list.php');
		}
		else {
			header('Location: profile.php');
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
	<form action="loginprocess.php" method="post">
		<table>
			<tr>
				<td>
					<label for="username">Username: </label>
				</td>
				<td>
					<input type="text" name="username">
				</td>
			</tr>
			<tr>
				<td>
					<label for="pass">Password: </label>
				</td>
				<td>
					<input type="password" name="pass">
				</td>
			</tr>
			<tr>
				<td>
					<label for="pass">Remeber ME: </label>
				</td>
				<td>
					<input type="checkbox" name="remeber">
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<input type="submit" name="login" value="Login">
					<input type="reset" name="reset">
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<a href="register.php">Sign Up</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
