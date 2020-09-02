<?php

namespace App\Http\Requests;

use App\Rules\SpaceCheck;
use Illuminate\Foundation\Http\FormRequest;

class ChangeItem extends FormRequest
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
            'item_name' => ['required','max:20', new SpaceCheck],
            'creator' => ['required','max:20', new SpaceCheck],
            'caption' => ['required','max:80', new SpaceCheck],
            'status' => 'required|integer|between:0,1',
        ];
    }

    public function attributes()
    {
        return [
            'item_name' => '自主トレ名',
            'creator' => '作者名',
            'caption' => '説明文',
            'status' => 'ステータス',
        ];
    }
}
