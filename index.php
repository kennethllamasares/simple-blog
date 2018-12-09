<?php
	require_once 'app/bootstrap.php';

	$user = new User();

    $page_title = 'Simple Blog - a place to read and write big ideas and important stories';

    $posts = DB::getInstance()->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id");
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<?php include('./partials/head.php'); ?>

	</head>

  <body>

    <?php include('./partials/nav.php'); ?>

	<!-- Page Header -->
	<header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<div class="site-heading">
						<h1>Simple Blog</h1>
						<span class="subheading">A place to read and write big ideas and important stories</span>
					</div>
				</div>
			</div>
		</div>
	</header>

    <!-- Main Content -->
    <div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-10 mx-auto">
				<?php if(!$posts->count()): ?>
					<p class="text-center">No posts available.</p>
				<?php else: ?>
					<?php foreach($posts->results() as $post): ?>
						<div class="post-preview">
							<a href="post.php?title=<?php echo str_slug($post->title); ?>">
								<h2 class="post-title">
									<?php echo $post->title; ?>
								</h2>
								<h3 class="post-subtitle">
									<?php echo substr(strip_tags($post->content), 0, 200); ?>
								</h3>
							</a>
							<p class="post-meta">Posted by
								<a><?php echo $post->author; ?></a>
								on <?php echo date("F d, Y", strtotime($post->created_at)); ?>
							</p>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<hr>
			</div>
		</div>
    </div>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>

	</body>
</html>
