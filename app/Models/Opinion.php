<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GiveOpinion;
use Carbon\Carbon;

class Opinion extends Model
{
    public function insertOpinion($request){
        $now = Carbon::now();
        DB::table('opinions')->INSERT(
            [
                'name' => $request->name,
                'email' => $request->email,
                'opinion' => $request->opinion,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function showOpinion(){
        $opinions = DB::table('opinions')
            ->orderBy('id', 'DESC')
            ->get();
        return $opinions;
    }
}
