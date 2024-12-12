<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $books=Book::all();
        //  return view('books.index',compact('books'));
        //  return view('books.backend.index', compact('books'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valaidated = $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'description'=>'nullable|string',
            'published_year'=>'required|integer|min:1000|max:9999',
        ]);
        Book::create($valaidated);

        return redirect()->route('books.index')->with('success','書籍已新增');
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
        return view('books.edit',compact('book'));

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
            'published_year'=>'required|integer|min:1000|max:9999',
        ]);

        $book -> update($valaidated);

        return redirect()->route('books.index')->with('success','書籍已更新');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success','書籍已刪除');
    }
}
