<x-template>
    <div class="container">
        <a class="btn btn-success" href="{{ route('user.create') }}">Tambah user</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width:50px"></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-info">Ubah</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-template>
