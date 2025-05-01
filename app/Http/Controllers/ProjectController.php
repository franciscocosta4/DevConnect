<?php
// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        // Mostrar projetos do utilizador
        $projects = Auth::user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'visibility' => 'required|in:public,private',
            'zip_file' => 'required|file',
        ]);

        $path = $request->file('zip_file')->store('projects');

        Project::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'zip_file_path' => $path,
        ]);

        return redirect()->route('projects.index');
    }

    public function show($slug)
    {
        $projects = Auth::user()->projects; // por causa da sidebar

        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->visibility == 'private' && $project->user_id !== Auth::id()) {
            abort(403);
        }
        return view('projects.show', compact('project', 'projects'));
    }

    public function edit($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'visibility' => 'required|in:public,private',
        ]);

        $project->title = $request->title;
        $project->description = $request->description;
        $project->visibility = $request->visibility;

        if ($request->hasFile('zip_file')) {
            $path = $request->file('zip_file')->store('projects');
            $project->zip_file_path = $path;
        }

        $project->slug = \Str::slug($project->title); // atualizar o slug
        $project->save();

        return redirect()->route('projects.show', $project->slug);
    }

    public function destroy($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projeto apagado com sucesso.');
    }



}
