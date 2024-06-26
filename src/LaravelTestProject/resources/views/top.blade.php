<!DOCTYPE html>
<html>

<head>
    <title>Search Book</title>
</head>

<body>
    <div>
        <h1>Search Book</h1>
        <hr>
    </div>
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif
    <div>
        <form action="{{ route('search') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <h2>Title or Author:</h2>
                <input type="text" name="query" maxlength="100" placeholder="Enter title or author">
            </div>
            <button type="submit" name="submit">Search</button>
        </form>
    </div>
</body>

</html>
