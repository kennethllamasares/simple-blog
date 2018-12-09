<?php
	require_once 'app/bootstrap.php';

	$user = new User();

	$search = null;

   	if(isset($_GET['title'])) {
   		$title = str_slug($_GET['title'], ' ');

   		$search = DB::getInstance()->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.title = ?", [$title]);
   	} elseif (isset($_GET['id'])) {
   		$id = $_GET['id'];

   		$search = DB::getInstance()->query("SELECT posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.id = ?", [$id]);
   	} else {
   		Redirect::to('index.php');
   	}

   	if(!$search || !$search->count()) {
   		Redirect::to('index.php');
   	}

   	$post = $search->first();

   	$page_title = 'Simple Blog | ' . $post->title;

   	$comments = DB::getInstance()->query("SELECT comments.id, comments.content, comments.created_at, users.name as author FROM comments LEFT JOIN users ON comments.user_id=users.id WHERE comments.post_id = ? ", [$post->id]);

   	if(Input::exist() && $user->isLoggedIn()) {
    	$validate = new validate();
        $validation = $validate->check($_POST, array(
            'comment' => array('required' => true)
        ));

        if($validation->passed()) {
            $comment = new Comment();

	        try {

	            $comment->create(array(
	                'content' => Input::get('comment'),
	                'post_id' => $post->id,
	                'user_id' => $user->data()->id,
	                'created_at' => date("Y-m-d H:i:s")
	            ));

	            // Session::flash('home', 'You have been registered and can now log in!');
	            
	            Redirect::to('post.php?title=' . str_slug($post->title, '-'));
	        } catch (Exception $e) {
	            die($e->getMessage());
	        }
        } else {
        	$errors = $validation->errors();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<?php include('./partials/head.php'); ?>

		<style>
			.comment-wrapper {
				margin-top: 20px;
			}
		</style>
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
						<h1><?php echo $post->title; ?></h1>
						<span class="subheading">Posted by <?php echo $post->author; ?> on <?php echo date("F d, Y", strtotime($post->created_at)); ?></span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Post Content -->
	<article>
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<?php echo $post->content; ?>
				</div>
			</div>

			<br/>
			<br/>
			<div class="row">
			    <div class="col-lg-8 col-md-10 mx-auto">
			        <div class="comment-wrapper">
			            <div class="panel panel-info">
			                <div class="panel-heading">
			                	<h3>Comment Panel</h3>
			                </div>
			                <div class="panel-body">
			                	<?php if($user->isLoggedIn()): ?>
			                		<?php if(isset($errors)): ?>
				                    	<div class="bg-danger validation-errors">
				                    		<ul>
				                    			<?php foreach($errors as $error): ?>
				                    				<li><?php echo $error; ?></li>
				                    			<?php endforeach; ?>
				                    		</ul>
				                    	</div>
				                    <?php endif; ?>
			                		<form method="post"  role="form" action="" novalidate>
				                		<textarea class="form-control" placeholder="write a comment..." rows="3" name="comment"></textarea>
					                    <br>
					                    <button type="submit" class="btn btn-info pull-right">Post</button>
				                	</form>
			                	<?php else: ?>
			                		<p><a href="login.php">Sign in</a> to leave a comment.</p>
			                	<?php endif; ?>
			                    
			                    <div class="clearfix"></div>
			                    <hr>

			                    <?php if(!$comments->count()): ?>
									<p class="text-center">No comments available.</p>
								<?php else: ?>
									<ul class="media-list">
										<?php foreach($comments->results() as $comment): ?>
											<li class="media">
					                            <div class="media-body">
					                                <span class="text-muted float-right">
					                                    <small class="text-muted"><?php echo dateDiff($comment->created_at, date("Y-m-d H:i:s")); ?></small>
					                                </span>
					                                <strong class="text-success"><?php echo $comment->author; ?></strong>
					                                <p><?php echo $comment->content; ?></p>
					                            </div>
					                        </li>
										<?php endforeach; ?>
				                    </ul>
								<?php endif; ?>
			                </div>
			            </div>
			        </div>

			    </div>
			</div>
		</div>
	</article>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>

  </body>
</html>
