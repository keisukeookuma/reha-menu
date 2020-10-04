<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\TemplateItem;
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
                $templateItem = new TemplateItem();
                $items = $templateItem->getTemplateItemsForUsers($request, $user_id, $admin_id);
            }else{
                $item = new Item();
                $items = $item->getItemForUsers($request, $admin_id, $user_id);
            }
        }else{
            if($request->type === 'template'){
                $templateItem = new TemplateItem();
                $items = $templateItem->getTemplateItems($request, $admin_id);
            }else{
                $item = new Item();
                $items = $item->getItem($request, $admin_id);
            }
        }
        $json = $items;
        return response()->json($json);
    }
}