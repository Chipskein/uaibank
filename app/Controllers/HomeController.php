<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $session=session();
        if($session->has('id')&&$session->has('username')&&$session->has('name')&&$session->has('birthdate')){
            return redirect()->to(base_url('/users/'));
        }
        else return redirect()->to(base_url('/users/login'));
    }
}