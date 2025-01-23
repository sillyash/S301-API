<?php
require_once 'Modele.php';

class Est_envoye_au_membre extends Modele {
    private static $cle = ['loginInter', 'idNotification'];
    private static $table = 'Est_envoye_au_membre';

    public string $loginInter;
    public int $idNotification;

    public function __construct(
        string $loginInter,
        int $idNotification
    ) {
        $this->loginInter = $loginInter;
        $this->idNotification = $idNotification;
    }

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (loginInter, idNotification) "
				. "VALUES (:loginInter, :idNotification)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
				$stmt->bindParam(':idNotification', $this->idNotification, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
