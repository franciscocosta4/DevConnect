@extends('layouts.app')

@section('content')
    <div class="projects-container">
        <input type="text" id="search-bar" placeholder="Pesquisar por projetos...">
        
        <h2 class="projects-title">Todos os Projetos Públicos</h2>
        
        <ul class="projects-list">
            @foreach ($projects->where('visibility', 'public') as $project)
                <li class="project-item">
                    <a href="{{ route('projects.show', $project->slug) }}" class="project-link-page">
                        {{ $project->title }}
                    </a>
                    <p class="project-description">{{ Str::limit($project->description, 100) }}</p>
                    <div class="project-meta">
                        <span>Criado por: {{ $project->user->name }}</span>
                        <span>• {{ $project->created_at->diffForHumans() }}</span>
                    </div>
                </li>
                <br>
            @endforeach
        </ul>
    </div>
@endsection

<style>
    /* Projects Page Styles */
    .projects-container {
        max-width: 800px; /* Reduzi a largura máxima */
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .projects-title {
        font-size: 1.5rem;
        color: #1a365d;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    #search-bar {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e0;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }

    .search-bar:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }

    .projects-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 1rem; /* Espaço entre os itens */
    }

    .project-item {
        width: 100%; /* Ocupa 100% da largura disponível */
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .project-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .project-link-page {
        color: #1a365d;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 500;
        display: block; /* Faz o link ocupar toda a largura */
        margin-bottom: 0.5rem;
    }

    .project-link-page:hover {
        color: #1a4d8c;
        text-decoration: underline;
    }

    .project-description {
        color: #4a5568;
        margin: 0.5rem 0;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .project-meta {
        font-size: 0.8rem;
        color: #718096;
        margin-top: 0.75rem;
        display: flex;
        gap: 0.5rem;
    }
</style>