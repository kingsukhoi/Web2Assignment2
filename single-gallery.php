<?php
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();
$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    // redirect to error page
    send_error(400, "Single gallery page: Shits borked, query string not set");
}

$paramList = 'GalleryID,GalleryName,GalleryNativeName,GalleryCity,GalleryAddress,GalleryCountry,Latitude,Longitude,GalleryWebSite,FlickrPlaceID,YahooWoeID,GooglePlaceID';

$data = getDataByID($pdo, $id,"GalleryID", $paramList, 'art.Galleries');


if ($data->rowCount() == 0){
    // redirect to error page
    send_error(400, "Single gallery page: Shits borked, gallery ID not valid");
}
?>

<!DOCTYPE html>
<html lang="en">

<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->

<body>
<?php
    include 'components/nav.php';
    generateNavBar($pdo);

/**
 * I'm gonna clean this up later, just trying to get shit to work for now.
 */


$result = $data->fetch();


$GalleryName = $result['GalleryName'];
$GalleryNativeName = $result['GalleryNativeName'];
$GalleryCity = $result['GalleryCity'];
$GalleryCountry = $result['GalleryCountry'];
$GalleryAddress = $result['GalleryAddress'];
$lat = $result['Latitude'];
$long = $result['Longitude'];
$site = $result['GalleryWebSite'];
$GalleryID = $result['GalleryID'];
?>

<div class="row">

    <div id="gallery-single" class="three columns">

        <h1>Gallery Info</h1>
        <div class="row">
            <div id="gallery-info" class="two column">
                <div id="gallery-name">Name: <? echo $GalleryName?></div>
                <div id="gallery-native-name">Native name: <? echo $GalleryNativeName?></div>
                <div id="gallery-address">Address: <? echo $GalleryAddress?></div>
                <div id="gallery-city">City: <? echo $GalleryCity?></div>
                <div id="gallery-country">Country: <? echo $GalleryCountry?></div>
                <div id="gallery-website">WebSite:
                    <a target="_blank" href = '<? echo $site?>'> <? echo $site?></a> </div>
            </div>



        </div>
        <h1>GalleryMap</h1>
        <script src="js/helpers.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVshRDR6jMy2PTWORIhuaA5-LE73vYlN4" async defer></script>
        <script src="js/single-gallery.js"></script>
        <div class="row">
            <div id="map" class="two column">
            </div>
        </div>

    </div>
    <div id="paintings" class="nine columns">
        <h1>Paitings</h1>

        <div id='painting-table' class="row">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th></th>
                    <th data-sort="title">Title</th>
                    <th data-sort="artist">Artist</th>
                    <th data-sort="year">Year</th>
                </tr>
                </thead>
                <tbody>
                    <img class="loading" src="images/Blocks-1s-200px.gif">
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>



