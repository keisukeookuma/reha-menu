<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\library\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }


    public function getData(Request $request)
    {   
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $admin = Common::check_admin($user_id);
        if(isset($user_id)){
            if($request->type === 'template'){
                $template_word = $request->template_word;
                $offset = $request->offset;
                if($request->template_word == $user_id) {
                    $items = DB::table('template_items')
                            ->select('template_items.id', 'items.item_name', 'templates.creator as template_creator', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id','items.caption as caption', 'img')
                            ->join('templates', 'template_items.template_id', '=', 'templates.id')
                            ->join('items', 'template_items.item_id', '=', 'items.id')
                            ->where('templates.user_id', $user_id)
                            ->orderBy('templates_id', 'ASC')
                            ->limit(30)
                            ->offset($offset)
                            ->get();
                }else{
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
                }
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
        }else{
            if($request->type === 'template'){
                $template_word = $request->template_word;
                $offset = $request->offset;
                $items = DB::table('template_items')
                        ->select('template_items.id', 'items.item_name', 'templates.creator as template_creator', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id','items.caption as caption', 'img')
                        ->join('templates', 'template_items.template_id', '=', 'templates.id')
                        ->join('items', 'template_items.item_id', '=', 'items.id')
                        ->where(function ($query) use ($admin_id, $user_id){
                            $query->whereIn('templates.user_id',[$admin_id, $user_id]);
                                    // ->orWhere('templates.status', 0);
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
                                $query->whereIn('items.user_id',[$admin_id, $user_id]);
                                    //   ->orWhere('status', 0);
                            })
                            ->where(function ($query) use ($search_word){
                                $query  ->where('item_name', 'LIKE' ,'%'.$search_word.'%')
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

}
