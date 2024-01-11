<x-template>
    <div class="container">
        <form method="post" class="was-validated">
            @csrf
            <x-form.group for="name" label="Nama">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $user->name ?? '' }}" required>
            </x-form.group>
            <x-form.group for="email" label="Email">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') ?? $user->email ?? '' }}" required>
            </x-form.group>
            <x-form.group for="role" label="Role">
                <select name="role" id="role" class="form-select" required>
                    <option value="" selected disabled>Pilih role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->value }}" @selected((old('role') ?? $user->role->value ?? '') == $role->value)>{{ $role->name }}</option>
                    @endforeach
                </select>
            </x-form.group>
            @empty($user)
            <x-form.group for="password" label="Password">
                <input type="password" name="password" id="password" class="form-control" required>
            </x-form.group>
            <x-form.group for="password_confirmation" label="Konfirmasi password">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </x-form.group>
            @endif
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                @isset($user)
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                @endisset
                <a class="btn btn-secondary" href="{{ route('user.list') }}">Kembali</a>
            </div>
        </form>
    </div>

    @isset($user)
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-danger">
                    <h1 class="modal-title fs-5">Hapus user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus user?
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('user.delete', ['id' => $user->id]) }}">
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
