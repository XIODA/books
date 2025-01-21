<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>{{ $book->title }}</h1>
        <p><strong>作者：</strong>{{ $book->author }}</p>
        <p><strong>出版年份：</strong>{{ $book->published_year }}</p>
        @if ($book->img)
            <img src="{{ asset('storage/' . $book->img) }}" alt="{{ $book->title }}">
        @endif
        <p>{{ $book->description }}</p>
        
    </div>
</body>
</html>