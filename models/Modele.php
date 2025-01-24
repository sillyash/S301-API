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
        require_once($className . ".php");

        if (!class_exists($className)) {
            throw new Exception("Class '$className' does not exist.");
            return;
        }

        Router::addRoute('POST', "/$className", function()
        {
            $data = json_decode(file_get_contents("php://input"));
    
            try {
                $classInstance = new static::$table($data);
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
        
        echo $attrList;
        echo '\n';
        echo $argsList;

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
