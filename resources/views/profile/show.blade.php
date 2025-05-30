<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        <div class="profile-container">
            <!-- Seção de cabeçalho do perfil -->
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <p class="profile-email">{{ $user->email }}</p>
                    <p class="profile-bio-label">bio:</p>
                    <div class="profile-bio-box">
                        @if($user->bio)
                            <p class="profile-bio">{{ $user->bio }}</p>
                        @elseif($user->id === Auth::id())
                            <p>
                                Ainda não tens uma bio. <a href="{{ route('profile.edit') }}" class="btn-new">Adiciona uma
                                    aqui</a>.
                            </p>
                        @endif
                    </div>
                    <p class="profile-stats">
                        <span>{{ $projects->count() }} Projetos</span>
                        <span>{{ $posts->count() }} Posts</span>
                    </p>

                    @if($user->id === Auth::id())
                        <br>
                        <a href="{{ route('profile.edit') }}" class="btn-new">+ Editar o meu perfil</a>
                    @endif
                </div>
            </div>

            <!-- Seção de conteúdo -->
            <div class="profile-content">
                <!-- Seção de projetos -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2>Projetos Publicados</h2>
                        @if($user->id === Auth::id())
                            <a href="{{ route('projects.create') }}" class="btn-new">+ Novo Projeto</a>
                        @endif
                    </div>

                    @if ($projects->count())
                        <div class="projects-grid">
                            @foreach ($projects as $project)
                                <div class="project-card">
                                    <div class="project-header">
                                        <h3 class="project-title">
                                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                        </h3>
                                        <span class="project-visibility {{ $project->visibility }}">
                                            {{ $project->visibility == 'public' ? 'Público' : 'Privado' }}
                                        </span>
                                    </div>
                                    <p class="project-description">{{ Str::limit($project->description, 120) }}</p>
                                    <div class="project-footer">
                                        <span class="project-date">{{ $project->created_at->format('d/m/Y') }}</span>
                                        <span class="project-likes">{{ $project->likes_count }} ♥</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p>Nenhum projeto publicado ainda.</p>
                            @if($user->id === Auth::id())
                                <a href="{{ route('projects.create') }}" class="btn-new">Criar primeiro projeto</a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Seção de posts -->
                <div class="profile-section">
                    <div class="section-header">
                        <h2>Posts Recentes</h2>
                    </div>

                    @if ($posts->count())
                        <div class="posts-list">
                            @foreach ($posts as $post)
                                <div class="post-card">
                                    <p class="post-content">{{ $post->content }}</p>
                                    <div class="post-footer">
                                        <span class="post-date">{{ $post->created_at->diffForHumans() }}</span>
                                        <span class="post-likes">{{ $post->likedByUsers->count() }} ♥</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p>Nenhum post publicado ainda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <style>
            /* Estilos gerais */
            .profile-container {
                width: 1200px;
                margin: 2rem auto;
                padding: 0 1rem;
            }

            /* Cabeçalho do perfil */
            .profile-header {
                display: flex;
                align-items: center;
                gap: 2rem;
                margin-bottom: 3rem;
                padding-bottom: 2rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background-color: #1a365d;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                font-weight: bold;
                flex-shrink: 0;
            }

            .profile-info {
                flex: 1;
            }

            .profile-name {
                font-size: 2rem;
                font-weight: 700;
                color: #1a365d;
                margin: 0 0 0.5rem 0;
            }

            .profile-email {
                color: #718096;
                margin: 0 0 1rem 0;
            }

            .profile-stats {
                display: flex;
                gap: 1.5rem;
            }

            .profile-bio-label {
                color: #718096;
                font-weight: 600;
                margin-bottom: 0.5rem;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.05em;
            }

            .profile-bio-box {
                background-color: #ffffff;
                padding: 1rem 1.25rem;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                margin-top: 0.25rem;
                color: #4a5568;
                font-size: 0.95rem;
                line-height: 1.5;
            }

            .profile-bio {
                margin: 0;
            }


            .profile-stats span {
                font-weight: 500;
                color: #4a5568;
            }

            /* Seções de conteúdo */
            .profile-content {
                display: grid;
                gap: 3rem;
            }

            .profile-section {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                padding: 1.5rem;
            }

            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #f1f5f9;
            }

            .section-header h2 {
                font-size: 1.25rem;
                font-weight: 600;
                color: #1a365d;
                margin: 0;
            }

            /* Cards de projetos */
            .projects-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1.5rem;
            }

            .project-card {
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1.25rem;
                transition: all 0.2s;
            }

            .project-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }

            .project-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 0.75rem;
            }

            .project-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin: 0;
            }

            .project-title a {
                color: #1a365d;
                text-decoration: none;
            }

            .project-title a:hover {
                text-decoration: underline;
            }

            .project-visibility {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.25rem 0.5rem;
                border-radius: 1rem;
            }

            .project-visibility.public {
                background-color: #ebf8f2;
                color: #2f855a;
            }

            .project-visibility.private {
                background-color: #fff5f5;
                color: #c53030;
            }

            .project-description {
                color: #4a5568;
                font-size: 0.9rem;
                line-height: 1.5;
                margin: 0 0 1rem 0;
            }

            .project-footer {
                display: flex;
                justify-content: space-between;
                font-size: 0.8rem;
                color: #718096;
            }

            /* Lista de posts */
            .posts-list {
                display: grid;
                gap: 1rem;
            }

            /* Cards de posts */
            .post-card {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1rem 1.25rem;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
                transition: all 0.2s;
            }

            .post-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }

            .post-content {
                color: #4a5568;
                font-size: 0.95rem;
                line-height: 1.5;
                margin-bottom: 0.75rem;
            }

            .post-footer {
                display: flex;
                justify-content: space-between;
                font-size: 0.8rem;
                color: #718096;
            }

            /* Botão de novo projeto */
            .btn-new {
                display: inline-block;
                background-color: #3182ce;
                color: white;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                border-radius: 0.375rem;
                text-decoration: none;
                transition: background-color 0.2s;
            }

            .btn-new:hover {
                background-color: #2b6cb0;
            }

            /* Estado vazio */
            .empty-state {
                text-align: center;
                padding: 2rem;
                color: #718096;
                background-color: #f7fafc;
                border: 1px dashed #cbd5e0;
                border-radius: 0.5rem;
            }

            .empty-state p {
                margin-bottom: 1rem;
            }

            .empty-state a.btn-new {
                margin-top: 0.5rem;
                display: inline-block;
            }
        </style>