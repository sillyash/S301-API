<?php

abstract class Procedure {
    protected static string $name;
    protected static ?array $in;
    protected static ?array $out;

    public static function handlePostRequest() {
        $class = get_called_class();
        $name = $class::$name;
        Router::addRoute('POST', "/proc/$name", function() {
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                $inUser = $data['in'] ?? null;
                $outUser = $data['out'] ?? null;
            } catch (Throwable $e) {
                fieldsIncomplete($data, $e->getMessage());
                return;
            }

            try {
                static::callProc($inUser, $outUser);
                $res = array(
                    'in' => $inUser,
                    'out' => $outUser
                );
            } catch (Throwable $e) {
                sqlError($e->getMessage(), $data);
                return;
            }

            echo json_encode($res);
        });
    }

    public static function callProc(array $inUser, array& $outUser = null) {
        $class = get_called_class();
        $inarr = $class::$in;
        $outarr = $class::$out;
        
        if ($inarr) static::checkArgsIn($inUser);
        if ($outarr) static::checkArgsOut($outUser);
        
        $db = Database::$conn;
        $name = $class::$name;
        $sql = "CALL $name(";
        
        $inList = "";
        if ($inarr) {
            foreach ($inarr as $in) {
                if ($inList == "") $inList .= ":$in";
                else $inList .= ", :$in";
            }
        }
        
        $outList = "";
        if ($outarr) {
            foreach ($outarr as $out) {
                if ($outList == "") $outList .= ":$out";
                else $outList .= ", :$out";
            }
        }
        
        $sql .= $inList;
        if (!empty($outList)) {
            $sql .= ", $outList";
        }

        $sql .= ")";
        
        $stmt = $db->prepare($sql);
        
        if ($inarr) {
            foreach ($inarr as $in) {
                $attr = ":$in";
                $val = $inUser[$in];
                //echo "attr : $attr, val : $val\n";
                $stmt->bindValue($attr, $val);
            }
        }

        if ($outarr) {
            foreach ($outarr as $out) {
                $attr = ":$out";
                $val = $outUser[$out];
                //echo "attr : $attr, val : $val\n";
                $stmt->bindParam($attr, $val);
            }
        }

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage() . " Request : '$sql'");
        }
    }

    public static function checkArgsIn(array $inUser) {
        $class = get_called_class();
        if (!$class::$in) return;

        $class = get_called_class();
        foreach ($class::$in as $in) {
            if (!array_key_exists($in, $inUser)) {
                throw new Exception("Missing argument : $in");
            }
        }
    }

    public static function checkArgsOut(array $outUser) {
        $class = get_called_class();
        if (!$class::$out) return;

        $class = get_called_class();
        foreach ($class::$out as $out) {
            if (!array_key_exists($out, $outUser)) {
                throw new Exception("Missing argument : $out");
            }
        }
    }

    public function get(string $name) { return $this->$name; }
}

?>
