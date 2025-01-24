<?php
require_once 'Modele.php';

class Scrutin extends Modele {
    protected static string $table = 'Scrutin';
    protected static array $cle = ['idScrutin'];
    protected static array $requiredAttributes = [
        'dureeDiscussion',
        'dureeScrutin',
        'natureScrutin',
        'idProposition'
    ];

    public int $idScrutin;
    public int $dureeDiscussion;
    public int $dureeScrutin;
    public string $natureScrutin;
    public string $resultatScrutin;
    public int $idProposition;

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (dureeDiscussion, dureeScrutin, natureScrutin, resultatScrutin, idProposition) "
        . "VALUES (:dureeDiscussion, :dureeScrutin, :natureScrutin, :resultatScrutin, :idProposition)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':dureeDiscussion', $this->dureeDiscussion, PDO::PARAM_INT);
        $stmt->bindParam(':dureeScrutin', $this->dureeScrutin, PDO::PARAM_INT);
        $stmt->bindParam(':natureScrutin', $this->natureScrutin, PDO::PARAM_STR);
        $stmt->bindParam(':resultatScrutin', $this->resultatScrutin, PDO::PARAM_STR);
        $stmt->bindParam(':idProposition', $this->idProposition, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
