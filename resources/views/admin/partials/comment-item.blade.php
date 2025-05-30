@php
    $maxLevel = 3; // Máximo de níveis de aninhamento
    $levelClass = $level > 0 ? 'comment-level-' . min($level, $maxLevel) : '';
@endphp

<div class="comment-item {{ $levelClass }} mb-3 pl-3">
    <div class="comment-content">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="comment-header">
                <strong class="text-primary">
                    <i class="fas fa-user-circle"></i> {{ $comment->user->name }}
                </strong>
                <small class="text-muted ml-2">
                    <i class="fas fa-clock"></i> {{ $comment->created_at->format('d/m/Y H:i') }}
                    @if($comment->created_at != $comment->updated_at)
                        • <em>editado</em>
                    @endif
                </small>
                
                @if($comment->parent_id)
                    <small class="text-info ml-2">
                        <i class="fas fa-reply"></i> Resposta
                    </small>
                @endif
            </div>
            
            <div class="comment-actions">
                <button type="button" 
                        class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('comment', {{ $comment->id }}, '{{ route('admin.comments.destroy', $comment) }}')"
                        title="Eliminar comentário">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        
        <div class="comment-text">
            <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
        </div>
        
        @if($comment->children->isNotEmpty())
            <div class="comment-stats mt-2">
                <small class="text-muted">
                    <i class="fas fa-reply"></i> {{ $comment->children->count() }} 
                    {{ $comment->children->count() == 1 ? 'resposta' : 'respostas' }}
                </small>
            </div>
        @endif
    </div>
    
    <!-- Comentários filhos (respostas) -->
    @if($comment->children->isNotEmpty() && $level < $maxLevel)
        <div class="children-comments mt-2">
            @foreach($comment->children as $childComment)
                @include('admin.partials.comment-item', ['comment' => $childComment, 'level' => $level + 1])
            @endforeach
        </div>
    @elseif($comment->children->isNotEmpty() && $level >= $maxLevel)
        <!-- Se atingimos o nível máximo, mostramos apenas um indicador -->
        <div class="mt-2">
            <small class="text-muted">
                <i class="fas fa-ellipsis-h"></i> 
                {{ $comment->children->count() }} resposta(s) adicional(is)...
            </small>
        </div>
    @endif
</div>