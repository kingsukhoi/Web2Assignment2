<?php
include "inc/session.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc' ?>
<!---->

<body>
<?php
    include 'components/nav.php';
    include "db/db_helper.php";
    $pdo = newConnection();
    generateNavBar($pdo);

?>

<?php
/**
 * I'm gonna clean this up later, just trying to get shit to work for now.
 */

include "db/db_helper.php";
include "db/data_helper.php";


$conn = newConnection();

$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
$paramList = 'GalleryID,GalleryName,GalleryNativeName,GalleryCity,GalleryAddress,GalleryCountry,Latitude,Longitude,GalleryWebSite,FlickrPlaceID,YahooWoeID,GooglePlaceID';

$data = getDataByID($conn, $id,"GalleryID", $paramList, 'art.Galleries');

$galleryName = '';

$conn = 'null';


?>

<div class="row">

    <div id="artist-single" class="three columns">

        <h1>Gallery Info</h1>
        <div class="row">
            <div id="artist-info" class="two column">
                <div id="artist-name">Name:</div>
                <div id="artist-dob">DOB:</div>
                <div id="artist-nat">Nat:</div>
                <div id="artist-desc">desc:</div>
            </div>

        </div>
        <h1>GalleryMap</h1>
        <div class="row">
            <div id="gallery-map" class="two column">


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
                    <th>title</th>
                    <th>Artist</th>
                    <th>Year</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td><img></td>
                    <td>Mona lisa</td>
                    <td>Davinchi</td>
                    <td>Italy</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>

</html>



