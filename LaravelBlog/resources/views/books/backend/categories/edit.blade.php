@extends('layouts.app') <!-- 或者你的主佈局名稱 -->

@section('content')
<div class="container">
    <h1>修改類別</h1>
    <form action="{{ route('categories.update',$categories->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">類別名稱</label>
            <input type="text" id="name" name="name" value=" {{ old('name', $categories->name) }} " required>
        </div>
        <button type="submit">更新</button>
    </form>
</div>
@endsection