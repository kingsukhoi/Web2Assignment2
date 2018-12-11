<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 12/9/18
 * Time: 4:54 PM
 */
include "inc/session.inc.php";
include "db/db_helper.php";
include "db/data_helper.php";
include 'helpers/HTTPFunctions.php';
$pdo = newConnection();
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->

<body>
<?php
error_reporting(0);
ini_set('display_errors', 0);
include 'components/nav.php';
generateNavBar($pdo);
//print_r(gettype(count(Session_Singleton::ListAllFavorites())));
if (Session_Singleton::SessionStarted()){
if (empty(Session_Singleton::ListAllFavorites())){
    ?>
    <h1>Please add some favorites</h1>
    <?
}
else{
if (count(Session_Singleton::ListAllFavorites()) == 1) {
    $favoriteList = Session_Singleton::ListAllFavorites()[0];
} else {
    $favoriteList = implode(',', Session_Singleton::ListAllFavorites());
}
$stmt = $pdo->prepare(
    "SELECT p.PaintingID, p.ImageFileName, p.Title, p.ArtistID, p.YearOfWork, concat(IFNULL(a.FirstName, ''), ' ', IFNULL(a.LastName, ' ')) AS Name
FROM Paintings p JOIN Artists a ON p.ArtistID = a.ArtistID
WHERE PaintingID IN ($favoriteList)
ORDER BY Title");
//$stmt -> bindValue(':ids', $favoriteList);
$stmt->execute();
?>
<div id="favorite-table">
    <div>
        <table>
            <thead>
            <tr>
                <th></th>
                <th data-sort="title">Title</th>
                <th data-sort="artist">Artist</th>
                <th data-sort="year">Year</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?
            foreach ($stmt as $row) {
                ?>
                <tr>
                    <td><img src="make-image.php?size=square&amp;width=100&amp;type=paintings&amp;file=<?
                        echo $row['ImageFileName'] ?>"
                             alt="A Centennial of Independence" data-image-file="<?
                        echo $row['ImageFileName'] ?>"></td>
                    <td><?
                        echo $row['Title'] ?></td>
                    <td><?
                        echo trim($row['Name']) ?></td>
                    <td><?
                        echo $row['YearOfWork'] ?></td>
                    <td><a href="services/favorites.php?remove=<?
                        echo $row['PaintingID'] ?>">
                            <img src="images/garbage.png" alt="garbage" width="50px">
                        </a></td>
                </tr>
                <?
            } ?>
            </tbody>
        </table>
        <?
    }
}
        else {
            ?>
            <br>
            <h1>Please <a href="./login.php">Login</a> To View Favorites</h1>
            <?
        }

        ?>
    </div>
</div>
</body>
</html>