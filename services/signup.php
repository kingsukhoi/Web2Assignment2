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

function getPostVar(string $postName, string $prettyName){
    return isset($_POST['firstname']) ?
        : sendErrorToSignUpPage($prettyName. ' cannot be empty');
}

/**
 * extract customer vars from POST
 * @return array customer data
 */
function getCustomerData()
{
    $customerArray[':fname'] = getPostVar('firstname', 'First Name');
    $customerArray[':lname'] = getPostVar('lastname', 'Last Name');
    $customerArray[':city'] = getPostVar('city', 'City');
    $customerArray[':country'] = getPostVar('country', 'Country');
    $customerArray[':email'] = getPostVar('email', 'Email');

    if (!filter_var($customerArray[':email'], FILTER_VALIDATE_EMAIL)){
        sendErrorToSignUpPage('Email format is invalid' . filter_var($customerArray[':email'], FILTER_VALIDATE_EMAIL));
    }

    return $customerArray;
}


/**
 * @param $email string Email of user
 * @return array password data
 */
function GetPasswordArray(string $email)
{
    $pwdArray[':email'] = $email;
    $pwdArray[':pwd'] = getPostVar('password', 'Password');
    $pwdArray[':salt'] = GenSalt();
    $pwdArray[':pwd'] = GenHash($pwdArray[':pwd'], $pwdArray[':salt']);
    return $pwdArray;
}


/**
 * @param $pdo
 * @param $customerArray array customer array
 */
function InsertCustomerData(PDO $pdo, $customerArray)
{
    $customerSql = 'INSERT INTO Customers (FirstName, LastName, City, Country, Email)
VALUES (:fname, :lname, :city, :country, :email );';
    runQuery($pdo, $customerSql, $customerArray);
}


/**
 * @param $pdo
 * @param $pwdArray array password array
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
 * @return string customer id
 */
function GetNewCustomerID(PDO $pdo, string $email)
{
    return getDataByEmail($pdo, $email, 'CustomerID') -> fetch()[0];
}

/**
 * main function
 */
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