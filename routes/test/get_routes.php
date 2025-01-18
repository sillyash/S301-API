<?php
$route_index = API_ROUTE_INDEX+1;

try {
    $request = $uri[$route_index];
} catch (Exception $e) {
    $request = null;
}

switch ($request) {
    case 'data':
        get_data($db);
        break;
    case 'vars':
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
