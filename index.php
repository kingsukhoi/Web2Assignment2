<? include "inc/session.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc' ?>
<!---->

<body>
<?php include 'components/nav.php' ?>

<div id="gallery-list" class="row">
    <div class="twelve columns ">
        <!--todo gio this needs to be a link, or do some JS to redirect shit-->
        <h2>Galleries</h2>
        <ul></ul>
        <p>we will use a toggle to hide and show the list, will cover the page</p>

    </div>
</div>
<div class="row">

    <div id="artist" class="eight columns">
        <h1>Artist</h1>
        <div class="row">
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
            <div class="three columns">
                <img>
            </div>
        </div>

    </div>
    <div id="Genres" class="four columns">
        <h1>Genres</h1>
        <div class="row">
            <div id="genres-list" class="two column">
                <ul>
                    <li>Modern</li>
                    <li>Contemporary</li>
                    <li>Abstract</li>
                    <li>Modern</li>
                    <li>Contemporary</li>
                    <li>Abstract</li>
                    <li>Modern</li>
                    <li>Contemporary</li>
                    <li>Abstract</li>
                    <li>Modern</li>
                    <li>Contemporary</li>
                    <li>Abstract</li>
                </ul>
            </div>

        </div>
    </div>
</div>
<script src="js/index.js"></script>

</body>

</html>



