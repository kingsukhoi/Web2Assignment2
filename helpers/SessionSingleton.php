<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 04/12/18
 * Time: 9:27 PM
 */

class Session_Singleton
{
    /**
     * @var string Customer key in session array
     */
    static $CUSTOMER_ID_KEY = 'CustomerID';
    /**
     * @var string Favorites key in session array
     */
    static $FAVORITES_KEY = 'Favorites';

    /**
     * @param string $id customer id
     */
    static function StartUserSession(string $id)
    {
        $_SESSION[self::$CUSTOMER_ID_KEY] = $id;
    }

    /** kill a user session
     * @return bool true if session existed and was destroyed, false if there was not session or something else went wrong
     */
    static function EndUserSession()
    {
        session_unset();
        return session_destroy();
    }

    /** check if there is an existing session
     * @return bool True if session exists.
     */
    static function SessionStarted()
    {
        return (!trim($_SESSION[self::$CUSTOMER_ID_KEY])=="");
    }

    /**
     * add painting id to favorites
     * @param $paintingID int painting id
     * @return bool true if success, false if not
     */
    static function AddToFavorites(int $paintingID)
    {
        if (self::SessionStarted()) {
            $_SESSION[self::$FAVORITES_KEY][] = $paintingID;
            return true;
        }
        return false;
    }

    /**
     * get list of all favorites
     * @return array|null array of favorites
     */
    static function ListAllFavorites()
    {
        if (self::SessionStarted()) {
            return $_SESSION[self::$FAVORITES_KEY];
        }
        return null;
    }

    /**
     * Get the customer ID
     * @return bool|string bool if shit hit the fan, string if there's an id
     */
    static function GetCustomerID(){
        if(self::SessionStarted())
            return $_SESSION[self::$CUSTOMER_ID_KEY];
        else
            return false;
    }
}