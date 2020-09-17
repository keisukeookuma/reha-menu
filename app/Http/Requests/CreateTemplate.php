<?php

namespace App\Http\Requests;

use App\Rules\SpaceCheck;
use App\Rules\CountContents;
use Illuminate\Foundation\Http\FormRequest;

class CreateTemplate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'template_name' => ['required','max:20', new SpaceCheck],
            'template_status' => 'required|integer|between:0,1',
            'template_items' => ['required', new CountContents],
            'template_kind' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'template_name' => 'テンプレート名',
            'template_status' => 'ステータス',
            'template_items' => '自主トレ',
            'template_kind' => 'テンプレート種類',
        ];
    }
}
