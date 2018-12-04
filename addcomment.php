<?php 
	require_once 'functions.php';
	session_start();

	//if(isset($_SESSION['loggeduser'])) {

		if($_POST) {

			$comment = new comment();

			if(isset($_SESSION['loggeduser'])) {
				$loguser = $_SESSION['loggeduser'];
				$comment->user_id = $loguser->id;
			}
			else {
				$comment->user_id = null;
			}

			if(isset($_POST['post_id']))
				$comment->post_id = (int) $_POST['post_id'];
			
			if(isset($_POST['title'])&&!empty($_POST['title']))
				$comment->title = $_POST['title'];
			else {
				header('Location: index.php?error=title cant be empty');
			}
			if(isset($_POST['content'])&&!empty($_POST['content']))
				$comment->content = $_POST['content'];
			else {
				header('Location: index.php?error=content cant be empty');
			}


			$state = $comment->insert();

			if($state) {
				//echo "success";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
			else {
				header('Location: index.php?error=failed to add new comment');
			}
		}
	//}

	// else {
		
	// 	exit;
	// }

?>



