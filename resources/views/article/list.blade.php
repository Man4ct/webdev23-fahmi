<!DOCTYPE html>
<html>

<head>
    <title>Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</head>

<body><x-template>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if (count($articles) < 10)
                @canany(['isAdmin', 'isAuthor'])
                    <a class="btn btn-success" href="{{ route('article.create') }}">Tambah Artikel</a>
                    @endcanany
                @endif

                <a href="{{ route('article_category.list') }}" class="btn btn-primary">Kategori artikel</a>
            </div>
            @foreach ($articles as $article)
                <div class="card mt-3">
                    <div class="card-body">
                        <a href="{{ route('article.single', ['slug' => $article->slug]) }}">
                            <h5 class="card-title">{{ $article->title }}</h5>
                        </a>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $article->updated_at }}</h6>
                        <p class="card-text">
                            {{ $article->content }}
                        </p>
                        {{-- <div class="badge text-bg-light">
                            {{ $article->category->name }}
                        </div> --}}
                        <div class="mt-3">
                            @if($article->comments_count > 0)
                            <div class="mb-2 text-muted">Komentar terakhir</div>
                            <x-article-comment
                            :comment="$article->comments->last()"></x-article-comment>
                            @endif
                            <a href="{{ route('article.single', ['slug' => $article->slug])
                            }}#comment">Lihat {{ $article->comments_count }} komentar</a>
                            </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-template>
</body>
