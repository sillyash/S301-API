<?php
require_once(__DIR__ . '/../config.php');
require_once('db.php');
require_once('send_email.php');
require_once('Router.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

Database::createConnection();
Router::init();

// Define routes
Router::addRoute('GET', '/data', function() {
    if (!isset($_GET['table'])) {
        http_response_code(400);
        echo json_encode(["error" => "Table parameter is required"]);
        return;
    }
    $table = $_GET['table'];
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : null;
    get_data($table, $rows);
});

Router::addRoute('GET', '/test/env', function() {
    get_env();
});

function get_env() {
    $response = array(
        "URI" => $_SERVER['REQUEST_URI'],
        "REQUEST_METHOD" => $_SERVER['REQUEST_METHOD'],
        "ROOT_PATH" => ROOT_PATH,
        "PHP_VERSION" => phpversion(),
        "DB_HOST" => DB_HOST,
        "DB_NAME" => DB_NAME,
        "DB_USER" => DB_USER,
        "DB_PASS" => DB_PASS,
        "EMAIL_HEADERS" => EMAIL_HEADERS
    );
    
    echo json_encode($response);
}

function get_data(string $table, int $rows = null) {
    $table = strtolower($table);
    $table = ucfirst($table);
    $db = Database::$conn;

    if ($rows) {
        $query = "SELECT * FROM `$table` LIMIT :rows";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':rows', $rows, PDO::PARAM_INT);
    } else {
        $query = "SELECT * FROM `$table`";
        $stmt = $db->prepare($query);
    }
    
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
}

?>
