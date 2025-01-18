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

$database = new Database();
$db = $database->getConnection();

$router = new Router();

// Define routes
$router->addRoute('GET', '/data/vin', function() use ($db) {
    get_data($db);
});

$router->addRoute('GET', '/test/env', function() {
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

function get_data($db) {
    $query = "SELECT * FROM Vin";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

?>
