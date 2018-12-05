<?php
include "../db/db_helper.php";
include "../json/json_helper.php";
include '../db/data_helper.php';
/*
with no parameter, return JSON representation of all artists.
If supplied with id parameter, then return just JSON data for single specified artist.
*/
include "../inc/json.inc.php";

$connection = newConnection();

$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
}

$paramList = "ArtistID,FirstName,LastName,Nationality,Gender,YearOfBirth,YearOfDeath,Details,ArtistLink";

echo pdoStmtToJson(getDataByID($connection, $id,"ArtistID" ,$paramList, "art.Artists"));

$connection = null;
