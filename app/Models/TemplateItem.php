<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\library\Common;
use Illuminate\Http\Request;


class TemplateItem extends Model
{
    public function getTemplateItemsForUsers($request, $user_id, $admin_id ){
        $template_word = $request->template_word;
        $offset = $request->offset;
        if($template_word == $user_id) {
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
        return $items;
    }

    public function getTemplateItems($request, $admin_id){
        $template_word = $request->template_word;
        $offset = $request->offset;
        $items = DB::table('template_items')
                ->select('template_items.id', 'items.item_name', 'templates.creator as template_creator', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id','items.caption as caption', 'img')
                ->join('templates', 'template_items.template_id', '=', 'templates.id')
                ->join('items', 'template_items.item_id', '=', 'items.id')
                ->where(function ($query) use ($admin_id){
                    $query->whereIn('templates.user_id',[$admin_id]);
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
        
        return $items;
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
