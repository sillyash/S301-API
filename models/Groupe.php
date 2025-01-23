<?php
require_once 'Modele.php';

class Groupe extends Modele {
    private static array $cle = ['idGroupe'];
    private static string $table = 'Groupe';
    private static array $requiredAttributes = ['nomGroupe'];

    public int $idGroupe;
    public string $nomGroupe;

    public function __construct(
        string $nomGroupe,
        int $idGroupe = null
    ) {
        if ($idGroupe) {
            $this->idGroupe = $idGroupe;
        }
        $this->nomGroupe = $nomGroupe;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (nomGroupe) VALUES (:nomGroupe)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomGroupe', $this->nomGroupe, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}

?>
