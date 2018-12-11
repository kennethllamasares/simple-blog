<?php
	class User {
		private $_db,
				$_data,
				$_sessionName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = new Database();
			$this->_sessionName = Config::get('session/session_name');

			if (!$user) {
				if(Session::exists($this->_sessionName)) {
					$user = Session::get($this->_sessionName);
					if($this->find($user)) {
						$this->_isLoggedIn = true;
					}
				}
			}
		}

		public function create($fields = array()) {
			$keys = array_keys($fields);
			$values = [];

			foreach ($fields as $field => $value) {
				array_push($values, ":{$field}");
			}

			$sql = "INSERT INTO users (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ")";

			if(!$this->_db->query($sql, $fields)) {
				throw new Exception('Something went wrong. Unable to create an account.');
			}
		}

		public function find($user = null) {
			if($user) {
				$field = is_numeric($user) ? 'id' : 'email';

				$sql = "SELECT * FROM users";

				if($field == 'email') {
					$sql .= " WHERE email=:email";
				} else {
					$sql .= " WHERE id=:id";
				}

				$this->_db->bind($field, $user);
				$data = $this->_db->row($sql);

				if($data) {
					$this->_data = $data;
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

			$sql = "UPDATE users SET {$set} WHERE id = :id";
			
			$fields['id'] = $id;

			$this->_db->query($sql, $fields);
		}

		public function login($email = null, $password = null) {

			$user = $this->find($email);
			if($user) {
				if($this->data()['password'] === md5($password)) {
					Session::put($this->_sessionName, $this->data()['id']);
					return true;
				}	
			}
			//print_r( $this->_data);
			return false;
		}

		public function logout() {
			Session::delete($this->_sessionName);
		}

		public function data() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}
?>