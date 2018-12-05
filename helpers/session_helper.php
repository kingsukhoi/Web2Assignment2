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
    if(SessionStarted()){
        return;
    }
    $success = session_start();
    if (!$success)
        die(1);
    $_SESSION['ID'] = $CustomerID;
}

/** kill a user session
 * @return bool
 */
function EndUserSession(){
    if (!SessionStarted()){
        return;
    }
    return session_destroy();
}

/** check if there is an existing session
 * @return bool True if session exists.
 */
function SessionStarted(){
    return session_id() == '' || !isset($_SESSION);
}