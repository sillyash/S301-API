<?php
require_once 'Modele.php';

class Commentaire extends Modele {
    private static string $table = 'Commentaire';
    private static array $cle = ['idCommentaire'];
    private static array $requiredAttributes = [
        'descCommentaire',
        'dateCommentaire',
        'loginInter',
        'idProposition'
    ];

    public int $idCommentaire;
    public string $descCommentaire;
    public string $dateCommentaire;
    public string $loginInter;
    public int $idProposition;

    /**
     * Constructeur de la classe Commentaire
     * @param int $idMembre
     * @param int $idProposition
     * @param string $descCommentaire
     * @param DateTime $dateCommentaire (optionnel)
     * @param int $idCommentaire (optionnel)
     * @return void
     */
    public function __construct(
        int $idMembre,
        int $idProposition,
        string $descCommentaire,
        DateTime $dateCommentaire = null,
        int $idCommentaire = null
    ) {
        if ($idCommentaire) $this->idCommentaire = $idCommentaire;
        if ($dateCommentaire) $this->dateCommentaire = $dateCommentaire;
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
