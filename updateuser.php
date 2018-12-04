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

	$user = new user();
	
	$user->id = $loguser->id;
	
	if(isset($_POST['username'])&&!empty($_POST['username'])) 
        $user->username = $_POST['username'];
    
    if(isset($_POST['pass'])&&!empty($_POST['pass']))
        $user->pass = sha1($_POST['pass']);
    else 
        $user->pass = $loguser->pass;
    
    if(isset($_POST['email'])&&!empty($_POST['email']))
        $user->email = $_POST['email'];

    $usr = $user->update();
	
    if($usr) {
    	$_SESSION['loggeduser'] = $usr;
	 	header('Location: profile.php?message=updated successfully');
    }
    else {
    	echo "Error in Updating User .. ";
	 	echo "<br>";
	 	echo "<a href='update.php'>Back to Update Page</a>";
    }


?>