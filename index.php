<?php
require_once('config.php');
require_once(ROOT_PATH . '/api/api.php');

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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$request_method = $_SERVER["REQUEST_METHOD"];

Router::dispatch($request_method, $uri);

?>
