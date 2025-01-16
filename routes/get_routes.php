<?php
require_once(__DIR__ . '/../config.php');

switch ($uri[API_ROUTE_INDEX]) {
    case 'data':
        get_data($db);
        break;
    case 'test':
        get_DevTest($uri);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

function get_DevTest($uri) {
    $response = array(
        "URI" => $_SERVER['REQUEST_URI'],
        "REQUEST_METHOD" => $_SERVER['REQUEST_METHOD'],
        "URI2" => $uri,
        "ROOT_PATH" => ROOT_PATH,
        "PHP_VERSION" => phpversion(),
        "DB_HOST" => DB_HOST,
        "DB_NAME" => DB_NAME,
        "DB_USER" => DB_USER,
        "DB_PASS" => DB_PASS,
        "EMAIL_FROM" => EMAIL_FROM,
        "EMAIL_REPLY_TO" => EMAIL_REPLY_TO,
        "HEADERS" => HEADERS
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
