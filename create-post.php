<?php
	require_once 'app/bootstrap.php';

	$user = new User();

    $page_title = 'Simple Blog - Create New Post';

    if(!$user->isLoggedIn()) {
    	Redirect::to('index.php');
    }

    if(Input::exist() && $user->isLoggedIn()) {
    	$validate = new Validate();
        $validation = $validate->check($_POST, array(
            'title' => array('required' => true),
            'content' => array('required' => true)
        ));

        if($validation->passed()) {
            $post = new Post();

	        try {

	            $post->create(array(
	                'title' => Input::get('title'),
	                'content' => Input::get('content'),
	                'user_id' => $user->data()['id'],
	                'created_at' => date("Y-m-d H:i:s")
	            ));
	            Session::flash('posts', 'Post successfully created.');

	            Redirect::to('posts.php');
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
						<h1>Create New Post</h1>
					</div>
				</div>
			</div>
		</div>
	</header>

    <!-- Main Content -->
    <div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-10 mx-auto">
				<?php if(isset($errors)): ?>
                	<div class="bg-danger validation-errors">
                		<ul>
                			<?php foreach($errors as $error): ?>
                				<li><?php echo $error; ?></li>
                			<?php endforeach; ?>
                		</ul>
                	</div>
                <?php endif; ?>
				<form id="createPostForm" method="POST" action="" novalidate autocomplete="off">
					<div class="form-group">
						<input type="text" name="title" class="form-control" placeholder="Title" id="title">
					</div>
					<div class="form-group">
						<textarea id="content" name="content" style="display:none;"></textarea>
					</div>
		            <br/>
		            <div class="form-group">
		              <button type="submit" class="btn btn-primary">Submit Post</button>
		            </div>
		        </form>
			</div>
		</div>
    </div>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>
    <script>
    	$(function (){
    		$('#content').show();
    		$('#content').summernote({
				height: 300,
				popover: {
					image: [],
					link: [],
					air: []
				}
			});
    	});
    </script>
	</body>
</html>
