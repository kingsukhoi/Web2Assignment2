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


<div class="row">

    <div id="image-single" class="six columns">

        <h1>Image</h1>
        <div class="row">
            <div id="artist-info" class="two column">
                <div id="artist-name">Name:</div>
                <div id="artist-dob">DOB:</div>
                <div id="artist-nat">Nat:</div>
                <div id="artist-desc">desc:</div>
            </div>

        </div>

    </div>
    <div id="paintings" class="six columns">
        <h1>Title</h1>

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



