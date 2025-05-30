<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class SearchController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    $query = Project::query()->where('visibility', 'public');

    if ($search) {
        $query->where('title', 'like', '%' . $search . '%');
    }

    $projects = $query->get();

    return view('projects.index', compact('projects', 'search'));
}

}
