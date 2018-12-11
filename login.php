<?php
	require_once 'app/bootstrap.php';

	$user = new User();
    if($user->isLoggedIn()) {
    	Redirect::to('index.php');
    }

    $page_title = "Simple Blog - Sign In";

    if(Input::exist()) {
    	$validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array('required' => true),
            'password' => array('required' => true)
        ));

        if($validation->passed()) {
            $user = new User();
            $login = $user->login(Input::get('email'), Input::get('password'));

            if($login) {
                Redirect::to('index.php');
            } else {
            	$errors = ['Login failed.'];
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
						<h1>Sign In</h1>
					</div>
				</div>
			</div>
		</div>
	</header>

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
				<form method="post"  role="form" action="" novalidate autocomplete="off">

					<?php if(Session::exists('home')): ?>
						<div class="alert alert-success" role="alert">
							<?php echo '<p>' . Session::flash('home') . '</p>' ; ?>
						</div>
					<?php endif; ?>
					 
					 <div class="form-group">
					 	<label for="exampleInputEmail1">Email address</label>
					    	<input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?php echo escape(Input::get('email')); ?>" placeholder="Enter your Email" >
					 </div>
					 <div class="form-group">
					    <label for="exampleInputPassword1">Password</label>
					    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" >
					 </div>
					 <button type="submit" class="btn btn-primary">Sign In</button>
					 </br>
				</form>
			</div>
		</div>
	</div>

    <?php include('./partials/footer.php'); ?>

    <?php include('./partials/scripts.php'); ?>
	</body>
</html>
