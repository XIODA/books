<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Comment;
use SebastianBergmann\CodeUnit\FunctionUnit;

class CommentController extends Controller
{
    public function store(Request $request,Book $book){
        // dd(session('user_id'));
        $validated = $request->validate([
           'content'=>'required|string|max:1000', 
        ]);

        $book->comments()->create([
            'content'=>$validated['content'],
            'book_id' => $book->id,
            'user_id'=>session('user_id'), 
        ]);

        return redirect()->route('books.index',$book->id)->with('success','留言新增成功');
    }
    //留言後台
    public function backend(){
        $comments=Comment::where('user_id',auth()->id())->with('book')->paginate(10); 
        return view('books.backend.comments.index',compact('comments'));
    }

    //新增刪除功能
    public function destroy(Comment $comment){
        $comment->delete();
        return redirect()->route('backend.comments.index')->with('success','留言已刪除');
    }

    //新增編輯功能
    public function edit(Comment $comment){
        return view('books.backend.comments.edit',compact('comment'));
    }

    //更新留言
    public function update(Request $request , Comment $comment){
        $validated = $request->validate([
            'content'=>'required|string|max:1000',
        ]);

        $comment -> update(['content'=>$validated['content']]);

        return redirect()->route('backend.comments.index')->with('success','留言已更新');
    }
}
