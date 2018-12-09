<?php
	require_once 'app/bootstrap.php';

	$user = new User();

    $page_title = 'Simple Blog - My Posts';

    $posts = DB::getInstance()->query("SELECT posts.id, posts.title, posts.content, posts.created_at, posts.updated_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.user_id = ?", [$user->data()->id]);
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<?php include('./partials/head.php'); ?>

	</head>

  <body>

    <?php include('./partials/nav.php'); ?>

	<!-- Page Header -->
	<header class="masthead">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<div class="site-heading">
						<h1>My Posts</h1>
					</div>
				</div>
			</div>
		</div>
	</header>

    <!-- Main Content -->
    <div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-10 mx-auto">
				<a href="create-post.php" class="btn btn-primary">Create New Post</a>
				<br>
				<br>
				<?php if(Session::exists('posts')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo '<p>' . Session::flash('posts') . '</p>' ; ?>
					</div>
				<?php endif; ?>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Date Created</th>
								<th>Last Modified</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!$posts->count()): ?>
								<tr>
									<td colspan="4">No posts available.</td>
								</tr>
							<?php else: ?>
								<?php foreach($posts->results() as $post): ?>
									<tr>
										<td><a href="post.php?title=<?php echo str_slug($post->title); ?>"><?php echo $post->title?></a></td>
										<td><?php echo dateDiff($post->created_at, date("Y-m-d H:i:s"));?></td>
										<td><?php echo $post->updated_at ? dateDiff($post->updated_at, date("Y-m-d H:i:s")) : '-';?></td>
										<td>
											<a href="edit-post.php?id=<?php echo $post->id; ?>">Edit</a>
											<a class="delete-post" href="javascript:void(0);" data-id="<?php echo $post->id; ?>">Delete</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				
				<hr>
			</div>
		</div>
    </div>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>
    <script>
    	$(function (){
    		$(document).on('click', '.delete-post', function (e) {
    			e.preventDefault();

    			if (confirm("Are you sure you want to delete this post?")) {
					$.post('delete-post.php', {id: $(this).data('id')}).done(function (data) {

						var response = JSON.parse(data);

						if(response.success == true) {
							window.location.reload();
						} else {
							alert(response.message);
						}
					});
				}

    			return false;
    		});
    	});
    </script>
	</body>
</html>
