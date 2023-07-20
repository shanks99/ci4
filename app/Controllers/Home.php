<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('layout/header')
            . view('pages/home')
            . view('layout/footer');
    }
}
