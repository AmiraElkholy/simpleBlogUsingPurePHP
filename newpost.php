<?php 
	require_once 'functions.php';
	session_start();

	if(isset($_GET['error'])) {
		echo "<p class='error'>".$_GET['error']."</p>";
	}

	if(isset($_SESSION['loggeduser'])) {

		if($_POST) {

			$post = new post();

			if(isset($_SESSION['loggeduser'])) {
				$loggeduser = $_SESSION['loggeduser'];
				$post->user_id = $loggeduser->id;
			}
			
			if(isset($_POST['title'])&&!empty($_POST['title']))
				$post->title = $_POST['title'];
			else {
				header('Location: newpost.php?error=title cant be empty');
			}
			if(isset($_POST['content'])&&!empty($_POST['content']))
				$post->content = $_POST['content'];
			else {
				header('Location: newpost.php?error=content cant be empty');
			}


			$state = $post->insert();

			if($state) {
				//echo "success";
				header('Location: profile.php');
			}
			else {
				header('Location: newpost.php?error=failed to create new post');
			}
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
	<title>Registeration</title>
	<style type="text/css">
		.error {
			background-color: pink;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid red;
		}
		.message {
			background-color: lightblue;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid blue;
		}
		textarea {
			width: 400px;
			height: 250px;
		}
	</style>
</head>
<body>
	<form method="post" action="newpost.php">
		<table>
			<tr style="text-align: center;">
				<td colspan="2">Create New Post</td>
			</tr>
			<tr>
				<td>
					<label for="title">Title:</label> 
				</td>
				<td>
					<input type="text" name="title">
				</td>
			</tr>
			<tr>
				<td>
					<label for="content">content:</label> 
				</td>
				<td>
					<textarea name="content"></textarea>
				</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">
					<input type="submit" name="submit" value="Create Post">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>