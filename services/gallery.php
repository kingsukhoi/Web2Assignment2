<?php
/*
with no parameter, return JSON representation of all galleries.
If supplied with id parameter, then return just JSON data for single specified gallery.
*/

include "../db/db_helper.php";
include "../db/data_helper.php";
include "../json/json_helper.php";

include "../inc/json.inc.php";


$connection = newConnection();

$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
$paramList = 'GalleryID,GalleryName,GalleryNativeName,GalleryCity,GalleryAddress,GalleryCountry,Latitude,Longitude,GalleryWebSite,FlickrPlaceID,YahooWoeID,GooglePlaceID
';
echo pdoStmtToJson(getDataByID($connection, $id,"GalleryID", $paramList, 'art.Galleries'));



$connection = null;
