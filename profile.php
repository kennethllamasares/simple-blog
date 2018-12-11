<?php
	require_once 'app/bootstrap.php';

	$user = new User();

    $page_title = 'Simple Blog - Profile';

    if(!$user->isLoggedIn()) {
    	Redirect::to('index.php');
    }

    if(Input::exist() && $user->isLoggedIn()) {
    	$validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
	            'required' => true
	        ),
	        'email' => array(
	            'required' => true,
	            'valid' => true,
	            'unique:except' => 'users,' . $user->data()['id']
	        ),
        ));

        if($validation->passed()) {
            $u = new User();

	        try {

	            $u->update($user->data()['id'], array(
	                'name' => Input::get('name'),
	                'email' => Input::get('email')
	            ));
	            Session::flash('profile', 'Profile successfully updated.');

	            Redirect::to('profile.php');
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
						<h1>Profile</h1>
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
                <?php if(Session::exists('profile')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo '<p>' . Session::flash('profile') . '</p>' ; ?>
					</div>
				<?php endif; ?>
				<form id="createPostForm" method="POST" action="" novalidate autocomplete="off">
					<div class="form-group">
						<input type="text" name="name" class="form-control" placeholder="Name" id="name" value="<?php echo $user->data()['name']; ?>">
					</div>
					<div class="form-group">
						<input type="text" name="email" class="form-control" placeholder="Email Address" id="title" value="<?php echo $user->data()['email']; ?>">
					</div>
		            <br/>
		            <div class="form-group">
		              <button type="submit" class="btn btn-primary">Update</button>
		            </div>
		        </form>
			</div>
		</div>
    </div>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>
	</body>
</html>
