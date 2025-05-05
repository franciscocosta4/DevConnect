@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0&icon_names=favorite" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=favorite" />
    
    <div class="feed-container">
        <div class="feed-wrapper">
            <h2 class="feed-title">Feed</h2>

            <!-- Formulário de postagem -->
            <div class="card post-card">
                <form class="post-form" action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="content" required placeholder="O que você está pensando?"></textarea>
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">Postar</button>
                    </div>
                </form>
            </div>

            <!-- Lista de posts -->
            @if (!empty($posts))
    @foreach ($posts as $post)
        <div class="card post-card">
            <!-- Cabeçalho do post -->
            <div class="post-header">
                <div class="post-author-container">
                    <div class="user-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                    <div class="author-info">
                        <p class="post-author">{{ $post->user->name }}</p>
                        <span class="post-time">
                            {{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->diffForHumans() : 'Data não disponível' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Conteúdo do post -->
            <div class="post-content-wrapper">
                <p class="post-content">{{ $post->content }}</p>
            </div>

            <!-- Ações do post -->
            <div class="post-actions">
                <div class="action-group">
                    <form  action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form">
                        @csrf
                        <button  style="margin-top: 16px;" type="submit" class="like-btn">
                            @if($post->isLikedBy(Auth::user()))
                                <img src="{{ asset('images/favorite_FILL.png') }}" alt="Descurtir" class="like-icon" title="Remover like">
                            @else
                                <img src="{{ asset('images/favorite.png') }}" alt="Curtir" class="like-icon" title="Dar like">
                            @endif
                        </button>
                        <span style="margin-top: 16px;" class="like-count">{{ $post->likedByUsers->count() }}</span>
                    </form>
                </div>

                @auth
                <div class="action-group">
                    <button class="action-btn toggle-comment-btn" data-post-id="{{ $post->id }}">
                        Comentar
                    </button>
                </div>
                @endauth

                <div class="action-group">
                    <button class="action-btn toggle-comments-btn" data-post-id="{{ $post->id }}">
                        Comentários ({{ $post->comments->count() }})
                    </button>
                </div>

                @if (Auth::id() === $post->user_id)
                <div class="action-group">
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button style="margin-top: 16px;" class="action-btn delete-btn" type="submit" onclick="return confirm('Apagar este post?')">
                            Excluir
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Formulário de comentário (oculto por padrão) -->
            @auth
            <div class="comment-form-container" id="comment-form-{{ $post->id }}" style="display: none;">
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
                    @csrf
                    <textarea name="content" rows="3" placeholder="Escreve um comentário..." required></textarea>
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">Comentar</button>
                    </div>
                </form>
            </div>
            @endauth

            <!-- Seção de comentários (oculta por padrão) -->
            <div class="comments-section" id="comments-section-{{ $post->id }}" style="display: none;">
                @foreach ($post->comments->where('parent_id', null) as $comment)
                    @include('comments._comment', ['comment' => $comment, 'level' => 0])
                @endforeach
            </div>
        </div>
    @endforeach
@endif
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle do formulário de comentário
    document.addEventListener('click', function(e) {
        // Toggle do formulário de comentário
        if (e.target.classList.contains('toggle-comment-btn')) {
            e.preventDefault();
            const postId = e.target.getAttribute('data-post-id');
            const commentForm = document.getElementById(`comment-form-${postId}`);
            if (commentForm) {
                commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
            }
        }
        
        // Toggle da seção de comentários
        if (e.target.classList.contains('toggle-comments-btn')) {
            e.preventDefault();
            const postId = e.target.getAttribute('data-post-id');
            const commentsSection = document.getElementById(`comments-section-${postId}`);
            if (commentsSection) {
                const isHidden = commentsSection.style.display === 'none';
                commentsSection.style.display = isHidden ? 'block' : 'none';
                e.target.textContent = isHidden 
                    ? `Ocultar Comentários (${e.target.textContent.match(/\d+/)[0]})` 
                    : `Comentários (${e.target.textContent.match(/\d+/)[0]})`;
            }
        }
    });

    // Fechar todos os formulários e seções de comentários ao carregar a página
    document.querySelectorAll('.comment-form-container, .comments-section').forEach(element => {
        element.style.display = 'none';
    });
});
</script>

<style>
    /* Estilos base */
    .feed-container {
        padding: 2rem 1rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .feed-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Card styles */
    .post-card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        width: 100%;
    }

    /* Form styles */
    .post-form textarea,
    .comment-form-container textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        min-height: 100px;
        resize: vertical;
        font-family: inherit;
        font-size: 0.95rem;
    }

    .post-form textarea:focus,
    .comment-form-container textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
    }

    .submit-btn {
        background-color: #2563eb;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .submit-btn:hover {
        background-color: #1d4ed8;
    }

    /* Post header styles */
    .post-header {
        margin-bottom: 1rem;
    }

    .post-author-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .author-info {
        display: flex;
        flex-direction: column;
    }

    .post-author {
        font-weight: 600;
        color: #111827;
        margin: 0;
        font-size: 0.95rem;
    }

    .post-time {
        font-size: 0.75rem;
        color: #64748b;
    }

    /* Post content */
    .post-content-wrapper {
        margin-bottom: 1.25rem;
    }

    .post-content {
        color: #334155;
        margin: 0;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Post actions */
    .post-actions {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 0;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1rem;
    }

    .action-group {
        display: flex;
        align-items: center;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: #64748b;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 0.5rem;
        border-radius: 0.25rem;
    }

    .action-btn:hover {
        background-color: #f8fafc;
    }

    .delete-btn {
        color: #ef4444;
    }

    .toggle-comment-btn {
        color: #2563eb;
    }

    .material-symbols-outlined {
        font-size: 1.1rem;
        vertical-align: middle;
    }

    /* Like button styles */
    .like-form {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .like-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }

    .like-icon {
        width: 20px;
        height: 20px;
        transition: all 0.2s;
    }

    .like-count {
        font-size: 0.85rem;
        color: #64748b;
        min-width: 1.25rem;
    }

    /* Comments section */
    .comments-section {
        margin-top: 1rem;
    }

    .comment-form-container {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
    }

    /* User avatar */
    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Responsividade */
    @media (max-width: 640px) {
        .feed-container {
            padding: 1.5rem 0.75rem;
        }
        
        .post-card {
            padding: 1rem;
        }
        
        .post-actions {
            gap: 0.5rem;
        }
        
        .action-btn {
            font-size: 0.8rem;
            padding: 0.25rem;
        }
    }
</style>
