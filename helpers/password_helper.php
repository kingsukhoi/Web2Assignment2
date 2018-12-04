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
 * @param int $length length of salt
 * @return string salt
 */
function GenSalt($length = 32){
    // from https://stackoverflow.com/questions/4356289/php-random-string-generator
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}