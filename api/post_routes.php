<?php
/* This file is used to define routes for POST requests. */
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

A_pour_reaction::handlePostRequest();
A_pour_theme::handlePostRequest();
Budget::handlePostRequest();
Commentaire::handlePostRequest();
Concerne_la_notification::handlePostRequest();
Est_envoye_au_membre::handlePostRequest();
Fait_partie_de::handlePostRequest();
Groupe::handlePostRequest();
Internaute::handlePostRequest();
Notification::handlePostRequest();
Propose::handlePostRequest();
Proposition::handlePostRequest();
Reaction::handlePostRequest();
Reagit::handlePostRequest();
Role::handlePostRequest();
Scrutin::handlePostRequest();
Signalement::handlePostRequest();
Theme::handlePostRequest();
Vote::handlePostRequest();

?>
