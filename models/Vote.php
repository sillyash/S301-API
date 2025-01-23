<?php
require_once 'Modele.php';

class Vote extends Modele {
    private static $cle = ['loginInter', 'idScrutin'];
    private static $table = 'Vote';

    public string $loginInter;
    public int $idScrutin;

    public function __construct(
        string $loginInter,
        int $idScrutin
    ) {
        $this->loginInter = $loginInter;
        $this->idScrutin = $idScrutin;
    }

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
