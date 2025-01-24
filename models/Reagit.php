<?php
require_once 'Modele.php';

class Reagit extends Modele {
  protected static string $table = 'Reagit';
  protected static array $cle = ['loginInter', 'idReaction'];

    public string $loginInter;
    public int $idReaction;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (loginInter, idReaction) "
				. "VALUES (:loginInter, :idReaction)";

        $stmt = $db->prepare($query);
				$stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->bindParam(':idReaction', $this->idReaction, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
