<?php
/* This file is used to define routes for POST requests. */

Router::addRoute('POST', '/proposition', function() {
    require_once(ROOT_PATH . '/models/Proposition.php');
    $data = json_decode(file_get_contents("php://input"));

    try {
        $proposition = new Proposition($data);
    } catch (Exception $e) {
        objectCreateError($e->getMessage(), $data);
        return;
    }

    try {
        $proposition->pushToDb();
    } catch (Exception $e) {
        sqlError($e->getMessage(), $proposition);
        return;
    }

    creationSuccess($proposition);
});

?>
