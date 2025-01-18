<?php
require_once('config.php');
require_once(ROOT_PATH . '/api/api.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$request_method = $_SERVER["REQUEST_METHOD"];

Router::dispatch($request_method, $uri);

?>
