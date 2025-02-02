<?php

abstract class View {
    protected static string $table;
    protected static array $cle;

    public static function handleGetRequest() {
        $table = static::$table;
        Router::addRoute('GET', "/view/$table", function() {
            $rows = $_GET['rows'] ?? null;
            $orderby = $_GET['orderby'] ?? null;
            $class = get_called_class();
            try {
                $data = $class::getFromdb($rows, $orderby);
                echo json_encode($data);
            } catch (Throwable $e) {
                echo json_encode(array("error" => $e->getMessage()));
            }
        });
    }

    public static function getFromdb($rows = null, $orderby = null) : array|null {
        $db = Database::$conn;
        $table = static::$table;
        $sql = "SELECT * FROM $table";

        if (empty(static::$cle) || empty($_GET)) {
            if ($orderby) $sql .= " ORDER BY $orderby";
            if ($rows) $sql .= " LIMIT $rows";
    
            try {
                $result = $db->query($sql);
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
            } catch (Throwable $e) {
                throw new Exception($e->getMessage() . " " . $sql);
                return null;
            }
            return $data;
        }

        $argsList = "";

        foreach (static::$cle as $cle) {
            if ($argsList == "") $argsList .= " WHERE ($cle=:$cle)";
            $argsList .= " AND ($cle=:$cle)";
        }

        $sql .= $argsList;
        if ($orderby) $sql .= " ORDER BY $orderby";
        if ($rows) $sql .= " LIMIT $rows";
        $stmt = $db->prepare($sql);
        
        try {
            foreach (static::$cle as $cle) {
                $stmt->bindParam(":$cle", $_GET[$cle]);
            }
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage() . " " . $sql);
            return null;
        }
        return $data;
    }
}

?>