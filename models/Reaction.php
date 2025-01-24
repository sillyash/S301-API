<?php
require_once 'Modele.php';

class Reaction extends Modele {
    protected static string $table = 'Reaction';
    protected static array $cle = ['idReaction'];

    public int $idReaction;
    public int $typeReaction;

    public function __construct(
        int $typeReaction,
        int $idReaction = null
    ) {
        if ($idReaction) $this->idReaction = $idReaction;
        $this->typeReaction = $typeReaction;
    }

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (typeReaction) VALUES (:typeReaction)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':typeReaction', $this->typeReaction, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
