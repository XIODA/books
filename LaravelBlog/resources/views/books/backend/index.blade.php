@extends('layouts.app')

@section('content')
@if(Auth::check())
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{ route('books.index') }}">{{session('name')}}的書庫</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">新增書籍</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">管理類別</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('backend.comments.index') }}">管理留言</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <img src="{{ $book->img ? Storage::url($book->img) : 'https://via.placeholder.com/150' }}" 
                             class="card-img-top" 
                             alt="書籍圖片">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">
                                <strong>類別：</strong> 
                                @if ($book->categories->isNotEmpty())
                                    {{ $book->categories->pluck('name')->join(', ') }}
                                @else
                                    無分類
                                @endif
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                       
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-primary btn-sm">編輯</a>
                      
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
@else
您沒有權限查看裡面的資料。
@endif
@endsection