<?php
require_once 'Modele.php';

class Budget extends Modele {
    protected static string $table = 'Budget';
    protected static array $cle = ['idBudget'];
    protected static array $requiredAttributes = ['limiteBudgetGlobal'];

    public int $idBudget;
    public int $limiteBudgetGlobal;

    public function __construct(
        int $limiteBudgetGlobal,
        int $idBudget = null
    ) {
        if ($idBudget) $this->idBudget = $idBudget;
        $this->limiteBudgetGlobal = $limiteBudgetGlobal;
    }

    public function pushToDb() {
        $db = Database::$conn;

        $query = "INSERT INTO ".static::$table." (limiteBudgetGlobal) VALUES (:limiteBudgetGlobal)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':limiteBudgetGlobal', $this->limiteBudgetGlobal, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}

?>
