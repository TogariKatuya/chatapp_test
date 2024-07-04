<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome CDNを追加 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1>Search Results</h1>
        <hr>
    </div>
    @if (count($books) > 0)
        <ul>
            @foreach ($books as $book)
                <li>
                    <h2>{{ $book->volumeInfo->title }}</h2>
                    <p>{{ isset($book->volumeInfo->authors) ? implode(', ', $book->volumeInfo->authors) : 'Unknown Author' }}
                    </p>
                    <p>{{ isset($book->volumeInfo->description) ? $book->volumeInfo->description : 'No description available' }}
                    </p>
                    @if (isset($book->volumeInfo->imageLinks->thumbnail))
                        <img src="{{ $book->volumeInfo->imageLinks->thumbnail }}" alt="{{ $book->volumeInfo->title }}">
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>該当する書籍は見つかりませんでした。</p>
    @endif
    <a href="{{ url('/') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>
</body>

</html>
