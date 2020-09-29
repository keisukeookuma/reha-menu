<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function terms()
    {
        $return_url = url()->previous();
        return view('terms',['return_url' => $return_url]);
    }
}
