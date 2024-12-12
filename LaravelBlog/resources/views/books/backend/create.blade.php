@extends('layouts.app')

@section('content')
    <h1>新增書籍</h1>
    
    {{-- 顯示表單驗證錯誤 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">書名：</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div>
            <label for="author">作者：</label>
            <input type="text" id="author" name="author" value="{{ old('author') }}" required>
        </div>
        <div>
            <label for="published_year">出版年份：</label>
            <input type="number" id="published_year" name="published_year" value="{{ old('published_year') }}" required>
        </div>
        <div>
            <label for="img">上傳圖片：</label>
            <input type="file" id="img" name="img" >
        </div>
        <button type="submit">新增</button>
    </form>
@endsection