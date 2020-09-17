<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CountContents implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //現在はテンプレートのアイテム数確認のため３つに限定
        $template_items = $value;
        if(count($value)>3){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '自主トレは3つまでです。';
    }
}
