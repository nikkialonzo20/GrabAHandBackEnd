<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 2/22/2017
 * Time: 8:19 AM
 */

namespace App\Http\Controllers;


class GrabController extends Controller
{

    public function __construct(){
        $this->user = new User();
        $this->job = new Job();
        $this->admin = new Admin();
    }
}