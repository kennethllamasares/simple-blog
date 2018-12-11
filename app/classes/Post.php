<?php
	class Post {
		private $_db,
				$_data;

		public function __construct($user = null) {
			$this->_db = new Database();
		}

		public function create($fields = array()) {
			$keys = array_keys($fields);
			$values = [];

			foreach ($fields as $field => $value) {
				array_push($values, ":{$field}");
			}

			$sql = "INSERT INTO posts (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";

			if(!$this->_db->query($sql, $fields)) {
				throw new Exception('Something went wrong. Unable to create a post.');
			}
		}

		public function find($post = null) {
			if($post) {
				$field = (is_numeric($post)) ? 'id' : 'title';
				$data = $this->_db->get('posts', array($field, '=', $post));
				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function update($id, $fields) {
			$set = '';
			$x = 1;

			foreach ($fields as $field => $value) {
				$set .= "{$field} = :{$field}";
				if($x < count($fields)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE posts SET {$set} WHERE id = :id";

			$fields['id'] = $id;

			$this->_db->query($sql, $fields);
		}

		public function delete($id) {
			if(!$this->_db->query('DELETE FROM posts WHERE id=:id', ['id' => $id])) {
				throw new Exception('Something went wrong. Unable to delete post.');
			}
		}

		public function data() {
			return $this->_data;
		}

	}

?>