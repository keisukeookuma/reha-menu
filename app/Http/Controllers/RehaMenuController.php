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

    //Rules/TemplateCheckUserId.phpにも同様の記述あり
    private function admin_id()
    {
        return $admin_id = 1;
    }

    private function check_admin()
    {
        $admin_id = self::admin_id();
        $check_admin = '';
        if(Auth::id() === $admin_id){
            $check_admin = 'admin';
        }
        return $check_admin;
    }

    public function getData(Request $request)
    {   
        $admin_id = self::admin_id();
        $admin = self::check_admin();
        $user_id = Auth::id();
        if($request->type === 'template'){
            
            $template_word = $request->template_word;
            $items = DB::table('items')
                        ->join('templates', 'items.id', '=', 'templates.item_id')
                        ->whereIn('templates.user_id',[$admin_id, $user_id])
                        ->where('kind', 'LIKE','%'.$template_word.'%')
                        ->orderBy('template_name')
                        ->get();
            $items = $items -> groupBy('template_name');
            $items = self::templates_caption_add_number($items);
        }else{
            $search_word = $request->search_word;
            $offset = $request->offset;
            $items = DB::table('items')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->whereIn('items.user_id',[$admin_id, $user_id])
                        ->where(function ($query) use ($search_word){
                            $query  ->where('item_name', 'LIKE' ,'%'.$search_word.'%')
                                    ->orWhere('caption', 'LIKE', '%'.$search_word.'%')
                                    ->orWhere('search_word', 'LIKE', '%'.$search_word.'%');
                        })
                        // ->where('item_name', 'LIKE' ,'%'.$search_word.'%')
                        // ->orWhere('caption', 'LIKE', '%'.$search_word.'%')
                        // ->orWhere('search_word', 'LIKE', '%'.$search_word.'%')
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->limit(10)
                        ->offset($offset)
                        ->get();
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

    public function tool()
    {
        $admin_id = self::admin_id();
        $admin = self::check_admin();
        $user_id = Auth::id();
        if($admin === 'admin'){
            $items = DB::table('items')
                        ->select('items.id','item_name', 'creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->groupBy('items.id')
                        ->get();
            // テンプレート作成時にitemの項目を出す            
            $make_template_items = DB::table('items')
                        ->select('items.id', 'item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $admin_id)
                        ->groupBy('items.id')
                        ->get();

            $templates = DB::table('items')
                        ->select('items.id','item_name', 'creator', 'template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind')
                        ->join('templates', 'items.id', '=', 'templates.item_id')
                        ->get();
            $templates = $templates -> groupBy('template_name');
        }else{
            $items = DB::table('items')
                        ->select('items.id','item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $user_id)
                        ->groupBy('items.id')
                        ->get();

            $make_template_items = DB::table('items')
                        ->select('items.id', 'item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->where('items.user_id', $user_id)
                        ->orWhere('items.user_id', $admin_id)
                        ->groupBy('items.id')
                        ->get();

            $templates = DB::table('items')
                        ->select('items.id', 'templates.user_id', 'item_name', 'creator', 'template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind')
                        ->join('templates', 'items.id', '=', 'templates.item_id')
                        ->where('templates.user_id',$user_id)
                        ->get();
            $templates = $templates -> groupBy('template_name');
        }
        return view('tool',['items' => $items, 'templates' => $templates, 'make_template_items' => $make_template_items,'admin' => $admin]);
    }

    public function createItem(CreateItem $request)
    {
        $user_id = Auth::id();
        $now = Carbon::now();
        $request->search_word = self::nullFilter($request->search_word);
        $search_word = implode( ",", $request->search_word);
        // dd($search_word);
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
            foreach ($item_id as $item){
                DB::table('templates')->INSERT(
                    [
                        'user_id' => $user_id,
                        'item_id' => $item,
                        'template_name' => $request->template_name,
                        'status' => $request->template_status,
                        'kind' => $request->template_kind,
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
        dd($request);
        $admin = self::check_admin();
        $user_id = Auth::id();
        $templates_id = $request->templates_id;
        $check_user_id = [];
        foreach($templates_id as $val){
            // echo 'ok';
            $check_user_id[] = DB::table('templates')
                            ->select('user_id')
                            ->where('id',$val)
                            ->get();    
        }
        // var_dump($check_user_id);
        foreach($check_user_id as $value){
            foreach($value as $val2){
                if($user_id !== $val2->user_id){
                    // echo 'あなたのテンプレートではないため削除できません';
                    $errors = 'あなたのテンプレートではないため削除できません';
                    return view('tool', ['errors' => $errors]);
                }else{
                    echo '削除できました';
                }
            }
        }
    }
}