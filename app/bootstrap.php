<?php

	session_start();

	date_default_timezone_set("Asia/Manila");

	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'db' => 'simple_blog'
		),
		'session' => array(
			'session_name' => 'user',
			'token_name' => 'token'
		)
	);

	//autoloods the class that is used
	spl_autoload_register(function($class) {
		require_once 'app/classes/' . $class . '.php';
	});

	//loads sanitize.php
	require_once 'functions/sanitize.php';
	require_once 'functions/string.php';
?>

