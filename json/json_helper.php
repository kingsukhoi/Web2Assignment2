<?php
/**
 * @param PDOStatement $stmt pdo statement that has been executed
 * @return false|string
 */
function pdoStmtToJson(PDOStatement $stmt){
    //todo add 404 if there is no data, via exception
    return json_encode($stmt -> fetchAll(PDO::FETCH_ASSOC));
}