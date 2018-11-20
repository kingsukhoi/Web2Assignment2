<?php
/**
 * @param PDOStatement $stmt pdo statement that has been executed
 * @return false|string
 */
function pdoStmtToJson(PDOStatement $stmt){
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    if (count($data) == 0){
        header("HTTP/1.0 404 Not Found");
        return json_encode(['error' => 'page not found']);
    }
    return json_encode($data);
}