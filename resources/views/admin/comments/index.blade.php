@extends('layouts.admin')

@section('title', 'Gestão de Comentários')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestão de Comentários</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-newspaper"></i> Ver Posts
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Dashboard
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if($comments->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Nenhum comentário encontrado</h4>
                            <p class="text-muted">Ainda não existem comentários no sistema.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Autor</th>
                                        <th>Post</th>
                                        <th>Conteúdo</th>
                                        <th>Tipo</th>
                                        <th>Data</th>
                                        <th width="120">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td>
                                                <span class="badge badge-secondary">#{{ $comment->id }}</span>
                                            </td>
                                            <td>
                                                <div class="user-info">
                                                    <strong class="text-primary">{{ $comment->user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $comment->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="post-info">
                                                    <small class="text-muted">Post por {{ $comment->post->user->name }}</small>
                                                    <br>
                                                    <div class="post-excerpt">
                                                        {{ Str::limit($comment->post->content, 50) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="comment-content" style="max-width: 300px;">
                                                    <div class="content-preview">
                                                        {{ Str::limit($comment->content, 100) }}
                                                    </div>
                                                    @if(strlen($comment->content) > 100)
                                                        <button type="button" class="btn btn-link btn-sm p-0" 
                                                                onclick="toggleFullContent({{ $comment->id }})">
                                                            <small>Ver mais...</small>
                                                        </button>
                                                        <div id="full-content-{{ $comment->id }}" class="full-content" style="display: none;">
                                                            {!! nl2br(e($comment->content)) !!}
                                                            <button type="button" class="btn btn-link btn-sm p-0" 
                                                                    onclick="toggleFullContent({{ $comment->id }})">
                                                                <small>Ver menos</small>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($comment->parent_id)
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-reply"></i> Resposta
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">
                                                        Para #{{ $comment->parent_id }}
                                                    </small>
                                                @else
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-comment"></i> Principal
                                                    </span>
                                                @endif
                                                
                                                @if($comment->children->count() > 0)
                                                    <br>
                                                    <small class="text-success">
                                                        <i class="fas fa-reply"></i> 
                                                        {{ $comment->children->count() }} resposta(s)
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <strong>{{ $comment->created_at->format('d/m/Y') }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $comment->created_at->format('H:i') }}</small>
                                                    @if($comment->created_at != $comment->updated_at)
                                                        <br>
                                                        <small class="text-warning">
                                                            <i class="fas fa-edit"></i> Editado
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group-vertical btn-group-sm">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete('comment', {{ $comment->id }}, '{{ route('admin.comments.destroy', $comment) }}')"
                                                            title="Eliminar comentário">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginação -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $comments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalhes do Comentário -->
<div class="modal fade" id="commentDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Comentário</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="commentDetailsContent">
                <!-- Conteúdo será carregado via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Eliminação -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminação</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="deleteMessage">Tem a certeza que deseja eliminar este comentário?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Atenção:</strong> Se este comentário tiver respostas, elas também serão eliminadas!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-info, .post-info, .date-info {
    font-size: 0.9em;
}

.post-excerpt {
    font-style: italic;
    color: #6c757d;
    font-size: 0.85em;
}

.comment-content {
    font-size: 0.9em;
}

.content-preview {
    margin-bottom: 5px;
}

.full-content {
    margin-top: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.table td {
    vertical-align: middle;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
}

.badge {
    font-size: 0.75em;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85em;
    }
    
    .btn-group-vertical .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(type, id, url) {
    const message = 'Tem a certeza que deseja eliminar este comentário? Se tiver respostas, elas também serão eliminadas.';
    
    $('#deleteMessage').text(message);
    $('#deleteForm').attr('action', url);
    $('#deleteModal').modal('show');
}

function toggleFullContent(commentId) {
    const preview = $(`#full-content-${commentId}`).siblings('.content-preview');
    const fullContent = $(`#full-content-${commentId}`);
    
    if (fullContent.is(':visible')) {
        fullContent.hide();
        preview.show();
    } else {
        preview.hide();
        fullContent.show();
    }
}

function viewCommentDetails(commentId) {
    // Simulação de carregamento de detalhes via AJAX
    // Em uma implementação real, você faria uma requisição AJAX aqui
    $('#commentDetailsContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <p class="mt-2">Carregando detalhes do comentário...</p>
        </div>
    `);
    
    $('#commentDetailsModal').modal('show');
    
    // Simular carregamento
    setTimeout(() => {
        // Encontrar os dados do comentário na tabela
        const row = $(`button[onclick="viewCommentDetails(${commentId})"]`).closest('tr');
        const author = row.find('.user-info strong').text();
        const authorEmail = row.find('.user-info small').text();
        const content = row.find('.comment-content').text();
        const date = row.find('.date-info strong').text() + ' ' + row.find('.date-info small').first().text();
        const type = row.find('.badge').first().text().trim();
        
        $('#commentDetailsContent').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-user"></i> Autor</h6>
                    <p><strong>${author}</strong><br><small class="text-muted">${authorEmail}</small></p>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-calendar"></i> Data</h6>
                    <p>${date}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-tag"></i> Tipo</h6>
                    <p>${type}</p>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-hashtag"></i> ID</h6>
                    <p>#${commentId}</p>
                </div>
            </div>
            <hr>
            <h6><i class="fas fa-comment"></i> Conteúdo</h6>
            <div class="p-3 bg-light rounded">
                ${content.replace(/\n/g, '<br>')}
            </div>
        `);
    }, 1000);
}

$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Tooltip initialization
    $('[title]').tooltip();
    
    // Table row hover effect
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});
</script>
@endpush btn-info btn-sm"
                                                            onclick="viewCommentDetails({{ $comment->id }})"
                                                            title="Ver detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn