<?php
/**
 * @param PDOStatement $stmt pdo statement that has been executed
 * @return false|string
 */
function pdoStmtToJson(PDOStatement $stmt){
    return json_encode($stmt -> fetchAll(PDO::FETCH_ASSOC));
}