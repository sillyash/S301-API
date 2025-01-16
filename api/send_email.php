<?php
require_once('../config/config.php');

function send_email(string $to, string $subject, string $message) {
    $mailOK = mail($to, $subject, $message, HEADERS);
    return $mailOK;
}

?>
