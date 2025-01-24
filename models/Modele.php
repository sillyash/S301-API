<?php

define('CONSTRUCT_POST', 0);
define('CONSTRUCT_PUT', 1);
define('CONSTRUCT_DELETE', 2);

abstract class Modele {
    protected static string $table;
    protected static array $cle;
    protected static array $requiredAttributes;

    public function __construct(array | object $attrs, int $flag = CONSTRUCT_POST) {
        if (is_null($attrs)) throw new ArgumentCountError("Object $attrs is null.");

        foreach ($attrs as $attr => $value) {
            $this->set($attr, $value);
        }

        // Check keys (PRIMARY KEY in DB)
        if ($flag == CONSTRUCT_DELETE || $flag == CONSTRUCT_PUT) {
            foreach (static::$cle as $k) {
                if (!isset($this->$k))
                    throw new ArgumentCountError("Key value $attr not set.");
        }
        
        // Check required attributes (NOT NULL in DB)
        if ($flag == CONSTRUCT_POST)
            foreach (static::$requiredAttributes as $req) {
                if (!isset($this->$req))
                    throw new ArgumentCountError("Required attribute $req is not defined.");
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
                $classInstance = new static::$table($data, CONSTRUCT_POST);
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


    public static function handlePutRequest() {
        $className = static::$table;
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('PUT', "/$className", function()
        {
            $data = json_decode(file_get_contents("php://input"), true, JSON_THROW_ON_ERROR);
    
            try {
                $classInstance = new static::$table($data, CONSTRUCT_PUT);
            } catch (Throwable $e) {
                objectCreateError($e->getMessage(), $data);
                return;
            }
    
            try {
                $classInstance->updateToDb();
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
                $classInstance = new static::$table($data, CONSTRUCT_DELETE);
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
    * This function is used to update a Model on the database.
    * @return bool The result of the update .
    */
    public function updateToDb(array $updates) {
        $db = Database::$conn;
        $keyList = "";

        // keyList : (key1 = :key1) AND (key2 = :key2)
        foreach (static::$cle as $attr) {
            if ($keyList == "") {
                $keyList = "($attr = :$attr)";
            } else {
                $keyList = "$keyList AND ($attr = :$attr)";
            }
        }

        $argsList = "";
        // argsList : arg1 = :arg1, arg2 = :arg2
        foreach ($updates as $attr => $val) {
            if ($argsList == "") {
                $argsList = "$attr = :$attr";
            } else {
                $argsList = $argsList . ", $attr = :$attr";
            }
        }

        $query = "UPDATE " . static::$table . " SET " . $argsList . " WHERE " . $keyList;
        $stmt = $db->prepare($query);

        // Insertion des clés
        foreach (static::$cle as $attr) {
            if ($this->get($attr) === null) {
                throw new ArgumentCountError("Key value $attr not set.");
                return false;
            }
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindParam(":$attr", $val, $PDOtype);
        }

        // Insertion des valeurs à update
        foreach ($updates as $attr => $val) {
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
