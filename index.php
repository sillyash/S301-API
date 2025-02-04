<?php
require_once('config.php');
require_once(ROOT_PATH . '/api/db.php');
Database::createConnection();

/* Models */
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

A_pour_reaction::init();
A_pour_theme::init();
Budget::init();
Commentaire::init();
Concerne_la_notification::init();
Est_envoye_au_membre::init();
Fait_partie_de::init();
Groupe::init();
Internaute::init();
Notification::init();
Propose::init();
Proposition::init();
Reaction::init();
Reagit::init();
Role::init();
Scrutin::init();
Signalement::init();
Theme::init();
Vote::init();

/* Views */
require_once(ROOT_PATH . '/views/BudgetsParThematique.php');
require_once(ROOT_PATH . '/views/GroupesUtilisateur.php');
require_once(ROOT_PATH . '/views/MembresGroupe.php');
require_once(ROOT_PATH . '/views/PropositionsPopulaires.php');
require_once(ROOT_PATH . '/views/PropositionsRecentes.php');
require_once(ROOT_PATH . '/views/PropositionsUtilisateur.php');
require_once(ROOT_PATH . '/views/PropositionsValidees.php');
require_once(ROOT_PATH . '/views/VueBudgetsParThematique.php');
require_once(ROOT_PATH . '/views/ScrutinsGroupe.php');
require_once(ROOT_PATH . '/views/PropositionsGroupe.php');
require_once(ROOT_PATH . '/views/PropositionsDetaillees.php');

/* Procedures */
require_once(ROOT_PATH . '/procs/addUserToGroup.php');

require_once(ROOT_PATH . '/api/api.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$request_method = $_SERVER["REQUEST_METHOD"];

Router::dispatch($request_method, $uri);

?>
