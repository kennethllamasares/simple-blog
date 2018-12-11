<?php
	require_once 'app/bootstrap.php';

	$user = new User();

	$db = new Database();

	if(Input::exist() && $user->isLoggedIn()) {
		$id = $_POST['id'];

		$post = $db->row("SELECT posts.user_id, posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.id=:id", ['id' => $id]);

		if($post) {

	   		if($post['user_id'] == $user->data()['id']) {
	   			$p = new Post();
	   			$p->delete($post['id']);
	   			echo json_encode(['message' => 'Post successfully deleted.', 'success' => true]);
	   			exit();
	   		}
   		}

		echo json_encode(['message' => 'Something went wrong. Unable to delete post.', 'success' => false]);
		exit();
	}
?>