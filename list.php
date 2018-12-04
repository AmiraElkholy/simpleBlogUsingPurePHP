<?php
	require_once 'functions.php';
	session_start();

	if(isset($_SESSION['loggeduser'])) {
		$loguser = $_SESSION['loggeduser'];
		
		if($loguser->username === "admin") {
			$usr = new user();
			$users = $usr->selectAll();
		}
		else {
			header('Location: login.php?error=you are not allowed access.. ');
			exit;
		}		
	}
	else {
		header('Location: login.php?error=you are not logged in, please log in first');
		exit;
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
	<style type="text/css">
		.error {
			background-color: pink;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid red;
		}
	</style>
</head>
<body>
	<a href="register.php">create new user</a>
	<table>
		<tr>
			<td>id</td>
			<td>Username</td>
			<td>Email</td>
			<td>Pass</td>
		</tr>		


		<?php 
			foreach ($users as $user) {
				echo "<tr>";
				echo "<td>".$user->id."</td>";
				echo "<td>".$user->username."</td>";
				echo "<td>".$user->email."</td>";
				echo "<td>".$user->pass."</td>";
				echo "<td>";
		?>

					<a href="delete.php?id=<?= $user->id ?>">delete</a>

		<?php   echo"</td>";
				echo "</tr>";
			}	
		?>

	</table>
	<p><a href="logout.php">Logout</a></p>
</body>
</html>