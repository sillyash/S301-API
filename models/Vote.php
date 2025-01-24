<?php
require_once 'Modele.php';

class Vote extends Modele {
  protected static string $table = 'Vote';
  protected static array $cle = ['loginInter', 'idScrutin'];
  protected static array $requiredAttributes = ['loginInter', 'idScrutin'];

    public string $loginInter;
    public int $idScrutin;
}

?>
