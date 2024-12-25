<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
    //登入
    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            // return redirect()->intended('books.index');
            return redirect()->route('books.index')->with('success', '您已成功登入');
        }
        return back()->withErrors([
            'email'=>'提供的憑證與我們的紀錄不符',
        ]);
        
    }

    
   //登出
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('books');
    }

    //註冊
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ]);

        //建立新的使用者
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        //自動登入
        Auth::login($user);

        //跳轉到書庫頁面
        return redirect()->route('books.index');
    }
    
}
