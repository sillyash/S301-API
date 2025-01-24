<?php
require_once 'Modele.php';

class Internaute extends Modele {
    protected static string $table = 'Internaute';
    protected static array $cle = ['loginInter'];
    protected static array $requiredAttributes = [
        'nomInter',
        'prenomInter',
        'emailInter',
        'loginInter',
        'mdpInter'
    ];

    public string $nomInter;
    public string $prenomInter;
    public string $emailInter;
    public string $loginInter;
    public string $mdpInter;
    public string $adrInter;

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (nomInter, prenomInter, emailInter, loginInter, mdpInter, adrInter)"
        ." VALUES (:nomInter, :prenomInter, :emailInter, :loginInter, :mdpInter, :adrInter)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomInter', $this->nomInter, PDO::PARAM_STR);
        $stmt->bindParam(':prenomInter', $this->prenomInter, PDO::PARAM_STR);
        $stmt->bindParam(':emailInter', $this->emailInter, PDO::PARAM_STR);
        $stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->bindParam(':mdpInter', $this->mdpInter, PDO::PARAM_STR);
        $stmt->bindParam(':adrInter', $this->adrInter, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}

?>
