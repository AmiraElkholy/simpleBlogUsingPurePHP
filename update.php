<?php
	require_once 'functions.php';
	session_start();
	require 'config.php';
	
	if(isset($_SESSION['loggeduser'])) {
		$loguser = $_SESSION['loggeduser'];
	}
	else {
		header('Location: login.php?error=you are not logged in');
		exit;
	}

	$usr = new user();

	$user = $usr->selectbyid($loguser->id);

	if(!$user) {
		echo "fail";
		//header('Location: profile.php');
		exit;
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Update User Info</title>
</head>
<body>
	<form method="post" action="updateuser.php">
		<table>
			<tr>
				<td>
					<label for="name">Name:</label> 
				</td>
				<td>
					<input type="text" name="username" value="<?= $user->username ?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="pass">Password:</label> 
				</td>
				<td>
					<input type="text" name="pass" value="">
					<span>only enter if you want to change</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="email">Email:</label> 
				</td>
				<td>
					<input type="text" name="email" value="<?= $user->email ?>">
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<input type="submit" name="submit" value="save">
					<a href="profile.php">cancel</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>