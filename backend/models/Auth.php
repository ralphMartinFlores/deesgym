<?php
    class Authentication {
        protected $pdo, $gm;

        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
            $this->gm = new GlobalMethods($pdo);
        }

        function encryptPassword($password): ?string {
            $hashFormat = "$2y$10$";
            $saltLength = 22;
            $salt = $this->generateSalt($saltLength);
            return crypt($password, $hashFormat.$salt);
        }

        function generateSalt($length): ?string {
            $urs = md5(uniqid(mt_rand(), true));
            $b64String = base64_encode($urs);
            $mb64String = str_replace('+', '.', $b64String);
            return substr($mb64String, 0, $length);
        }

		# JWT
		protected function generateHeader() {
			$h = [
				"typ"=>"JWT",
				"alg"=>"HS256",
				"app"=>"My App",
				"dev"=>"The Developer"
			];
			return str_replace("=", "", base64_encode(json_encode($h)));
		}

		protected function generatePayload($uc, $ue, $ito) {
			$p = [
				"uc"=>$uc,
				"ue"=>$ue,
				"ito"=>$ito,
				"iby"=>"The Developer",
				"ie"=>"thedeveloper@test.com",
				"exp"=>date("Y-m-d H:i:s") //date_create()
			];
			return str_replace("=", "", base64_encode(json_encode($p)));
		}

		protected function generateToken($usercode, $useremail, $fullname) {
			$header = $this->generateHeader();
			$payload = $this->generatePayload($usercode, $useremail, $fullname);
			$signature = hash_hmac("sha256", "$header.$payload", base64_encode(SECRET));
			return "$header.$payload." .str_replace("=", "", base64_encode($signature));
		}

		#./JWT

		public function isAuthorized($user_id, $token) {
			$sql = "SELECT fld_token FROM users_tbl WHERE fld_id = $user_id";
			return $this->checkAuthorization($sql, $token);
		}

		public function checkAuthorization($sql, $signature) {
			if($result = $this->conn->query($sql)) {
				if($result->num_rows>0) {
					$rec = $result->fetch_assoc();
					$token_arr = explode('.', $rec['fld_token']);
					if($token_arr[2] == $signature) {
						return true;
					}
					return false;
				}
			}
		}

		public function showToken($data){
			$user_data = []; 
			foreach ($data as $key => $value) {
				array_push($user_data, $value);
			}
			return $this->generateToken($user_data[1], $user_data[2], $user_data[3]);
		}

        // Account Registration
        public function registerAccount($table, $dt) {
			$this->sql="SELECT * FROM $table WHERE user_email = '$dt->user_email' LIMIT 1";

			try {
				if(!$res = $this->pdo->query($this->sql)->fetchColumn()>0) {
					$encryptedPassword = $this->encryptPassword($dt->user_password);
					$dt->user_password = $encryptedPassword;
					$response = $this->gm->insert($table, $dt);
					if ($response['code'] === 200) {
						$id = $this->pdo->lastInsertId();
						return $this->gm->insert("carts_tbl", ["user_id" => $id]);
					}
				}

				http_response_code(401);
				$data = array(); $code = 401; $msg = "Email Address already exist"; $remarks = "failed";

			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}

			// return $this->sendPayload($data, $remarks, $msg, $code);
        }


        // Login Account
        public function login($table, $dt) {
            $this->sql = "SELECT * FROM $table WHERE user_username = '$dt->param1' LIMIT 1";

			try {
				if ($res = $this->pdo->query($this->sql)->fetchColumn()>0) {
					$result=$this->pdo->query($this->sql)->fetchAll();

					$data = array(); $code = 0; $msg = ""; $remarks = "";
					foreach ($result as $rec) { 
						if($this->passwordCheck($dt->param2, $rec['user_password'])){
							$code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";

                            $uc = $rec['user_id'];
                            $ue = $rec['user_username'];
                            $tk = $this->generateToken($uc, $ue, $ue);
                            $toke_arr = explode('.', $tk);

                            $sql = "UPDATE user_tbl SET user_token='$tk' WHERE user_id='$uc'";
                            $this->pdo->query($sql);

							$data = array(
								"id" => $rec['user_id'],
								"username" => $rec['user_username'],
                                'key' => $toke_arr[2]
							);

						} else{
							$data = array(); $code = 401; $msg = "Incorrect Password"; $remarks = "failed";
						}
					}
				} else{
					http_response_code(401);
					$data = array(); $code = 401; $msg = "User does not exist"; $remarks = "failed";
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
			return $this->sendPayload($data, $remarks, $msg, $code);
        }
        
        function passwordCheck($pw, $existingpw){
			$hash=crypt($pw, $existingpw);
			return ($hash === $existingpw) ? true : false;	
		}


		// Change Password
		public function changePassword($table, $dt, $id) {
			$this->sql = "SELECT * FROM $table WHERE fld_id = $id";

			try {
				if ($res = $this->pdo->query($this->sql)->fetchColumn()>0) {
					$result=$this->pdo->query($this->sql)->fetchAll();

					$data = array(); $code = 0; $msg = ""; $remarks = "";
					foreach ($result as $rec) { 
						if($this->passwordCheck($dt->currentPassword, $rec['user_password'])){
							$code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";
							$encryptedPassword = $this->encryptPassword($dt->newPassword);
							return $this->gm->update($table, ["user_password" => $encryptedPassword], "fld_id = $id");
						}
					}
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
		}

		// Change Password
		public function changeUserPassword($table, $dt, $id) {
			$this->sql = "SELECT * FROM $table WHERE fld_id = $id";

			try {
				if ($res = $this->pdo->query($this->sql)->fetchColumn()>0) {
					$result=$this->pdo->query($this->sql)->fetchAll();

					$data = array(); $code = 0; $msg = ""; $remarks = "";
					foreach ($result as $rec) { 
						$code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";
						$encryptedPassword = $this->encryptPassword($dt->newPassword);
						return $this->gm->update($table, ["user_password" => $encryptedPassword], "fld_id = $id");
					}
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
		}


		public function validateUser($table, $dt, $filter_data) {
			$this->sql = "SELECT * FROM $table WHERE fld_id = $filter_data";

			try {
				if ($res = $this->pdo->query($this->sql)->fetchColumn()>0) {
					$result=$this->pdo->query($this->sql)->fetchAll();

					$data = array(); $code = 0; $msg = ""; $remarks = "";
					foreach ($result as $rec) { 
						if($this->passwordCheck($dt->adminPassword, $rec['user_password'])){
							$code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";
						} else{
							$data = array(); $code = 401; $msg = "Incorrect Password"; $remarks = "failed";
						}
					}
				} else {
					http_response_code(400);
					$data = array(); $code = 401; $msg = "User does not exist"; $remarks = "failed";
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
			return $this->sendPayload($data, $remarks, $msg, $code);
		}

		public function sendPayload($payload, $remarks, $message, $code) {
			$status = array("remarks"=>$remarks, "message"=>$message);
			http_response_code($code);
			return array(
				"status"=>$status,
				"payload"=>$payload,
				'prepared_by'=>'Bernie L. Inociete Jr., Developer',
				"timestamp"=>date_create()
			);
		}
    }
?>