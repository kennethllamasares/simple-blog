<?php
	require_once 'app/bootstrap.php';
	
	$user = new User();
	$user->logout();
	// session_destroy();
	Session::flash('home', 'You have been logged out!');
	Redirect::to('login.php');

?>