<?php
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();
$id = "";
if (isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    // redirect to error page
    send_error(400, "Single painting page: Shits borked, query string not set");
}
$paintingInfoSql ="
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
$paintingInfoStmt -> execute(['id'=>$id]);

$commentSql = "
SELECT Reviews.`Comment` FROM Reviews
WHERE PaintingID = 25 AND Reviews.`Comment` IS NOT NULL;
";
$commentStmt = $pdo -> prepare($commentSql);
$commentStmt -> execute([':id'=>$id]);

if ($paintingInfoStmt->rowCount() == 0){
    // redirect to error page
    send_error(400, "Single painting page: Shits borked, Painting ID not valid");
}
$paintingInfoData = $paintingInfoStmt->fetch();
$title = $paintingInfoData['Title'];
$full_name = trim($paintingInfoData['FirstName'].' '.$paintingInfoData['LastName']);
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

<body>
<?php
include 'components/nav.php';
generateNavBar($pdo);
?>


<div class="row">

    <div id="image-single" class="six columns">

        <div class="row">
            <img src="./make-image.php?file=<?= $image_file_name?>&type=paintings&size=full">
        </div>

    </div>
    <div id="image-details" class="six columns">
        <h2><?echo $title?>, <?echo $full_name?></h2>
        <p>
            Gallery: <?= $gallery_name?>
            Year: <?= $year?>
            Genre: <?= $genre_name?>
            Description: <?= $description?>
        </p>
        <div class="row u-full-width">
            <span> Color Scheme </span>
        </div>
        <div id="rating" class="u-cf">
            <span>Rating</span><?= $rating?><button class="button-primary">Vote</button>
            <div>
                <p>Reviews</p>
                <?foreach ($commentStmt as $row){?>
                    <p><?echo $row['Comment']?></p>
                <?}?>
            </div>
        </div>
    </div>
</div>


</body>

</html>



