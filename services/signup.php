<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 12:30 PM
 */

include "../db/db_helper.php";
include "../db/data_helper.php";
include "../helpers/password_helper.php";

include "../helpers/HTTPFunctions.php";

session_start();
include "../helpers/SessionSingleton.php";

/**
 * @param $msg string message to send
 * @return bool did it work this is purely there to silence php storm
 */
function sendErrorToSignUpPage(string $msg){
    set_redirect('../signup.php?error='.$msg);
    exit();
    /** @noinspection PhpUnreachableStatementInspection */
    return false;
}

/**
 * extract vars from POST
 * @return mixed
 */
function getCustomerData()
{
    $customerArray[':fname'] = isset($_POST['firstname']) ? $_POST['firstname']
        : sendErrorToSignUpPage('First Name cannot be empty');
    $customerArray[':lname'] = isset($_POST['lastname']) ? $_POST['lastname']
        : sendErrorToSignUpPage('Last Name cannot be empty');
    $customerArray[':city'] = isset($_POST['city']) ? $_POST['city']
        : sendErrorToSignUpPage('City cannot be empty');
    $customerArray[':country'] = isset($_POST['country']) ? $_POST['country']
        : sendErrorToSignUpPage('Country cannot be empty');
    $customerArray[':email'] = isset($_POST['email']) ? $_POST['email']
        : sendErrorToSignUpPage('Email cannot be empty');
    return $customerArray;
}


/**
 * @param $email string Email of user
 * @return mixed
 */
function GetPasswordArray(string $email)
{
    $pwdArray[':email'] = $email;
    $pwdArray[':pwd'] = isset($_POST['password']) ? $_POST['password']
        : sendErrorToSignUpPage('Password cannot be empty');
    $pwdArray[':salt'] = GenSalt();
    $pwdArray[':pwd'] = GenHash($pwdArray[':pwd'], $pwdArray[':salt']);
    return $pwdArray;
}


/**
 * @param $pdo
 * @param $customerArray
 */
function InsertCustomerData(PDO $pdo, $customerArray)
{
    $customerSql = 'INSERT INTO Customers (FirstName, LastName, City, Country, Email)
VALUES (:fname, :lname, :city, :country, :email );';
    runQuery($pdo, $customerSql, $customerArray);
}


/**
 * @param $pdo
 * @param $pwdArray
 */
function InsertPassword(PDO $pdo, $pwdArray)
{
    $pwdSql = 'INSERT INTO CustomerLogon (UserName, Pass, Salt) 
VALUES (:email,:pwd,:salt);';
    runQuery($pdo, $pwdSql, $pwdArray);
}


/**
 * @param PDO $pdo
 * @param string $email email address of user
 * @return mixed
 */
function GetNewCustomerID(PDO $pdo, string $email)
{
    return getDataByEmail($pdo, $email, 'CustomerID') -> fetch()[0];
}

function main(){
    $pdo = newConnection();
    try {
        $pdo->beginTransaction();

        $customerArray = getCustomerData();
        $email = $customerArray[':email'];
        if(EmailExists($pdo, $email)){
            $pdo -> rollBack();
            sendErrorToSignUpPage($email. " is in use");
        }
        InsertCustomerData($pdo, $customerArray);
        $pwdArray = GetPasswordArray($email);
        InsertPassword($pdo, $pwdArray);
        Session_Singleton::StartUserSession(GetNewCustomerID($pdo, $email));

        $pdo->commit();
    }catch (PDOException $e){
        $pdo->rollBack();
        sendErrorToSignUpPage($e->getMessage());
    }

    set_redirect('../index.php');
}

main();