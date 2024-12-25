@extends('layouts.app') <!-- 或者你的主佈局名稱 -->

@section('content')
<div class="container">
    <h1>新增類別</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">類別名稱</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">儲存</button>
    </form>
</div>
@endsection