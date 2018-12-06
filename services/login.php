<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 26/11/18
 * Time: 10:18 AM
 * This will handle storing login info in session.
 * Will also redirect back home
 */

session_start();
include "../helpers/SessionSingleton.php";

include "../inc/json.inc.php";

include "../helpers/HTTPFunctions.php";

include '../db/db_helper.php';
include "../db/data_helper.php";
include "../helpers/password_helper.php";

$username = $_POST['username'];
$password = $_POST['password'];

$conn = newConnection();

$params = 'CustomerID, UserName, Pass, Salt';
$data = getDataByID($conn, $username, "UserName", $params, 'CustomerLogon');

if ($data -> rowCount() != 1){
    set_http_status(500, 'Database Error');
    exit(1);
}

$data = $data -> fetch();

$dbPass = $data['Pass'];
$dbSalt = $data['Salt'];

if(IsPasswordSame($password, $dbPass, $dbSalt)){
    Session_Singleton::StartUserSession($data['CustomerID']);
    set_redirect('../index.php');
}
else{
    set_http_status(401, 'Not Authorized');
}
