<?php
	class Comment {
		private $_db,
				$_data;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
		}

		public function create($fields = array()) {
			if(!$this->_db->insert('comments', $fields)) {
				throw new Exception('Something went wrong. Unable to create comment.');
			}
		}

		public function find($id) {
			if($id) {
				$data = $this->_db->get('comments', array('id', '=', $id));
				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function update($id, $fields) {
			if(!$this->_db->update('comments', $id, $fields)) {
				throw new Exception('Something went wrong. Unable to update comment.');
			}
		}

		public function delete($where) {
			if(!$this->_db->delete('comments', $where)) {
				throw new Exception('Something went wrong. Unable to delete comment.');
			}
		}

		public function data() {
			return $this->_data;
		}

	}

?>