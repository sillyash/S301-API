<?php
require_once 'Modele.php';

class Commentaire extends Modele {
    protected static string $table = 'Commentaire';
    protected static array $cle = [];
    protected static array $requiredAttributes = [];
    protected static array $optionalAttributes = [];
}

?>
