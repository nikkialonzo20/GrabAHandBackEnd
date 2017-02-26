<?php

namespace App\Util;

use App\Util\AndroidFCMNotification;
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 2/26/2017
 * Time: 8:23 PM
 */
class Helper
{
    public static function sendNotification($token){
        $AFN = new \AndroidFCMNotification($token, "ping");
        $AFN->sendNotif();
    }
}