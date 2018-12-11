<?php
/**
 * Created by PhpStorm.
 * User: farsos
 * Date: 26/11/18
 * Time: 8:01 PM
 */

    /**
     * Set http status header
     * By default it's 200
     * IF the status code isn't 200, it displays a json message detailing what fucked up
     * @param int $status HTTP status code
     * @param string $msg a meaningful message aka. what fucked up
     * @param string|null $redirectUrl where to send user
     */
function send_error(int $status, string $msg, string $redirectUrl=null){
    header("HTTP/1.0 $status $msg");
    if ($redirectUrl==null){
        //echo json_encode(['status'=>$status, 'message'=>$msg]);
        set_redirect('error.php?error='.$msg);
    }else{
        set_redirect($redirectUrl.'?error='.$msg);
    }
    exit();
}

function set_redirect(string $location){
    header('Location: ' . $location);
}