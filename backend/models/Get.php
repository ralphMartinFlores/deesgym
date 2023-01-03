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

		// Count Records
		public function countRecords($table, $filter_data, $byID) {
            $this->sql = "SELECT COUNT($byID) as records_total FROM $table ";
            if ($filter_data != null) {
                $this->sql .= " WHERE $filter_data";
            }
            $data = array(); $errmsg = ""; $code = 0;
			try {
				if ($res = $this->pdo->query($this->sql)->fetchAll()) {
					foreach ($res as $rec) {
						array_push($data, $rec);
						$res = null; $code = 200;
					}
				}
			} catch(\PDOException $e) {
				$errmsg = $e->getMessage(); $code = 401;
			}
			return $this->sendPayload($data, "success", $errmsg, $code);
		}
        
		// SELECT ALL USERS
		public function getUsers($table, $filter_data) {

			$this->sql = "SELECT fld_id, user_lname, user_fname, user_email, user_image, user_contactnum, user_password, user_role, user_isDeleted, user_dateJoined FROM $table ";

            if($filter_data != null) {
                $this->sql .= " WHERE $filter_data";
            }
			
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

		public function getProducts($table, $filter_data) {
			$this->sql = "SELECT $table.*, brands_tbl.brand_name, categories_tbl.category_name FROM $table LEFT JOIN categories_tbl ON $table.category_id = categories_tbl.category_id LEFT JOIN brands_tbl ON $table.brand_id = brands_tbl.brand_id";
			
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

		public function productDetails($table, $filter_data) {
			$this->sql = "SELECT $table.*, brands_tbl.brand_name, categories_tbl.category_name, product_images_tbl.prod_img_filepath FROM $table
							LEFT JOIN categories_tbl ON $table.category_id = categories_tbl.category_id 
							LEFT JOIN brands_tbl ON $table.brand_id = brands_tbl.brand_id 
							LEFT JOIN product_images_tbl ON $table.prod_id = product_images_tbl.prod_id 
							WHERE $table.prod_id = $filter_data";
			
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

		public function getProductRating($table){
			$this->sql = "SELECT prod_id, SUM(rating_star) 'sum', COUNT(user_id) 'count' FROM $table GROUP BY prod_id";
			// SELECT prod_id, ROUND(AVG(rating_star), 2) 'avg', COUNT(user_id) FROM $table GROUP BY prod_id
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

		public function getUserCart($table, $filter_data) {
			$this->sql = "SELECT 
						users_tbl.fld_id, 

						$table.cart_id, 
						cart_items_tbl.cart_item_id, 
						cart_items_tbl.cart_item_isTod,
						cart_items_tbl.cart_item_quantity, 

						brands_tbl.brand_id, 
						brands_tbl.brand_name, 

						products_tbl.prod_id, 
						products_tbl.prod_name,
						products_tbl.prod_model, 
						products_tbl.prod_image_filepath, 
						products_tbl.prod_sell_price, 
						products_tbl.prod_tod_code, 
						products_tbl.prod_oem_code,
						products_tbl.prod_color

						FROM $table LEFT JOIN users_tbl ON users_tbl.fld_id = $table.user_id 
						LEFT JOIN cart_items_tbl ON cart_items_tbl.cart_id = $table.cart_id
						LEFT JOIN products_tbl ON products_tbl.prod_id = cart_items_tbl.prod_id 
						LEFT JOIN brands_tbl ON brands_tbl.brand_id = products_tbl.brand_id
						WHERE users_tbl.fld_id = $filter_data";

						
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

		public function getUserOrders($table, $filter_data) {
			$this->sql = "SELECT 
						order_items_tbl.order_item_id, 
						orders_tbl.order_id, 

						suppliers_tbl.sup_code,

						users_tbl.user_email,

						brands_tbl.brand_name,

						products_tbl.prod_id, 
						products_tbl.prod_name, 
						products_tbl.prod_model, 
						products_tbl.prod_color,
						products_tbl.prod_sell_price, 
						products_tbl.prod_tod_code, 
						products_tbl.prod_oem_code,

						orders_tbl.order_grand_total, 
						orders_tbl.order_total_items,
						orders_tbl.order_status,

						order_items_tbl.order_item_tracking_number,
						order_items_tbl.order_item_isTod, 
						order_items_tbl.order_item_quantity,

						orders_tbl.order_createdAt

						FROM $table 
						LEFT JOIN order_items_tbl ON order_items_tbl.order_id = $table.order_id 
						LEFT JOIN suppliers_tbl ON suppliers_tbl.sup_id = order_items_tbl.supplier_id 
						LEFT JOIN users_tbl ON users_tbl.fld_id = $table.user_id
						LEFT JOIN products_tbl ON products_tbl.prod_id = order_items_tbl.prod_id 
						LEFT JOIN brands_tbl ON brands_tbl.brand_id = products_tbl.brand_id";
			if ($filter_data != null) {
				$this->sql .= " WHERE users_tbl.fld_id = $filter_data";
			}
			$this->sql .= " ORDER BY order_items_tbl.order_item_id  DESC";			

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

		public function getClientOrders($table, $filter_data) {
			$this->sql = "SELECT * FROM $table";

			if ($filter_data != null) {
				$this->sql .= " WHERE user_id = $filter_data";
			}

			$this->sql .= " ORDER BY order_id DESC";		

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

		public function getClientOrderItems($table, $user_id, $order_id) {
			$this->sql = "SELECT 

						$table.order_grand_total, 
						$table.order_total_items, 
						$table.order_status,

						order_items_tbl.order_item_tracking_number,
						order_items_tbl.order_item_isTod, 
						order_items_tbl.order_item_quantity,

						products_tbl.prod_name, 
						products_tbl.prod_model, 
						products_tbl.prod_color, 
						products_tbl.prod_image_filepath, 
						products_tbl.prod_sell_price, 
						products_tbl.prod_tod_code, 
						products_tbl.prod_oem_code,

						brands_tbl.brand_name,

						$table.order_createdAt 

						FROM $table 
						LEFT JOIN users_tbl ON users_tbl.fld_id = $table.user_id 
						LEFT JOIN order_items_tbl ON order_items_tbl.order_id = $table.order_id
						LEFT JOIN suppliers_tbl ON suppliers_tbl.sup_id = order_items_tbl.supplier_id 
						LEFT JOIN products_tbl ON products_tbl.prod_id = order_items_tbl.prod_id 
						LEFT JOIN brands_tbl ON brands_tbl.brand_id = products_tbl.brand_id";

			if ($user_id != null && $order_id != null) {
				$this->sql .= " WHERE users_tbl.fld_id = $user_id AND $table.order_id = $order_id";
			}
			$this->sql .= " ORDER BY order_items_tbl.order_item_id  DESC";			

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

		public function getRegularOrders($table, $user_id) {
			$this->sql = "SELECT products_tbl.*, brands_tbl.brand_name, categories_tbl.category_name, $table.reg_isTod 
			FROM $table LEFT JOIN products_tbl ON products_tbl.prod_id = $table.prod_id 
			LEFT JOIN brands_tbl ON brands_tbl.brand_id = products_tbl.brand_id 
			LEFT JOIN categories_tbl ON categories_tbl.category_id = products_tbl.category_id 
			WHERE $table.user_id = $user_id";

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

		public function getProductReviews($table, $user_id, $prod_id) {
			$this->sql ="SELECT users_tbl.user_lname, users_tbl.user_fname, $table.rating_star, $table.rating_createdAt, $table.rating_comment FROM $table 
			LEFT JOIN users_tbl ON users_tbl.fld_id = $table.user_id WHERE $table.prod_id = $prod_id";
			
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

		public function transactions($table, $filter_data) {
			
			$this->sql = "SELECT $table.*, customers_tbl.* FROM $table INNER JOIN customers_tbl ON customers_tbl.customer_id = $table.customer_id";

			if ($filter_data != null) {
				$this->sql .= " WHERE customers_tbl.customer_id = $filter_data";
			}

			$this->sql .= " GROUP BY trans_id DESC";

						
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

		public function transcationItems($table, $filter_data) {
			
			$this->sql = "SELECT transactions_tbl.*, $table.*, products_tbl.* 
			FROM $table INNER JOIN transactions_tbl ON transactions_tbl.trans_id = $table.trans_id
			INNER JOIN products_tbl ON products_tbl.prod_id = $table.prod_id
			INNER JOIN categories_tbl ON categories_tbl.category_id = products_tbl.category_id
			INNER JOIN brands_tbl ON brands_tbl.brand_id = products_tbl.brand_id";

			if ($filter_data != null) {
				$this->sql .= " WHERE transactions_tbl.trans_id = $filter_data";
			}

			// return $this->sql;
						
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