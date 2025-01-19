<?php
require_once 'Modele.php';

class Proposition extends Modele {
    protected static $cle = 'idProposition';
    protected static $table = 'Proposition';

    protected int $idProposition;
    protected string $titre;
    protected string $description;

    /**
     * Constructeur de la classe Proposition
     * @param string $titre Le titre de la proposition
     * @param string $description La description de la proposition
     * @param int $idProposition L'identifiant de la proposition (optionnel)
     * @return void
     */
    public function __construct(string $titre, string $description, int $idProposition = -1) {
        if ($idProposition !== -1) {
            $this->idProposition = $idProposition;
        }
        $this->titre = $titre;
        $this->description = $description;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO " . static::$table ." (titreProposition, descProposition) VALUES (:titre, :description)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
        return true;
    }
}

?>
