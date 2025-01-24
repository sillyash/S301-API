<?php
require_once 'Modele.php';

class Role extends Modele {
    protected static string $table = 'Role';
    protected static array $cle = ['idRole'];
    protected static array $requiredAttributes = ['nomRole'];

    public int $idRole;
    public string $nomRole;
}

?>
