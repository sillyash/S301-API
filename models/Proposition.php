<?php
require_once 'Modele.php';

class Proposition extends Modele {
    private static $cle = 'idProposition';
    private static $table = 'Proposition';

    public int $idProposition;
    public string $titre;
    public string $description;
    public string $dateProp;
    public int $idBudget;

    /**
     * Constructeur de la classe Proposition
     * @param string $titre Le titre de la proposition
     * @param string $description La description de la proposition
     * @param int $idProposition L'identifiant de la proposition (optionnel)
     * @return void
     */
    public function __construct(
        string $titre,
        string $description,
        int $idBudget,
        int $idProposition = null,
        DateTime $dateProp = null
    ) {
        if ($idProposition) $this->idProposition = $idProposition;
        if ($dateProp) $this->dateProp = $dateProp;
        $this->titre = $titre;
        $this->description = $description;
        $this->idBudget = $idBudget;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO " . static::$table ." (titreProposition, descProposition, idBudget) VALUES (:titre, :description, :idBudget)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':idBudget', $this->idBudget);
        $stmt->execute();
        return true;
    }
}

?>
