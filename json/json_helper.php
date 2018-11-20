<?php
/**
 * @param PDOStatement $stmt pdo statement that has been executed
 * @return false|string json representation of pdo stmt. If there is no data in pdo stmt, it set's the header
 * to 404 and returns an error response
 */
function pdoStmtToJson(PDOStatement $stmt){
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    if (count($data) == 0){
        header("HTTP/1.0 404 Not Found");
        return json_encode(['error' => 'id not found']);
    }
    return json_encode($data);
}