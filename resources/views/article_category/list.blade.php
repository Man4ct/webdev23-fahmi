<x-template>
    <div class="container">
        <a class="btn btn-success" href="{{ route('article_category.create') }}">Tambah kategori</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="width:50px"></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('article_category.edit', ['id' => $category->id]) }}" class="btn btn-info">Ubah</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-template>
