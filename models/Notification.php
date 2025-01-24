<?php
require_once 'Modele.php';

class Notification extends Modele {
    protected static string $table = 'Notification';
    protected static array $cle = ['idNotification'];
    protected static array $requiredAttributes = [
        'typeNotification',
        'messageNotification'
    ];

    public int $idNotification;
    public string $typeNotification;
    public string $messageNotification;
    public string $etatNotification;
    public string $frequenceNotification;
}

?>
