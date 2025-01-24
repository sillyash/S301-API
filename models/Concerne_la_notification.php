<?php
require_once 'Modele.php';

class Concerne_la_notification extends Modele {
  protected static string $table = 'Concerne_la_notification';
  protected static array $cle = ['idProposition', 'idNotification'];
  protected static array $requiredAttributes = ['idProposition', 'idNotification'];

    public int $idProposition;
    public int $idNotification;
}

?>
