<?php
require_once 'Modele.php';

class Commentaire extends Modele {
    protected static string $table = 'Commentaire';
    protected static array $cle = ['idCommentaire'];
    protected static array $requiredAttributes = [
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
