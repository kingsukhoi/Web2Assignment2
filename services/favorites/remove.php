<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 12/9/18
 * Time: 7:40 PM
 */

include "../../helpers/SessionSingleton.php";
include "../../helpers/HTTPFunctions.php";

function removeByID($id){
    Session_Singleton::RemoveFavorite($id);
}

function removeAll(){
    Session_Singleton::RemoveAllFavorites();
}

function main(){
    if (isset($_GET['id'])){
        removeByID($_GET['id']);
    }
    elseif (isset($_GET['all'])){
        removeAll();
    }
    set_redirect($_SERVER['HTTP_REFERER']);
}