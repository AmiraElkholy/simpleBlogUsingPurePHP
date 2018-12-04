<?php 
	require_once 'functions.php';
	session_start();


	if(isset($_SESSION['loggeduser'])) {
		
		$loguser = $_SESSION['loggeduser'];

		$post = new post();

		if(!(isset($_GET['id']))) {
			echo "error , no post chosen to delete !";
			exit;
		}
		$id = $_GET['id'];
		$user_id = $loguser->id;

		$state =  $post->delete($id, $user_id);

		

		if($state) {
			echo "success";
			header('Location: profile.php');
		}

		else {
			echo "Error in deleting post .. ";
		 	echo "<br>";
		 	echo "<a href='profile.php'>Back</a>";
		}	

	}
	else {
		
		header('Location: login.php?error=you are not logged in, please log in first');
		exit;
	}

	
?>