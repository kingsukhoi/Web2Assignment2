<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 8:50 PM
 */

session_start();

include "../helpers/SessionSingleton.php";
include "../helpers/HTTPFunctions.php";
Session_Singleton::EndUserSession();

set_redirect($_SERVER['HTTP_REFERER']);