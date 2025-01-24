<?php
require_once 'Modele.php';

class Concerne_la_notification extends Modele {
  protected static string $table = 'Concerne_la_notification';
  protected static array $cle = ['idProposition', 'idNotification'];
  protected static array $requiredAttributes = ['idProposition', 'idNotification'];

    public int $idProposition;
    public int $idNotification;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (idProposition, idNotification) "
				. "VALUES (:idProposition, :idNotification)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
				$stmt->bindParam(':idNotification', $this->idNotification, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
