<?php 
	require_once 'functions.php';
	session_start();
	
	
	if(isset($_SESSION['loggeduser'])) {
		$loguser = $_SESSION['loggeduser'];
	}
	else {
		header('Location: login.php?error=you are not logged in');
		exit;
	}

	$post = new post();
	
	$post->user_id = $loguser->id;
	
	if(isset($_POST['id'])&&!empty($_POST['id'])) 
        $post->id = $_POST['id'];

	if(isset($_POST['title'])&&!empty($_POST['title'])) 
        $post->title = $_POST['title'];
    
    if(isset($_POST['content'])&&!empty($_POST['content']))
        $post->content = $_POST['content'];

    

    $pst = $post->update();
	
    

    if($pst) {
    	// echo "success";
	 	header('Location: profile.php?message=post updated successfully');
    }
    else {
    	echo "Error in updating post .. ";
	 	echo "<br>";
	 	echo "<a href='profile.php'>Back to profile</a>";
    }


?>