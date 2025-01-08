<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function show($id){
        //with(['comments.book'])：載入用戶的留言資料，以及留言所屬的書籍資料。
        //with(['friends'])：載入用戶的好友資料。
        $user = User::with(['comments.book','friends'])->findOrFail($id);
        return view('user.show',compact('user'));
    }
}
