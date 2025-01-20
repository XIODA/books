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

<!-- 用戶資訊 -->
<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-body text-center">
            <!-- 大頭貼 -->
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="大頭貼" class="img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px;">
            <h3 class="text-primary">{{ $user->name }}</h3>
            <p class="text-muted">{{ $user->bio }}</p>
            <p><strong>生日：</strong>{{ $user->birthday }}</p>

            @if(auth()->id() !== $user->id)
                @php
                        // 檢查送出的好友請求
                        $sendRequest = \App\Models\Friendship::where('user_id', auth()->id())
                                        ->where('friend_id', $user->id)
                                        ->first();

                        // 檢查收到的好友請求
                        $receivedRequest = \App\Models\Friendship::where('user_id', $user->id)
                                            ->where('friend_id', auth()->id())
                                            ->first();
                @endphp

                @if($sendRequest && $sendRequest->status === 'pending') 
                    <!--好友邀請發送-->
                    <button class="btn btn-secondary" disabled>好友請求已發送</button>
                @elseif($receivedRequest && $receivedRequest->status =='pending')
                    <!--接受好友邀請-->
                    <form action="{{ route('friend.accept') }}" method="POST"  style="display: inline;">
                        @csrf
                        <input type="hidden" name="friendship_id" value="{{$receivedRequest->id}}">
                        <button type="submit" class="btn btn-success">接受好友邀請</button>
                    </form>
                @elseif(($sendRequest && $sendRequest->status === 'accepted') || ($receivedRequest && $receivedRequest->status === 'accepted'))
                    <!--已是好友-->
                    <div class="d-inline-block">
                        <button class="btn btn-success" disabled>已是好友</button>
                    </div>
                        <!-- 刪除好友 -->
                     <form action="{{route('friend.delete')}}" method="POST" class="d-inline-block">
                        @csrf
                        <input type="hidden" name="friendship_id"  
                                value="{{ $sendRequest ? $sendRequest->id : ($receivedRequest ? $receivedRequest->id : '') }}">
                        <button class="btn btn-danger" >刪除好友</button>
                     </form>
                @else
                    <!--加入好友-->
                    <form action="{{ route('friend.request') }}" method="POST">
                        @csrf
                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-primary">加入好友</button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    <!-- 留言區 -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>留言</h4>
        </div>
        <div class="card-body">
            @forelse($user->comments as $comment)
                <div class="mb-3">
                    <p>{{ $comment->content }}</p>
                    <p><strong>書籍：</strong> 
                        <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#bookModal{{ $comment->book->id }}">{{ $comment->book->title }}</button>
                    </p>
                    <small class="text-muted">{{ $comment->created_at->format('Y-m-d H:i') }}</small>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="bookModal{{ $comment->book->id }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $comment->book->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookModalLabel{{ $comment->book->id }}">{{ $comment->book->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6><strong>作者：</strong> {{ $comment->book->author }}</h6>
                                <p><strong>出版年份：</strong> {{ $comment->book->published_year }}</p>
                                <p><strong>分類：</strong> 
                                    @if ($comment->book->categories->isNotEmpty())
                                        {{ $comment->book->categories->pluck('name')->join(', ') }}
                                    @else
                                        無分類
                                    @endif
                                </p>
                                <p><strong>簡介：</strong> {{ $comment->book->description }}</p>
                                <div>
                                    @if ($comment->book->img)
                                        <img src="{{ asset('storage/' . $comment->book->img) }}" alt="{{ $comment->book->title }}" class="img-fluid">
                                    @else
                                        <p>無圖片</p>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @if ($comment->book->is_public)
                                        <span class="badge bg-success">公開</span>
                                    @else
                                        <span class="badge bg-secondary">隱藏</span>
                                    @endif    
                                </div>
                            </div>
                            <div class="mt-5">
                                <h3>留言板</h3>
                                @foreach($comment->book->comments as $comment)
                                    <div class="card my-2">
                                        <div class="card-body">
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="avatar" width="50" class="mt-2"><p style="color:red;font-weight:900">{{ $comment->user->name }}:</p> <p>{{ $comment->content }}</p>
                                            <small>在 {{ $comment->created_at->timezone('Asia/Taipei')->format('Y-m-d H:i') }} 發表</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">暫無留言</p>
            @endforelse
        </div>
    </div>

    <!-- 好友區 -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h4>好友列表</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($user->friends as $friend)
                    <div class="col-md-4 text-center mb-3">
                        <a href="/user/{{$friend->id}}"><img src="{{ asset('storage/' . $friend->avatar) }}" alt="好友大頭貼" class="img-thumbnail rounded-circle" style="width: 75px; height: 75px;"></a>
                        <p class="mt-2 mb-0">{{ $friend->name }}</p>
                        <small class="text-muted">{{ $friend->bio }}</small>
                    </div>
                @empty
                    <p class="text-muted">暫無好友</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4>確認邀請</h4>
        </div>
        <div class="card-body">
            <div class="row">
                
            <!-- 顯示收到的好友請求 -->
                @php
                    $receivedRequests = \App\Models\Friendship::where('friend_id', auth()->id())
                                        ->where('status', 'pending')
                                        ->get();
                @endphp
                @if(auth()->id() === $user->id)

                    @if($receivedRequests->isNotEmpty())
                        
                            @foreach($receivedRequests as $request)
                            <div class="col-md-4 text-center mb-3">
                                <a href="/user/{{$request->sender->id}}"><img src="{{ asset('storage/' . $request->sender->avatar) }}" alt="大頭貼" class="img-thumbnail rounded-circle" style="width: 75px; height: 75px;"></a>
                                <p class="mt-2 mb-0">{{ $request->sender->name }}</p>
                                    <!-- 接受好友請求 -->
                                    <form action="{{ route('friend.accept') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="friendship_id" value="{{ $request->id }}">
                                        <button type="submit" class="btn btn-success btn-sm">接受</button>
                                    </form>
                                    <!-- 拒絕好友請求 -->
                                    <form action="{{ route('friend.reject') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="friendship_id" value="{{ $request->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">拒絕</button>
                                    </form>

                            </div>
                                   
                                
                            @endforeach
                        
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection