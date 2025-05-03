@extends('layouts.app')

@section('content')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0&icon_names=favorite" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=favorite" />
    <div class="feed-container">
        <div class="feed-wrapper">
            <h2 class="feed-title">Feed</h2>

            <!-- Formulário de postagem -->
            <div class="card">
                <form class="post-form" action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="content" required placeholder="O que você está pensando?"></textarea>
                    <button type="submit" class="submit-btn">Postar</button>
                </form>
            </div>
            @if (!empty($posts))
                @foreach ($posts as $post)
                    <div class="card">
                        <div class="flex items-start">
                            <div class="user-avatar">T</div>
                            <div class="post-content-wrapper">
                                <div class="post-header">
                                    <p class="post-author">{{ $post->user->name }}</p>
                                    @if ($post->created_at)
                                        <span class="post-time">
                                            {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="post-time">
                                            Data não disponível
                                        </span>
                                    @endif
                                </div>
                                <p class="post-content">{{ $post->content }}</p>
                                <div class="post-actions">
                                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form">
                                        @csrf
                                        <button type="submit" class="like-btn">
                                            @if($post->isLikedBy(Auth::user()))
                                                <img src="{{ asset('images/favorite_FILL.png') }}" alt="Descurtir" class="like-icon"
                                                    title="Remover like">
                                            @else
                                                <img src="{{ asset('images/favorite.png') }}" alt="Curtir" class="like-icon"
                                                    title="Dar like">
                                            @endif
                                        </button>
                                        <span class="like-count">{{ $post->likedByUsers->count() }}</span>
                                    </form>
                                    <form action="">
                                        <button class="action-btn">
                                            Comentar
                                        </button>

                                    </form>
                                    @if (Auth::id() === $post->user_id)
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="action-btn" type="submit"
                                                onclick="return confirm('Apagar este post?')">excluir post </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
<style>
    /* Estilos base */
    .feed-container {
        padding: 3rem 0;
        max-width: 56rem;
        margin: 0 8%;
    }

    .feed-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    /* Card styles */
    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        width: 100%;
    }

    /* Form styles */
    .post-form textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .post-form textarea:focus {
        outline: none;
        border-color: #1a365d;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .submit-btn {
        background-color: #1a365d;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #2563eb;
    }

    /* Post styles */
    .post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .post-author {
        font-weight: 500;
        color: #111827;
        margin-right: 10px;
    }

    .post-time {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .post-content {
        color: #374151;
        margin: 0.5rem 0 1rem;
    }

    .post-actions {
        display: flex;
        flex-direction: row;
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        color: #6b7280;
        background: none;
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        color: #3b82f6;
    }

    .like-form {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .like-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
    }

    .like-icon {
        width: 24px;
        height: 24px;
        transition: all 0.2s;
        object-fit: contain;
    }

    .like-btn:hover .like-icon {
        transform: scale(1.1);
        opacity: 0.8;
    }

    .like-count {
        font-size: 0.9rem;
        color: #4a5568;
        min-width: 1.5rem;
        text-align: center;
        font-family: 'Figtree', sans-serif;
    }

    .like-btn:active .like-icon {
        animation: bounce 0.3s;
    }

    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
        }
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
        margin-right: 1rem;
    }
</style>