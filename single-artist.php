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
    send_error(400, "Single artist page: Shits borked, query string not set or not valid");
}

$paramList = 'ArtistID,FirstName,LastName,Nationality,Gender,YearOfBirth,YearOfDeath,Details,ArtistLink';

$data = getDataByID($pdo, $id, "ArtistID", $paramList, 'art.Artists');


if ($data->rowCount() == 0) {
    // redirect to error page
    send_error(400, "Single artist page: Shits borked, artist ID not valid");
}

$result = $data->fetch();

if ($result['FirstName']) {
    $artistName = $result['FirstName'] . " " . $result['LastName'];
} else {
    $artistName = $result['LastName'];
}
if ($result['YearOfDeath']) {
    $artistYears = $result['YearOfBirth'] . ' - ' . $result['YearOfDeath'];
} else {
    $artistYears = $result['YearOfBirth'];
}
$artistNationality = $result['Nationality'];
$artistGender = $result['Gender'];

if ($artistGender == 'M') {
    $artistGender = "Male";
} else {
    $artistGender = "Female";
}
$artistDetails = $result['Details'];
$artistLink = $result['ArtistLink'];


?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->
<?php
include 'components/nav.php';
generateNavBar($pdo);
?>
<body>


<div class="row"></div>
<div class="row">

    <div id="artist-single" class="five columns">


        <div class="row">
            <h1><?php echo $artistName ?></h1>
            <div id="artist-info" class="two column">
                <img src="make-image.php?size=square&type=artists&file=<?php echo $id ?>"/>
                <table class="u-full-width info-table">
                    <tr id="artist-lifespan">
                        <td>Life Span</td>
                        <td><? echo $artistYears ?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo $artistGender ?></td>
                    </tr>
                    <tr id="artist-nat">
                        <td>Nationality</td>
                        <td><?php echo $artistNationality ?></td>
                    </tr>
                    <tr id="artist-desc">
                        <td>Description</td>
                        <td><?php echo $artistDetails ?></td>
                    </tr>
                    <tr id="artist-link">
                        <td>WebLink</td>
                        <td><a target="_blank" href='<? echo $artistLink ?>'> <? echo $artistLink ?></a></td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
    <div id="Genres">

        <div id='painting-table' class="row">
            <h1>Paintings</h1>
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th data-sort="title">Title</th>
                    <th data-sort="artist">Artist</th>
                    <th data-sort="year">Year</th>
                </tr>
                </thead>
                <img class="loading" src="images/Blocks-1s-200px.gif">
                <tbody>
                </tbody>


            </table>
        </div>
    </div>
</div>

<script src="js/helpers.js"></script>
<script src="js/single-artist.js"></script>
</body>

</html>



