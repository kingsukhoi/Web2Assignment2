<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 26/11/18
 * Time: 10:25 AM
 */


/**
 * verify's if user password matches the one in the db
 * @param string $UserPwd
 * @param string $hash
 * @param string $salt
 * @return bool if password matches
 */
function IsPasswordSame(string $UserPwd, string $hash, string $salt){
    $userHash = md5($UserPwd . $salt);
    return $userHash == $hash;
}

/** generates password hash
 * @param string $UserPwd
 * @param string $salt
 * @return string
 */
function GenHash(string $UserPwd, string $salt){

    $pwdHash = md5($UserPwd . $salt);
    return $pwdHash;
}

/** generate a salt
 * @return string salt
 */
function GenSalt(){
    try {
        return random_bytes(32);
    } catch (Exception $e) {
        die($e);
    }
}