@extends('layouts.app')

@section('content')
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