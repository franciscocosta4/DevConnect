<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::with([
        'user',
        'likedByUsers',
        'comments.user',           // para mostrar o autor do comentário
        'comments.children.user',  // para mostrar os filhos e respetivos autores
    ])
    ->latest()
    ->get();

    return view('dashboard', compact('posts'));
}


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard');
    }
    public function show($id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard', $post->id);
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('dashboard');
    }


    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);

        if ($post->likedByUsers->contains(Auth::id())) {
            $post->likedByUsers()->detach(Auth::id());
        } else {
            $post->likedByUsers()->attach(Auth::id());
        }

        return back();
    }
}
