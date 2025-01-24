<?php
require_once 'Modele.php';

class Proposition extends Modele {
    protected static string $table = 'Proposition';
    protected static array $cle = ['idProposition'];
    protected static array $requiredAttributes = [
        'titre',
        'description',
        'idBudget'
    ];

    public int $idProposition;
    public string $titre;
    public string $description;
    public int $popularite;
    public string $dateProp;
    public int $idBudget;
            
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
