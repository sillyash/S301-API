<?php
/* This file is used to define routes for GET requests. */
require_once(ROOT_PATH . '/models/A_pour_reaction.php');
require_once(ROOT_PATH . '/models/A_pour_theme.php');
require_once(ROOT_PATH . '/models/Budget.php');
require_once(ROOT_PATH . '/models/Commentaire.php');
require_once(ROOT_PATH . '/models/Concerne_la_notification.php');
require_once(ROOT_PATH . '/models/Est_envoye_au_membre.php');
require_once(ROOT_PATH . '/models/Fait_partie_de.php');
require_once(ROOT_PATH . '/models/Groupe.php');
require_once(ROOT_PATH . '/models/Internaute.php');
require_once(ROOT_PATH . '/models/Notification.php');
require_once(ROOT_PATH . '/models/Propose.php');
require_once(ROOT_PATH . '/models/Proposition.php');
require_once(ROOT_PATH . '/models/Reaction.php');
require_once(ROOT_PATH . '/models/Reagit.php');
require_once(ROOT_PATH . '/models/Role.php');
require_once(ROOT_PATH . '/models/Scrutin.php');
require_once(ROOT_PATH . '/models/Signalement.php');
require_once(ROOT_PATH . '/models/Theme.php');
require_once(ROOT_PATH . '/models/Vote.php');

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

A_pour_reaction::handleGetRequestTable();
A_pour_theme::handleGetRequestTable();
Budget::handleGetRequestTable();
Commentaire::handleGetRequestTable();
Concerne_la_notification::handleGetRequestTable();
Est_envoye_au_membre::handleGetRequestTable();
Fait_partie_de::handleGetRequestTable();
Groupe::handleGetRequestTable();
Internaute::handleGetRequestTable();
Notification::handleGetRequestTable();
Propose::handleGetRequestTable();
Proposition::handleGetRequestTable();
Reaction::handleGetRequestTable();
Reagit::handleGetRequestTable();
Role::handleGetRequestTable();
Scrutin::handleGetRequestTable();
Signalement::handleGetRequestTable();
Theme::handleGetRequestTable();
Vote::handleGetRequestTable();

?>