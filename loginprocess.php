<?php
	require_once 'functions.php'; 
	session_start();
	require 'config.php';

	$user = new user();
	$user->username = $_POST['username'];
	$user->pass = sha1($_POST['pass']);

	$usr = $user->login();

	if($usr) {
		if($usr->username === "admin") {
			$_SESSION['loggeduser'] = $usr;
	 		header('Location: list.php');
	 		if(isset($_POST['remeber'])) {
				setcookie('username', $usr->username, time()+(60*60*24*30));
			}
		}
		else {
			$_SESSION['loggeduser'] = $usr;
	 		header('Location: profile.php');
	 		if(isset($_POST['remeber'])) {
				setcookie('username', $usr->username, time()+(60*60*24*30));
			}
		}
	}
	else {
		header('Location: login.php?error=your login failed, please check your username and password');
	}


?>