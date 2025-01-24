<?php
require_once 'Modele.php';

class Est_envoye_au_membre extends Modele {
  protected static string $table = 'Est_envoye_au_membre';
  protected static array $cle = ['loginInter', 'idNotification'];
  protected static array $requiredAttributes = ['loginInter', 'idNotification'];

    public string $loginInter;
    public int $idNotification;

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
