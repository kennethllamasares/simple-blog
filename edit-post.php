<?php
	require_once 'app/bootstrap.php';

	$user = new User();

	$db = new Database();

    $page_title = 'Simple Blog - Edit Post';

    if(!$user->isLoggedIn()) {
    	Redirect::to('index.php');
    }

    if(isset($_GET['id'])) {
    	$id = $_GET['id'];

   		$post = $db->row("SELECT posts.user_id, posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.id = :id", ['id' => $id]);

   		if(!$post) {
	   		Redirect::to('index.php');
	   	}
    } else {
    	Redirect::to('index.php');
    }

    if(!empty($_POST)) {
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
		    'title' => array('required' => true),
		    'content' => array('required' => true)
		));

		if($validation->passed() && ($post['user_id'] == $user->data()['id'])) {
		    $p = new Post();

		    try {
		        $p->update($post['id'], array(
		            'title' => Input::get('title'),
		            'content' => Input::get('content'),
		            'user_id' => $user->data()['id'],
		            'updated_at' => date("Y-m-d H:i:s")
		        ));
		        Session::flash('post', 'Post successfully updated.');
		        Redirect::to('edit-post.php?id=' . $post['id']);
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
						<h1>Edit Post</h1>
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
                <?php if(Session::exists('post')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo '<p>' . Session::flash('post') . '</p>' ; ?>
					</div>
				<?php endif; ?>
				<form id="createPostForm" method="POST" action="" novalidate autocomplete="off">
					<div class="form-group">
						<input type="text" name="title" class="form-control" placeholder="Title" id="title" value="<?php echo $post['title']; ?>">
					</div>
					<div class="form-group">
						<textarea id="content" name="content" style="display:none;">
							<?php echo $post['content']; ?>
						</textarea>
					</div>
		            <br/>
		            <div class="form-group">
		              <button type="submit" class="btn btn-primary">Update Post</button>
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
