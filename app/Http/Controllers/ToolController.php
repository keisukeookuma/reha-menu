<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\TemplateItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateItem;
use App\Http\Requests\ChangeItem;
use App\Http\Requests\CreateTemplate;
use App\Http\Requests\DeleteTemplate;
use App\library\Common;
use Illuminate\Support\Str;

class ToolController extends Controller
{
    public function tool()
    {
        $user_id = Auth::id();
        $admin_id = Common::admin_id();
        $admin = Common::check_admin($user_id);

        $item = new Item();
        $items = $item->getToolItem();
        // テンプレート作成時にitemの項目を出す
        $item_list_for_template = $item->getItemListForTemplate();

        $templateItem = new TemplateItem();
        $templates = $templateItem->getToolTemplate();

        return view('tool',['items' => $items, 'templates' => $templates, 'item_list_for_template' => $item_list_for_template,'admin' => $admin, 'admin_id' => $admin_id]);
    }

    public function createItem(CreateItem $request)
    {
        $request->search_word = self::nullFilter($request->search_word);
        $search_word = implode( ",", $request->search_word);

        $folderFilePath = $request->file->store('img');
        $filePath = str_replace('img/', '', $folderFilePath);
        
        $item = new Item();
        $item->insertItemDb($request, $search_word, $filePath);
        
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
        $item = new Item();
        $item->deleteItemDb($request);

        return redirect('/tool');
    }

    public function changeItem(ChangeItem $request)
    {
        $item = new Item();
        $item->changeItemDb($request);
        return redirect('/tool');
    }

    public function createTemplate(CreateTemplate $request)
    {
        $templateItem = new TemplateItem();
        $templates = $templateItem->insertTemplateDb($request);
        return redirect('/tool');
    }

    public function deleteTemplate(DeleteTemplate $request)
    {
        $templateItem = new TemplateItem();
        $templates = $templateItem->deleteTemplateDb($request);
        return redirect('/tool');
    }
}
