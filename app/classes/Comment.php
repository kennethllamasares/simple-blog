<?php
	class Comment {
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

			$sql = "INSERT INTO comments (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";

			if(!$this->_db->query($sql, $fields)) {
				throw new Exception('Something went wrong. Unable to create comment.');
			}
		}

		public function data() {
			return $this->_data;
		}

	}

?>