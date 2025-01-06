@extends('layouts.app') <!-- 或者你的主佈局名稱 -->

@section('content')
<div class="container">
    <h1 class="mb-4">編輯留言</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('backend.comments.update', $comment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">留言內容</label>
            <textarea id="content" name="content" class="form-control" rows="4" required>{{ old('content', $comment->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新留言</button>
        <a href="{{ route('backend.comments.index') }}" class="btn btn-secondary">返回</a>
    </form>
</div>
@endsection