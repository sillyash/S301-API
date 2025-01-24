<?php
require_once 'Modele.php';

class Reagit extends Modele {
  protected static string $table = 'Reagit';
  protected static array $cle = ['loginInter', 'idReaction'];
  protected static array $requiredAttributes = ['loginInter', 'idReaction'];

    public string $loginInter;
    public int $idReaction;
}

?>
