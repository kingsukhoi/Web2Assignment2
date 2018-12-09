<? include "inc/session.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc' ?>
<!---->

<body>
<?php include 'components/nav.php';
generateNavBar() ?>

<div id="gallery-list" class="row dropdown">
    <div class="twelve columns ">
        <h2 >Galleries</h2>
        <ul class="dropdown-content"><img src="images/Blocks-1s-200px.gif" alt="Loading"></ul>
        <!--<p>we will use a toggle to hide and show the list, will cover the page</p>-->

    </div>
</div>
<div class="row">

    <div id="artist" class="eight columns">
        <h1>Artist</h1>
        <div id="carrousel">
            <div class="row listPhotos">
                <img src="images/Blocks-1s-200px.gif" alt="Loading">
            </div>
        </div>

    </div>
    <div id="Genres" class="four columns">
        <h1>Genres</h1>
        <div class="row">
            <div id="genres-list" class="two column">
                <ul>
                    <img src="images/Blocks-1s-200px.gif" alt="Loading">
                </ul>
            </div>

        </div>
    </div>
</div>
</body>
<script src="js/helpers.js"></script>
<script src="js/index.js"></script>
<script src="js/carrousel.js">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.2.0/prototype.js"></script>
</html>



