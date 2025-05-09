<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Project;
use App\Models\User;
use App\Models\Post;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */public function public($username): View
{
    // Busca o usuário pelo campo 'username'
    $user = User::where('username', $username)->firstOrFail(); 

    // Apenas projetos públicos
    $projects = $user->projects()->where('visibility', 'public')->latest()->get();
    $posts = $user->posts()->latest()->get();

    return view('profile.public', compact('user', 'projects', 'posts'));
}

    public function show(Request $request): View
{
    $user = $request->user();

    $projects = $user->projects()->latest()->get(); // Garante que tens a relação no modelo User
    $posts = $user->posts()->latest()->get();

    return view('profile.show', compact('user', 'projects', 'posts'));
}
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
