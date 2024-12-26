<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //前台頁面
    public function index(Request $request)
    {
        
         $books=Book::all();
        
        //  return view('books.index',compact('books'));

    //初始化查詢
    $query = Book::query();
    
    //未登入情況
    if(!auth()->check()){
        $query->where('is_public',true);
    }else{
        //登入情況
        
        $query->where(function($subQuery){
            $subQuery->where('is_public',true)
                     ->orWhere('user_id',auth()->id());
        });
    }

    //如果搜索參數存在，則進行篩選
    if($request->filled('search')){
        $search = $request->input('search');
        $query    -> where(function($subQuery) use ($search){
            $subQuery -> where('title','like','%'.$search.'%')
                   -> orWhere('author','like','%'.$search.'%');

        });
    }
    if($request->filled('category')){
        $categoryId = $request->input('category');
        $query->whereHas('categories', function ($subQuery) use ($categoryId) {
            $subQuery->where('categories.id', $categoryId);
        });
    }

    //分頁顯示
    $books = $query->paginate(6);
    $books->appends($request->all()); //點選分頁時保留搜索的參數
    $categories = Category::all(); //傳遞所有類別

    return view('books.index',compact('books','categories'));


    }
    //後台頁面
    public function backend()
    {
         $books=Book::all();
         $query = Book::query();
         $query->where(function($subQuery){
            $subQuery->where('user_id',auth()->id());
        });

         $books = $query->paginate(6);
         return view('books.backend.index',compact('books'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::all();
        
        $categories = Category::all()->map(function ($category) {
            $category->depth = $category->parent_id ? 1 : 0;
            return $category;
        });
        return view('books.backend.create',compact('categories'));

        
    }

   

    /**
     * Store a newly created resource in storage.
     */
    //處理書籍數據
    public function store(Request $request)
    {
        // dd(session('user_id'));
        // dd($request->all());
        $valaidated = $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'description'=>'nullable|string',
            'categories'=>'array', //驗證類別數據
            'published_year'=>'required|integer|min:1000|max:9999',
            'img'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048', //圖片驗證
            'parent_id'=>'nullable|exists:categories,id',
            'is_public' => 'nullable',
        ]);

        if($request->hasfile('img')){
            $filePath = $request->file('img')->store('images','public'); //儲存在public的images
        }

        
        // Book::create($valaidated);
        $book = Book::create([
            'title' => $valaidated['title'],
            'author' => $valaidated['author'],
            'published_year' => $valaidated['published_year'],
            'img' => $filePath ?? null,
            'user_id' => session('user_id'),
            'is_public'=>$valaidated['is_public'], //根據是否勾選公開
        ]);

        $book->categories()->sync($request->categories); //保存類別
        
        // return redirect('/books/backend')->with('success', '書籍已新增');
        return redirect()->route('books.backend')->with('success', '書籍已新增');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        // $categories = Category::all();
        $categories = Category::all()->map(function ($category) {
            $category->depth = $category->parent_id ? 1 : 0;
            return $category;
        });
        return view('books.backend.edit',compact('book','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        
        $valaidated = $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'description'=>'nullable|string',
            'categories' => 'array',
            'published_year'=>'required|integer|min:1000|max:9999',
            'img'=>'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'is_public'=>'nullable|boolean',
        ]);
        
        $valaidated['is_public'] = $request->input('is_public', 0);

        //處理圖片文件上傳
        if($request->hasfile('img')){
            //刪除舊照片
            if($book->img){
                Storage::delete('public/'.$book->img);
            }

            //儲存新圖片
            $path = $request->file('img')->store('images','public');
            $valaidated['img']=$path;
        }

        $book -> update($valaidated);
        $book -> categories()->sync($request->categories); //更新類別

        return redirect('/books/backend')->with('success','書籍已更新');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books/backend')->with('success','書籍已刪除');
    }
    public function toggleVisibility(Book $book)
    {
    if ($book->user_id !== auth()->id()) {
        abort(403, '您無權修改此書庫');
    }

    $book->is_public = !$book->is_public;
    $book->save();

    return redirect()->route('books.index')->with('success', '書庫公開狀態已更新');
    }
}
