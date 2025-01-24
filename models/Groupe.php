<?php
require_once 'Modele.php';

class Groupe extends Modele {
    protected static array $cle = ['idGroupe'];
    protected static string $table = 'Groupe';
    protected static array $requiredAttributes = ['nomGroupe'];

    public int $idGroupe;
    public string $nomGroupe;
}

?>
