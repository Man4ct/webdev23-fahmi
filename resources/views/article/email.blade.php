<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Artikel baru untuk Anda</title>
    <style>
        body {
            background: #d3d3d3;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            margin: 3em;
            padding: 1em 2em;
            background: #f5f5f5;
            border-radius: 5px;
            box-shadow: 2px 1px 3px #a2a2a2;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Artikel baru untuk Anda</h3>
        <h1>{{ $article->title }}</h1>
        <h5>{{ $article->updated_at }}</h5>
        @if ($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" style="max-height:300px">
        @endif
        <p>{{ $article->content }}</p>
    </div>
</body>

</html>
