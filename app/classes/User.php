<?php
	class User {
		private $_db,
				$_data,
				$_sessionName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
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
			if(!$this->_db->insert('users', $fields)) {
				throw new Exception('Something went wrong. Unable to create an account.');
			}
		}

		public function find($user = null) {
			if($user) {
				$field = (is_numeric($user)) ? 'id' : 'email';
				$data = $this->_db->get('users', array($field, '=', $user));

				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function update($id, $fields) {
			if(!$this->_db->update('users', $id, $fields)) {
				throw new Exception('Something went wrong. Unable to update user.');
			}
		}

		public function login($email = null, $password = null) {

			$user = $this->find($email);
			if($user) {
				if($this->data()->password === md5($password)) {
					Session::put($this->_sessionName, $this->data()->id);
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