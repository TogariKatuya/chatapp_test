<!-- resources/views/book_details.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>{{ $book['volumeInfo']['title'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ url()->previous() }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>{{ $book['volumeInfo']['title'] }}</h1>
        </div>
        <hr>

        <h2>{{ $book['volumeInfo']['title'] }}</h2>
        <p>{{ isset($book['volumeInfo']['authors']) ? implode(', ', $book['volumeInfo']['authors']) : '不明な著者' }}</p>
        <p>{{ isset($book['volumeInfo']['description']) ? $book['volumeInfo']['description'] : '説明はありません' }}</p>
        @if (isset($book['volumeInfo']['imageLinks']['thumbnail']))
            <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}" alt="{{ $book['volumeInfo']['title'] }}">
        @endif
    </div>
</body>

</html>
