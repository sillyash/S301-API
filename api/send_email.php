<?php

function send_email(string $to, string $subject, string $message) {
    $mailOK = mail($to, $subject, $message, EMAIL_HEADERS);
    return $mailOK;
}

?>
