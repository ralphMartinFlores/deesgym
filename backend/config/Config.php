<?php 
    // HEADERS
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=utf-8");
    header("Access-Control-Allow-Methods: POST, GET");
    
    // TIME ZONE
    date_default_timezone_set('Australia/Sydney');

    // IMPORTS
    require_once("./models/Get.php");
    require_once("./models/Post.php");
    require_once("./models/Global.php");
    require_once("./models/Auth.php");

    // Model
    define("DB", "deesgym_db");
    define("USER", "root");
    define("PWORD", "");
    define("SERVER", "localhost");
    define("CHARSET", "utf8");
    define("SECRET", base64_encode("deesgym"));

    class Connection {
        protected $connectionString = "mysql:host=".SERVER.";dbname=".DB.";charset=".CHARSET;
        protected $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        ];

        public function connect() {
            return new \PDO($this->connectionString, USER, PWORD, $this->options);
        }
    }
?>