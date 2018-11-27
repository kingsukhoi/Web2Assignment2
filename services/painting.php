<?php
/*
with no parameter, return JSON representation of all paintings.
If supplied with id parameter, then return just JSON data for single specified painting.
If supplied with artist parameter, then return painting data for specified artist id.
If supplied with gallery parameter, then return painting data for specified gallery id.
If supplied with genre parameter, then return painting data for specified genre id.
*/

include "../db/db_helper.php";
include "../db/data_helper.php";
include "../json/json_helper.php";

include "../inc/json.inc.php";

$conn = newConnection();

$rows = "
PaintingID,ArtistID,GalleryID,ImageFileName,Title,ShapeID,MuseumLink,AccessionNumber,
CopyrightText,Description,Excerpt,YearOfWork,Width,Height,Medium,
Cost,MSRP,GoogleLink,GoogleDescription,WikiLink
";

$table = "art.Paintings";

if(isset($_GET['id'])){
    echo pdoStmtToJson(getData($conn, $_GET['id'],"PaintingID", $rows, $table));
}
elseif(isset($_GET['artist'])){
    echo pdoStmtToJson(getData($conn, $_GET['artist'],"ArtistID", $rows, $table));
}
elseif(isset($_GET['gallery'])){
    echo pdoStmtToJson(getData($conn, $_GET['gallery'],"GalleryID", $rows, $table));
}
elseif(isset($_GET['genre'])){
    $sql = "SELECT $rows
FROM Paintings
WHERE PaintingID IN (SELECT PaintingID FROM PaintingGenres WHERE GenreID = :gid);";
    $stmt = $conn -> prepare($sql);
    $stmt -> bindValue(':gid', $_GET['genre']);
    $stmt -> execute();
    echo pdoStmtToJson($stmt);
}
else{
    echo pdoStmtToJson(getData($conn, "","", $rows, $table));
}
