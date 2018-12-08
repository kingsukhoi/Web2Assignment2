<?php
include '../helpers/HTTPFunctions.php';
/**
 * @param PDOStatement $stmt pdo statement that has been executed
 * @return false|string json representation of pdo stmt. If there is no data in pdo stmt, it set's the header
 * to 404 and returns an error response
 */
function pdoStmtToJson(PDOStatement $stmt){
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    if (count($data) == 0){
        send_error(404, 'id not found');
        return "";
    }
    if(count($data) == 1){
        $data = $data[0];
    }
    return json_encode($data);
}