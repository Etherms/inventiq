<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->select('id', 'name', 'email', 'created_at')
                ->latest()
                ->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return back()->with('success', 'User updated successfully.');
    }

    public function sendPasswordReset(User $user)
    {
        Password::sendResetLink([
            'email' => $user->email,
        ]);

        return back()->with('success', 'Password reset link sent.');
    }
}