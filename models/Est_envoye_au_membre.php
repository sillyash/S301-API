<?php
require_once 'Modele.php';

class Est_envoye_au_membre extends Modele {
  protected static string $table = 'Est_envoye_au_membre';
  protected static array $cle = ['loginInter', 'idNotification'];
  protected static array $requiredAttributes = ['loginInter', 'idNotification'];

    public string $loginInter;
    public int $idNotification;
}

?>
