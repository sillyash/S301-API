<?php
require_once 'Modele.php';

class Commentaire extends Modele {
    protected static string $table = 'Commentaire';
    protected static array $cle = ['idCommentaire'];
    protected static array $requiredAttributes = [
        'descCommentaire',
        'dateCommentaire',
        'loginInter',
        'idProposition'
    ];

    public int $idCommentaire;
    public string $descCommentaire;
    public string $dateCommentaire;
    public string $loginInter;
    public int $idProposition;
}

?>
