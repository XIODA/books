@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{asset('books/backend')}}">勖群的書庫</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{asset('books')}}">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">新增書籍</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('books.create') }}">設定</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                            <li><a class="dropdown-item" href="blog-home.html">Blog Home</a></li>
                            <li><a class="dropdown-item" href="blog-post.html">Blog Post</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">作品</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                            <li><a class="dropdown-item" href="portfolio-overview.html">作品總覽</a></li>
                            <li><a class="dropdown-item" href="portfolio-item.html">作品清單</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <ul>
        @foreach($books as $book)
            <li>
                <table>
                    <tr>
                        <td><?php if($book->img!=null){?><img src="{{ Storage::url($book->img) }}" style="width:120px"><?php }else{echo '圖片尚未存在'; }?></td>
                    </tr>
                    <tr>
                        <td>標題 : {{ $book->title }} |</td>
                    </tr>
                </table>
                <a href="{{ route('books.edit', $book) }}">編輯</a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">刪除</button>
                </form>
                <hr>
            </li>
        @endforeach
    </ul>
    <div class="mt-4">
        {{$books->links('pagination::bootstrap-5')}}
    </div>
@endsection

