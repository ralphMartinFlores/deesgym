<?php  
	class GlobalMethods {
		protected $pdo;

		public function __construct(\PDO $pdo) {
			$this->pdo = $pdo;
		}

		// SELECT
		public function exec_query($table, $filter_data) {
			$this->sql = "SELECT * FROM $table ";

            if($filter_data != null) {
                $this->sql .= " WHERE $filter_data";
            }
			// END OF RESIDENT PROFILING GLOBAL METHOD
			
			$data = array(); $code = 0; $msg= ""; $remarks = "";
			try {
				if ($res = $this->pdo->query($this->sql)->fetchAll()) {
					foreach ($res as $rec) { array_push($data, $rec);}
					$res = null; $code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
			return $this->sendPayload($data, $remarks, $msg, $code);
		}

		public function insert($table, $data){
			
			$i = 0; $fields=[]; $values=[];
			foreach ($data as $key => $value) {
				array_push($fields, $key);
				array_push($values, $value);
			}
			try {
				$ctr = 0;
				$sqlstr="INSERT INTO $table (";
				foreach ($fields as $value) {
					$sqlstr.=$value; $ctr++;
					if($ctr<count($fields)) {
						$sqlstr.=", ";
					} 	
				} 
				$sqlstr.=") VALUES (".str_repeat("?, ", count($values)-1)."?)";

				$sql = $this->pdo->prepare($sqlstr);
				$sql->execute($values);
				return array("code"=>200, "remarks"=>"success");
			} catch (\PDOException $e) {
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("code"=>$code, "errmsg"=>$errmsg);
		}

		public function update($table, $data, $condition){
			$fields=[]; $values=[];
			$setStr = "";
			foreach ($data as $key => $value) {
				array_push($fields, $key);
				array_push($values, $value);
			}
			try{
				$ctr = 0;
				$sqlstr = "UPDATE $table SET ";
					foreach ($data as $key => $value) {
						$sqlstr .="$key=?"; $ctr++;
						if($ctr<count($fields)){
							$sqlstr.=", ";
						}
					}
					$sqlstr .= " WHERE $condition";
					$sql = $this->pdo->prepare($sqlstr);
					$sql->execute($values);
				return array("code"=>200, "remarks"=>"success");	
			}
			catch(\PDOException $e){
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("code"=>$code, "errmsg"=>$errmsg);
		}

		public function remove($table, $conditionString) {
			try {
				$sqlstr = "DELETE FROM $table WHERE $conditionString";
				$sql = $this->pdo->prepare($sqlstr);
				$sql->execute();
				$code = 200; $errmsg = '';
			} catch(\PDOException $e) {
				$errmsg = $e->getMessage(); $code = 403;
			}
			return array("code" => $code, "errmsg" => $errmsg);
		
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