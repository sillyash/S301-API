<?php

/* This file is used to define routes for POST requests. */

/*
* Route: /test/post
* This route is used to test POST requests.
*/

Router::addRoute('POST', '/proposition', function() {
    post_proposition();
});

function post_proposition() {
    require_once(ROOT_PATH . '/models/Proposition.php');

    $data = json_decode(file_get_contents("php://input"));
    $db = Database::$conn;

    $titre = $data->titre;
    $description = $data->description;

    $proposition = new Proposition($titre, $description);

    $query = "INSERT INTO Proposition::$table (titreProposition, descProposition)
            VALUES (:name, :email, :proposition)";

    $response = array(
        "message" => "Proposition added successfully",
        "data" => $data
    );

    echo json_encode($response);
}

/* This function is used to return a JSON response when fields are incomplete. */
function fieldsIncomplete() {
    $response = array(
        "message" => "Please fill in all fields"
    );

    echo json_encode($response);
}

/*
* This function is used to handle special characters in a string.
* @param string $data The string to handle.
* @return string The string with special characters handled.
*/
function handleChars(string $data) {
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

?>
