<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserList extends Model
{
    public function showUserList(){
        $userList = DB::table('users')
            ->orderBy('id', 'DESC')
            ->get();
        return $userList;
    }
}
