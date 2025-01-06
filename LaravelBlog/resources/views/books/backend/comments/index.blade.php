@extends('layouts.app')


@section('content')
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



<div class="container">
    <h1 class="mb-4">留言管理</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>留言內容</th>
                <th>書籍名稱</th>
                <th>使用者名稱</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->book->title }}</td>
                    <td>{{ $comment->user->name }}</td>
                    <td>
                        <a href="{{ route('backend.comments.edit', $comment) }}" class="btn btn-sm btn-warning">編輯</a>
                        <form action="{{ route('backend.comments.destroy', $comment) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('確定刪除這條留言嗎？')">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $comments->links() }} <!-- 分頁導航 -->
</div>
@endsection