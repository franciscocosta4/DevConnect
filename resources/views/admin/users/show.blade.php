@extends('layouts.admin')

@section('title', 'Detalhes do Utilizador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Informações do Utilizador -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($user->avatar)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ Storage::url($user->avatar) }}"
                                 alt="Avatar do utilizador"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="profile-user-img img-fluid img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">
                        @if($user->username)
                            {{ $user->username }}
                        @else
                            Utilizador
                        @endif
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Projetos</b> <a class="float-right">{{ $user->projects->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Posts</b> <a class="float-right">{{ $user->posts->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Total de Comentários</b> 
                            <a class="float-right">{{ $user->posts->sum(function($post) { return $post->comments->count(); }) }}</a>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar à Lista
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informações Pessoais</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>

                    @if($user->bio)
                        <strong><i class="fas fa-quote-left mr-1"></i> Biografia</strong>
                        <p class="text-muted">{!! nl2br(e($user->bio)) !!}</p>
                        <hr>
                    @endif

                    <strong><i class="fas fa-calendar-alt mr-1"></i> Membro desde</strong>
                    <p class="text-muted">
                        {{ $user->created_at->format('d/m/Y H:i') }}
                        <br>
                        <small>({{ $user->created_at->diffForHumans() }})</small>
                    </p>
                    <hr>

                    @if($user->cv_path)
                        <strong><i class="fas fa-file-pdf mr-1"></i> Currículo</strong>
                        <p class="text-muted">
                            <a href="{{ Storage::url($user->cv_path) }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Descarregar CV
                            </a>
                        </p>
                        <hr>
                    @endif

                    <strong><i class="fas fa-clock mr-1"></i> Última Atualização</strong>
                    <p class="text-muted">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Conteúdo do Utilizador -->
        <div class="col-md-8">
            <!-- Projetos -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-folder"></i> Projetos ({{ $user->projects->count() }})
                    </h3>
                </div>
                <div class="card-body">
                    @if($user->projects->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Este utilizador ainda não tem projetos.</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($user->projects as $project)
                                <div class="col-md-6 mb-3">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h5 class="card-title">{{ $project->title }}</h5>
                                            <div class="card-tools">
                                                <span class="badge badge-{{ $project->visibility == 'public' ? 'success' : 'warning' }}">
                                                    {{ $project->visibility == 'public' ? 'Público' : 'Privado' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if($project->description)
                                                <p class="text-muted">{{ Str::limit($project->description, 100) }}</p>
                                            @else
                                                <p class="text-muted"><em>Sem descrição</em></p>
                                            @endif
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> {{ $project->created_at->format('d/m/Y') }}
                                            </small>
                                            @if($project->zip_file_path)
                                                <br>
                                                <small class="text-success">
                                                    <i class="fas fa-file-archive"></i> Arquivo anexado
                                                </small>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Posts -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-newspaper"></i> Posts ({{ $user->posts->count() }})
                    </h3>
                </div>
                <div class="card-body">
                    @if($user->posts->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Este utilizador ainda não fez posts.</p>
                        </div>
                    @else
                        @foreach($user->posts as $post)
                            <div class="card card-outline card-secondary mb-3">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-newspaper text-primary"></i>
                                            Post #{{ $post->id }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $post->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">{!! nl2br(e(Str::limit($post->content, 200))) !!}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">
                                                <i class="fas fa-comments"></i> {{ $post->comments->count() }} comentários
                                            </small>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver Detalhes
                                            </a>
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Comentários Recentes -->
            @if($user->posts->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comments"></i> Comentários Recentes
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $recentComments = $user->posts->flatMap->comments->sortByDesc('created_at')->take(5);
                        @endphp
                        
                        @if($recentComments->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Ainda não há comentários nos posts deste utilizador.</p>
                            </div>
                        @else
                            @foreach($recentComments as $comment)
                                <div class="card card-outline card-light mb-2">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong>{{ $comment->user->name ?? 'Utilizador Anónimo' }}</strong>
                                                <small class="text-muted">comentou em "{{ Str::limit($comment->post->content, 50) }}"</small>
                                            </div>
                                            <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <p class="mb-0 text-muted">{{ Str::limit($comment->content, 150) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection