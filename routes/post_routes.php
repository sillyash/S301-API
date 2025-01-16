<?php
require_once(__DIR__ . '/../config.php');

switch ($uri[API_ROUTE_INDEX]) {
    case 'data':
        insert_data($db);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

function insert_data($db) {
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "INSERT INTO your_table (column1, column2) VALUES (:value1, :value2)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":value1", $data['value1']);
    $stmt->bindParam(":value2", $data['value2']);
    if($stmt->execute()) {
        send_email("recipient@example.com", "New Record Inserted", "A new record has been inserted into the database.");
        echo json_encode(array("message" => "Record inserted successfully."));
    } else {
        echo json_encode(array("message" => "Failed to insert record."));
    }
}

?>
