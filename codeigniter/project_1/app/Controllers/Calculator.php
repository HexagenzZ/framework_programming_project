<?php

namespace App\Controllers;

class Calculator extends BaseController
{
    public function index(): string
    {
        return view('calculator_view');
    }
}
