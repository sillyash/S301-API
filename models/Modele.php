<?php

define('CONSTRUCT_POST', 0);
define('CONSTRUCT_PUT', 1);
define('CONSTRUCT_DELETE', 2);
define('CONSTRUCT_GET', 3);

abstract class Modele extends stdClass {
    protected static string $table;
    protected static array $cle;
    protected static array $requiredAttributes;
    protected static array $optionalAttributes;

    public function __construct(array | object $attrs, int $flag = CONSTRUCT_POST) {
        $class = get_called_class();

        if (is_null($attrs)) throw new ArgumentCountError("Object $attrs is null.");

        foreach ($attrs as $attr => $value) {
            $this->set($attr, $value);
        }

        // Check keys (PRIMARY KEY in DB)
        if ($flag == CONSTRUCT_DELETE || $flag == CONSTRUCT_PUT || $flag == CONSTRUCT_GET) {
            foreach ($class::$cle as $k) {
                if (!isset($this->$k))
                    throw new ArgumentCountError("Key value $attr not set.");
            }
        }

        // Check required attributes (NOT NULL in DB)
        if ($flag == CONSTRUCT_POST) {
            foreach ($class::$requiredAttributes as $req) {
                if (!isset($this->$req))
                    throw new ArgumentCountError("Required attribute $req is not defined.");
            }
        }
    }

    /**
     * This function is used to initialize the Model.
     */
    public static function init() {
        $class = get_called_class();
        $class::$cle = [];
        $class::$requiredAttributes = [];
        $class::$optionalAttributes = [];

        $db = Database::$conn;
        $query = $db->query("SELECT * FROM " . $class::$table . " LIMIT 1");
        
        if (!$query) {
            throw new Exception("Table " . $class::$table . " doesn't exist.");
            return false;
        }
        $cols = $query->columnCount();
            
        for ($i = 0; $i < $cols; $i++) {
            $meta = $query->getColumnMeta($i);
            $flags = $meta["flags"];
            $colName = $meta["name"];
            
            if (in_array("primary_key", $flags)) {
                $class::$cle[] = $colName;
            }

            else if (in_array("not_null", $flags)) {
                $class::$requiredAttributes[] = $colName;
            }

            else {
                $class::$optionalAttributes[] = $colName;
            }
        }

        /*
        echo "\nCLE : "; var_dump($class::$cle);
        echo "\nREQ : "; var_dump($class::$requiredAttributes);
        echo "\nOPT : "; var_dump($class::$optionalAttributes);
        echo "\n\n";
        */
    }

    /**
     * This function is used to handle the GET request for a table.
     */
    public static function handleGetRequestTable() {
        $class = get_called_class();
        $table = $class::$table;
        Router::addRoute('GET', "/table/$table", function() {
            $db = Database::$conn;
            $class = get_called_class();
            $table = $class::$table;
            $rows = $_GET['rows'] ?? null;
            $orderby = $_GET['orderby'] ?? null;
            $query = "SELECT * FROM `$table`";
            
            if ($orderby) {
                if (
                    !in_array($orderby, $class::$requiredAttributes)
                    && !in_array($orderby, $class::$optionalAttributes)
                    && !in_array($orderby, $class::$cle)
                ) {
                    $dump = array(
                        "table" => $table,
                        "cle" => $class::$cle,
                        "req" => $class::$requiredAttributes,
                        "opt" => $class::$optionalAttributes
                    );
                    //echo json_encode($dump);
                    throw new Exception("Column $orderby doesn't exist in table : " . json_encode($dump));
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
            $class = get_called_class();
            $data = $_GET;
    
            try {
                $classInstance = new $class::$table($data, CONSTRUCT_GET);
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
        $className = get_called_class();
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('POST', "/$className", function()
        {
            $className = get_called_class();
            $data = json_decode(file_get_contents("php://input"), true, JSON_THROW_ON_ERROR);
    
            try {
                $classInstance = new $className::$table($data, CONSTRUCT_POST);
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
        $className = get_called_class();
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('PUT', "/$className", function()
        {
            $className = get_called_class();
            $data = json_decode(file_get_contents("php://input"), true, JSON_THROW_ON_ERROR);
    
            try {
                $classInstance = new $className::$table($data, CONSTRUCT_PUT);
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
        $className = get_called_class();
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('DELETE', "/$className", function()
        {
            $className = get_called_class();
            $data = $_GET;
    
            try {
                $classInstance = new $className::$table($data, CONSTRUCT_DELETE);
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
        $class = get_called_class();
        $db = Database::$conn;
        $argsList = "";

        // argsList : (arg1 = :arg1) AND (arg2 = :arg2)
        foreach ($class::$cle as $attr) {
            if ($argsList == "") {
                $argsList = "($attr=:$attr)";
            } else {
                $argsList = "$argsList AND ($attr=:$attr)";
            }
        }

        $query = "SELECT * FROM " . $class::$table . " WHERE " . $argsList;
        $stmt = $db->prepare($query);

        foreach ($class::$cle as $attr) {
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
        $class = get_called_class();

        $attrList = "";
        $argsList = "";

        /* 
         * attrList : (arg1, arg2, arg3)
         * argsList : (:arg1, :arg2, :arg3)
        */
        foreach ($class::$requiredAttributes as $attr) {
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

        $query = "INSERT INTO " . $class::$table . $attrList . " VALUES " . $argsList;
        $stmt = $db->prepare($query);

        foreach ($class::$requiredAttributes as $attr) {
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
        $class = get_called_class();

        // keyList : (key1 = :key1) AND (key2 = :key2)
        foreach ($class::$cle as $attr) {
            if ($keyList == "") {
                $keyList = "($attr=:$attr)";
            } else {
                $keyList = "$keyList AND ($attr=:$attr)";
            }
        }

        $argsList = "";
        // argsList : arg1 = :arg1, arg2 = :arg2
        foreach ($class::$requiredAttributes as $attr) {
            if ($argsList == "") {
                $argsList = "$attr=:$attr";
            } else {
                $argsList = "$argsList, $attr=:$attr";
            }
        }

        $query = "UPDATE " . $class::$table . " SET " . $argsList . " WHERE " . $keyList;
        $stmt = $db->prepare($query);

        // Insertion des clés
        foreach ($class::$cle as $attr) {
            if ($this->get($attr) === null) {
                throw new ArgumentCountError("Key value $attr not set.");
            }
            $val = $this->get($attr);
            $PDOtype = static::getPDOtype($val);
            $stmt->bindValue(":$attr", $val, $PDOtype);
        }

        // Insertion des valeurs à update (on les met toutes au cas où)
        foreach ($class::$requiredAttributes as $attr) {
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
        $class = get_called_class();

        // argsList : (arg1 = :arg1) AND (arg2 = :arg2)
        foreach ($class::$cle as $attr) {
            if ($argsList == "") {
                $argsList = "($attr=:$attr)";
            } else {
                $argsList = "$argsList AND ($attr=:$attr)";
            }
        }

        $query = "DELETE FROM " . $class::$table . " WHERE " . $argsList;
        $stmt = $db->prepare($query);

        foreach ($class::$cle as $attr) {
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

    public static function getCle() { return static::$cle; }
    public static function getTable() { return static::$table; }
    public function get(string $attr) { return $this->$attr; }
    public function set(string $attr, mixed $value) { $this->$attr = $value; }
}

?>
