<?php
    class Get {
        protected $pdo;
		private $gm;
		private $sql;
		private $otp;
		private $data = array();
		private $staus = array();

        public function __construct(\PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function sendPayload($payload, $remarks, $message, $code) {
			$status = array("remarks"=>$remarks, "message"=>$message);
			http_response_code($code);
			return array(
				"status"=>$status,
				"payload"=>$payload,
				'prepared_by'=>'Christian V. Alip, Developer',
				"timestamp"=>date_create());
		} 
    }
?>