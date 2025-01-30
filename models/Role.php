<?php
require_once 'Modele.php';

class Role extends Modele {
    protected static string $table = 'Role';
    protected static array $cle = [];
    protected static array $requiredAttributes = [];
    protected static array $optionalAttributes = [];
}

?>
