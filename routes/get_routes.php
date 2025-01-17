<?php
require_once(__DIR__ . '/../config.php');

switch ($uri[API_ROUTE_INDEX]) {
    case 'test':
        require(ROUTES_PATH . "/test/get_routes.php");
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

?>
