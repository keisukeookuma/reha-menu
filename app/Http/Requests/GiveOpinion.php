<?php

namespace App\Http\Requests;

use App\Rules\SpaceCheck;
use Illuminate\Foundation\Http\FormRequest;

class GiveOpinion extends FormRequest
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
            'name' =>  ['required','max:20', new SpaceCheck],
            'opinion' => ['required','max:150', new SpaceCheck],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名前',
            'opinion' => 'ご意見',
        ];
    }
}
