<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Opinion;
use App\Http\Requests\GiveOpinion;


class OpinionController extends Controller
{
    public function opinion()
    {
        $return_url = url()->previous();
        return view('opinion',['return_url' => $return_url]);
    }

    public function giveOpinion(GiveOpinion $request)
    {
        $opinion = new Opinion();
        $opinion->insertOpinion($request);
        $return_url = $request->return_url;
        return redirect('/opinion')->with(['message'=>'ご意見ありがとうございました！', 'return_url'=>$return_url]);
    }

    public function opinionShow()
    {
        $opinion = new Opinion();
        $opinions = $opinion->showOpinion();
        return view('opinion_show',['opinions' => $opinions]);
    }
}
