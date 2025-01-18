<?php
require_once(__DIR__ . '/../config.php');
$route_index = API_ROUTE_INDEX;

try {
    $request = $uri[$route_index];
} catch (Exception $e) {
    $request = null;
}

switch ($request) {
    case 'test':
        require(ROUTES_PATH . "/test/get_routes.php");
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

?>
