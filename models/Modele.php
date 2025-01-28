<?php

define('CONSTRUCT_POST', 0);
define('CONSTRUCT_PUT', 1);
define('CONSTRUCT_DELETE', 2);
define('CONSTRUCT_GET', 3);

#[AllowDynamicProperties]
abstract class Modele {
    protected static string $table;
    protected static array $cle;
    protected static array $requiredAttributes;
    protected static array $dynamicAttributes = [];

    public function __construct(array | object $attrs, int $flag = CONSTRUCT_POST) {
        if (is_null($attrs)) throw new ArgumentCountError("Object $attrs is null.");

        foreach ($attrs as $attr => $value) {
            $this->set($attr, $value);
        }

        // Check keys (PRIMARY KEY in DB)
        if ($flag == CONSTRUCT_DELETE || $flag == CONSTRUCT_PUT || $flag == CONSTRUCT_GET) {
            foreach (static::$cle as $k) {
                if (!isset($this->$k))
                    throw new ArgumentCountError("Key value $attr not set.");
            }
        }

        // Check required attributes (NOT NULL in DB)
        if ($flag == CONSTRUCT_POST) {
            foreach (static::$requiredAttributes as $req) {
                if (!isset($this->$req))
                    throw new ArgumentCountError("Required attribute $req is not defined.");
            }
        }
    }

    /**
     * This function is used to initialize the Model.
     */
    public static function init() {
        $columns = static::tableDescFromDB();
        static::$cle = [];
        static::$requiredAttributes = [];

        foreach ($columns as $column) {
            $query = Database::$conn->query("SHOW COLUMNS FROM " . static::$table . " LIKE '$column'");
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($result['Key'] === 'PRI') {
                static::$cle[] = $column;
            }

            if ($result['Null'] === 'NO') {
                static::$requiredAttributes[] = $column;
            }

            if (!property_exists(static::class, $column)) {
                static::addAttribute($column);
            }
        }
    }

    /**
     * Adds a dynamic attribute to the model if it does not already exist.
     *
     * @param string $propertyName The name of the attribute to add.
     */
    protected static function addAttribute($propertyName) {
        // Get the child class
        $className = get_called_class();
        $className::$dynamicAttributes[] = $propertyName;
    }

    /**
     * This function is used to handle the GET request for a table.
     */
    public static function handleGetRequestTable() {
        $table = static::$table;
        Router::addRoute('GET', "/table/$table", function() {
            $db = Database::$conn;
            $table = static::$table;
            $rows = $_GET['rows'] ?? null;
            $orderby = $_GET['orderby'] ?? null;
            $query = "SELECT * FROM `$table`";
            
            if ($orderby) {
                if (!in_array($orderby, static::$requiredAttributes) && !in_array($orderby, static::$cle)) {
                    throw new Exception("Column $orderby doesn't exist in $table.");
                    return false;
                }
                // ORDER BY clauses cannot use prepared statements
                // However, safe to use because $orderby is part of ::$cle or ::$requiredAttributes
                $query = $query . " ORDER BY $orderby";

                $desc = $_GET['desc'] ?? null;
                if ($desc) {
                    if ($desc != "true") {
                        throw new Exception("desc must be 'true'.");
                        return false;
                    }
                    $query = $query . " DESC";
                } else {
                    $query = $query . " ASC";
                }
            }

            if ($rows) {
                if (!is_numeric($rows)) {
                    throw new Exception("Rows must be a number.");
                    return false;
                }
                
                $rows = intval($rows);
                
                if ($rows < 0) {
                    throw new Exception("Rows must be a positive number.");
                    return false;
                }
                
                $query = $query . " LIMIT :rows";
            }
        
            $stmt = $db->prepare($query);
            if ($rows) $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            
            try {
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                sqlError($e->getMessage(), $table);
                return;
            }
            
            echo json_encode($data);
        });
    }

