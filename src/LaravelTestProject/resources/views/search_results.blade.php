<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div>
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
                </li>
            @endforeach
        </ul>
    @else
        <p>No books found.</p>
    @endif
    <a href="{{ url('/') }}">Back to Search</a>
</body>

</html>
