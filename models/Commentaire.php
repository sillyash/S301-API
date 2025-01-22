<?php
require_once 'Modele.php';

class Commentaire extends Modele {
    private static $cle = 'idCommentaire';
    private static $table = 'Commentaire';

    public int $idCommentaire;
    public string $descCommentaire;
    public string $dateCommentaire;
    public int $idMembre;
    public int $idProposition;

    /**
     * Constructeur de la classe Commentaire
     * @param int $idMembre
     * @param int $idProposition
     * @param string $descCommentaire
     * @param string $dateCommentaire
     * @param int $idCommentaire
     * @return void
     */
    public function __construct(
        int $idMembre,
        int $idProposition,
        string $descCommentaire,
        string $dateCommentaire = null,
        int $idCommentaire = null
    ) {
        if ($idCommentaire !== null) {
            $this->idCommentaire = $idCommentaire;
        }

        if ($dateCommentaire === null) {
            $dateCommentaire = date('Y-m-d H:i:s');
        }

        $this->idMembre = $idMembre;
        $this->idProposition = $idProposition;
        $this->descCommentaire = $descCommentaire;
        $this->dateCommentaire = $dateCommentaire;
    }
    
    public function pushToDb() {
        $db = Database::$conn;
        $query = "INSERT INTO ".static::$table." (idMembre, idProposition, descCommentaire, dateCommentaire) "
        ."VALUES (:idMembre, :idProposition, :descCommentaire, :dateCommentaire)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':idMembre', $this->idMembre);
        $stmt->bindParam(':idProposition', $this->idProposition);
        $stmt->bindParam(':descCommentaire', $this->descCommentaire);
        $stmt->bindParam(':dateCommentaire', $this->dateCommentaire);
        $stmt->execute();
        return true;
    }
    
}

?>
