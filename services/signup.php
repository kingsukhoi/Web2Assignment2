<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 12:30 PM
 */

include "../db/db_helper.php";
include "../helpers/password_helper.php";

function sendErrorToSignUpPage($msg){
    header('Location: ../signup.php?error='.$msg);
    set_http_status(400, 'Bad Request');
    exit(1);
    /** @noinspection PhpUnreachableStatementInspection */
    return false;
}



$customerArray[':fname'] = isset($_POST['firstname']) ? $_POST['firstname']
    : sendErrorToSignUpPage('First Name cannot be empty');
$customerArray[':lname'] = isset($_POST['lastname']) ? $_POST['lastname']
    : sendErrorToSignUpPage('Last Name cannot be empty');
$customerArray[':city'] = isset($_POST['city'])?$_POST['city']
    : sendErrorToSignUpPage('City cannot be empty');
$customerArray[':country'] = isset($_POST['country'])?$_POST['country']
    : sendErrorToSignUpPage('Country cannot be empty');
$customerArray[':email'] = isset($_POST['email'])?$_POST['email']
    : sendErrorToSignUpPage('Email cannot be empty');

$pwdArray[':email'] = $customerArray[':email'];
$pwdArray[':pwd'] = isset($_POST['password'])?$_POST['password']
    : sendErrorToSignUpPage('Password cannot be empty');
$pwdArray[':salt'] = GenSalt();
$pwdArray[':pwd'] = GenHash($pwdArray[':pwd'], $pwdArray[':salt']);


$pdo = newConnection();
$customerSql = 'INSERT INTO Customers (FirstName, LastName, City, Country, Email)
VALUES (:fname, :lname, :city, :country, :email );';
runQuery($pdo, $customerSql, $customerArray);

$pwdSql = 'INSERT INTO CustomerLogon (UserName, Pass, Salt) 
VALUES (:email,:pwd,:salt);';
runQuery($pdo, $pwdSql, $pwdArray);

$idStmt = $pdo -> prepare('SELECT CustomerID FROM art.Customers WHERE Email = :email');
$idStmt->execute([':email'=>$customerArray[':email']]);
$id = $idStmt -> fetch();
$id = $id[0];

header('Location: ../helpers/whats-in-json.php?json='.json_encode($id));
