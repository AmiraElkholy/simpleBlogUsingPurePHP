<?php 
	require_once 'functions.php';
	session_start();

	if(isset($_SESSION['loggeduser'])) {
		$user = $_SESSION['loggeduser'];
		session_destroy();
		header('Location: login.php?message=you are logged out ,,');
		exit;
	}
	if(isset($_COOKIE['username'])) {
		setcookie('username','',time()-(10*60*60));
	}

	else {
		header('Location: login.php?error=you are not logged in, please log in first');
		exit;
	}

?>