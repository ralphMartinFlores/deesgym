<?php
    class Post {
        private $pdo;
		private $gm;
		private $sql;
		private $otp;
		private $data = array();
		private $staus = array();
        
        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
			$this->gm = new GlobalMethods($pdo);
        }

		public function updateStatus($table, $payload) {
			$this->sql = "UPDATE $table SET member_status = 0, member_membershipexp = null WHERE member_membershipexp < NOW()";

			try {
				if($this->pdo->query($this->sql)) {
					return array("code"=>200, "remarks"=>"success");
				}
			} catch (\PDOException $e) {
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("code"=>$code, "errmsg"=>$errmsg);
		}


        public function sendPayload($payload, $remarks, $message, $code) {
			$status = array("remarks"=>$remarks, "message"=>$message, "code"=>$code);
			http_response_code($code);
			return array(
				"status"=>$status,
				"payload"=>$payload,
				'prepared_by'=>'Christian V. Alip, Developer',
				"timestamp"=>date_create());
		} 
    }
?>