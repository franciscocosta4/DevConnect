<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administração</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard de Administração</h1>
            <p>Bem-vindo ao painel de controlo administrativo</p>
        </div>

        <div class="card-grid">
            <div class="card blue">
                <p class="card-title">Total de Utilizadores</p>
                <p class="card-value">{{ $stats['users'] }}</p>
            </div>
            <div class="card green">
                <p class="card-title">Total de Projetos</p>
                <p class="card-value">{{ $stats['projects'] }}</p>
            </div>
            <div class="card yellow">
                <p class="card-title">Total de Posts</p>
                <p class="card-value">{{ $stats['posts'] }}</p>
            </div>
            <div class="card purple">
                <p class="card-title">Total de Comentários</p>
                <p class="card-value">{{ $stats['comments'] }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h3>Projetos Recentes</h3>
            </div>
            <div class="section-body">
                @if($recentProjects->count() > 0)
                    @foreach($recentProjects as $project)
                        <div class="item">
                            <div>
                                <h4>{{ $project->title }}</h4>
                                <p>Por: {{ $project->user->name }}</p>
                                <p>{{ $project->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="button-link">Editar</a>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('admin.projects') }}" class="button-link">Ver todos os projetos →</a>
                    </div>
                @else
                    <p>Nenhum projeto encontrado.</p>
                @endif
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h3>Posts Recentes</h3>
            </div>
            <div class="section-body">
                @if($recentPosts->count() > 0)
                    @foreach($recentPosts as $post)
                        <div class="item">
                            <div>
                                <p>{{ Str::limit($post->content, 60) }}</p>
                                <p>Por: {{ $post->user->name }}</p>
                                <p>{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="button-link">Editar</a>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('admin.posts') }}" class="button-link">Ver todos os posts →</a>
                    </div>
                @else
                    <p>Nenhum post encontrado.</p>
                @endif
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h3>Utilizadores Recentes</h3>
            </div>
            <div class="section-body">
                @if($recentUsers->count() > 0)
                    @foreach($recentUsers as $user)
                        <div class="item" style="justify-content:left; margin-left: 10px;">
                            <div class="avatar-container">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar" alt="{{ $user->name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        <span>{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div style="justify-content:left; margin-left: 14px;">
                                <p> <small>nome pessoal:</small> {{ $user->name }}</p>
                                <p><small>nome de utilizador:</small> {{ $user->username }}</p>
                                <p><small>registado a :</small> {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('admin.users') }}" class="button-link">Ver todos os utilizadores →</a>
                    </div>
                @else 
                    <p>Nenhum utilizador encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>

<style>
    body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9fafb;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
}

.header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.5rem;
}

.header p {
    color: #4b5563;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
}

.card.blue { border-color: #3b82f6; }
.card.green { border-color: #10b981; }
.card.yellow { border-color: #f59e0b; }
.card.purple { border-color: #8b5cf6; }

.card-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
}

.card-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #111827;
}

.section {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.section-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.section-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
}

.section-body {
    padding: 1.5rem;
}

.item {
    background-color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.item p {
    margin: 0.2rem 0;
}

a.button-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}

a.button-link:hover {
    color: #1e40af;
}

.avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    object-fit: cover;
}

.avatar-placeholder {
    width: 2.5rem;
    height: 2.5rem;
    background-color: #d1d5db;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4b5563;
    font-weight: 500;
}

</style>