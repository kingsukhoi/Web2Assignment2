<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 9:27 PM
 */
/**
 * @param string $CustomerID id of the customer this session belongs to
 */
function StartUserSession(string $CustomerID){
    $success = session_start();
    if (!$success)
        die(1);
    $_SESSION['ID'] = $CustomerID;
}

function EndUserSession(){
    return session_destroy();
}