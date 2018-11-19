<?php
/*
 * contains functions to help with querying data.
 */

/** For use in services. Run query that will return all parameters if ID is empty, or a specific row if there is an id
 * @param PDO $connection
 * @param string $id
 * @param string $idName
 * @param string $paramList
 * @param string $table
 * @return bool|PDOStatement
 */
function getData(PDO $connection, string $id, string $idName,string $paramList, string $table){
    $sql = "
SELECT $paramList
FROM $table
";
    // truthy falsy baby
    if ($id){
        $sql .= "WHERE $idName = :id";
    }
    $stmt = $connection -> prepare($sql);
    $stmt -> bindValue(':id', $id);
    $stmt -> execute();
    return $stmt;
}