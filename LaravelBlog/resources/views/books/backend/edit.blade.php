@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{asset('books/backend')}}">勖群的書庫</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{asset('books')}}">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">新增書籍</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">設定</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                            <li><a class="dropdown-item" href="blog-home.html">Blog Home</a></li>
                            <li><a class="dropdown-item" href="blog-post.html">Blog Post</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">作品</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                            <li><a class="dropdown-item" href="portfolio-overview.html">作品總覽</a></li>
                            <li><a class="dropdown-item" href="portfolio-item.html">作品清單</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="title">標題</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required>
        </div>

        <div>
            <label for="author">作者</label>
            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required>
        </div>

        <div>
            <label for="description">描述</label>
            <textarea name="description" id="description">{{ old('description', $book->description) }}</textarea>
        </div>

        <div>
            <label for="published_year">出版年份</label>
            <input type="number" name="published_year" id="published_year" 
                   value="{{ old('published_year', $book->published_year) }}" required>
        </div>

        <div>
            <label for="img">圖片</label>
            <input type="file" name="img" id="img" accept="image/*">
            @if($book->img)
                <div>
                    <p>當前圖片：</p>
                    <img src="{{ asset('storage/' . $book->img) }}" alt="書籍圖片" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <button type="submit">更新書籍</button>
    </form>
@endsection