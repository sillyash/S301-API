<?php
require_once 'Modele.php';

class A_pour_reaction extends Modele {
  protected static string $table = 'A_pour_reaction';
  protected static array $cle = ['idProposition', 'idReaction'];
  protected static array $requiredAttributes = ['idProposition', 'idReaction'];

    public int $idProposition;
    public int $idReaction;
}

?>
