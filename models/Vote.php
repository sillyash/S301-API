<?php
require_once 'Modele.php';

class Vote extends Modele {
    protected static string $table = 'Vote';
    protected static array $cle = [];
    protected static array $requiredAttributes = [];
    protected static array $optionalAttributes = [];
}

?>
