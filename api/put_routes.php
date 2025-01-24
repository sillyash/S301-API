<?php
/*  This file is used to define routes for DELETE requests. */
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

A_pour_reaction::handlePutRequest();
A_pour_theme::handlePutRequest();
Budget::handlePutRequest();
Commentaire::handlePutRequest();
Concerne_la_notification::handlePutRequest();
Est_envoye_au_membre::handlePutRequest();
Fait_partie_de::handlePutRequest();
Groupe::handlePutRequest();
Internaute::handlePutRequest();
Notification::handlePutRequest();
Propose::handlePutRequest();
Proposition::handlePutRequest();
Reaction::handlePutRequest();
Reagit::handlePutRequest();
Role::handlePutRequest();
Scrutin::handlePutRequest();
Signalement::handlePutRequest();
Theme::handlePutRequest();
Vote::handlePutRequest();

?>
