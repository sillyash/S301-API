<?php
require_once('../config/config.php');
require_once(ROOT_PATH . '/api/api.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        require_once '../routes/get_routes.php';
        break;
    case 'POST':
        require_once '../routes/post_routes.php';
        break;
    case 'PUT':
        require_once '../routes/put_routes.php';
        break;
    case 'DELETE':
        require_once '../routes/delete_routes.php';
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>
