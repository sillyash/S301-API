<?php

switch ($uri[2]) {
    case 'data':
        get_data($db);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}

function get_data($db) {
    $query = "SELECT * FROM your_table";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

?>
