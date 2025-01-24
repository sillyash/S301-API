<?php
require_once 'Modele.php';

class Internaute extends Modele {
    protected static string $table = 'Internaute';
    protected static array $cle = ['loginInter'];
    protected static array $requiredAttributes = [
        'nomInter',
        'prenomInter',
        'emailInter',
        'loginInter',
        'mdpInter'
    ];

    public string $nomInter;
    public string $prenomInter;
    public string $emailInter;
    public string $loginInter;
    public string $mdpInter;
    public string $adrInter;
}

?>
