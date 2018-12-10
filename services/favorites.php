<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 12/9/18
 * Time: 7:55 PM
 *
 * favorites page
 * this allows you to add and remove by id
 * if there is more than one argument will throw error
 */

session_start();
include '../helpers/SessionSingleton.php';
include "../db/db_helper.php";
include "../helpers/HTTPFunctions.php";
/**
 * check number of arguments
 */
function CheckArgNum(){
    if(count($_GET) == 0 || count($_GET) > 1){
        send_error(400, 'Invalid Number of Arguments');
    }
}

function AddToFav($id){
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
}
function RemoveFromFav($id){
    Session_Singleton::RemoveFavorite($id);
}

function RemoveAllFromFav(){
    Session_Singleton::RemoveAllFavorites();
}

/**
 * process the arguments
 */
function ProcessArguments(){
    if(isset($_GET['add'])){
        AddToFav($_GET['add']);
    }
    elseif (isset($_GET['remove'])){
        RemoveFromFav($_GET['remove']);
    }
    elseif (isset($_GET['remove-all'])){
        RemoveAllFromFav();
    }
    else{
        send_error(400, 'No Valid Argument');
    }
    set_redirect($_SERVER['HTTP_REFERER']);
}

/**
 * allowed operations are:
 * add: id
 * remove: id
 * remove-all: bool
 */
function main(){
    CheckArgNum();
    ProcessArguments();
}



main();