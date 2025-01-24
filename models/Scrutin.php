<?php
require_once 'Modele.php';

class Scrutin extends Modele {
    protected static string $table = 'Scrutin';
    protected static array $cle = ['idScrutin'];
    protected static array $requiredAttributes = [
        'dureeDiscussion',
        'dureeScrutin',
        'natureScrutin',
        'idProposition'
    ];

    public int $idScrutin;
    public int $dureeDiscussion;
    public int $dureeScrutin;
    public string $natureScrutin;
    public string $resultatScrutin;
    public int $idProposition;
}

?>
