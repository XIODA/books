@extends('layouts.app')
@section('content')

<!-- 頂部導航欄 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container px-5">
        <a class="navbar-brand" href="{{ asset('books') }}">
            
            共享區
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ asset('books') }}">首頁</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ asset('about') }}">關於我</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ asset('contact') }}">聯絡我們</a></li>

                @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="/user/{{ Auth::user()->id }}">個人頁面</a></li>
                        <li><a class="dropdown-item" href="/books/backend">我的書庫</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">編輯個人資料</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">登出</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登入</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register.form') }}">註冊</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1>編輯個人資料</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">名稱</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">電子郵件</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">新密碼（留空則不更改）</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">確認新密碼</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">大頭貼</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label for="birthday" class="form-label">生日</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday', $user->birthday) }}">
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">個人介紹</label>
            <textarea name="bio" id="bio" class="form-control" rows="4">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection