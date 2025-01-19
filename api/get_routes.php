<?php

/* This file is used to define routes for GET requests. */

/*
* Route: /test/env
* This route is used to test the environment of the API.
*/

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

/*
* Route: /data
* This route is used to get data from a table in the database.
* Required parameters:
* - table: The name of the table to get data from.
* Optional parameters:
* - rows: The number of rows to get from the table.
*/

Router::addRoute('GET', '/data', function() {
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