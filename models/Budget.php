<?php
require_once 'Modele.php';

class Budget extends Modele {
    protected static string $table = 'Budget';
    protected static array $cle = [];
    protected static array $requiredAttributes = [];
    protected static array $optionalAttributes = [];
}

?>
