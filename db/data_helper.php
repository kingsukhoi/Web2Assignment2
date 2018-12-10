<?php
/*
 * contains functions to help with querying data.
 */

/**get data by id
 * For use in services. Run query that will return all parameters if ID is empty, or a specific row if there is an id
 * @param PDO $connection $pdo connection
 * @param string $id id you want to fetch
 * @param string $idName name of the PK in database
 * @param string $paramList comma separated list of parameters you want
 * @param string $table table name
 * @return bool|PDOStatement
 */
function getDataByID(PDO $connection, string $id, string $idName, string $paramList, string $table)
{
    $sql = "
SELECT $paramList
FROM $table
";
    // truthy falsy baby
    if ($id) {
        $sql .= "WHERE $idName = :id";
    }
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt;
}

function getDataByEmail(PDO $connection, string $email, string $paramList)
{
    $stmt = $connection->prepare("SELECT $paramList FROM art.Customers WHERE Email = :email;");
    $stmt->execute([':email' => $email]);
    return $stmt;
}

/** check if user email exists in database
 * @param PDO $pdo pdo connection
 * @param string $email email address
 * @return bool True email exists. False no exist
 */
function EmailExists(PDO $pdo, string $email)
{
    return !(getDataByEmail($pdo, $email, 'CustomerID')->rowCount() == 0);
}