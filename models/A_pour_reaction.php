<?php
require_once 'Modele.php';

class A_pour_reaction extends Modele {
    private static $cle = ['idProposition', 'idReaction'];
    private static $table = 'A_pour_reaction';

    public int $idProposition;
    public int $idReaction;

    public function __construct(
        int $idProposition,
        int $idReaction
    ) {
        $this->idProposition = $idProposition;
        $this->idReaction = $idReaction;
    }

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (idProposition, idReaction) "
				. "VALUES (:idProposition, :idReaction)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
				$stmt->bindParam(':idReaction', $this->idReaction, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
