<?php
require_once 'Modele.php';

class Fait_partie_de extends Modele {
  protected static string $table = 'Fait_partie_de';
  protected static array $cle = ['idGroupe', 'loginInter'];
  protected static array $requiredAttributes = ['idGroupe', 'loginInter'];

    public int $idGroupe;
    public string $loginInter;
    public int $idRole;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (idProposition, loginInter, idRole) "
				. "VALUES (:idProposition, :loginInter, :idRole)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
        $stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
				$stmt->bindParam(':idRole', $this->idRole, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
