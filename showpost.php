<?php  
	require_once "functions.php";
	session_start();

	if(isset($_GET['id'])) {
		$post = new post();
		$id = $_GET['id'];
		$post = $post->selectbyid($id);

		if(!$post) {
			echo "Error, no such post !";
			exit;
		}

		$user = new user();
		$user = $user->selectbyid($post->user_id);

		if(!$user) {
			echo "error displaying post";
			exit;
		}
	}
	else {
		echo "Error, No Post chosen to display !!";
		exit;
	}


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
	<title><?= $post->title?></title>
	<style type="text/css">
		h2 {
			font-family: verdana;
			font-size: 50px;
		}
		p {
			font: verdana bold;
			font-size: 30px;
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
	<article>
		<h2><?= $post->title ?></h2>
		<p><?= $post->content ?></p>
		<br><br>
		<table>
			<tr>
				<td>Created By:</td>
				<td><?= $user->username ?></td>
			</tr>
			<tr>
				<td>At :</td>
				<td> <?= $post->stamp_created ?></td>
			</tr>
			<tr>
				<td>Last Modified :</td>
				<td><?=	$post->stamp_updated ?></td>
			</tr>
		</table>
		<br>


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
							//grab user who wrote comment ..
							$commuser = new user();
							$commuser = $commuser->selectbyid($comment->user_id);
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

			<?php if($loguser):?>

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

			<?php endif; ?>
			<br>
		<a href="index.php">back to main page</a>
	</article>
</body>
</html>