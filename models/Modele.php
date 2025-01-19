<?php

class Modele {
    private static $cle;
    private static $table;

    public static function getCle() {
        return static::$cle;
    }

    public static function setCle($cle) {
        static::$cle = $cle;
    }

    public static function getTable() {
        return static::$table;
    }

    public static function setTable($table) {
        static::$table = $table;
    }

    public function get(string $attr) {
        return $this->$attr;
    }

    public function set(string $attr, mixed $value) {
        $this->$attr = $value;
    }
}

?>
