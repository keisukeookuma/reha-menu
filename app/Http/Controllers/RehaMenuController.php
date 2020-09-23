<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateItem;
use App\Http\Requests\ChangeItem;
use App\Http\Requests\GiveOpinion;
use App\Http\Requests\CreateTemplate;
use App\Http\Requests\DeleteTemplate;
use App\library\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $admin = Common::check_admin($user_id);
        if($request->type === 'template'){
            
            $template_word = $request->template_word;
            $offset = $request->offset;
            $items = DB::table('template_items')
                        ->select('template_items.id', 'items.item_name', 'templates.creator as template_creator', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id','items.caption as caption', 'img')
                        ->join('templates', 'template_items.template_id', '=', 'templates.id')
                        ->join('items', 'template_items.item_id', '=', 'items.id')
                        ->where(function ($query) use ($admin_id, $user_id){
                            $query->whereIn('templates.user_id',[$admin_id, $user_id])
                                  ->orWhere('templates.status', 0);
                        })
                        ->where('templates.kind', 'LIKE','%'.$template_word.'%')
                        ->orderBy('templates_id', 'ASC')
                        ->limit(30)
                        ->offset($offset)
                        ->get();
            $items = $items -> groupBy('templates_id');
            $items = $items -> take(10);
            $items = self::template_creator_name_if_admin_delete($items);
            $items = self::templates_caption_add_number($items);
        }else{
            $search_word = $request->search_word;
            $offset = $request->offset;
            $items = DB::table('items')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where(function ($query) use ($admin_id, $user_id){
                            $query->whereIn('items.user_id',[$admin_id, $user_id])
                                  ->orWhere('status', 0);
                        })
                        ->where(function ($query) use ($search_word){
                            $query  ->where('item_name', 'LIKE' ,'%'.$search_word.'%')
                                    ->orWhere('caption', 'LIKE', '%'.$search_word.'%')
                                    ->orWhere('creator', 'LIKE', '%'.$search_word.'%')
                                    ->orWhere('search_word', 'LIKE', '%'.$search_word.'%');
                        })
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->limit(10)
                        ->offset($offset)
                        ->get();
            $items = self::creator_name_if_admin_delete($items);
            $items = self::caption_add_number($items);
        }
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

    private function creator_name_if_admin_delete($sample)
    {
        $admin_id = Common::admin_id();
        foreach($sample as $array){
            
            if($array->user_id === $admin_id){
                $array->creator = '';
            }
            $productList[] = $array;
        }
        return $productList;
    }

    private function templates_caption_add_number($samples)
    {
        foreach($samples as $val => $sample){
            foreach($sample as $key => $array){
                $data = [];
                $result = [];
                $data = explode("\n", $array->caption);
                foreach($data as $value){
                    $result[] = $value;
                }
                $array->caption = $result;
            }
            $sample[$key] = $array;
            $productList[$val] = $sample;
        }
        return $productList;
    }

    private function template_creator_name_if_admin_delete($samples)
    {
        $admin_id = Common::admin_id();

        foreach($samples as $val => $sample){
            foreach($sample as $key => $array){
                if($array->user_id === $admin_id){
                    $array->template_creator = '';
                }
            }
            $sample[$key] = $array;
            $productList[$val] = $sample;
        }
        return $productList;
    }

    public function tool()
    {
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $admin = Common::check_admin($user_id);
        if($admin === 'admin'){
            $items = DB::table('items')
                        ->select('items.id','item_name', 'creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->get();
            // テンプレート作成時にitemの項目を出す            
            $item_list_for_template = DB::table('items')
                        ->select('items.id', 'item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $admin_id)
                        ->orderBy('item_id', 'DESC')
                        ->get();

            $templates = DB::table('template_items')
                        ->select('template_items.id', 'items.item_name', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id', 'templates.creator')
                        ->join('templates', 'template_items.template_id', '=', 'templates.id')
                        ->join('items', 'template_items.item_id', '=', 'items.id')
                        ->get();
            $templates = $templates -> groupBy('templates_id');
        }else{
            $items = DB::table('items')
                        ->select('items.id','item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $user_id)
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->get();

            $item_list_for_template = DB::table('items')
                        ->select('items.id', 'item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $user_id)
                        ->orWhere('items.user_id', $admin_id)
                        ->groupBy('items.id')
                        ->get();

            $templates = DB::table('template_items')
                        ->select('template_items.id', 'items.item_name', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.creator')
                        ->join('templates', 'template_items.template_id', '=', 'templates.id')
                        ->join('items', 'template_items.item_id', '=', 'items.id')
                        ->where('templates.user_id',$user_id)
                        ->get();
            $templates = $templates -> groupBy('templates_id');
        }
        // dd($item_list_for_template);
        return view('tool',['items' => $items, 'templates' => $templates, 'item_list_for_template' => $item_list_for_template,'admin' => $admin, 'admin_id' => $admin_id]);
    }

    public function createItem(CreateItem $request)
    {
        $user_id = Auth::id();
        $now = Carbon::now();
        $request->search_word = self::nullFilter($request->search_word);
        $search_word = implode( ",", $request->search_word);
        if($request->sqltype === 'new_product'){
            $folderFilePath = $request->file->store('img');
            $filePath = str_replace('img/', '', $folderFilePath);
            DB::transaction(function () use($request, $search_word, $filePath, $user_id, $now) {
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
                DB::table('search_words')->INSERT(
                    [
                        'item_id' => $item_id,
                        'search_word' => $search_word,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            });
        }

        return redirect('/tool');
    }

    private function nullFilter($value){
        $array = array_filter($value, 'self::nullDelete');
        return $array;
    }

    private function nullDelete($val){
        return !is_null($val);
    }

    public function deleteItem(Request $request)
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

    public function opinionShow()
    {
        $opinions = DB::table('opinions')
            ->orderBy('id', 'DESC')
            ->get();
        return view('opinion_show',['opinions' => $opinions]);
    }

    public function createTemplate(CreateTemplate $request)
    {
        $user_id = Auth::id();
        $now = Carbon::now();
        $item_id = $request->template_items;
        DB::transaction(function () use($request, $item_id, $user_id, $now) {
            $template_id = DB::table('templates')->insertGetId(
                [
                    'user_id' => $user_id,
                    'template_name' => $request->template_name,
                    'creator' => $request->template_creator,
                    'status' => $request->template_status,
                    'kind' => $request->template_kind,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            foreach ($item_id as $item){  
                DB::table('template_items')->INSERT(
                    [
                        'template_id' => $template_id,
                        'item_id' => $item,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        });
        return redirect('/tool');
    }

    public function deleteTemplate(DeleteTemplate $request)
    {
        $templates_id = $request->templates_id;
        DB::transaction(function () use($templates_id) {
            DB::table('template_items')
            ->WHERE('template_id', $templates_id)
            ->DELETE();

            DB::table('templates')
                ->WHERE('id', $templates_id)
                ->DELETE();
        });
        return redirect('/tool');
    }
}