@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <!-- Cabeçalho do perfil -->
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-email">{{ $user->email }}</p>
                <p class="profile-stats">
                    <span>{{ $projects->count() }} Projetos</span>
                    <span>{{ $posts->count() }} Posts</span>
                </p>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="profile-content">
            <!-- Projetos -->
            <div class="profile-section">
                <div class="section-header">
                    <h2>Projetos Públicos</h2>
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
                        <p>Este utilizador ainda não tem projetos públicos.</p>
                    </div>
                @endif
            </div>

            <!-- Posts -->
            <div class="profile-section">
                <div class="section-header">
                    <h2>Posts</h2>
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
                        <p>Este utilizador ainda não publicou posts.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

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

        .profile-stats span {
            font-weight: 500;
            color: #4a5568;
        }

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

        .posts-list {
            display: grid;
            gap: 1rem;
        }

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
    </style>
@endsection
