<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 26/11/18
 * Time: 10:18 AM
 * This will handle storing login info in session.
 * Will also redirect back home
 */


include '../db/db_helper.php';
include "../db/data_helper.php";
include "../helpers/password_helper.php";

$username = $_POST['username'];
$password = $_POST['password'];

$conn = newConnection();

$params = 'CustomerID, UserName, Pass, Salt';
$data = getData($conn, $username, "UserName", $params, 'CustomerLogon');

if ($data -> rowCount() != 1){
    header("HTTP/1.0 500 Database Problem");
    exit(1);
}

$data = $data -> fetch();

$dbPass = $data['Pass'];
$dbSalt = $data['Salt'];

if(IsPasswordSame($password, $dbPass, $dbSalt)){
    $_SESSION['CustomerID'] = $data['CustomerID'];
    header("Location: ../index.php");
    session_start();
}
else{
    header("HTTP/1.0 401 Unauthorized");
}



