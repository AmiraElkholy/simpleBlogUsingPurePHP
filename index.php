<?php  
	require_once "functions.php";
	session_start();

	$post = new post();
	$posts = $post->selectAll();

	if(isset($_GET['error'])) {
		echo "<p class='error'>".$_GET['error']."</p>";
	}

	if(isset($_SESSION['loggeduser'])) {
		$loguser = $_SESSION['loggeduser'];
	}
	else {
		$loguser = false;
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Index Page</title>
	<style type="text/css">
		h1 {
			font-family: verdana;
			font-size: 50px;
		}
		h2 {
			font-family: verdana;
			font-size: 35px;
		}
		p {
			font-size: 20px;
		}
		.error {
			background-color: pink;
			color: white;
			width: 800px;
			padding: 10px;
			border: 1px solid red;
		}
		input[type="text"] {
			margin-top: 3px;
		}
		span {
			font-size: smaller;
		}
		h4 {
			margin-bottom: 0px !important;
		}
		span {
			color: grey;
			display: inline-block;
		} 
		span span {
			color: black;
		}
	</style>
</head>
<body>

	<?php if($posts):?>
			<h1>ITI Blog Posts</h1>
			<hr>
				<?php 
					foreach ($posts as $post) {
						echo "<article>";
						echo "<h2>".$post->title."</h2>";
						echo "<p>".substr($post->content, 0, 100).' '.'<a href="showpost.php?id='.$post->id.'">read more..</a>'."</p>";
				?>

				<?php if($loguser&&$loguser->id===$post->user_id): ?>
					<a href="editpost.php?id=<?= $post->id ?>">edit</a>
					<a href="deletepost.php?id=<?= $post->id ?>">delete</a>
				<?php endif; ?>

				<br><br>
				
				<br>

				<?php
					//grab comments , for this specific post 
					$comments = new comment();
					$comments = $comments->selectbypost($post->id);

					if($comments) {
						echo "<h4>commetns: </h4>";
						foreach($comments as $comment) {
							//grab user/visitor who wrote comment ..
							$commuser = new user();
							if($comment->user_id !== null) {
								$commuser = $commuser->selectbyid($comment->user_id);
							}
							else {
								$commuser->username = "visitor";
							}
							echo "<span>";
							echo "<span>title:</span> &nbsp;".$comment->title;
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							echo " <span>";
							echo "by : ".$commuser->username;
							echo " at: ".$comment->stamp_created;
							echo "</span>";
							echo "<br>";
							echo $comment->content;
							echo "</span>";
							echo "<br>";
						}
					}
				?>

			<!-- <?php //if($loguser):?> -->

				<form method="post" action="addcomment.php">
					<input type="hidden" name="post_id" value="<?= $post->id?>">
					<table>
						<tr>
							<td>
								<input type="text" name="title" placeholder="comment title">
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="content" placeholder="write your comment here" cols="33"></textarea>
							</td>
						</tr>
						<tr style="text-align: center;">
							<td colspan="2">
								<input type="submit" name="submit" value="add comment">
							</td>
						</tr>
					</table>
				</form>

			<!-- <?php //endif; ?> -->
					
					<br>
					<br>
				<?php  	
					echo "<hr>";
					echo "</article>";
					}	
				?>	
		<?php endif;?>

		<br><br>
		<?php if($loguser): ?>
			<a href="logout.php">Logout</a>
		<?php endif; ?>

</body>
</html>