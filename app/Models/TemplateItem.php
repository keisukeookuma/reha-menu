<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\library\Common;

class TemplateItem extends Model
{
    // tool
    public function getToolTemplate(){
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $templates = DB::table('template_items')
                    ->select('template_items.id', 'items.item_name', 'templates.template_name', 'items.status as items_status', 'templates.id as templates_id','templates.status as templates_status', 'templates.kind', 'templates.user_id', 'templates.creator')
                    ->join('templates', 'template_items.template_id', '=', 'templates.id')
                    ->join('items', 'template_items.item_id', '=', 'items.id')
                    ->when($user_id !== $admin_id, function($query) use ($user_id) {
                        return $query->where('templates.user_id', $user_id);
                    })
                    ->orderBy('templates_id', 'DESC')
                    ->get();
        $templates = $templates -> groupBy('templates_id');

        return $templates;
    }

    public function insertTemplateDb($request){
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
    }

    public function deleteTemplateDb($request){
        $templates_id = $request->templates_id;
        DB::transaction(function () use($templates_id) {
            DB::table('template_items')
            ->WHERE('template_id', $templates_id)
            ->DELETE();

            DB::table('templates')
                ->WHERE('id', $templates_id)
                ->DELETE();
        });
    }

    // index

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
