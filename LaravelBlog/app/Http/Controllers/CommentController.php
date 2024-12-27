<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
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
}
