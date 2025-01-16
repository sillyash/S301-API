<?php

// Paths
define('ROOT_PATH', realpath('../' . dirname(__FILE__)));

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'prj-mmorich');
define('DB_USER', 'prj-mmorich');
define('DB_PASS', 'vZnmFpECUAvJTwCf');

// Email
define('EMAIL_FROM', 'prj-mmorich@projets.iut-orsay.fr');
define('EMAIL_REPLY_TO', 'noreply@projets.iut-orsay.fr');
define('HEADERS', [
    'From' => 'prj-mmorich <' . EMAIL_FROM . '>',
    'Cc' => 'prj-mmorich <' . EMAIL_FROM . '>',
    'X-Sender' => 'prj-mmorich <' . EMAIL_FROM . '>',
    'X-Mailer' => 'PHP/' . phpversion(),
    'X-Priority' => '1',
    'Return-Path' => EMAIL_REPLY_TO,
    'MIME-Version' => '1.0',
    'Content-Type' => 'text/html; charset=iso-8859-1'
]);

?>
