<?php
require_once 'Modele.php';

class A_pour_reaction extends Modele {
  protected static string $table = 'A_pour_reaction';
  protected static array $cle = ['idProposition', 'idReaction'];
  protected static array $requiredAttributes = ['idProposition', 'idReaction'];

    public int $idProposition;
    public int $idReaction;

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
