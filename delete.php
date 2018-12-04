<?php 
	require_once 'functions.php';
	session_start();
	require('config.php');


	if(isset($_SESSION['loggeduser'])) {
		
		$loguser = $_SESSION['loggeduser'];

		if($loguser->username === "admin") {
		
			$user = new user();

			$user->id = $_GET['id'];

			$state =  $user->delete();

			if($state) {
				echo "success";
				header('Location: list.php');
			}

			else {
				echo "Error in Deleting User .. ";
			 	echo "<br>";
			 	echo "<a href='list.php'>Back</a>";
			}
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