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
$paintingInfoSql = "
SELECT p.PaintingID,p.ArtistID,p.GalleryID,p.ImageFileName,p.Title,p.YearOfWork,p.JsonAnnotations,p.Description,
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
$paintingInfoStmt->execute(['id' => $id]);

$commentSql = "
SELECT Reviews.`Comment` FROM Reviews
WHERE PaintingID = 25 AND Reviews.`Comment` IS NOT NULL;
";
$commentStmt = $pdo->prepare($commentSql);
$commentStmt->execute([':id' => $id]);

if ($paintingInfoStmt->rowCount() == 0) {
    // redirect to error page
    send_error(400, "Single painting page: Shits borked, Painting ID not valid");
}
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

    </div>
    <div id="image-details" class="five columns">
        <table class="info-table">
            <tr> <h2><? echo $title ?>, <? echo $full_name ?></h2></tr>
            <tr id="Gallery"><td>Gallery:</td> <td><? echo $gallery_name?></td></tr>
            <tr id="genre-g"><td>Genre</td> <td><?=$genre_name?></td></tr>
            <tr id="description"><td>Description</td> <td><? echo $description?></td></tr>
            <tr><td>Rating</td><td><?= $rating ?> <button class="button-primary">Vote</button>
                </td></tr>
            <tr><td>Color Scheme</td>
                <td id="color-scheme-container">
                    <?foreach ($colorData->dominantColors as $color){?>
                        <div class="color-scheme-box" style="background-color: <?php echo $color->web?>"></div>
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



