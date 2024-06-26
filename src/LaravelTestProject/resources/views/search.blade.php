<!DOCTYPE html>
<html>

<head>
    <title>Search Book</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div>
        <h1>Search Book</h1>
        <hr>
    </div>
    <div>
        <form action="{{ route('search') }}" method="post">
            @csrf
            <div>
                <label for="query">Title or Author:</label>
                <input type="text" id="query" name="query" placeholder="Enter title or author">
            </div>
            <button type="submit">Search</button>
        </form>
    </div>
</body>

</html>
