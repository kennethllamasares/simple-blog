<?php
	require_once 'app/bootstrap.php';

	$user = new User();
    if($user->isLoggedIn()) {
    	Redirect::to('index.php');
    }

    $page_title = "Simple Blog - Become a member";

    if(Input::exist()) {
		$validate = new Validate();
	    $validation = $validate->check($_POST, array(
	        'name' => array(
	            'required' => true
	        ),
	        'email' => array(
	            'required' => true,
	            'valid' => true,
	            'unique' => 'users'
	        ),
	        'password' => array(
	            'required' => true
	        ),
	        'password_confirmation' => array(
	            'required' => true,
	            'matches' => 'password'
	        )
	    ));

	    if($validation->passed()) {
	        //echo 'passed';
	        $u = new User();

	        try {

	            $u->create(array(
	                'name' => Input::get('name'),
	                'email' => Input::get('email'),
	                'password' => md5(Input::get('password'))
	            ));

	            Session::flash('home', 'You have been registered and can now log in!');
	            
	            Redirect::to('login.php');
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
						<h1>Sign Up</h1>
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
				<form method="post" role="form" action="" autocomplete="off">
					<div class="form-group">
						<label for="yourName">Name<span class="required">*</span>:</label>
						<input type="text" name="name" class="form-control" id="yourName" value="<?php echo escape(Input::get('name')); ?>" placeholder="Enter your Name" maxlength="50" >
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email address<span class="required">*</span>:</label>
						<input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?php echo escape(Input::get('email')); ?>" placeholder="Enter your Email" maxlength="50" >
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password<span class="required">*</span>:</label>
						<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" maxlength="50" >
					</div>
					<div class="form-group">
						<label for="repeatPassword">Re-enter Password<span class="required">*</span>:</label>
						<input type="password" name="password_confirmation" class="form-control" id="repeatPassword" placeholder="Repeat Password" maxlength="50" >
					</div>
	                 
	                <button type="submit" class="btn btn-primary">Sign Up</button>
	                </br>
				</form>
			</div>
		</div>
	</div>

    <?php include('./partials/footer.php'); ?>
    <?php include('./partials/scripts.php'); ?>
	</body>
</html>