<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;

class FriendshipController extends Controller
{
    //搜尋用戶
    public function search(Request $request){
        $query = $request->get('q');
        $users = User::where('name','LIKE','%'.$query.'%')
                    ->where('id','!=',auth()->id()) //排除自己
                    ->get(['id','name']);

        return response()->json($users);
    }
    // 發送好友請求
    public function sendRequest(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id'
        ]);

        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $request->friend_id,
            'status' => 'pending',
        ]);

        return back()->with('success', '好友請求已發送！');
    }

    // 接受好友請求
    public function acceptRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friendships,id',
        ]);

        $friendship = Friendship::findOrFail($request->friendship_id);

        // 確保是該用戶的好友請求
        if ($friendship->friend_id !== auth()->id()) {
            return back()->with('error', '無權限操作！');
        }

        $friendship->update(['status' => 'accepted']);

        //同步建立反向的好友關係
        Friendship::updateOrCreate(
            [
                'user_id'=>$friendship->friend_id,
                'friend_id'=>$friendship->user_id,
            ],
            [
                'status'=>'accepted',
            ]
        );

        return back()->with('success', '已接受好友請求！雙方已成為好友!');
    }
    //拒絕好友請求功能
    public function rejectRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friendships,id',
        ]);

        $friendship = Friendship::findOrFail($request->friendship_id);

        // 確保只有接收者可以操作
        if ($friendship->friend_id !== auth()->id()) {
            return back()->with('error', '無權限操作！');
        }

        $friendship->delete();

        return back()->with('success', '已拒絕好友請求！');
    }

    //刪除好友
    public function delete(Request $request){
       

        $friendship = Friendship::find($request->friendship_id);

        if ($friendship) {
            $friendship->delete();

            // 可選：根據雙向好友邏輯刪除對方的關係
            Friendship::where('user_id', $friendship->friend_id)
                    ->where('friend_id', $friendship->user_id)
                    ->delete();

            return back()->with('success', '好友已刪除');
        }

        return back()->with('error', '好友關係不存在');
    }
}
