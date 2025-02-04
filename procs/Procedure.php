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
                $data = json_decode(file_get_contents('php://input'));
                $inUser = $data['in'] ?? null;
                $outUser = $data['out'] ?? null;
            } catch (Throwable $e) {
                fieldsIncomplete($data);
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

    public static function callProc(array $inUser, array& $outUser = array()) {
        $class = get_called_class();
        if ($class::$in) static::checkArgsIn($inUser);
        if ($class::$out) static::checkArgsOut($outUser);

        $db = Database::$conn;
        $name = $class::$name;
        $sql = "CALL $name(";

        $inList = "";
        foreach ($class::$in as $in) {
            if ($inList == "") $inList .= ":$in";
            $inList .= ", :$in";
        }

        $outList = "";
        foreach ($class::$out as $out) {
            if ($outList == "") $outList .= ":$out";
            $outList .= ", :$out";
        }

        $sql .= $inList;
        if (!empty($outList)) $sql .= ", $outList)";
        else $sql .= ")";

        $stmt = $db->prepare($sql);
        
        foreach ($class::$in as $in) {
            $stmt->bindParam(":$in", $inUser[$in]);
        }

        foreach ($class::$out as $out) {
            $stmt->bindParam(":$out", $outUser[$out]);
        }

        try {
            $stmt->execute();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage() . " Request : '$sql'");
        }
    }

    public static function checkArgsIn(array $inUser) {
        if (!$class::$in) return;

        $class = get_called_class();
        foreach ($class::$in as $in) {
            if (!array_key_exists($in, $inUser)) {
                throw new Exception("Missing argument : $in");
            }
        }
    }

    public static function checkArgsOut(array& $outUser) {
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
