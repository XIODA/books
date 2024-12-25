@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>登入</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">電子郵件：</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">密碼：</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">登入</button>
    </form>
</div>
@endsection