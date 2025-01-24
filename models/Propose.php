<?php
require_once 'Modele.php';

class Propose extends Modele {
  protected static string $table = 'Propose';
  protected static array $cle = ['idProposition', 'loginInter'];
  protected static array $requiredAttributes = ['idProposition', 'loginInter'];

    public int $idProposition;
    public string $loginInter;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (idProposition, loginInter) "
				. "VALUES (:idProposition, :loginInter)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
				$stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}

?>
