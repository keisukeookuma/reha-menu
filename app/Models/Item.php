<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\library\Common;
use Carbon\Carbon;

class Item extends Model
{
    protected $guarded = [
        'id'
    ];

    //tool
    public function getToolItem(){
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $items = DB::table('items')
                        ->select('items.id','item_name', 'items.user_id', 'creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->when($user_id !== $admin_id, function($query) use ($user_id) {
                            return $query->where('items.user_id', $user_id);
                        })
                        ->groupBy('items.id')
                        ->orderBy('items.id', 'DESC')
                        ->get();
        return $items;
    }

    public function getItemListForTemplate(){
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $item_list_for_template = DB::table('items')
                        ->select('items.id', 'item_name', 'items.user_id','creator', 'caption', DB::raw('GROUP_CONCAT(search_word) as search_word'), 'img', 'items.status as items_status')
                        ->join('search_words', 'items.id', '=', 'search_words.item_id')
                        ->when($user_id !== $admin_id, function($query) use ($user_id) {
                            return $query->where('items.user_id', $user_id);
                        })
                        ->orWhere('items.user_id', $admin_id)
                        ->groupBy('items.id')
                        ->get();
        return $item_list_for_template;
    }

    public function insertItemDb($request, $search_word, $filePath){
        $user_id = Auth::id();
        $now = Carbon::now();
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

    public function deleteItemDb($request){
        $item_id = $request->item_id;
        $deleteFile = $request->deletefiles;
        DB::transaction(function () use ($item_id, $deleteFile){
            DB::table('template_items')
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
    }

    public function changeItemDb($request){
        $now = Carbon::now();
        DB::transaction(function () use($request,$now) {
            DB::table('items')
                ->where('id', $request->id)
                ->update([
                    'item_name' => $request->item_name,
                    'creator' => $request->creator,
                    'caption' => $request->caption,
                    'status' => $request->status,
                    'updated_at' => $now
            ]);
            DB::table('search_words')
                ->where('item_id', $request->id)
                ->update([
                    'search_word' => $request->search_word,
                    'updated_at' => $now
            ]);
        });
    }

    // index
    public function getItemForUsers($request, $admin_id, $user_id){
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
        return $items;
    }

    public function getItem($request, $admin_id){
        $search_word = $request->search_word;
        $offset = $request->offset;
        $items = DB::table('items')
                    ->join('search_words', 'items.id', '=', 'search_words.item_id')
                    ->where(function ($query) use ($admin_id){
                        $query->whereIn('items.user_id',[$admin_id]);
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

        return $items;
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

}