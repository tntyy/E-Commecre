<?php
if (!class_exists('Database')) {

    class Database {
        private static $instance = null;

        private function __construct() {} // chặn khởi tạo trực tiếp
        private function __clone() {}     // chặn clone


        
        public static function getInstance() {
            if (self::$instance === null) {

                $host = "localhost";
                $dbname = "ecom";  
                $username = "root";
                $password = "";

                try {
                    self::$instance = new PDO(
                        "mysql:host=$host;dbname=$dbname;charset=utf8",
                        $username,
                        $password
                    );
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Kết nối thất bại: " . $e->getMessage());
                }
            }
            
            return self::$instance;
        }
    }

}
?>