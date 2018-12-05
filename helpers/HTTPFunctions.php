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
 */
function set_http_status($status=200, $msg="success"){
    header("HTTP/1.0 $status $msg");
    if ($status != 200)
        echo json_encode(['status'=>$status, 'message'=>$msg]);
}

function set_redirect(string $location){
    header('Location: ' . $location);
}