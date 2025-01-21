@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $book->title }}</h1>
    <p><strong>作者：</strong> {{ $book->author }}</p>
    <p><strong>出版年份：</strong> {{ $book->published_year }}</p>
    <p><strong>簡介：</strong> {{ $book->description }}</p>
    <div>
        @if ($book->img)
            <img src="{{ asset('storage/' . $book->img) }}" alt="{{ $book->title }}" style="max-width: 100%;">
        @else
            <p>無圖片</p>
        @endif
    </div>
    <a href="{{asset('books')}}" class="btn btn-primary">返回</a>
</div>
@endsection