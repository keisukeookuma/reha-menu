<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {
        $return_url = url()->previous();
        return view('contact',['return_url' => $return_url]);
    }
}
