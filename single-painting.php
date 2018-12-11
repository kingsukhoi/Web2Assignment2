<?php
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // redirect to error page
    send_error(400, "Single painting page: Shits borked, query string not set");
}

$checkIfIDExistsSql = "SELECT count(*) FROM Paintings WHERE PaintingID = :id;";
$checkIfIDExistsStmt = $pdo->prepare($checkIfIDExistsSql);
$checkIfIDExistsStmt->execute([':id' => $id]);

if ($checkIfIDExistsStmt->fetch()[0] == 0) {
    // redirect to error page
    send_error(400, "Single painting page: Shits borked, Painting ID not valid");
}

$paintingInfoSql = "
SELECT p.PaintingID,p.ArtistID,p.GalleryID,p.ImageFileName,p.Title,p.YearOfWork,p.JsonAnnotations,p.Description,p.ArtistID,
       IFNULL(a.FirstName, '') as FirstName, IFNULL(a.LastName, '') as LastName,
       g.GalleryID, g.GalleryName,
       ROUND(AVG(r.Rating), 1) as Rating,
       ge.GenreName, ge.GenreID
FROM art.Paintings p
  JOIN Artists a ON p.ArtistID = a.ArtistID
  JOIN Reviews r ON p.PaintingID = r.PaintingID
  JOIN Galleries g ON p.GalleryID = g.GalleryID
  JOIN PaintingGenres pg ON p.PaintingID = pg.PaintingID
  JOIN Genres ge ON pg.GenreID = ge.GenreID
WHERE p.PaintingID = :id;
";
$paintingInfoStmt = $pdo->prepare($paintingInfoSql);
$paintingInfoStmt->execute([':id' => $id]);

$commentSql = "
SELECT Reviews.`Comment` FROM Reviews
WHERE PaintingID = 25 AND Reviews.`Comment` IS NOT NULL;
";
$commentStmt = $pdo->prepare($commentSql);
$commentStmt->execute([':id' => $id]);

$paintingInfoData = $paintingInfoStmt->fetch();
$title = $paintingInfoData['Title'];
$full_name = trim($paintingInfoData['FirstName'] . ' ' . $paintingInfoData['LastName']);
$gallery_id = $paintingInfoData['GalleryID'];
$gallery_name = $paintingInfoData['GalleryName'];
$genre_name = $paintingInfoData['GenreName'];
$genre_id = $paintingInfoData['GenreID'];
$rating = $paintingInfoData['Rating'];
$colorData = json_decode($paintingInfoData['JsonAnnotations']);
$year = $paintingInfoData['YearOfWork'];
$description = $paintingInfoData['Description'];
$image_file_name = $paintingInfoData['ImageFileName'];
$artist_id = $paintingInfoData['ArtistID'];
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



<div class="row">

    <div id="image-single" class="four columns">

        <img src="./make-image.php?file=<?= $image_file_name ?>&type=paintings&size=full">
        <?if(Session_Singleton::SessionStarted()){
            if(Session_Singleton::InFavorites($id)){
                ?>
                <a class="button" href="services/favorites.php?remove=<?echo $id?>">Remove From Favorites</a>
                <?
            }else{
                ?>
                <a class="button-primary button" href="services/favorites.php?add=<?echo $id?>">Add To Favorites</a>
                <?
            }

        }
        ?>
    </div>
    <div id="image-details" class="five columns">
        <table class="info-table">
            <tr><td colspan="2"><h2><? echo $title ?></h2></td> </tr>
            <tr><td>Artist</td><td>
                    <a  href="single-artist.php?id=<?echo $artist_id?>"><? echo $full_name ?></a>
                </td> </tr>
            <tr id="Gallery"><td>Gallery:</td>
                <td>
                    <a  href="single-gallery.php?id=<?echo $gallery_id?>"><? echo $gallery_name?>
                    </a>
                </td>
            </tr>
            <tr id="genre-g"><td>Genre</td>
                <td>
                    <a href="single-genre.php?id=<?echo $genre_id?>" ><?=$genre_name?></a>
                </td></tr>
            <tr id="description"><td>Description</td> <td><? echo $description?></td></tr>
            <tr><td>Rating</td><td><?= $rating ?> <button class="button-primary">Vote</button>
                </td></tr>
            <tr><td>Color Scheme</td>
                <td id="color-scheme-container">
                    <?foreach ($colorData->dominantColors as $color){?>
                        <div class="tooltip color-scheme-box" style="background-color: <?php echo $color->web?>">
                            <span class="tooltiptext"><?echo $color->name?></span>
                        </div>
                    <?}?>
                </td>
            </tr>
            <tr><td colspan="2">Reviews</td></tr>
            <? foreach ($commentStmt as $row) { ?>
                <tr><td colspan="2" style="font-weight: normal"><? echo $row['Comment'] ?></td></tr>
            <? } ?>
        </table>
        </div>
    </div>
</div>


</body>

</html>



