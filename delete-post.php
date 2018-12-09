<?php
	require_once 'app/bootstrap.php';

	$user = new User();

	if(Input::exist() && $user->isLoggedIn()) {
		$id = $_POST['id'];

		$search = DB::getInstance()->query("SELECT posts.user_id, posts.id, posts.title, posts.content, posts.created_at, users.name as author FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.id=?", [$id]);

		if($search->count()) {
	   		$post = $search->first();

	   		if($post->user_id == $user->data()->id) {
	   			$p = new Post();
	   			$p->delete(['id', '=', $post->id]);
	   			echo json_encode(['message' => 'Post successfully deleted.', 'success' => true]);
	   			exit();
	   		}
   		}

		echo json_encode(['message' => 'Something went wrong. Unable to delete post.', 'success' => false]);
		exit();
	}
?>