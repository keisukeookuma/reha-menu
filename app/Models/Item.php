<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\library\Common;
use Illuminate\Http\Request;

class Item extends Model
{
    protected $guarded = [
        'id'
    ];

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