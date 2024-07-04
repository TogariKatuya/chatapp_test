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
        <form action="{{ route('search') }}" method="get">
            @csrf
            <div>
                <label for="query">Title or Author</label>
                <input type="text" id="query" name="query" placeholder="Enter title or author"
                    value="{{ old('query') }}">
            </div>

            <!-- エラーメッセージを表示 -->
            @if ($errors->has('query'))
                <div class="error">
                    <strong>{{ $errors->first('query') }}</strong>
                </div>
            @endif

            <button type="submit">Search</button>
        </form>
    </div>
</body>

</html>
