<?php
require_once 'Modele.php';

class A_pour_theme extends Modele {
    private static $cle = ['idProposition', 'idTheme'];
    private static $table = 'A_pour_theme';

    public int $idProposition;
    public int $idTheme;

    public function __construct(
        int $idProposition,
        int $idTheme
    ) {
        $this->idProposition = $idProposition;
        $this->idTheme = $idTheme;
    }

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
