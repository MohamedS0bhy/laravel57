<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
   public static function randomkey($length = 64)
    {
        $string = "";
        $characters = "1234567890abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // change to whatever characters you want
        while ($length > 0) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
            $length -= 1;
        }
        return $string;
    }
}
