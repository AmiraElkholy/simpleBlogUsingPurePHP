<?php 
	require_once 'functions.php';
	session_start();

	if(isset($_SESSION['loggeduser'])) {
		$user = $_SESSION['loggeduser'];
		echo "hello , ".$user->username;
		//fetch all post by current logged user
		$post = new post();
		$posts = $post->selectbyuser($user->id);

	}

	else {
		header('Location: login.php?error=you are not logged in, please log in first');
		exit;
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>My Profile</title>
</head>
<body>

		<br><br>
		<a href="index.php">Go To Main Page</a>

		<br/><br/>
		<?php if($posts):?>
			<h2>your posts</h2>
			<table style="text-align: center;" border="2">
				<thead>
					<tr>
						<td>id</td>
						<td>title</td>
						<td>content</td>
					</tr>
				</thead>
				<tbody>

					<?php 
						foreach ($posts as $post) {
							echo "<tr>";
							echo "<td>".$post->id."</td>";
							echo "<td>".$post->title."</td>";
							echo "<td>".$post->content."</td>";
							echo "<td>";
					?>

								<a href="editpost.php?id=<?= $post->id ?>">edit</a>
								<a href="deletepost.php?id=<?= $post->id ?>">delete</a>

					<?php   echo"</td>";
							echo "</tr>";
						}	
					?>	


				</tbody>
			</table>
		<?php endif;?>

		<br>
		<a href='newpost.php' style='text-align:center;'>Create New Post</a>

		<br>

		<br><a href='update.php' style='text-align:center;'>Update Profile Info</a>
		<br><a href='logout.php' style='text-align:center;'>Logout</a>

</body>
</html>