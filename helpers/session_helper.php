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
 * @return bool true if session existed and was destroyed, false if there was not session or something else went wrong
 */
function EndUserSession(){
    if (!SessionStarted()){
        return false;
    }
    return session_destroy();
}

/** check if there is an existing session
 * @return bool True if session exists.
 */
function SessionStarted(){
    // copied from https://stackoverflow.com/questions/3538513/detect-if-php-session-exists#answer-40939132
    return session_status() == PHP_SESSION_ACTIVE;
}