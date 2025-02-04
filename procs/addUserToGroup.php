<?php
require_once 'Procedure.php';

class AddUserToGroup extends Procedure {
    protected static string $name = 'addUserToGroup';
    protected static ?array $in = ['id_user', 'id_group'];
    protected static ?array $out = null;
}

?>
