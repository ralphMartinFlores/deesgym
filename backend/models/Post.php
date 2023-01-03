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

		public function addNewProduct($table, $dt) {
			$response = $this->gm->insert($table, $dt->load);
			// return $response;
			if ($response['code'] === 200) {
				$id = $this->pdo->lastInsertId();

				for($i = 0; $i < sizeof($dt->images); $i++) {
					$product_id[] = $id;
					$product_image_filepath[] = $dt->images[$i];
					$values[] = "($product_id[$i], '$product_image_filepath[$i]')";
				}

				$this->sql = "INSERT INTO product_images_tbl (prod_id, prod_img_filepath) VALUES " . implode(', ', $values);
				
				if($this->pdo->query($this->sql)) {
					return array("code"=>200, "remarks"=>"success");
				}
			} else {
				return array("code"=>404, "remarks"=>"error");
			}
		}

		public function addToCart($table, $dt, $isRegularOrder) {
			$cartId;
			$this->sql = "SELECT cart_id FROM carts_tbl WHERE user_id = $dt->user_id";

			try {
				if($this->pdo->query($this->sql)) {
					if ($res = $this->pdo->query($this->sql)->fetchAll()) {
						foreach ($res as $rec) {
							$cartId = $rec['cart_id'];
						}
					}

					$prod_id = $dt->prod_id;
					$cart_id = $cartId;
					$cart_item_isTod = $dt->cart_item_isTod;
					$values[] = "($prod_id, $cart_id, $cart_item_isTod)";

					$this->sql = "INSERT INTO cart_items_tbl (prod_id, cart_id, cart_item_isTod) VALUES " . implode(', ', $values);
					
					if($this->pdo->query($this->sql) && $isRegularOrder) {
						$this->sql = "DELETE FROM regular_orders_tbl WHERE prod_id = $dt->prod_id";
						$this->pdo->query($this->sql);
					}
					return array("code"=>200, "remarks"=>"success");
				}
			} catch (\PDOException $e) {
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("code"=>$code, "errmsg"=>$errmsg);
		}

		public function clearCartRegularOders($table, $filter_data) {
			$this->sql = "SELECT * FROM $table WHERE $filter_data";

			try {
				if ($res = $this->pdo->query($this->sql)->fetchAll()) {
					foreach ($res as $rec) {
						return $this->gm->remove($table, $filter_data);
					}
					$res = null; $code = 200; $msg = "Successfully retrieved the requested records"; $remarks = "success";
				}
			} catch (\PDOException $e) {
				$msg = $e->getMessage(); $code = 401; $remarks = "failed";
			}
		}

		public function placeOrder($table, $data, $userId) {
			$order_total = $data[0]->order_total;
			$order_shipping_fee = $data[0]->order_shipping_fee;
			$order_grand_total = $order_total + $order_shipping_fee;
			$order_total_items = sizeof($data);
			$id = '';

			$this->sql = "INSERT INTO $table (user_id, order_total, order_shipping_fee, order_grand_total, order_total_items) 
							VALUES ($userId, $order_total, $order_shipping_fee, $order_grand_total, $order_total_items)";
			// return array("data" => $data, "sql" => $this->sql);
			try {
				if($this->pdo->query($this->sql)) {
					$id = $this->pdo->lastInsertId();
					$values = [];

					for($i = 0; $i < sizeof($data); $i++) {
						$order_id = $id;
						$supplier_id = $data[$i]->supplier_id;
						$prod_id = $data[$i]->prod_id;
						$order_item_quantity = $data[$i]->cart_item_quantity;
						$order_item_isTod = $data[$i]->cart_item_isTod;
						array_push($values, "($supplier_id, $order_id, $prod_id, $order_item_quantity, $order_item_isTod)");
					}

					$this->sql = "INSERT INTO order_items_tbl (supplier_id, order_id, prod_id, order_item_quantity, order_item_isTod) VALUES " . implode(', ', $values);
					if ($this->pdo->query($this->sql)) return array("code"=>200, "remarks"=>"success");
				}
			} catch (\PDOException $e) {
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("id", $id, "code"=>$code, "errmsg"=>$errmsg);
		}

		public function updateOrder($table, $data, $filter_data) {
			$response; $response2; $response3;

			$response = $this->gm->update($table, ["order_item_tracking_number" => $data->order_item_tracking_number], $filter_data);

			if($response['code'] === 200) {
				$response2 = $this->gm->update("orders_tbl", ["order_status" => $data->order_status], "order_id = $data->order_id");

				if ($response2['code'] === 200) {
					$this->sql = "SELECT * FROM products_tbl WHERE prod_id = $data->prod_id";

					$prod_id = $data->prod_id; 
					$prod_sell_price = $data->prod_sell_price;

					$data = array(); $code = 0; $msg= ""; $remarks = "";

					try {
						if ($res = $this->pdo->query($this->sql)->fetchAll()) {
							foreach ($res as $rec) { 
								return $this->gm->update("products_tbl", ["prod_sell_price" => $prod_sell_price], "prod_id = $prod_id");
							}
							$res = null; $code = 200; $remarks = "success";
						}
					} catch (\PDOException $e) {
						$msg = $e->getMessage(); $code = 401; $remarks = "failed";
					}
					return array($code, $remarks);			
				}

			}

		}
		public function updateOrders($table, $userId) {
			$this->sql = "UPDATE orders_tbl SET order_status = 2 WHERE order_createdAt < NOW() - INTERVAL 2 WEEK";

			if($userId != null) {
				$this->sql .= " AND user_id = $userId";
			}

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

		public function checkout($table, $data) {
			try {
				$product_id = [];
				$item_quantity = [];
				$values = [];

				for($i = 0; $i < sizeof($data); $i++) {
					$prod_id[] = $data[$i]->prod_id;
					$item_quantity[] = $data[$i]->cart_item_quantity;
					// $values[] = "($product_id[$i], $item_quantity[$i])";

					$this->sql = "UPDATE products_tbl SET prod_qty = prod_qty - $item_quantity[$i] WHERE prod_id = $prod_id[$i]";
					$this->pdo->query($this->sql);
				}
				return array("code"=>200, "remarks"=>"success");
			} catch (\PDOException $e) {
				$errmsg = $e->getMessage();
				$code = 403;
			}
			return array("code"=>$code, "errmsg"=>$errmsg);
		}

		public function newTransaction($table, $dt) {
			$response;
			$response = $this->gm->insert('transactions_tbl', $dt[0]);
			if ($response['code'] === 200) {
				$id = $this->pdo->lastInsertId();

				for ($i=0; $i < sizeof($dt[1]) ; $i++) { 
					$trans_id[] = $id;
					$prod_id[] = $dt[1][$i]->prod_id;
					$trans_item_isTod[] = $dt[1][$i]->cart_item_isTod;
					$trans_prod_qty[] = $dt[1][$i]->cart_item_quantity;
					$values[] = "($trans_id[$i], $prod_id[$i], $trans_item_isTod[$i], '$trans_prod_qty[$i]')";
				}
				
				try {
					$this->sql = "INSERT INTO transaction_items_tbl (trans_id, prod_id, trans_item_isTod, trans_prod_qty) VALUES " . implode(', ', $values);
					
					if($this->pdo->query($this->sql)) {

						for ($i=0; $i < sizeof($dt[1]) ; $i++) {

							$prod_id[] = $dt[1][$i]->prod_id;
							$item_quantity[] = $dt[1][$i]->cart_item_quantity;

							$this->sql = "UPDATE products_tbl SET prod_qty = prod_qty - $item_quantity[$i] WHERE prod_id = $prod_id[$i]";

							if($this->pdo->query($this->sql)) {
								return array("code"=>200, "remarks"=>"success");
							}
						}
					}
				} catch (\Throwable $th) {
					$errmsg = $e->getMessage();
					$code = 403;
				}
				return array("code"=>$code, "errmsg"=>$errmsg);
			}
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