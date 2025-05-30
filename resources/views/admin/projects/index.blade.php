<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gerir Projetos</title>
    <style>
        /* Reset e base */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f9fafb;
            color: #374151;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        header .titles {
            max-width: 60%;
        }

        header h1 {
            font-size: 1.875rem;
            /* 30px */
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }

        header p {
            color: #374151;
            margin: 0;
        }

        /* Botões */
        .btn {
            display: inline-block;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
            color: white;
            cursor: pointer;
            user-select: none;
            text-align: center;
        }

        .btn-gray {
            background-color: #6b7280;
        }

        .btn-gray:hover {
            background-color: #4b5563;
        }

        .btn-blue {
            background-color: #2563eb;
        }

        .btn-blue:hover {
            background-color: #1d4ed8;
        }

        .btn+.btn {
            margin-left: 1rem;
        }

        /* Filtros */
        .filters {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }

        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filters label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #374151;

        }

        .filters input[type="text"],
        .filters select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            outline-offset: 2px;
        }

        .filters input[type="text"]:focus,
        .filters select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .filters button {
            background-color: #2563eb;
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .filters button:hover {
            background-color: #1d4ed8;
        }

        /* Tabela de projetos */
        .projects {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .projects table {
            border-collapse: collapse;
            width: 100%;
            min-width: 700px;
        }

        .projects thead {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .projects th,
        .projects td {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.875rem;
            color: #374151;
        }

        .projects th {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            vertical-align: bottom;
        }

        .projects tbody tr:hover {
            background-color: #f3f4f6;
        }

        .projects tbody td {
            font-size: 1rem;
            color: #374151;
            vertical-align: top;
        }

        .projects tbody td.text-right {
            text-align: right;
        }

        /* Status */
        .status-public {
            background-color: #d1fae5;
            color: #065f46;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-private {
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        /* Link de download */
        .download-link {
            display: flex;
            align-items: center;
            color: #2563eb;
            font-size: 0.875rem;
        }

        .download-link svg {
            margin-right: 0.25rem;
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }

        .download-link:hover {
            color: #1d4ed8;
        }

        /* Ações */
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            font-size: 0.875rem;
        }

        .actions a,
        .actions button {
            cursor: pointer;
            background: none;
            border: none;
            font-weight: 600;
            color: #2563eb;
            padding: 0;
        }

        .actions a:hover,
        .actions button:hover {
            color: #1d4ed8;
        }

        .actions button {
            color: #dc2626;
        }

        .actions button:hover {
            color: #991b1b;
        }

        /* Paginação simples */
        .pagination {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            header .titles {
                max-width: 100%;
                margin-bottom: 1rem;
            }

            .filters form {
                grid-template-columns: 1fr !important;
            }

            .btn+.btn {
                margin-left: 0;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <header>
            <div class="titles">
                <h1>Gerir Projetos</h1>
                <p>Visualize e faça a gestão de todos os projetos do sistema</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-gray">← Dashboard</a>
            </div>
        </header>

        <!-- Filtros e Pesquisa -->
        <section class="filters">
            <form method="GET" action="{{ route('admin.projects') }}">
                <div>
                    <label for="search">Pesquisar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Título ou descrição..." />
                </div>
                <div>
                    <label for="visibility">Visibilidade</label>
                    <select name="visibility" id="visibility">
                        <option value="">Todas</option>
                        <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Público</option>
                        <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privado
                        </option>
                    </select>
                </div>
                <div>
                    <label for="user">Utilizador</label>
                    <input type="text" name="user" id="user" value="{{ request('user') }}"
                        placeholder="Nome do utilizador..." />
                </div>
                <div>
                    <button type="submit">Filtrar</button>
                </div>
            </form>
        </section>

        <!-- Lista de Projetos -->
        <section class="projects">
            <table>
                <thead>
                    <tr>
                        <th>Projeto</th>
                        <th>Utilizador</th>
                        <th>Visibilidade</th>
                        <th>Arquivo</th>
                        <th>Data</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if($projects->count() > 0)
                        @foreach($projects as $project)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $project->title }}</strong><br />
                                        <small>{{ Str::limit($project->description, 60) }}</small><br />
                                        <small style="color:#9ca3af;">Slug: {{ $project->slug }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $project->user->name }}</strong><br />
                                        <small>{{ $project->user->username }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="{{ $project->visibility == 'public' ? 'status-public' : 'status-private' }}">
                                        {{ $project->visibility == 'public' ? 'Público' : 'Privado' }}
                                    </span>
                                </td>
                                <td>
                                    @if($project->zip_file_path)
                                        <a href="{{ asset('storage/' . $project->zip_file_path) }}" class="download-link" download>
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Download
                                        </a>
                                    @else
                                        <small style="color:#9ca3af;">Sem arquivo</small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $project->created_at->format('d/m/Y') }}</div>
                                    <div style="color:#6b7280; font-size:0.75rem;">{{ $project->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="actions">
                                        <a href="{{ route('admin.projects.edit', $project) }}">Editar</a>
                                        <button
                                            onclick="if(confirm('Tem certeza que deseja remover este projeto?')) { document.getElementById('delete-form-{{ $project->id }}').submit(); }">Remover</button>
                                        <form id="delete-form-{{ $project->id }}"
                                            action="{{ route('admin.projects.destroy', $project) }}" method="POST"
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
                            <td colspan="6" style="text-align:center; padding:2rem; color:#6b7280;">
                                <p>Nenhum projeto encontrado.</p>
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-blue"
                                    style="margin-top: 1rem; display:inline-block;">+ Novo Projeto</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </section>

        <!-- Paginação -->
        @if($projects->hasPages())
            <div class="pagination">
                {{ $projects->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</body>

</html>