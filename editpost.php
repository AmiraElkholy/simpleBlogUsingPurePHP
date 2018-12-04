<?php
	require_once 'functions.php';
	session_start();
	require 'config.php';

	if(!(isset($_GET['id']))) {
		echo "no post is chosen !";
		exit;
	}
	
	if(isset($_SESSION['loggeduser'])) {
		$loguser = $_SESSION['loggeduser'];
	}
	else {
		header('Location: login.php?error=you are not logged in');
		exit;
	}

	$pst = new post();

	$pst->id = $_GET['id'];
	$pst->user_id = $loguser->id;

	$post = $pst->selectbyidanduserid($pst->id, $loguser->id);

	// var_dump($post);
	// die;

	if(!$post) {
		echo "no post of yours by this id";
		//header('Location: profile.php');
		exit;
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit post</title>
	<style type="text/css">
		textarea {
			width: 400px;
			height: 250px;
		}
	</style>
</head>
<body>
	<form method="post" action="editpostproccess.php">
		<input type="hidden" name="id" value="<?= $post->id; ?>">
		<table>
			<tr style="text-align: center;">
				<td colspan="2">Create New Post</td>
			</tr>
			<tr>
				<td>
					<label for="title">Title:</label> 
				</td>
				<td>
					<input type="text" name="title" value="<?= $post->title; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="content">content:</label> 
				</td>
				<td>
					<textarea name="content"><?= $post->content; ?></textarea>
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<input type="submit" name="submit" value="Update post">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>