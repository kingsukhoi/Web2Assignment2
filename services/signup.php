<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 12:30 PM
 */

include "../db/db_helper.php";
include "../helpers/password_helper.php";
$dbArray = [];

$dbArray[':fname'] = isset($_POST['firstname']) ? $_POST['firstname'] : null;
$dbArray[':lname'] = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$dbArray[':city'] = isset($_POST['city'])?$_POST['city'] : null;
$dbArray[':country'] = isset($_POST['country'])?$_POST['country'] : null;
$dbArray[':email'] = isset($_POST['email'])?$_POST['email'] : null;
$dbArray[':pwd'] = isset($_POST['password'])?$_POST['password'] : null;
$dbArray[':salt'] = GenSalt();
$dbArray[':pwd'] = GenHash($dbArray[':pwd'], $dbArray[':salt']);


$pdo = newConnection();

$customerInsert = $pdo->prepare(
    '
INSERT INTO Customers (FirstName, LastName, Address, City, Country, Postal, Phone, Email)
VALUES (:fname, :lname, :address, :city, :country, :postal, :email );
');
$customerInsert -> execute($dbArray);

$pwdInsert = $pdo->prepare(
    'INSERT INTO CustomerLogon (UserName, Pass, Salt)
VALUES (:email,:pwd,:salt);'
);
$pwdInsert -> execute($dbArray);

header('Location: ../helpers/whats-in-json.php?json='.json_encode($dbArray));
