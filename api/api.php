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

require_once('get_routes.php');
require_once('post_routes.php');
require_once('put_routes.php');
require_once('delete_routes.php');

?>
