<?php
require_once 'Modele.php';

class Budget extends Modele {
    protected static string $table = 'Budget';
    protected static array $cle = ['idBudget'];
    protected static array $requiredAttributes = ['limiteBudgetGlobal'];

    public int $idBudget;
    public int $limiteBudgetGlobal;
}

?>
