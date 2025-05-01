@extends('layouts.app')

@section('content')
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
                        <span class="post-time">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="post-content">{{ $post->content }}</p>
                    <div class="post-actions">
                        <button class="action-btn">
                            <svg class="action-icon" viewBox="0 0 24 24">
                                <path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            Curtir
                        </button>
                        <button class="action-btn">
                            <svg class="action-icon" viewBox="0 0 24 24">
                                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Comentar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        <!-- Post de exemplo -->
        <div class="card">
            <div class="flex items-start">
                <div class="user-avatar">T</div>
                <div class="post-content-wrapper">
                    <div class="post-header">
                        <p class="post-author">Teste User</p>
                        <span class="post-time"> 2 horas atrás</span>
                    </div>
                    <p class="post-content">Gosto de Laravel!</p>
                    <div class="post-actions">
                        <button class="action-btn">
                            <svg class="action-icon" viewBox="0 0 24 24">
                                <path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            Curtir
                        </button>
                        <button class="action-btn">
                            <svg class="action-icon" viewBox="0 0 24 24">
                                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Comentar
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
    margin-right:10px; 
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