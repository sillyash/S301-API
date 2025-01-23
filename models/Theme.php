<?php
require_once 'Modele.php';

class Theme extends Modele {
    private static string $table = 'Theme';
    private static array $cle = ['idTheme'];

    public int $idTheme;
    public string $nomTheme;
    public int $idGroupe;

    public function __construct(
        string $nomTheme,
        int $idGroupe,
        int $idTheme = null
    ) {
        if ($idTheme) $this->idTheme = $idTheme;
        $this->nomTheme = $nomTheme;
        $this->idGroupe = $idGroupe;
    }

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
