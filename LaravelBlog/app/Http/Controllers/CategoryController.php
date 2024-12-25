<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //顯示新增類別的表單
    public function create(){
        // dd('視圖路徑正確');
        $categories = Category::whereNull('parent_id')->get();
        return view('books.backend.categories.create',compact('categories'));
    }

    //儲存類別
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id', //檢查父類別存在
        ]);
    
    Category::create($validated);
    return redirect()->route('categories.index')->with('success', '類別已新增！');
    }

    // 顯示所有類別
    public function index()
    {
        $categories = Category::all();
        return view('books.backend.categories.index', compact('categories'));
    }

    //編輯功能
    public function edit($id){
        $categories = Category::findOrFail($id); //根據ID查找類別
        return view('books.backend.categories.edit',compact('categories'));
    }

    //處理表單提交的數據，更新類別
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255', //驗證類別的名稱
        ]);

        $category = Category::findOrFail($id);
        $category -> update($validated);

        return redirect()->route('categories.index')->with('success','類別已更新');
        }


    public function destroy($id){
        $category = Category::findOrFail($id);

        //如果要確保類別沒有被關聯使用，可以做檢查
        if($category->books()->exists()){
            return redirect()->route('categories.index')->with('error','無法刪除，目前類別正在使用');
        }

        $category->delete(); //刪除類別
        return redirect()->route('categories.index')->with('success','類別已刪除成功');
    }
}
