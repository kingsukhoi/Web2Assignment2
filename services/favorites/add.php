<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 12/9/18
 * Time: 7:25 PM
 */

session_start();
include '../../helpers/SessionSingleton.php';
include "../../db/db_helper.php";
include "../../helpers/HTTPFunctions.php";

if (!isset($_GET['id'])){
    send_error(400, 'No ID Provided');
}
$id = $_GET['id'];

$pdo = newConnection();

$stmt = $pdo -> prepare(
'SELECT PaintingID
FROM Paintings
WHERE PaintingID = :id');

$stmt->execute([':id'=>$id]);

if ($stmt -> rowCount() == 0){
    send_error(400, 'Invalid ID Provided');
}

Session_Singleton::AddToFavorites($id);

set_redirect($_SERVER['HTTP_REFERER']);