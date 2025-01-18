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
        delete_data($db);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

function delete_data($db) {
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "DELETE FROM your_table WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $data['id']);
    if($stmt->execute()) {
        echo json_encode(array("message" => "Record deleted successfully."));
    } else {
        echo json_encode(array("message" => "Failed to delete record."));
    }
}

?>
