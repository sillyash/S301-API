<?php
require_once 'Modele.php';

class Signalement extends Modele {
    private static $cle = 'idSignalement';
    private static $table = 'Signalement';

    public int $idSignalement;
    public int $nbSignalements;
    public string $loginInter;
    public int $idProposition;
    public int $idCommentaire;

    public function __construct(
        int $nbSignalements,
        string $loginInter,
        int $idProposition,
        int $idCommentaire,
        int $idSignalement = null
    ) {
        if ($idSignalement) $this->idSignalement = $idSignalement;
        $this->nbSignalements = $nbSignalements;
        $this->loginInter = $loginInter;
        $this->idProposition = $idProposition;
        $this->idCommentaire = $idCommentaire;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (nbSignalements, loginInter, idProposition, idCommentaire)"
        ." VALUES (:nbSignalements, :loginInter, :idProposition, :idCommentaire)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nbSignalements', $this->nbSignalements, PDO::PARAM_INT);
        $stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
        $stmt->bindParam(':idCommentaire', $this->idCommentaire, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
