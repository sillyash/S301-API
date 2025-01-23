<?php
require_once 'Modele.php';

class Role extends Modele {
    private static string $table = 'Role';
    private static array $cle = ['idRole'];

    public int $idRole;
    public string $nomRole;

    public function __construct(
        string $nomRole,
        int $idRole = null
    ) {
        if ($idRole) $this->idRole = $idRole;
        $this->nomRole = $nomRole;
    }

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (nomRole) VALUES (:nomRole)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomRole', $this->nomRole, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }

}

?>
