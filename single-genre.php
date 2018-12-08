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
<?php include 'inc/header.inc' ?>
<!---->

<body>
    <?php
        include 'components/nav.php';
        generateNavBar($pdo); ?>


    <div class="row">

        <div id="genre-single" class="three columns">

            <h1>Genre</h1>
            <div class="row">
                <div id="genre-info" class="two column">
                    <img src="make-image.php?type=genres&file=<?php echo $id ?>">
                    <div id="genre-name"><?php echo $genreName ?></div>
                    <div id="genre-desc">Description: <?php echo $genreDesc ?></div>
                    <div id="era">Era: <?php echo $eraName . ' (' . $eraYears . ')' ?></div>
                    <div id="genre-link">WebLink <a target="_blank" href='<? echo $genreLink ?>'> <? echo $genreLink ?>
                    </div>
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