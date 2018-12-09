<?php
	class Validate {
		private $_passed = false,
				$_errors = array(),
				$_db = null;

		public function __construct() {
			$this->_db = DB::getInstance();
		}

		public function check($source, $items = array()) {
			foreach($items as $item => $rules) {
				foreach($rules as $rule => $rule_value) {
					$value = $source[$item];
					$item = escape($item);
					if($rule === 'required' && empty($value)) {
						$this->addError("{$item} is required");
					} else if(!empty($value)) {
						switch($rule) {
							case 'valid':
								if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
				                    $this->addError('Invalid Email');
				                }
								break;

							case 'unique':
								$check = $this->_db->get($rule_value, array('email', '=', $value));
								if($check->count()) {
									$this->addError("{$item} already exists.");
								}
								break;

							case 'unique:except':
								$params = explode(',', $rule_value);

								// echo $params[1];
								// $check = $this->_db->get($params[0], array('email', '=', $value));
								$check = $this->_db->query("SELECT * FROM ". $params[0] . " WHERE email = ? AND id <> ?", [$value, $params[1]]);
								if($check->count()) {
									$this->addError("{$item} already exists.");
								}
								break;
							case 'matches':
								if($value != $source[$rule_value]) {
									$this->addError("Password and Confirmation Password doesn't match");
								}
								break;
						}
					}

					//echo "{$item} {$rule} must be {$rule_value}<br>"; 

				}	
			}

			if(empty($this->_errors)) {
				$this->_passed = true;
			}
			return $this;
		}

		private function addError($error) {
			$this->_errors[] = $error;
		}

		public function errors() {
			return $this->_errors;
		}

		public function passed() {
			return $this->_passed;
		}


	}
?>