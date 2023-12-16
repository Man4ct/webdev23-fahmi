<x-template>
    <div class="container">
        <form method="post" class="was-validated">
            @csrf
            <x-form.group for="name" label="Kategori">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $category->name ?? '' }}" required>
            </x-form.group>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                @isset($category)
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                @endisset
            </div>
        </form>
    </div>

    @isset($category)
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-danger">
                    <h1 class="modal-title fs-5">Hapus kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus kategori?
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('article_category.delete', ['id' => $category->id]) }}">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endisset
</x-template>