    /**
     * This function is used to handle the GET request for a table.
     */
    public static function handleGetRequest() {
        $className = static::$table;
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('GET', "/$className", function()
        {
            $data = $_GET;
    
            try {
                $classInstance = new static::$table($data, CONSTRUCT_GET);
            } catch (Throwable $e) {
                objectCreateError($e->getMessage(), $data);
                return;
            }
    
            try {
                $data = $classInstance->getFromDb();
            } catch (Throwable $e) {
                sqlError($e->getMessage(), $classInstance);
                return;
            }

            echo json_encode($data);
        });
    }

    /**
     * This function is used to handle the POST request for a table.
     */
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

    /**
     * This function is used to handle the PUT request for a table.
     */
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
    
            updateSuccess($classInstance);
        });
    }

    /**
     * This function is used to handle the DELETE request for a table.
     */
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
    * This function is used to get a Model from the database.
    * @return array|null The result of the get.
    */
    public function getFromDb() {
        $db = Database::$conn;
        $argsList = "";

        // argsList : (arg1 = :arg1) AND (arg2 = :arg2)
        foreach (static::$cle as $attr) {
            if ($argsList == "") {
                $argsList = "($attr=:$attr)";
            } else {
                $argsList = "$argsList AND ($attr=:$attr)";
            }
        }

        $query = "SELECT * FROM " . static::$table . " WHERE " . $argsList;
        $stmt = $db->prepare($query);

        foreach (static::$cle as $attr) {
            if ($this->get($attr) === null) {
                throw new ArgumentCountError("Key value $attr not set.");
                return false;
            }
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindValue(":$attr", $val, $PDOtype);
        }
        
        try {
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return null;
        }
        return $data;
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
            $stmt->bindValue(":$attr", $val, $PDOtype);
        }
        
        $stmt->execute();
        return true;
    }

    /**
    * This function is used to update a Model on the database.
    * @return bool The result of the update.
    */
    public function updateToDb() {
        $db = Database::$conn;
        $keyList = "";

        // keyList : (key1 = :key1) AND (key2 = :key2)
        foreach (static::$cle as $attr) {
            if ($keyList == "") {
                $keyList = "($attr=:$attr)";
            } else {
                $keyList = "$keyList AND ($attr=:$attr)";
            }
        }

        $argsList = "";
        // argsList : arg1 = :arg1, arg2 = :arg2
        foreach (static::$requiredAttributes as $attr) {
            if ($argsList == "") {
                $argsList = "$attr=:$attr";
            } else {
                $argsList = "$argsList, $attr=:$attr";
            }
        }

        $query = "UPDATE " . static::$table . " SET " . $argsList . " WHERE " . $keyList;
        $stmt = $db->prepare($query);

        // Insertion des clés
        foreach (static::$cle as $attr) {
            if ($this->get($attr) === null) {
                throw new ArgumentCountError("Key value $attr not set.");
            }
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindValue(":$attr", $val, $PDOtype);
        }

        // Insertion des valeurs à update (on les met toutes au cas où)
        foreach (static::$requiredAttributes as $attr) {
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindValue(":$attr", $val, $PDOtype);
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
                $argsList = "($attr=:$attr)";
            } else {
                $argsList = "$argsList AND ($attr=:$attr)";
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
            $stmt->bindValue(":$attr", $val, $PDOtype);
        }
        
        $stmt->execute();
        return true;
    }

    /**
     * This function is used to get the PDO type of a variable.
     * @param mixed $var The variable to get the PDO type of.
     * @return int The PDO type of the variable.
     */
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

    /**
     * This function is used to fetch the attributes of a Model from the database.
     * @return array The attributes of the Model.
     */
    public static function tableDescFromDB() {
        $db = Database::$conn;
        $table = ucfirst(strtolower(static::class));
        $query = $db->query("DESCRIBE $table");
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);

        return $columns;
    }

    public static function getCle() { return static::$cle; }
    public static function getTable() { return static::$table; }
    public function get(string $attr) { return $this->$attr; }
    public function set(string $attr, mixed $value) { $this->$attr = $value; }
}

?>
