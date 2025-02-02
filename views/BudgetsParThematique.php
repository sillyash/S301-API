<?php
require_once 'View.php';

class BudgetsParThematique extends View {
    protected static string $table = 'BudgetsParThematique';
    protected static array $cle = ['nomTheme'];
}

?>