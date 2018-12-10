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
/*testing only remove later*/
if(count(Session_Singleton::ListAllFavorites())==0){
    $favs = [5,7,8,11,12,14,15,16,23,24,25,26,29,30,31,391,392,393, ];
    foreach ($favs as $curr)
        Session_Singleton::AddToFavorites($curr);
}
?>
<!DOCTYPE html>
<html lang="en">
<!--header-->
<?php include 'inc/header.inc.php' ?>
<!---->

<body>
    <?php
        include 'components/nav.php';
        $favoriteList = implode(',', Session_Singleton::ListAllFavorites());
        generateNavBar($pdo);
        $stmt = $pdo -> prepare(
"SELECT p.PaintingID, p.ImageFileName, p.Title, p.ArtistID, p.YearOfWork, concat(IFNULL(a.FirstName, ''), ' ', IFNULL(a.LastName, ' ')) AS Name
FROM Paintings p JOIN Artists a ON p.ArtistID = a.ArtistID
WHERE PaintingID IN ($favoriteList)
ORDER BY Title");
        //$stmt -> bindValue(':ids', $favoriteList);
        $stmt -> execute();
    ?>
    <div>
        <div >
            <table id="favorite-table">
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
                <?foreach ($stmt as $row){?>
                <tr>
                    <td><img src="make-image.php?size=square&amp;width=100&amp;type=paintings&amp;file=<?echo $row['ImageFileName']?>"
                             alt="A Centennial of Independence" data-image-file="<?echo $row['ImageFileName']?>"></td>
                    <td><?echo $row['Title']?></td>
                    <td><?echo trim($row['Name'])?></td>
                    <td><?echo $row['YearOfWork']?></td>
                    <td><a href="services/favorites.php?remove=<?echo $row['PaintingID']?>">
                            <img src="images/garbage.png" alt="garbage" width="50px">
                        </a> </td>
                </tr>
                <?}?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>