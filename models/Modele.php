<?php

abstract class Modele {
    protected static string $table;
    protected static array $cle;
    protected static array $requiredAttributes;

    public function __construct(array | object $attrs, bool $keysOnly = false) {
        if (is_null($attrs)) throw new ArgumentCountError("Object $attrs is null.");

        if ($keysOnly == true)
        {
            foreach (static::$cle as $attr) {
                if (!isset($attrs[$attr])) {
                    throw new ArgumentCountError("Key value $attr not set.");
                    return false;
                }
                $value = $attrs[$attr];
                $this->set($attr, $value);
            }
        } else {
            foreach ($attrs as $attr => $value) {
                $this->set($attr, $value);
            }

            foreach (static::$requiredAttributes as $req) {
                if (!isset($this->$req)) throw new ArgumentCountError("Required attribute $req is not defined.");
            }
        }
    }


    public static function handlePostRequest() {
        $className = static::$table;
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('POST', "/$className", function()
        {
            $data = json_decode(file_get_contents("php://input"), true, JSON_THROW_ON_ERROR);
    
            try {
                $classInstance = new static::$table($data);
            } catch (Throwable $e) {
                objectCreateError($e->getMessage(), $data);
                return;
            }
    
            try {
                $classInstance->pushToDb();
            } catch (Throwable $e) {
                sqlError($e->getMessage(), $classInstance);
                return;
            }
    
            creationSuccess($classInstance);
        });
    }


    public static function handleDeleteRequest() {
        $className = static::$table;
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('DELETE', "/$className", function()
        {
            $data = $_GET;
    
            try {
                $classInstance = new static::$table($data, true);
            } catch (Throwable $e) {
                objectCreateError($e->getMessage(), $data);
                return;
            }
    
            try {
                $classInstance->deleteFromDb();
            } catch (Throwable $e) {
                sqlError($e->getMessage(), $classInstance);
                return;
            }
    
            deletionSuccess($classInstance);
        });
    }
    
    /**
    * This function is used to push a Model to the database.
    * @return bool The result of the push.
    */
    public function pushToDb() {
        $db = Database::$conn;

        $attrList = "";
        $argsList = "";

        /* 
         * attrList : (arg1, arg2, arg3)
         * argsList : (:arg1, :arg2, :arg3)
        */
        foreach (static::$requiredAttributes as $attr) {
            if ($attrList == "") {
                $attrList = "($attr";
                $argsList = "(:$attr";
            } else {
                $attrList = "$attrList, $attr";
                $argsList = "$argsList, :$attr";
            }
        }
        
        $attrList = $attrList . ")";
        $argsList = $argsList . ")";

        $query = "INSERT INTO " . static::$table . $attrList . " VALUES " . $argsList;
        $stmt = $db->prepare($query);

        foreach (static::$requiredAttributes as $attr) {
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindParam(":$attr", $val, $PDOtype);
        }
        
        $stmt->execute();
        return true;
    }

        /**
    * This function is used to delete a Model from the database.
    * @return bool The result of the delete.
    */
    public function deleteFromDb() {
        $db = Database::$conn;
        $argsList = "";

        // argsList : (arg1 = :arg1) AND (arg2 = :arg2)
        foreach (static::$cle as $attr) {
            if ($argsList == "") {
                $argsList = "($attr = :$attr)";
            } else {
                $argsList = "$argsList AND ($attr = :$attr)";
            }
        }

        $query = "DELETE FROM " . static::$table . " WHERE " . $argsList;
        $stmt = $db->prepare($query);

        foreach (static::$cle as $attr) {
            if ($this->get($attr) === null) {
                throw new ArgumentCountError("Key value $attr not set.");
                return false;
            }
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindParam(":$attr", $val, $PDOtype);
        }
        
        $stmt->execute();
        return true;
    }


    public static function getPDOtype(mixed $var) {
        switch ($var) {
            case is_int($var):
                $PDOtype = PDO::PARAM_INT;
                break;
            case is_bool($var):
                $PDOtype = PDO::PARAM_BOOL;
                break;
            case is_null($var):
                $PDOtype = PDO::PARAM_NULL;
                break;
            default:
                $PDOtype = PDO::PARAM_STR;
                break;
        }

        return $PDOtype;
    }

    public static function getCle() { return static::$cle; }
    public static function getTable() { return static::$table; }
    public function get(string $attr) { return $this->$attr; }
    public function set(string $attr, mixed $value) { $this->$attr = $value; }
}

?>
