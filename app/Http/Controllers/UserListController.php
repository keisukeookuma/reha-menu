<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserList;

class UserListController extends Controller
{
    public function userListShow(){
        $userList = new UserList();
        $userList = $userList->showUserList();
        return view('user_list',['userList' => $userList]);
    }
}
