<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard principal
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'projects' => Project::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentProjects = Project::with('user')->latest()->take(5)->get();
        $recentPosts = Post::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects', 'recentPosts'));
    }

    // === MÉTODOS DE PROJETOS ===
    public function projects()
    {
        $projects = Project::with('user')->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function createProject()
    {
        $users = User::all();
        return view('admin.projects.create', compact('users'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private',
            'zip_file' => 'nullable|file|mimes:zip|max:10240', // 10MB max
        ]);

        $data = $request->only(['user_id', 'title', 'description', 'visibility']);
        
        // Handle file upload
        if ($request->hasFile('zip_file')) {
            $zipFile = $request->file('zip_file');
            $fileName = time() . '_' . $zipFile->getClientOriginalName();
            $data['zip_file_path'] = $zipFile->storeAs('projects', $fileName, 'public');
        }

        Project::create($data);

        return redirect()->route('admin.projects')->with('success', 'Projeto criado com sucesso!');
    }

    public function editProject(Project $project)
    {
        $users = User::all();
        return view('admin.projects.edit', compact('project', 'users'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private',
            'zip_file' => 'nullable|file|mimes:zip|max:10240',
        ]);

        $data = $request->only(['user_id', 'title', 'description', 'visibility']);

        // Handle new file upload
        if ($request->hasFile('zip_file')) {
            // Delete old file if exists
            if ($project->zip_file_path && Storage::disk('public')->exists($project->zip_file_path)) {
                Storage::disk('public')->delete($project->zip_file_path);
            }

            $zipFile = $request->file('zip_file');
            $fileName = time() . '_' . $zipFile->getClientOriginalName();
            $data['zip_file_path'] = $zipFile->storeAs('projects', $fileName, 'public');
        }

        $project->update($data);

        return redirect()->route('admin.projects')->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroyProject(Project $project)
    {
        // Delete associated file
        if ($project->zip_file_path && Storage::disk('public')->exists($project->zip_file_path)) {
            Storage::disk('public')->delete($project->zip_file_path);
        }

        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Projeto eliminado com sucesso!');
    }

    // === MÉTODOS DE POSTS ===
    public function posts()
    {
        $posts = Post::with(['user', 'comments'])->latest()->paginate(15);
                $comments = Comment::with(['user', 'post', 'parent'])->latest()->paginate(15);
        return view('admin.posts.index', compact('posts','comments'));
    }

    public function editPost(Post $post)
    {
        $users = User::all();
        return view('admin.posts.edit', compact('post', 'users'));
    }

    public function updatePost(Request $request, Post $post)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $post->update($request->only(['user_id', 'content']));

        return redirect()->route('admin.posts')->with('success', 'Post atualizado com sucesso!');
    }

    public function destroyPost(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts')->with('success', 'Post eliminado com sucesso!');
    }

    // === MÉTODOS DE COMENTÁRIOS ===
    public function comments()
    {
        $comments = Comment::with(['user', 'post', 'parent'])->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroyComment(Comment $comment)
    {
        // Delete child comments recursively
        $this->deleteCommentWithChildren($comment);
        
        return redirect()->route('admin.comments')->with('success', 'Comentário eliminado com sucesso!');
    }

    private function deleteCommentWithChildren(Comment $comment)
    {
        // Delete all child comments first
        foreach ($comment->children as $child) {
            $this->deleteCommentWithChildren($child);
        }
        
        // Then delete the comment itself
        $comment->delete();
    }

    // === MÉTODOS DE USUÁRIOS ===
    public function users()
    {
        $users = User::withCount(['projects', 'posts'])->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load(['projects', 'posts.comments']);
        return view('admin.users.show', compact('user'));
    }

    // Editar utilizador
public function editUser(User $user)
{
    return view('admin.users.edit', compact('user'));
}

// Atualizar utilizador
public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'bio' => 'nullable|string',
        'cv_path' => 'nullable|file|mimes:pdf|max:2048',
        'avatar' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['name', 'username', 'email', 'bio']);

    // Upload de CV
    if ($request->hasFile('cv_path')) {
        if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
            Storage::disk('public')->delete($user->cv_path);
        }
        $data['cv_path'] = $request->file('cv_path')->store('cv', 'public');
    }

    // Upload de avatar
    if ($request->hasFile('avatar')) {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($data);

    return redirect()->route('admin.users.edit', $user)->with('success', 'Utilizador atualizado com sucesso!');
}

// Eliminar utilizador
public function destroyUser(User $user)
{
    // Eliminar ficheiros se existirem
    if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
        Storage::disk('public')->delete($user->cv_path);
    }

    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    $user->delete();

    return redirect()->route('admin.users')->with('success', 'Utilizador eliminado com sucesso!');
}

}