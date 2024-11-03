<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function addUser()
    {
        echo "add new user";
    }

    public function register()
    {
        echo "register new user";
    }
}
