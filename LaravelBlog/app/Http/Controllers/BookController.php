<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Models\Book;
use App\Models\Category;

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
        
        $valaidated = $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'description'=>'nullable|string',
            'categories'=>'array', //驗證類別數據
            'published_year'=>'required|integer|min:1000|max:9999',
            'img'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048', //圖片驗證
            'parent_id'=>'nullable|exists:categories,id',
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
        ]);
        
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
}
