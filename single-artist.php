<?php
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();

if (isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    // redirect to error page
    send_error(400, "Single artist page: Shits borked, query string not set or not valid");
}

$paramList = 'ArtistID,FirstName,LastName,Nationality,Gender,YearOfBirth,YearOfDeath,Details,ArtistLink';

$data = getDataByID($pdo, $id,"ArtistID", $paramList, 'art.Artists');


if ($data->rowCount() == 0){
    // redirect to error page
    send_error(400, "Single artist page: Shits borked, artist ID not valid");
}

$result = $data->fetch();

if($result['FirstName']) {
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

if ($artistGender == 'M'){
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

<body>
<?php
    include 'components/nav.php';
    generateNavBar($pdo);
?>


<div class="row">

    <div id="artist-single" class="three columns">

        <h1>About the artist</h1>
        <div class="row">
            <div id="artist-info" class="two column">
                <img src="make-image.php?size=square&type=artists&file=<?php echo $id ?>"/>
                <div id="artist-name"><?php echo $artistName. ', '. $artistYears ?></div>
                <div id="artist-gender">Gender: <?php echo $artistGender ?></div>
                <div id="artist-nat">Nationality: <?php echo $artistNationality ?></div>
                <div id="artist-desc">Description: <?php echo $artistDetails ?></div>
                <div id="artist-link">WebLink: <a target="_blank" href = '<? echo $artistLink?>'> <? echo $artistLink?></a> </div>
            </div>

        </div>

    </div>
    <div id="Genres" class="nine columns">
        <h1>Paitings</h1>

        <div id='painting-table' class="row">
            <table class="u-full-width">
                <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
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
<script src="js/single-artist.js"></script>
</body>

</html>



