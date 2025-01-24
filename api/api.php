<?php
require_once(__DIR__ . '/../config.php');
require_once('db.php');
require_once('Router.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

Database::createConnection();
Router::init();

/**
 * This function is used to return a JSON response when an object is created successfully.
 * @param mixed $object The object that was created.
 * @return void
 */
function creationSuccess(mixed $object) {
    header("HTTP/1.1 201 Created");

    $response = array(
        "message" => "Object created successfully",
        "object" => $object
    );

    echo json_encode($response);
}

function deletionSuccess(mixed $object) {
    header("");

    $response = array (
        "message" => "Object deleted successfully",
        "object" => $object
    );

    echo json_encode($response);
}

/**
 * This function is used to return a JSON response when fields are incomplete.
 * @param mixed $data The data that was used to create the object.
 * @return void
 */
function fieldsIncomplete(mixed $data) {
    header("HTTP/1.1 400 Bad Request");

    $response = array(
        "message" => "Please fill in all fields",
        "data" => $data
    );

    echo json_encode($response);
}

/**
 * This function is used to return a JSON response when an object cannot be created.
 * @param mixed $error The error message.
 * @param mixed $data The data that was used to create the object.
 * @return void
 */
function objectCreateError(mixed $error, mixed $data) {
    header("HTTP/1.1 422 Unprocessable Entity");

    $response = array(
        "message" => "Error creating object",
        "error" => $error,
        "data" => $data
    );

    echo json_encode($response);
}

/**
 * This function is used to return a JSON response when there is a SQL error.
 * @param mixed $error The error message.
 * @param mixed $data The data that was used to create the object.
 * @return void
 */
function sqlError(mixed $error, mixed $data) {
    header("HTTP/1.1 500 Internal Server Error");

    $response = array(
        "message" => "SQL error",
        "error" => $error,
        "data" => $data
    );

    echo json_encode($response);
}

/** 
 * This function is used to handle special characters in a string.
 * @param string $data The string to handle.
 * @return string The string with special characters handled.
 * @return void
 */
function handleChars(string $data) {
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

/**
 * This function is used to get data from a table in the database.
 * @param string $table The name of the table to get data from.
 * @param int $rows The number of rows to get from the table.
 * @return void
 */
function get_data(string $table, int $rows = null) {
    $table = strtolower($table);
    $table = ucfirst($table);
    $db = Database::$conn;

    if ($rows) {
        $query = "SELECT * FROM `$table` LIMIT :rows";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':rows', $rows, PDO::PARAM_INT);
    } else {
        $query = "SELECT * FROM `$table`";
        $stmt = $db->prepare($query);
    }
    
    try {
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        sqlError($e->getMessage(), $table);
        return;
    }

    echo json_encode($data);
}

require_once('get_routes.php');
require_once('post_routes.php');
require_once('put_routes.php');
require_once('delete_routes.php');

?>
