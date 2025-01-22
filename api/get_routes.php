<?php
/* This file is used to define routes for GET requests. */

Router::addRoute('GET', '/test/env', function() {
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
});

Router::addRoute('GET', '/table', function() {
    if (!isset($_GET['table'])) {
        http_response_code(400);
        echo json_encode(["error" => "Table parameter is required"]);
        return;
    }
    $table = $_GET['table'];
    $rows = isset($_GET['rows']) ? intval($_GET['rows']) : null;
    get_data($table, $rows);
});

?>