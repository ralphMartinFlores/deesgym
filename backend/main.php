<?php
    // IMPORTS
    require_once("./config/Config.php");


    // INSTANCES
    $db = new Connection();
    $pdo = $db->connect();
    $auth = new Authentication($pdo);
    $get = new Get($pdo);
    $gm = new GlobalMethods($pdo);
    $post = new Post($pdo);
    $otp = new Otp();
    $invoice = new Invoice();
    $order = new Order();


    // VALIDATE REQUEST
    if (isset($_REQUEST['request'])) {
		$request = explode('/', rtrim(($_REQUEST['request']), '/'));
	} else {
		$request = array("errorcatcher");
	}

    // Extract data from request body
	$d = json_decode(file_get_contents("php://input"));

    switch($_SERVER['REQUEST_METHOD']) {

        // GET request
		case 'GET':
            switch($request[0]) {
                
                case 'members':
                    if (count($request) > 1) {
                        echo json_encode($gm->exec_query($request[0]."_tbl", $request[1]), JSON_PRETTY_PRINT);
                    } else {
                        echo json_encode($gm->exec_query($request[0]."_tbl", null), JSON_PRETTY_PRINT);
                    }
                    break;


                case 'categories':
                    switch ($request[1]) {
                        case 'parent':
                            echo json_encode($gm->exec_query($request[0]."_tbl", "hasSubCategory = 1"), JSON_PRETTY_PRINT);
                            break;

                        case 'count':
                            echo json_encode($get->countRecords($request[0]."_tbl", null, "category_id"), JSON_PRETTY_PRINT);
                            break;

                        default:
                            echo json_encode($gm->exec_query($request[0]."_tbl", null), JSON_PRETTY_PRINT);
                            break;
                    }
                    break;
            }
            break;



        // POST request
        case 'POST':
            switch ($request[0]) {
                case 'register':
                    switch ($request[1]) {
                        case 'employee':
                            $data = newObj($_FILES, $_POST);
                            if ($data) {
                                echo json_encode($auth->registerAccount("users_tbl", $data), JSON_PRETTY_PRINT);
                            }
                            break;
                        
                        case 'user':
                            echo json_encode($auth->registerAccount("users_tbl", $d), JSON_PRETTY_PRINT);
                            break;

                        default:
                            echo json_encode("Invalid endpoint!");
                            break;
                    }
                    break;

                case 'login':
                    echo json_encode($auth->login("user_tbl", $d), JSON_PRETTY_PRINT);
                    break;

                    break;

                case 'members':
                    switch ($request[1]) {
                        case 'add':
                            echo json_encode($gm->insert($request[0]."_tbl", $d), JSON_PRETTY_PRINT);
                            break;
                        
                        case 'update':
                            echo json_encode($gm->update($request[0]."_tbl", $d, "member_id = $request[2]"), JSON_PRETTY_PRINT);
                            break;

                        case 'remove':
                            echo json_encode($gm->remove($request[0]."_tbl", "member_id = $request[2]"), JSON_PRETTY_PRINT);
                            break;

                        default:
                            echo json_encode("Invalid Route!");
                            break;
                    }
                    break;

                case 'products':
                    switch ($request[1]) {
                        case 'add':
                            echo json_encode($gm->addNewProduct($request[0]."_tbl", $data), JSON_PRETTY_PRINT);
                            break;

                        case 'update':
                            echo json_encode($gm->update($request[0]."_tbl", $d, "prod_id = $request[2]"), JSON_PRETTY_PRINT);
                            break;

                        case 'remove':
                            echo json_encode($gm->remove($request[0]."_tbl", "prod_id = $request[2]"), JSON_PRETTY_PRINT);
                            break;
                        
                        default:
                            echo json_encode("Invalid Route!");
                            break;
                    }
                    break;
            }
            break;

        default:
            echo json_encode("Please Contact Administrator");
            break;
    }
?>