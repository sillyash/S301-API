<?php
require_once 'Modele.php';

class Fait_partie_de extends Modele {
  protected static string $table = 'Fait_partie_de';
  protected static array $cle = ['idGroupe', 'loginInter'];
  protected static array $requiredAttributes = ['idGroupe', 'loginInter'];

    public int $idGroupe;
    public string $loginInter;
    public int $idRole;
}

?>
