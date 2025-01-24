<?php
require_once 'Modele.php';

class Vote extends Modele {
  protected static string $table = 'Vote';
  protected static array $cle = ['loginInter', 'idScrutin'];

    public string $loginInter;
    public int $idScrutin;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (loginInter, idScrutin) "
				. "VALUES (:loginInter, :idScrutin)";

        $stmt = $db->prepare($query);
				$stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->bindParam(':idScrutin', $this->idScrutin, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
