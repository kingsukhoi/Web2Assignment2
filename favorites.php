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
generateNavBar();
//print_r(gettype(count(Session_Singleton::ListAllFavorites())));
if (Session_Singleton::SessionStarted()){
if (empty(Session_Singleton::ListAllFavorites())){
    ?>
    <h1>Please add some favorites</h1>
    <?php
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
            <?php
            foreach ($stmt as $row) {
                ?>
                <tr>
                    <td><img src="make-image.php?size=square&amp;width=100&amp;type=paintings&amp;file=<?php
                        echo $row['ImageFileName'] ?>"
                             alt="A Centennial of Independence" data-image-file="<?php
                        echo $row['ImageFileName'] ?>"></td>
                    <td><?php
                        echo $row['Title'] ?></td>
                    <td><?php
                        echo trim($row['Name']) ?></td>
                    <td><?php
                        echo $row['YearOfWork'] ?></td>
                    <td><a href="services/favorites.php?remove=<?php                         echo $row['PaintingID'] ?>">
                            <img src="images/garbage.png" alt="garbage" width="50px">
                        </a></td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
        <a class="button button-primary" href="services/favorites.php?remove-all=true">Clear All</a>
        <?php
    }
}
        else {
            ?>
            <br>
            <h1>Please <a href="./login.php">Login</a> To View Favorites</h1>
            <?php
        }

        ?>
    </div>
</div>
</body>
</html>