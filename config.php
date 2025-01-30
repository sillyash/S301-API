<?php

// development flag
if (!defined('DEV')) define('DEV', true);

// error reporting
if (DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ERROR);
    ini_set('display_errors', 0);
}

// paths
if (!defined('ROOT_PATH')) define('ROOT_PATH', __DIR__);
if (!defined('ROUTES_PATH')) define('ROUTES_PATH', ROOT_PATH . "/routes");
if (!defined('API_ROUTE_INDEX')) define('API_ROUTE_INDEX', 3);

// database settings
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'prj-mmorich');
if (!defined('DB_USER')) define('DB_USER', 'prj-mmorich');
if (!defined('DB_PASS')) define('DB_PASS', 'vZnmFpECUAvJTwCf');

// email settings
if (!defined('EMAIL_FROM')) define('EMAIL_FROM', 'prj-mmorich@projets.iut-oray.fr');
if (!defined('EMAIL_REPLY_TO')) define('EMAIL_REPLY_TO', 'noreply@projets.iut-oray.fr');
if (!defined('EMAIL_HEADERS')) define('EMAIL_HEADERS', array(
    'MIME-Version' => '1.0',
    'Content-type' => 'text/html; charset=utf-8',
    'From' => EMAIL_FROM,
    'Reply-To' => EMAIL_REPLY_TO,
    'X-Mailer' => 'PHP/' . phpversion()
));

?>
