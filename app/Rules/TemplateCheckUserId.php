<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\library\Common;

class TemplateCheckUserId implements Rule
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
    public function passes($attribute, $templates_id)
    {
        $admin_id = Common::admin_id();
        $user_id = Auth::id();
        $check_user_id = DB::table('templates')
                        ->select('user_id')
                        ->where('id',$templates_id)
                        ->get();    
        if($user_id !== $check_user_id[0]->user_id){
            if($admin_id !== $user_id){
                return false;
            }
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
        return ':attributeは作成者のみ削除が行えます。';
    }
}
