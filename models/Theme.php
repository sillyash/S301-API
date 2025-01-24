<?php
require_once 'Modele.php';

class Theme extends Modele {
    protected static string $table = 'Theme';
    protected static array $cle = ['idTheme'];
    protected static array $requiredAttributes = ['nomTheme', 'idGroupe'];

    public int $idTheme;
    public string $nomTheme;
    public int $idGroupe;
}

?>
