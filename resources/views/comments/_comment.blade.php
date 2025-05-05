{{-- _comment.blade.php --}}
<div class="comment" style="margin-left: {{ $level * 20 }}px; margin-bottom: 1rem;">
    <div class="comment-header">
        <div class="user-avatar small">{{ substr($comment->user->name, 0, 1) }}</div>
        <div class="comment-meta">
            <span class="comment-author">{{ $comment->user->name }}</span>
            <span class="comment-time">
                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
            </span>
        </div>
    </div>
    
    <div class="comment-body">
        <p class="comment-content">{{ $comment->content }}</p>
        
        <div class="comment-actions">
            @if ($comment->user_id === Auth::id())
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="comment-action-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-btn delete-btn">Apagar</button>
                </form>
            @endif
            <button class="text-btn reply-btn" onclick="toggleReplyForm({{ $comment->id }})">Responder</button>
        </div>
        
        {{-- Formulário de resposta --}}
        <div id="reply-form-{{ $comment->id }}" class="reply-form" style="display: none;">
            <form action="{{ route('comments.store', $comment->post_id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" required placeholder="Escreva sua resposta..."></textarea>
                <div class="form-actions">
                    <button type="submit" class="btn primary">Enviar</button>
                    <button type="button" class="btn secondary" onclick="toggleReplyForm({{ $comment->id }})">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Comentários filhos --}}
    <div class="replies">
        @foreach ($comment->children as $child)
            @include('comments._comment', ['comment' => $child, 'level' => $level + 1])
        @endforeach
    </div>
</div>

<style>
    /* Estilos para comentários */
    .comment {
        border-left: 2px solid #e5e7eb;
        padding-left: 1rem;
        margin-top: 1rem;
    }
    
    .comment-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .comment-meta {
        display: flex;
        flex-direction: column;
    }
    
    .user-avatar.small {
        width: 1.75rem;
        height: 1.75rem;
        font-size: 0.9rem;
        background-color: #dbeafe;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .comment-author {
        font-weight: 500;
        color: #1f2937;
        font-size: 0.9rem;
    }
    
    .comment-time {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .comment-content {
        margin: 0.5rem 0;
        color: #374151;
        line-height: 1.5;
        font-size: 0.95rem;
    }
    
    .comment-actions {
        display: flex;
        gap: 1rem;
        margin: 0.75rem 0;
    }
    
    .text-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        padding: 0;
        color: #4b5563;
    }
    
    .delete-btn {
        color: #ef4444;
    }
    
    .reply-btn {
        color: #3b82f6;
    }
    
    .reply-form {
        margin: 1rem 0;
    }
    
    .reply-form textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        min-height: 80px;
        resize: vertical;
        font-family: inherit;
    }
    
    .form-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
    }
    
    .primary {
        background-color: #3b82f6;
        color: white;
    }
    
    .secondary {
        background-color: #e5e7eb;
        color: #4b5563;
    }
    
    .replies {
        margin-top: 1rem;
    }
</style>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>