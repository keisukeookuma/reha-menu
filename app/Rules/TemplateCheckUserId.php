<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemplateCheckUserId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    // private function admin_id()
    // {
    //     return $admin_id = 1;
    // }

    // private function check_admin()
    // {
    //     $admin_id = self::admin_id();
    //     $check_admin = '';
    //     if(Auth::id() === $admin_id){
    //         $check_admin = 'admin';
    //     }
    //     return $check_admin;
    // }

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
        $admin_id = Common::admin_id();
        $user_id = Auth::id();
        // $templates_id = $request->templates_id;
        $check_user_id = [];
        foreach($value as $val){
            $check_user_id[] = DB::table('templates')
                            ->select('user_id')
                            ->where('id',$val)
                            ->get();    
        }
        foreach($check_user_id as $val2){
            foreach($val2 as $val3){
                if($user_id !== $val3->user_id){
                    if($admin_id !== $user_id){
                        return false;
                    }
                }
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
