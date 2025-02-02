<?php
/* This file is used to define routes for GET requests. */

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

A_pour_reaction::handleGetRequest();
A_pour_theme::handleGetRequest();
Budget::handleGetRequest();
Commentaire::handleGetRequest();
Concerne_la_notification::handleGetRequest();
Est_envoye_au_membre::handleGetRequest();
Fait_partie_de::handleGetRequest();
Groupe::handleGetRequest();
Internaute::handleGetRequest();
Notification::handleGetRequest();
Propose::handleGetRequest();
Proposition::handleGetRequest();
Reaction::handleGetRequest();
Reagit::handleGetRequest();
Role::handleGetRequest();
Scrutin::handleGetRequest();
Signalement::handleGetRequest();
Theme::handleGetRequest();
Vote::handleGetRequest();

BudgetsParThematique::handleGetRequest();
GroupesUtilisateur::handleGetRequest();
MembresGroupe::handleGetRequest();
PropositionsPopulaires::handleGetRequest();
PropositionsRecentes::handleGetRequest();
PropositionsUtilisateur::handleGetRequest();
PropositionsValidees::handleGetRequest();
VueBudgetsParThematique::handleGetRequest();

?>