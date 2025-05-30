<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gerir Posts e Comentários</title>
    <style>
        /* Usa o mesmo CSS que me mostraste para o index dos posts */
        /* Copia o teu CSS do index dos posts aqui */
        /* Por brevidade não repito todo, mas tu copias e colas o que tens */
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <header>
            <div class="titles">
                <h1>Gerir Posts e Comentários</h1>
                <p>Visualize e faça a gestão de todos os posts e comentários do sistema</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-gray">← Dashboard</a>
            </div>
        </header>

        <!-- Lista de Posts -->
        <section class="projects" style="margin-bottom: 3rem;">
            <h2>Posts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Data</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if($posts->count() > 0)
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <strong>{{ $post->title }}</strong><br />
                                    <small>{{ Str::limit($post->content, 60) }}</small>
                                </td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    <div>{{ $post->created_at->format('d/m/Y') }}</div>
                                    <div style="color:#6b7280; font-size:0.75rem;">{{ $post->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}">Editar</a>
                                        <button id="remove-btn"
                                            onclick="if(confirm('Tem certeza que deseja remover este post?')) { document.getElementById('delete-post-{{ $post->id }}').submit(); }">Remover</button>
                                        <form id="delete-post-{{ $post->id }}"
                                            action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align:center; padding:2rem; color:#6b7280;">
                                <p>Nenhum post encontrado.</p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-blue"
                                    style="margin-top: 1rem; display:inline-block;">+ Novo Post</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if($posts->hasPages())
                <div class="pagination">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @endif
        </section>

        <!-- Lista de Comentários -->
        <section class="projects">
            <h2>Comentários</h2>
            <table>
                <thead>
                    <tr>
                        <th>Comentário</th>
                        <th>Post</th>
                        <th>Autor</th>
                        <th>Data</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if($comments->count() > 0)
                        @foreach($comments as $comment)
                            <tr>
                                <td>
                                    <small>{{ Str::limit($comment->content, 60) }}</small>
                                </td>
                                <td>
                                    <strong>{{ $comment->post->title }}</strong>
                                </td>
                                <td>{{ $comment->user->name }}</td>
                                <td>
                                    <div>{{ $comment->created_at->format('d/m/Y') }}</div>
                                    <div style="color:#6b7280; font-size:0.75rem;">{{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="actions">
                                        <button id="remove-btn" style=" text-decoration:none; font-color:red;"
                                            onclick="if(confirm('Tem certeza que deseja remover este comentário?')) { document.getElementById('delete-comment-{{ $comment->id }}').submit(); }">Remover</button>
                                        <form id="delete-comment-{{ $comment->id }}"
                                            action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                            style="display:none; ">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align:center; padding:2rem; color:#6b7280;">
                                <p>Nenhum comentário encontrado.</p>
                                <a href="" class="btn btn-blue" style="margin-top: 1rem; display:inline-block;">+ Novo
                                    Comentário</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if($comments->hasPages())
                <div class="pagination">
                    {{ $comments->appends(request()->query())->links() }}
                </div>
            @endif
        </section>
    </div>

</body>

</html>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f9fafb;
        color: #374151;
        margin: 0;
        padding: 2rem;
    }

    .container {
        max-width: 960px;
        margin: 0 auto;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .titles h1 {
        font-size: 1.75rem;
        margin: 0 0 0.25rem 0;
    }

    .titles p {
        margin: 0;
    }

    .btn {
        display: inline-block;
        font-weight: 600;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-blue {
        background-color: #2563eb;
        color: white;
    }

    .btn-blue:hover {
        background-color: #1d4ed8;
    }

    .btn-gray {
        background-color: #6b7280;
        color: white;
    }

    .btn-gray:hover {
        background-color: #4b5563;
    }

    .projects h2 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 0.375rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
    }

    thead tr {
        background-color: #f3f4f6;
        text-align: left;
        font-weight: 600;
        color: #6b7280;
    }

    th,
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .text-right {
        text-align: right;
    }

    .actions a,
    .actions button {
        margin-left: 0.5rem;
        background: none;
        border: none;
        color: #2563eb;
        cursor: pointer;
        font-size: 0.875rem;
        padding: 0;
        font-weight: 500;
    }

    .actions #remove-btn {
        color: red;
    }

    .actions #edit-btn {
        color: red;
    }

    .actions button:hover,
    .actions a:hover {
        text-decoration: underline;
        color: #1d4ed8;
    }

    .pagination {
        margin-top: 1rem;
        text-align: right;
        font-size: 0.875rem;
    }

    .pagination a {
        margin-left: 0.5rem;
        color: #2563eb;
        text-decoration: none;
    }

    .pagination a:hover {
        text-decoration: underline;
        color: #1d4ed8;
    }
</style>