<?php
require_once 'Modele.php';

class Notification extends Modele {
    private static $cle = 'idNotification';
    private static $table = 'Notification';

    public int $idNotification;
    public string $typeNotification;
    public string $messageNotification;
    public string $etatNotification;
    public string $frequenceNotification;

    public function __construct(
        string $typeNotification,
        string $messageNotification,
        string $etatNotification,
        string $frequenceNotification,
        int $idNotification = null
    ) {
        if ($idNotification) $this->idNotification = $idNotification;
        $this->typeNotification = $typeNotification;
        $this->messageNotification = $messageNotification;
        $this->etatNotification = $etatNotification;
        $this->frequenceNotification = $frequenceNotification;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (typeNotification, messageNotification, etatNotification, frequenceNotification)"
        ." VALUES (:typeNotification, :messageNotification, :etatNotification, :frequenceNotification)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':typeNotification', $this->typeNotification, PDO::PARAM_STR);
        $stmt->bindParam(':messageNotification', $this->messageNotification, PDO::PARAM_STR);
        $stmt->bindParam(':etatNotification', $this->etatNotification, PDO::PARAM_STR);
        $stmt->bindParam(':frequenceNotification', $this->frequenceNotification, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}

?>
