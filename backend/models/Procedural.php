<?php  
	function errMsg($errcode) {
		switch ($errcode) {
			case 400:
				$msg = "Bad Request. Please contact the systems administrator.";
			break;

			case 401:
				$msg = "Unauthorized user.";
			break;

			case 403:
				$msg = "Forbidden. Please contact the systems administrator.";
			break;
			
			default:
				$msg = "Request Not Found.";
			break;
		}

		http_response_code($errcode);
		return je(array("status"=>array("remarks"=>"failed", "message"=>$msg), "prepared_by"=>"Melner Balce, Gordon College-CCS", "timestamp"=>date_create()));
	}

	function je($param) {
		return json_encode($param, JSON_PRETTY_PRINT);
	}

	function jd($param) {
		return json_decode($param);
	}

	function response($param) {
		$string = je($param);
		$key = 'SampleCredential1234';
		$number = filter_var('AES-256-CBC', FILTER_SANITIZE_NUMBER_INT);
		$number = intval(abs($number));
		$ivLength = openssl_cipher_iv_length('AES-256-CBC');
	    $iv = openssl_random_pseudo_bytes($ivLength);

	    $salt = openssl_random_pseudo_bytes(256);
	    $iterations = 999;
	    $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($number / 4));

	    $encryptedString = openssl_encrypt($string, 'AES-256-CBC', hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);

	    $encryptedString = base64_encode($encryptedString);
	    unset($hashKey);

	    $output = ['ciphertext' => $encryptedString, 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];
	    unset($encryptedString, $iterations, $iv, $ivLength, $salt);

	    return je(array("a"=>base64_encode(json_encode($output))));
	}

	function check_message($param) {
		$ciphertext = $param;
		$key = hex2bin(substr($ciphertext, 43,32));
		$iv =  hex2bin(substr($ciphertext, 11,32));
		$payload = openssl_decrypt(substr($ciphertext, 75), 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
		$payload = preg_replace('/[\x00-\x1F\x7F]/u', '', $payload);
		return $payload; 
	}

    function newObj($files, $post) {
        $data = (object) array(						
            'user_lname' => $post['user_lname'],		
            'user_fname' => $post['user_fname'],
            'user_email' => $post['user_email'],
            'user_image' => '', //$url.$destination,
            'user_contactnum' => $post['user_contactnum'],
            'user_role' => $post['user_role'],
            // 'user_password' => $post['user_password'],
            'user_isDeleted' => $post['user_isDeleted']
        );

        if ($files) {
            $file = $files['user_image']['name'];
            $extension = pathinfo($file, PATHINFO_EXTENSION);
    
            $new_date_time = date_create();
            $date_time_format = $new_date_time->format('Y-m-d H:i:s');
            $filename = str_replace(str_split('- :'), '', $date_time_format);
            $new_file_name = "$filename.$extension";
    
            $destination = "uploads/users/" . $new_file_name;
            $file_tmp_name = $files['user_image']['tmp_name'];	
            $imageSize = 60;
            // $url = "http://localhost/cartridgeextra/cartridgeextra-api/";
            // $url = "http://localhost/cartridgeextra/cartridgeextra-api/";
    
            if(imagejpeg(imagecreatefromjpeg($file_tmp_name), $destination, $imageSize)) { 
                $data->user_image = $destination; //$url.$destination;
                $data->user_password = $post['user_password'];
                return $data;
            }
            return null;
        } else {
            unset($data->user_password);
            unset($data->user_image);
            return $data;
        }
    }

    function newImageObj($files) {
        $file = $files['user_image']['name'];
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        $new_date_time = date_create();
        $date_time_format = $new_date_time->format('Y-m-d H:i:s');
        $filename = str_replace(str_split('- :'), '', $date_time_format);
        $new_file_name = "$filename.$extension";

        $destination = "uploads/users/" . $new_file_name;
        $file_tmp_name = $files['user_image']['tmp_name'];	
        $imageSize = 60;
        // $url = "http://localhost/cartridgeextra/cartridgeextra-api/";
        // $url = "http://localhost/cartridgeextra/cartridgeextra-api/";

        if(imagejpeg(imagecreatefromjpeg($file_tmp_name), $destination, $imageSize)) { 
            return $data = (object) array('user_image' => $destination);
        }
        return null;
    }

    function newProductObject($files, $post) {
        $product_images = [];
        foreach($files['imgFile']['name'] as $key => $value){
            $file = $files['imgFile']['name'][$key];
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            $new_date_time = date_create();
            $date_time_format = $new_date_time->format('Y-m-d H:i:s');
            $filename = str_replace(str_split('- :'), '', $date_time_format);
            $new_file_name = "$filename$key.$extension";

            $destination = "uploads/products/" . $new_file_name;
            $file_tmp_name = $files['imgFile']['tmp_name'];
            array_push($product_images, $destination);
            
            move_uploaded_file($files['imgFile']['tmp_name'][$key],$destination);
        }
        $data = (object) array(		
            'prod_image_filepath' => $product_images[0],
            'category_id' => $post['category_id'],
            'brand_id' => $post['brand_id'],
            'prod_model' => $post['prod_model'],
            'prod_oem_code' => $post['prod_oem_code'],
            'prod_tod_code' => $post['prod_tod_code'],
            'prod_name' => $post['prod_name'],
            'prod_color' => $post['prod_color'],
            'prod_yield' => $post['prod_yield'],
            'prod_desc' => $post['prod_desc'],
            'prod_cost_raw' => $post['prod_cost_raw'],
            'prod_sell_price' => $post['prod_sell_price'],
            'prod_qty' => $post['prod_qty']
        );
        return (object) array("load" => $data, "images" => $product_images);
    }
?>