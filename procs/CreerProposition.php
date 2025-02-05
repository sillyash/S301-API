<?php
require_once 'Procedure.php';

class CreerProposition extends Procedure {
    protected static string $name = 'CreerProposition';
    protected static ?array $in = [
        'titre',
        'description',
        'idBudget',
        'coutProposition',
        'idTheme',
        'loginInter'
    ];
    protected static ?array $out = null;
}

?>
