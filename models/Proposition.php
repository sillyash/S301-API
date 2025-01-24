<?php
require_once 'Modele.php';

class Proposition extends Modele {
    protected static string $table = 'Proposition';
    protected static array $cle = ['idProposition'];
    protected static array $requiredAttributes = [
        'titre',
        'description',
        'idBudget'
    ];

    public int $idProposition;
    public string $titre;
    public string $description;
    public int $popularite;
    public string $dateProp;
    public int $idBudget;
}

?>
