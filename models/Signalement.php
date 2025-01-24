<?php
require_once 'Modele.php';

class Signalement extends Modele {
    protected static string $table = 'Signalement';
    protected static array $cle = ['idSignalement'];
    protected static array $requiredAttributes = [
        'loginInter',
        'idProposition',
        'idCommentaire'
    ];

    public int $idSignalement;
    public int $nbSignalements;
    public string $loginInter;
    public int $idProposition;
    public int $idCommentaire;
}

?>
