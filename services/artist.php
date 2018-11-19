<?php
include "../db/db_helper.php";
/*with no parameter, return JSON representation of all artists.
If supplied with id parameter, then return just JSON data for single specified artist.
*/
header('Content-Type: application/json');

function getArtist(PDO $connection, string $id){
    $sql = '
SELECT ArtistID,FirstName,LastName,Nationality,Gender,YearOfBirth,YearOfDeath,Details,ArtistLink 
FROM art.Artists
';
    if ($id){
        $sql .= 'WHERE ArtistID = :id';
    }
    $stmt = $connection -> prepare($sql);
    $stmt -> bindValue(':id', $id);
    $stmt -> execute();
    return $stmt;
}

$connection = newConnection();

$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
}

$result = getArtist($connection, $id);

$result = $result->fetchAll(PDO::FETCH_ASSOC);

$json = json_encode($result);

echo $json;
