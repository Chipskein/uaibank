<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UsersController extends BaseController
{
    public function showLoginForm()
    {
        return view('LoginForm');
    }
    public function Login()
    {
        return view('RegisterForm');
    }
    public function Logoff()
    {
        
    }
}
