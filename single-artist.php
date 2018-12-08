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
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc' ?>
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
                <img src="images/farsus.png">
                <div id="artist-name">Name:</div>
                <div id="artist-dob">DOB:</div>
                <div id="artist-nat">Nat:</div>
                <div id="artist-desc">desc:</div>
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
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>

</html>



