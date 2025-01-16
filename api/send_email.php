<?php
require_once('../config/config.php');

function send_email($to, $subject, $message) {
    $headers = "From: " . EMAIL_FROM . "\r\n";
    $headers .= "Reply-To: " . EMAIL_REPLY_TO . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if(mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

?>
