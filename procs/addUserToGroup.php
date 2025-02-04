<?php
require_once 'Procedure.php';

class AddUserToGroup extends Procedure {
    protected static string $name = 'addUserToGroup';
    protected static ?array $in = ['login', 'nomGrp'];
    protected static ?array $out = null;
}

?>
