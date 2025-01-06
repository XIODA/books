<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm(){            //顯示用戶的登入頁面
        return view('auth.login');              //使用view渲染到login.php這隻檔案
    }
    //登入
    public function login(Request $request){ 
        $credentials = $request->validate([
            'email'=>'required|email',          //必填,格式須符合email
            'password'=>'required'              //必填
        ]);

        if(Auth::attempt($credentials)){        //使用 Laravel 的 Auth 驗證憑證是否正確
            $user = Auth::user(); //獲取目前登入的使用者
            $request->session()->regenerate();  //重新生成用戶的 session ID（$request->session()->regenerate()），以防止 Session Fixation 攻擊。
            // return redirect()->intended('books.index');
            $request->session()->put('user_id', $user->id);
            $request->session()->put('name', $user->name);
            return redirect()->route('books.index')->with('success', '您已成功登入');
        }
        return back()->withErrors([
            'email'=>'提供的憑證與我們的紀錄不符',
        ]);
        
    }

    
   //登出
    public function logout(Request $request){
        Auth::logout(); //登出當前用戶。
        $request->session()->invalidate(); //使當前用戶的 session 無效
        $request->session()->regenerateToken(); //重新生成 CSRF token，避免舊的 token 被利用。

        return redirect('books');
    }

    //註冊
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([ //驗證用戶輸入
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users', //必填 格式須符合email 在user表中唯一
            'password'=>'required|string|min:6|confirmed', //confirmed=須和確認密碼一致
        ]);

        //建立新的使用者
        $user = User::create([ //在資料庫中新增一個使用者
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password) //將密碼使用bcrypt加密儲存
        ]);

        //自動登入
        Auth::login($user); //新註冊的用戶自動登入

        //跳轉到書庫頁面
        return redirect()->route('books.index'); 
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthday' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('avatar')) {
            // 刪除舊的大頭貼
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // 上傳新大頭貼
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // 如果密碼未更改，移除這個欄位
        }
        
        $user = Auth::user(); // 取得當前用戶
        $user->update($validated); // 更新資料庫中的用戶資料

        //刷新用戶資料
        Auth::user()->name = $validated['name'];

        return redirect()->route('books.index')->with('success', '個人資料已更新！');
    }
    
}
