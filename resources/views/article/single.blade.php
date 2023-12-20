<x-template>
    <div class="container">
        <div class="mb-3 text-end">
            <a href="{{ route('article.edit', ['id' => $article->id]) }}" class="btn
                btn-info">Ubah</a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#deleteModal">Hapus</button>
            <a href="{{ route('article.list') }}" class="btn
    btn-secondary">Kembali</a>
        </div>
        {{-- <div class="badge text-bg-light mb-3">
            {{ $article->category->name }}
        </div> --}}
        <h1>{{ $article->title }}</h5>
            <h5 class="mb-2 text-body-secondary">{{ $article->updated_at }}</h6>
                <p>
                    {{ $article->content }}
                </p>
                <div class="accordion mt-5" id="accordionComment">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{ $article->comments_count }} Komentar
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionComment">
                            <div class="accordion-body">
                                @foreach ($article->comments->sortByDesc('created_at') as $comment)
                                    <x-article-comment :comment="$comment"></x-article-comment>
                                @endforeach
                                <form method="post" action="{{ route('article.comment', ['id' => $article->id]) }}">
                                    @csrf
                                    <x-form.group for="comment" label="Tinggalkan komentar Anda">
                                        <textarea class="form-control" name="comment" id="comment"></textarea>
                                    </x-form.group>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-danger">
                    <h1 class="modal-title fs-5">Hapus artikel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus artikel?
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('article.delete', ['id' => $article->id]) }}">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-template>
