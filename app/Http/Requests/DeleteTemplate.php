<?php

namespace App\Http\Requests;

use App\Rules\TemplateCheckUserId;
use Illuminate\Foundation\Http\FormRequest;

class DeleteTemplate extends FormRequest
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
            'templates_id' => ['required','max:20', new TemplateCheckUserId],
            // 'templates_id' => ['required','max:20'],
        ];
    }
}
