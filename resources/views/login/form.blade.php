<x-template title="Login">
    <div class="container">
        <form method="post" action="{{ route('login') }}">
            @csrf
            <x-form.group for="email" label="Email">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') ?? '' }}"
                    required>
            </x-form.group>
            <x-form.group for="password" label="Password">
                <input type="password" name="password" id="password" class="form-control" required>
            </x-form.group>
            <button type="submit" class="btn btn-success">Masuk</button>
        </form>
    </div>
</x-template>