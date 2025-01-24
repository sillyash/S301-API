<?php
require_once 'Modele.php';

class A_pour_theme extends Modele {
  protected static string $table = 'A_pour_theme';
  protected static array $cle = ['idProposition', 'idTheme'];
  protected static array $requiredAttributes = ['idProposition', 'idReaction'];

    public int $idProposition;
    public int $idTheme;
}

?>
