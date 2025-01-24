<?php
require_once(__DIR__ . '/../config.php');

class Database {
    private static $host = DB_HOST;
    private static $db_name = DB_NAME;
    private static $username = DB_USER;
    private static $password = DB_PASS;
    public static $conn;

    public static function createConnection() {
        static::$conn = null;
        try {
            static::$conn = new PDO("mysql:host=" . static::$host . ";dbname=" .
                            static::$db_name, static::$username, static::$password);
            static::$conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
}

?>
