<?php
require_once 'Modele.php';

class Internaute extends Modele {
    private static $cle = 'idInternaute';
    private static $table = 'Internaute';

    public int $idInternaute;
    public string $nomInter;
    public string $prenomInter;
    public string $emailInter;
    public string $loginInter;
    public string $mdpInter;

    public function __construct(
        string $nomInter,
        string $prenomInter,
        string $emailInter,
        string $loginInter,
        string $mdpInter,
        int $idInternaute = null
    ) {
        if ($idInternaute) {
            $this->idInternaute = $idInternaute;
        }
        $this->nomInter = $nomInter;
        $this->prenomInter = $prenomInter;
        $this->emailInter = $emailInter;
        $this->loginInter = $loginInter;
        $this->mdpInter = $mdpInter;
    }

    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (nomInter, prenomInter, emailInter, loginInter, mdpInter)"
        ." VALUES (:nomInter, :prenomInter, :emailInter, :loginInter, :mdpInter)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomInter', $this->nomInter, PDO::PARAM_STR);
        $stmt->bindParam(':prenomInter', $this->prenomInter, PDO::PARAM_STR);
        $stmt->bindParam(':emailInter', $this->emailInter, PDO::PARAM_STR);
        $stmt->bindParam(':loginInter', $this->loginInter, PDO::PARAM_STR);
        $stmt->bindParam(':mdpInter', $this->mdpInter, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
}

?>
