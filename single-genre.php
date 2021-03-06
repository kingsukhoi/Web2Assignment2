<?php
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // redirect to error page
    send_error(400, "Single genre page: Shits borked, query string not set or not valid");
}

$paramList = 'GenreID,GenreName,EraID,Description,Link';

$data = getDataByID($pdo, $id, "GenreID", $paramList, 'art.Genres');


if ($data->rowCount() == 0) {
    // redirect to error page
    send_error(400, "Single genre page: Shits borked, genre ID not valid");
}

$result = $data->fetch();

$genreName = $result['GenreName'];
$genreDesc = $result['Description'];
$genreLink = $result['Link'];
$era = $result['EraID'];

$paramListEra = 'EraID,EraName,EraYears';
$eraData = getDataByID($pdo, $era, "EraID", $paramListEra, 'art.Eras');

$resultEra = $eraData->fetch();

$eraName = $resultEra['EraName'];
$eraYears = $resultEra['EraYears'];
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->
<?php
include 'components/nav.php';
generateNavBar(); ?>
<body>



<div class="row">

    <div id="genre-single" class="five columns">


        <div class="row">
            <h1><?php echo $genreName ?></h1>
            <div id="genre-info" class="two column">
                <img src="make-image.php?type=genres&file=<?php echo $id ?>">
                <table class="info-table">
                    <tr id="genre-desc">
                        <td>Description</td>
                        <td><?php echo $genreDesc ?></td>
                    </tr>
                    <tr id="era">
                        <td>Era</td>
                        <td><?php echo $eraName . ' (' . $eraYears . ')' ?></td>
                    </tr>
                    <tr id="genre-link">
                        <td>WebLink</td>
                        <td><a  href='<?php echo $genreLink ?>'> <?php echo $genreLink ?></a></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <div id="paintings" class="seven columns">


        <div id='painting-table' class="row">
            <h1>Paintings</h1>
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

<script src="js/helpers.js"></script>
<script src="js/single-genre.js"></script>
</body>

</html>