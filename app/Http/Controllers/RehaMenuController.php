<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateItem;
use App\Http\Requests\ChangeItem;
use App\Http\Requests\GiveOpinion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RehaMenuController extends Controller
{
    public function top()
    {
        return view('top');
    }

    public function index()
    {
        return view('index');
    }

    public function getData(Request $request)
    {   
        if(isset($request->template_word)===true){
            $template_word = $request->template_word;
            $items = DB::table('items')
                        ->join('templates', 'items.id', '=', 'templates.item_id')
                        ->where('template_name', 'LIKE', '%'.$template_word.'%')
                        ->orderBy('items.id', 'DESC')
                        ->get();
        }else{
            $search_word = $request->search_word;
            $offset = $request->offset;
            $items = DB::table('items')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('item_name', 'LIKE' ,'%'.$search_word.'%')
                        ->orWhere('caption', 'LIKE', '%'.$search_word.'%')
                        ->orWhere('search_word', 'LIKE', '%'.$search_word.'%')
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->limit(2)
                        ->offset($offset)
                        ->get();
        }
        $items = self::caption_add_number($items);
        $json = $items;
        return response()->json($json);
    }

    private function caption_add_number($sample)
    {
        foreach($sample as $array){
            $data = [];
            $result = [];
            $data = explode("\n", $array->caption);
            foreach($data as $value){
                $result[] = $value;
            }
            $array->caption = $result;
            $productList[] = $array;
        }
        return $productList;
    }

    public function tool()
    {
        $items = DB::table('items')
                    ->select('items.id','item_name', 'creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'template_name', 'status')
                    ->join('templates', 'items.id', '=', 'templates.item_id')
                    ->join('search_words', 'items.id', '=', 'search_words.item_id')
                    ->groupBy('items.id')
                    ->get();
        return view('tool',['items' => $items]);
    }

    public function toolCreate(CreateItem $request)
    {
        $user_id = Auth::id();
        $now = Carbon::now();
        if($request->sqltype === 'new_product'){
            $folderFilePath = $request->file->store('img');
            $filePath = str_replace('img/', '', $folderFilePath);
            
            DB::transaction(function () use($request, $filePath, $user_id, $now) {
                $item_id = DB::table('items')->insertGetId(
                    [
                        'user_id' => $user_id,
                        'item_name' => $request->item_name,
                        'creator' => $request->creator,
                        'caption' => $request->caption,
                        'img' => $filePath,
                        'status' => $request->status,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );

                DB::table('templates')->INSERT(
                    [
                        'user_id' => $user_id,
                        'item_id' => $item_id,
                        'template_name' => $request->template_name,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
                foreach($request->search_word as $value){
                    DB::table('search_words')->INSERT(
                        [
                            'item_id' => $item_id,
                            'search_word' => $value,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    );
                }
            });
        }

        return redirect('/tool');
    }

    public function toolDelete(Request $request)
    {
        $item_id = $request->item_id;
        $deleteFile = $request->deletefiles;
        DB::transaction(function () use ($item_id, $deleteFile){
            DB::table('templates')
                ->WHERE('item_id', $item_id)
                ->DELETE();
            
            DB::table('search_words')
                ->WHERE('item_id', $item_id)
                ->DELETE();
            
            DB::table('items')
                ->WHERE('id', $item_id)
                ->DELETE();
            Storage::delete('/img/'.$deleteFile);
        });
        return redirect('/tool');
    }

    public function changeItem(ChangeItem $request)
    {
        $now = Carbon::now();
        DB::table('items')
            ->where('id', $request->id)
            ->update([
                'item_name' => $request->item_name,
                'creator' => $request->creator,
                'caption' => $request->caption,
                'status' => $request->status,
                'updated_at' => $now
        ]);

        return redirect('/tool');
    }

    public function manual()
    {
        return view('manual');
    }

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

    public function opinion_show()
    {
        $opinions = DB::table('opinions')
            ->orderBy('id', 'DESC')
            ->get();
        return view('opinion_show',['opinions' => $opinions]);
    }
}