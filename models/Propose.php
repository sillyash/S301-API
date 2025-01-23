<?php
require_once 'Modele.php';

class Propose extends Modele {
    private static $cle = ['idProposition', 'loginInter'];
    private static $table = 'Propose';

    public int $idProposition;
    public string $loginInter;

    public function __construct(
        int $idProposition,
        string $loginInter
    ) {
        $this->idProposition = $idProposition;
        $this->loginInter = $loginInter;
    }

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
