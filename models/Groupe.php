<?php
require_once 'Modele.php';

class Groupe extends Modele {
    protected static array $cle = ['idGroupe'];
    protected static string $table = 'Groupe';
    protected static array $requiredAttributes = ['nomGroupe'];

    public int $idGroupe;
    public string $nomGroupe;

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
