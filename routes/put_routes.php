<?php
require_once(__DIR__ . '/../config.php');
$route_index = API_ROUTE_INDEX;

try {
    $request = $uri[$route_index];
} catch (Exception $e) {
    $request = null;
}

switch ($request) {
    case 'data':
        update_data($db);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

function update_data($db) {
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "UPDATE your_table SET column1 = :value1 WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":value1", $data['value1']);
    $stmt->bindParam(":id", $data['id']);
    if($stmt->execute()) {
        echo json_encode(array("message" => "Record updated successfully."));
    } else {
        echo json_encode(array("message" => "Failed to update record."));
    }
}

?>
