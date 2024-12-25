@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{ route('books.index') }}">勖群的書庫</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">新增書籍</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">管理類別</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">更新書籍</h1>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">標題</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $book->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">作者</label>
                <input type="text" class="form-control" name="author" id="author" value="{{ old('author', $book->author) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">描述</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $book->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">選擇類別</label>
                <select class="form-select" name="categories[]" id="categories" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $book->categories->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="published_year" class="form-label">出版年份</label>
                <input type="number" class="form-control" name="published_year" id="published_year" value="{{ old('published_year', $book->published_year) }}" required>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">圖片</label>
                <input type="file" class="form-control" name="img" id="img" accept="image/*">
                @if($book->img)
                    <div class="mt-3">
                        <p>當前圖片：</p>
                        <img src="{{ asset('storage/' . $book->img) }}" alt="書籍圖片" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">更新書籍</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">返回</a>
        </form>
    </div>
@endsection