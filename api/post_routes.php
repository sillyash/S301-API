<?php
/* This file is used to define routes for POST requests. */

Router::addRoute('POST', '/proposition', function() {
    require_once(ROOT_PATH . '/models/Proposition.php');

    $data = json_decode(file_get_contents("php://input"));
    $titre = isset($data->titre) ? $data->titre : null;
    $description = isset($data->description) ? $data->description : null;

    if (!$titre || !$description) {
        fieldsIncomplete($data);
        return;
    }

    try {
        $proposition = new Proposition($titre, $description);
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
