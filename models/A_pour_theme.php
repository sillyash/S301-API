<?php
require_once 'Modele.php';

class A_pour_theme extends Modele {
  protected static string $table = 'A_pour_theme';
  protected static array $cle = ['idProposition', 'idTheme'];
  protected static array $requiredAttributes = ['idProposition', 'idReaction'];

    public int $idProposition;
    public int $idTheme;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (idProposition, idTheme) "
				. "VALUES (:idProposition, :idTheme)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
				$stmt->bindParam(':idTheme', $this->idTheme, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
