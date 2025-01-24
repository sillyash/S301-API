<?php
require_once 'Modele.php';

class Reaction extends Modele {
    protected static string $table = 'Reaction';
    protected static array $cle = ['idReaction'];
    protected static array $requiredAttributes = ['typeReaction'];

    public int $idReaction;
    public int $typeReaction;
}

?>
