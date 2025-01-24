<?php
require_once 'Modele.php';

class Propose extends Modele {
  protected static string $table = 'Propose';
  protected static array $cle = ['idProposition', 'loginInter'];
  protected static array $requiredAttributes = ['idProposition', 'loginInter'];

    public int $idProposition;
    public string $loginInter;
}

?>
