<?php
include "inc/session.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
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

        <div class="row">
            <img src="#">Image goes here
        </div>

    </div>
    <div id="image-details" class="six columns">
        <h2>Title, Artist</h2>
        <p>
            Gallery:
            Year:
            Genre:
            Description
        </p>
        <div class="row u-full-width">
            <span> Color Scheme </span>
        </div>
        <div id="rating" class="u-cf">
            <span>Rating</span><button class="button-primary">Vote</button>
            <div>
                <p>Reviews</p>

            </div>
        </div>
        <!--        <div id='painting-table' class="row">-->
        <!--            <table class="u-full-width">-->
        <!--                <thead>-->
        <!--                <tr>-->
        <!--                    <th></th>-->
        <!--                    <th>title</th>-->
        <!--                    <th>Artist</th>-->
        <!--                    <th>Year</th>-->
        <!--                </tr>-->
        <!--                </thead>-->
        <!--                <tbody>-->
        <!--                <tr>-->
        <!--                    <td><img></td>-->
        <!--                    <td>Mona lisa</td>-->
        <!--                    <td>Davinchi</td>-->
        <!--                    <td>Italy</td>-->
        <!--                </tr>-->
        <!--                <tr>-->
        <!--                    <td><img></td>-->
        <!--                    <td>Mona lisa</td>-->
        <!--                    <td>Davinchi</td>-->
        <!--                    <td>Italy</td>-->
        <!--                </tr>-->
        <!--                </tbody>-->
        <!--            </table>-->
        <!--        </div>-->
    </div>
</div>


</body>

</html>



