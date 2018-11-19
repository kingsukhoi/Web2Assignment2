<?php
/*with no parameter, return JSON representation of all genres.
If supplied with id parameter, then return just JSON data for single specified genre
*/

include "../db/db_helper.php";
include "../db/data_helper.php";
include "../json/json_helper.php";

header('Content-Type: application/json');


$connection = newConnection();

$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
$paramList = 'GenreID,GenreName,EraID,Description,Link
';
echo pdoStmtToJson(getData($connection, $id,"GenreID", $paramList, 'art.Genres'));

$connection = null;
