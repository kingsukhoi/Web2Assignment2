<? include "inc/session.inc.php"; ?>
<!DOCTYPE html>
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->

<body>
<?php include 'components/nav.php';
generateNavBar() ?>

<div id="gallery-list" class="row">
    <div >
        <button onclick="showMenu()">Galleries</button>
        <ul style="display: none;">
            <img src="images/Blocks-1s-200px.gif" alt="Loading">
        </ul>
        <!--<p>we will use a toggle to hide and show the list, will cover the page</p>-->

    </div>
</div>
<div class="row">

    <div id="artist">
        <h1>Artist</h1>

        <div class="slider1">
            <img src="images/Blocks-1s-200px.gif" alt="Loading">
        </div>

    </div>
</div>
<div class="row">
    <div id="genres">
        <h1>Genres</h1>
        <div class="slider2">
            <img src="images/Blocks-1s-200px.gif" alt="Loading">
        </div>

    </div>
</div>
</body>
<?php include 'inc/footer.inc.php' ?>
</html>



