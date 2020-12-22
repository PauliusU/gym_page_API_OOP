<?php

namespace App\Controllers\Common\Auth;

use App\App;

class LogoutController
{
    /**
     * Log out the user and redirect to another location
     *
     */
    public function logout()
    {
        App::$session->logout('/login');
    }
}