<?php
require_once 'Modele.php';

class Concerne_la_notification extends Modele {
    private static $cle = ['idProposition', 'idNotification'];
    private static $table = 'Concerne_la_notification';

    public int $idProposition;
    public int $idNotification;

    public function __construct(
        int $idProposition,
        int $idNotification
    ) {
        $this->idProposition = $idProposition;
        $this->idNotification = $idNotification;
    }

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
