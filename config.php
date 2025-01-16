<?php

// paths
if (!defined('ROOT_PATH')) define('ROOT_PATH', __DIR__);
if (!defined('API_ROUTE_INDEX')) define('API_ROUTE_INDEX', 3);

// database settings
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'prj-mmorich');
if (!defined('DB_USER')) define('DB_USER', 'prj-mmorich');
if (!defined('DB_PASS')) define('DB_PASS', 'vZnmFpECUAvJTwCf');

// email settings
if (!defined('EMAIL_FROM')) define('EMAIL_FROM', 'email@example.com');
if (!defined('EMAIL_REPLY_TO')) define('EMAIL_REPLY_TO', 'replyto@example.com');
if (!defined('EMAIL_HEADERS')) define('EMAIL_HEADERS', array(
    'From' => EMAIL_FROM,
    'Reply-To' => EMAIL_REPLY_TO,
    'X-Mailer' => 'PHP/' . phpversion()
));

?>
