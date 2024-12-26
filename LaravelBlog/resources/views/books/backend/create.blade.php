@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">新增書籍</h1>

        {{-- 顯示表單驗證錯誤 --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">書名：</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">作者：</label>
                <input type="text" id="author" name="author" class="form-control" value="{{ old('author') }}" required>
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">選擇類別：</label>
                <select name="categories[]" id="categories" class="form-select" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                           {{ str_repeat('-',$category->depth)}} {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">按住 Ctrl 鍵以選擇多個類別</small>
            </div>
            

            <div class="mb-3">
                <label for="published_year" class="form-label">出版年份：</label>
                <input type="number" id="published_year" name="published_year" class="form-control" value="{{ old('published_year') }}" required>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">上傳圖片：</label>
                <input type="file" id="img" name="img" class="form-control">
            </div>
            
            <div class="mb-3">
                <label for="is_public" class="form-label">公開狀態</label>
                <div class="form-check">
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" id="is_public" name="is_public" value="1" class="form-check-input" 
                {{ old('is_public', true) ? 'checked' : '' }}>
                    <label for="is_public" class="form-check-label">公開</label>
                </div>
                <small class="form-text text-muted">勾選表示公開，未勾選表示隱藏。</small>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">新增</button>
                <a href="{{ route('books.backend') }}" class="btn btn-secondary">返回</a>
            </div>
        </form>
    </div>
    <br/>
@endsection