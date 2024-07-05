<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Search Results</h1>
        </div>
        <hr>

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
                            <img src="{{ $book->volumeInfo->imageLinks->thumbnail }}"
                                alt="{{ $book->volumeInfo->title }}">
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="pagination">
                @if ($currentPage > 1)
                    <a href="{{ route('search', ['query' => $query, 'page' => $currentPage - 1]) }}">&laquo; 前へ</a>
                @endif

                <span>ページ {{ $currentPage }}</span>

                @if (count($books) == $perPage)
                    <a href="{{ route('search', ['query' => $query, 'page' => $currentPage + 1]) }}">次へ &raquo;</a>
                @endif
            </div>
        @else
            <p>該当する書籍は見つかりませんでした。</p>
        @endif
    </div>
</body>

</html>
