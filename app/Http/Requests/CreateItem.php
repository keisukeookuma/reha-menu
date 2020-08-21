<?php

namespace App\Http\Requests;

use App\Rules\SpaceCheck;
use Illuminate\Foundation\Http\FormRequest;

class CreateItem extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => 'required|spaceCheck|max:20',
            'creator' => 'required|spaceCheck|max:20',
            'caption' => 'required|spaceCheck|max:60',
            'search_word' => 'required|max:25',
            'template_name' => 'required|max:20',
            'template_status' => 'required|integer|between:0,1',
            'status' => 'required|integer|between:0,1',
            'file' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sqltype' => 'required|spaceCheck'
        ];
    }

    public function attributes()
    {
        return [
            'item_name' => '自主トレ名',
            'creator' => '作者名',
            'caption' => '説明文',
            'search_word' => '検索ワード',
            'template_name' => 'テンプレート設定',
            'status' => 'ステータス',
            'file' => '画像',
        ];
    }
}
