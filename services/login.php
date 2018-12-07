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

    include "../helpers/HTTPFunctions.php";

    include '../db/db_helper.php';
    include "../db/data_helper.php";
    include "../helpers/password_helper.php";

    function send_error_to_login(int $status, string $msg){
        send_error($status, $msg, '../login.php');
    }

    function GetCustomerData($conn, $username){
        $params = 'CustomerID, UserName, Pass, Salt';
        $data = getDataByID($conn, $username, "UserName", $params, 'CustomerLogon');
        $data = $data -> fetch();
        return $data;
    }

    function LoginSuccess($id)
    {
        Session_Singleton::StartUserSession($id);
        set_redirect('../index.php');
    }

    function LoginFail()
    {
        send_error_to_login(401, 'Not Authorized');
    }
    
    function main (){
        $conn = newConnection();

        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!EmailExists($conn, $username)){
            send_error_to_login(401, 'Email not found');
        }
        $data = GetCustomerData($conn, $username);
        if(IsPasswordSame($password, $data['Pass'], $data['Salt'])){
            LoginSuccess($data['CustomerID']);
        }else{
            LoginFail();
        }
    }