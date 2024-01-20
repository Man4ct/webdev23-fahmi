<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function list(Request $request)
    {
        $users = Article::where(function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        })->paginate(20)->withQueryString();

        return view('user.list', [
            'users' => $users
        ]);
    }

    function create(Request $request)
    {
        $roles = collect(\App\Enums\UserRoleEnum::cases());

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
                'role' => ['required', 'string', Rule::in($roles->pluck('value'))],
                'password' => ['required', 'string', 'confirmed', 'max:255'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);

            if ($user) {
                return redirect()->route('user.list')
                    ->withSuccess('User berhasil dibuat');
            }

            return back()->withInput()
                ->withErrors([
                    'message' => 'Gagal menyimpan user'
                ]);
        }

        return view('user.form', [
            'roles' => $roles
        ]);
    }

    function edit(string $id, Request $request)
    {
        $roles = collect(\App\Enums\UserRoleEnum::cases());
        $user = User::where('id', $id)->first();

        if (!$user)
            return abort(404);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'role' => ['required', 'string', Rule::in($roles->pluck('value'))],
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            if ($user) {
                return redirect()->route('user.list')
                    ->withSuccess('User berhasil diubah');
            }

            return back()->withInput()
                ->withErrors([
                    'alert' => 'Gagal menyimpan user'
                ]);
        }

        return view('user.form', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    function delete(string $id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if (!$user)
            return abort(404);

        if ($user->delete()) {
            return redirect()->route('user.list')
                ->withSuccess('User telah dihapus');
        }

        return back()->withInput()
            ->withErrors([
                'alert' => 'Gagal menghapus user'
            ]);
    }
}
