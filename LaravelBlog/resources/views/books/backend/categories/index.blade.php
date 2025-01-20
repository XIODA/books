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
    <h1>分類管理</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">新增分類</a>

    @if($categories->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>分類名稱</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">編輯</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
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
            </tbody>
        </table>
    @else
        <p>目前沒有分類。</p>
    @endif
</div>
@endsection