@extends('layouts.app')
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
@section('content')
<body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="{{asset('books')}}">勖群的書庫</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="{{asset('books')}}">首頁</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{asset('about')}}">關於我</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">聯絡我們</a></li>

                            
                            @if(Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">作品</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="portfolio-overview.html">作品總覽</a></li>
                                    <li><a class="dropdown-item" href="portfolio-item.html">作品清單</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                            
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">書庫</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="{{ route('books.backend') }}">我的書庫設定</a></li>
                                    <form action="{{route('logout')}}" method="POST" style="display:inline;">
                                        @csrf

                                        <button type="submit" class="btn btn-link">登出</button>
                                    </form>
                                </ul>
                            @else
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">登入</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="{{ route('login') }}">登入</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register.form') }}">註冊</a></li>
                            @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="bg-dark py-5">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">A Bootstrap 5 template for modern businesses</h1>
                                <p class="lead fw-normal text-white-50 mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit!</p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Get Started</a>
                                    <a class="btn btn-outline-light btn-lg px-4" href="#!">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="https://dummyimage.com/600x400/343a40/6c757d" alt="..." /></div>
                    </div>
                </div>
            </header>
            
            <!-- Blog preview section-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">我的書庫</h2>
                                <p class="lead fw-normal text-muted mb-5">這裡是檢視我的書庫的地方!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                    <form action="{{route('books.index')}}" method="GET">
                        <input type="text" class="form-control" name="search" id="search" value="{{request('search')}}" placeholder="請輸入名稱">
                        <select class="form-control" name="category">
                            <option value="">請選擇</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}"
                                @if(request('category') == $category->id) selected @endif
                            >   
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        
                        
                        <button type="submit" class="btn btn-primary">搜尋</button>
                    </form>

                    @foreach($books as $book)
                        <div class="col-lg-4 mb-5" >
                            <div class="card h-100 shadow border-0">
                                <img class="card-img-top" src="{{ Storage::url($book->img) }}" alt="..." />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">News</div>
                                    <h5 class="card-title mb-3">{{ $book->title }}</h5>
                                    <!-- <p class="card-text mb-0">{{ $book->description }}</p> -->
                                    
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                            <div class="small">
                                                <div class="fw-bold">{{ $book->author }}</div>
                                                <div class="text-muted">{{ $book->created_at}} &middot; </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <!-- 詳細資訊按鈕 -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}">
                                查看詳情
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="bookModal{{ $book->id }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $book->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bookModalLabel{{ $book->id }}">{{ $book->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6><strong>作者：</strong> {{ $book->author }}</h6>
                                            <p><strong>出版年份：</strong> {{ $book->published_year }}</p>
                                            <p><strong>分類：</strong>
                                                @if ($book->categories->isNotEmpty())
                                                    {{ $book->categories->pluck('name')->join(', ') }}
                                                @else
                                                    無分類
                                                @endif
                                            </p>
                                            <p><strong>簡介：</strong> {{ $book->description }}</p>
                                            <div>
                                                @if ($book->img)
                                                    <img src="{{ asset('storage/' . $book->img) }}" alt="{{ $book->title }}" style="max-width: 100%;">
                                                @else
                                                    <p>無圖片</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                    @endforeach
                   

                    <!-- 分頁寫法 -->
                    <div class="mt-4">
                        {{ $books->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                   
                </div>
            </section>
        </main>
        <!-- Footer-->
        
        
@endsection
