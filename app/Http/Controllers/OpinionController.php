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
        return view('opinion');
    }

    public function giveOpinion(GiveOpinion $request)
    {
        $opinion = new Opinion();
        $opinion->insertOpinion($request);

        return redirect('/opinion')->with('message','ご意見ありがとうございました！');
    }

    public function opinionShow()
    {
        $opinion = new Opinion();
        $opinions = $opinion->showOpinion();
        return view('opinion_show',['opinions' => $opinions]);
    }
}
