<?php

namespace App\Controllers;

use App\Models\ResidentModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home'
        ];
        return view('Home/index', $data);
    }
}
