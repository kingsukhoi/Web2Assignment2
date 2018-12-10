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
}

/**
 * process the arguments
 */
function ProcessArguments(){
    if(isset($_GET['add'])){

    }
}

/**
 * allowed operations are:
 * add: id
 * remove: id
 * remove-all: empty
 */
function main(){
    CheckArgNum();

}



main();