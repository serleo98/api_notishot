<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

if (!function_exists('getUser')) {
    function getUser()
    {
        return auth('api')->user();
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return auth('api')->user();
    }
}

if (!function_exists('isLogged')) {
   function isLogged()
    {
        return (auth('api')->user() != null);
    }
}


if (!function_exists('parseTrueFalseNull')) {
    function parseTrueFalseNull($value)
    {
        if (is_null($value)) {
            return null;
        }
        switch ($value) {
            case 1:
                return true;
            case 0:
                return false;
            default:
                return null;
        }
    }

    if(!function_exists('issetNotNull')){
        function issetNotNull($param){
            return isset($param) && !is_null($param);
        }
    }
}




