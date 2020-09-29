<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function manual()
    {
        $return_url = url()->previous();
        return view('manual',['return_url' => $return_url]);
    }
}
