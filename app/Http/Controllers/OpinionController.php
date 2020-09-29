<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GiveOpinion;
use Carbon\Carbon;

class OpinionController extends Controller
{
    public function opinion()
    {
        return view('opinion');
    }

    public function giveOpinion(GiveOpinion $request)
    {
        $now = Carbon::now();
        DB::table('opinions')->INSERT(
            [
                'name' => $request->name,
                'opinion' => $request->opinion,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        return redirect('/opinion')->with('message','ご意見ありがとうございました！');
    }

    public function opinionShow()
    {
        $opinions = DB::table('opinions')
            ->orderBy('id', 'DESC')
            ->get();
        return view('opinion_show',['opinions' => $opinions]);
    }
}
