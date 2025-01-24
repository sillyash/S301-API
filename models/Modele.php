<?php

abstract class Modele {
    protected static string $table;
    protected static array $cle;
    protected static array $requiredAttributes;

    public function __construct(array | object $attrs) {
        if (is_null($attrs)) throw new ArgumentCountError();

        foreach ($attrs as $attr => $value) {
            $this->set($attr, $value);
        }

        foreach (static::$requiredAttributes as $req) {
            if (!isset($this->$req)) throw new ArgumentCountError();
        }
    }


    public static function handlePostRequest() {
        $className = static::$table;
        Router::addRoute('POST', "/$className", function()
        {
            $data = json_decode(file_get_contents("php://input"));
    
            try {
                $classInstance = new $className($data);
            } catch (Exception $e) {
                objectCreateError($e->getMessage(), $data);
                return;
            }
    
            try {
                $classInstance->pushToDb();
            } catch (Exception $e) {
                sqlError($e->getMessage(), $classInstance);
                return;
            }
    
            creationSuccess($classInstance);
        });
    }
    

    /**
    * This function is used to push an object to the database.
    * @return bool The result of the push.
    */
    abstract public function pushToDb();

    public static function getCle() { return static::$cle; }
    public static function getTable() { return static::$table; }
    public function get(string $attr) { return $this->$attr; }
    public function set(string $attr, mixed $value) { $this->$attr = $value; }
}

?>
