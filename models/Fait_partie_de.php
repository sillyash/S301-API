<?php
require_once 'Modele.php';

class Fait_partie_de extends Modele {
  private static string $table = 'Fait_partie_de';
  private static array $cle = ['idGroupe', 'loginInter'];
  private static array $requiredAttributes = ['idGroupe', 'loginInter'];

    public int $idGroupe;
    public string $loginInter;
    public int $idRole;

    public function __construct(
        int $idGroupe,
        string $loginInter,
        int $idRole
    ) {
        $this->idProposition = $idProposition;
        $this->loginInter = $loginInter;
        $this->idRole = $idRole;
    }

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
