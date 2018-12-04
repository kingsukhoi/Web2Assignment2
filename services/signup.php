<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 12:30 PM
 */

include "../db/db_helper.php";
include "../helpers/password_helper.php";


$customerArray[':fname'] = isset($_POST['firstname']) ? $_POST['firstname'] : null;
$customerArray[':lname'] = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$customerArray[':city'] = isset($_POST['city'])?$_POST['city'] : null;
$customerArray[':country'] = isset($_POST['country'])?$_POST['country'] : null;
$customerArray[':email'] = isset($_POST['email'])?$_POST['email'] : null;

$pwdArray[':email'] = $customerArray[':email'];
$pwdArray[':pwd'] = isset($_POST['password'])?$_POST['password'] : null;
$pwdArray[':salt'] = GenSalt();
$pwdArray[':pwd'] = GenHash($pwdArray[':pwd'], $pwdArray[':salt']);


$pdo = newConnection();

$customerInsert = $pdo->prepare(
    '
INSERT INTO Customers (FirstName, LastName, City, Country, Email)
VALUES (:fname, :lname, :city, :country, :email );
');
$customerInsert -> execute($customerArray);

$pwdInsert = $pdo->prepare(
    'INSERT INTO CustomerLogon (UserName, Pass, Salt)
VALUES (:email,:pwd,:salt);'
);
$pwdInsert -> execute($pwdArray);

header('Location: ../helpers/whats-in-json.php?json='.json_encode($pwdArray));
