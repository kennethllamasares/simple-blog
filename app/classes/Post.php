<?php
	class Post {
		private $_db,
				$_data;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
		}

		public function create($fields = array()) {
			if(!$this->_db->insert('posts', $fields)) {
				throw new Exception('Something went wrong. Unable to create post.');
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
			if(!$this->_db->update('posts', $id, $fields)) {
				throw new Exception('Something went wrong. Unable to update post.');
			}
		}

		public function delete($where) {
			if(!$this->_db->delete('posts', $where)) {
				throw new Exception('Something went wrong. Unable to delete post.');
			}
		}

		public function data() {
			return $this->_data;
		}

	}

?>