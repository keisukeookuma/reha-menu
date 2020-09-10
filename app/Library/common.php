<?php
namespace App\library;

class Common
{
    public static function admin_id()
    {
        return $admin_id = 1;
    }

    public static function check_admin($id)
    {
        $admin_id = self::admin_id();
        $check_admin = '';
        if($id === $admin_id){
            $check_admin = 'admin';
        }
        return $check_admin;
    }
}