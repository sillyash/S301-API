<?php
require_once('config.php');
require_once(ROOT_PATH . '/api/api.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        require_once (ROOT_PATH . '/routes/get_routes.php');
        break;
    case 'POST':
        require_once (ROOT_PATH . '/routes/post_routes.php');
        break;
    case 'PUT':
        require_once (ROOT_PATH . '/routes/put_routes.php');
        break;
    case 'DELETE':
        require_once (ROOT_PATH . '/routes/delete_routes.php');
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>
