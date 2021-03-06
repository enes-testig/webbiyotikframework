<?php

namespace Framework\Helpers;

use Framework\Core\Session;
use Framework\Http\Request;
use Framework\Layouts\Helpers\Csrf as ICsrf;

/**
 * Webbiyotik csrf class
 *
 * 
 * @package Webbiyotik
 * @license MIT
 * @copyright 2018
 */
class Csrf implements ICsrf
{
    /**
     * Get csrf token and a new one if expired.
     *
     * @return string
     */
    public static function makeToken() : String
    {
        $max_time   = 60 * 60 * 24;
        $csrf_token = Session::get('csrf_token');
        $stored_time= Session::get('csrf_token_time');

        if ($max_time + $stored_time <= time() || empty($csrf_token)) {
            Session::set('csrf_token', md5(uniqid(rand(), true)));
            Session::set('csrf_token_time', time());
        }

        return Session::get('csrf_token');
    }

    /**
     * Check csrf token.
     *
     * @return boolean
     */
    public static function isTokenValid() : Bool
    {
        return Request::post('token') === Session::get('csrf_token');
    }
}
