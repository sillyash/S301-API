<?php

abstract class Modele {
    private static $cle;
    private static $table;

    /**
    * This function is used to push an object to the database.
    * @return bool The result of the push.
    */
    abstract public function pushToDb();

    public static function getCle() {
        return static::$cle;
    }

    public static function getTable() {
        return static::$table;
    }

    public function get(string $attr) {
        return $this->$attr;
    }

    public function set(string $attr, mixed $value) {
        $this->$attr = $value;
    }
}

?>
