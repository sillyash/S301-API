<?php
require_once 'Modele.php';

class Theme extends Modele {
    protected static string $table = 'Theme';
    protected static array $cle = ['idTheme'];
    protected static array $requiredAttributes = ['nomTheme', 'idGroupe'];

    public int $idTheme;
    public string $nomTheme;
    public int $idGroupe;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (nomTheme, idGroupe) "
        . "VALUES (:nomTheme, :idGroupe)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomTheme', $this->nomInter, PDO::PARAM_STR);
        $stmt->bindParam(':idGroupe', $this->prenomInter, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
