@extends('layouts.app')

@section('content')
<div class="project-show-container">
    <!-- Cabeçalho com título e breadcrumb -->
    <div class="project-header">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <a href="{{ route('projects.index') }}">Projetos</a>
            <span>/</span>
            <span>{{ $project->title }}</span>
        </nav>
        <h1 class="project-title-page">{{ $project->title }}</h1>
        <div class="project-badge-page {{ $project->visibility == 'public' ? 'public' : 'private' }}">
            {{ $project->visibility == 'public' ? 'Público' : 'Privado' }}
        </div>
    </div>

    <!-- Metadados do projeto -->
    <div class="project-meta">
        <div class="meta-item">
            <svg class="meta-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            <span>Criado por: {{ $project->user->name }}</span>
        </div>
        <div class="meta-item">
            <svg class="meta-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
            <span>Atualizado em: {{ $project->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <!-- Descrição do projeto -->
    <div class="project-section">
        <h3 class="section-title">Descrição do Projeto</h3>
        <div class="project-content">
            <p class="project-description">{{ $project->description }}</p>
        </div>
    </div>

    <!-- Download -->
    @if($project->visibility == 'public' || $project->user_id == auth()->id())
    <div class="project-section">
        <h3 class="section-title">Arquivos do Projeto</h3>
        <div class="download-section">
            @if(Storage::exists($project->zip_file_path))
                <a href="{{ Storage::url($project->zip_file_path) }}" class="download-btn">
                    <svg class="download-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Download do Projeto
                    @php
                        $fileSize = Storage::size($project->zip_file_path);
                        $fileSizeMB = round($fileSize / 1024 / 1024, 2);
                    @endphp
                    <span class="file-size">(ZIP, {{ $fileSizeMB }} MB)</span>
                </a>
            @else
                <div class="file-missing">
                    <svg class="warning-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Arquivo não encontrado
                </div>
            @endif
        </div>
    </div>
@endif

    <!-- Ações do proprietário -->
    @if(auth()->id() == $project->user_id)
    <div class="project-actions">
    <button onclick="window.location='{{ route('projects.edit', $project->slug) }}'" class="action-btn edit-btn">
            <svg class="action-icon" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
            Editar Projeto
        </>
        <form method="POST" action="{{ route('projects.destroy', $project->slug) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este projeto?')">
                <svg class="action-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Excluir Projeto
            </button>
        </form>
    </div>
    @endif
</div>
@endsection

<style>
    /* Project Show Page Styles */
.project-show-container {
    max-width: 1100px;
    margin: 1.3rem 1rem;
    padding: 0px 1rem;
}

/* Header */
.project-header {
    position: relative;
    margin-bottom: 1.5rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.breadcrumb a {
    color: #4299e1;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.project-title-page {
    font-size: 2rem;
    color: #1a365d;
    margin: 0.5rem 0;
    font-weight: 700;
}

.project-badge-page {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.project-badge-page.public {
    background-color: #ebf8ff;
    color: #2b6cb0;
}

.project-badge-page.private {
    background-color: #fff5f5;
    color: #c53030;
}

/* Meta information */
.project-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2rem;
    color: #4a5568;
    font-size: 0.9rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-icon {
    width: 1rem;
    height: 1rem;
    color: #718096;
}

/* Sections */
.project-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.25rem;
    color: #2d3748;
    margin-bottom: 1rem;
    font-weight: 600;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 0.5rem;
}

.project-content {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
    line-height: 1.7;
}

.project-description {
    color: #4a5568;
    white-space: pre-line;
}

/* Download section */
.download-section {
    /* background-color: white; */
    border-radius: 0.5rem;
    /* box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); */
    padding: 1rem 1px;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background-color: #38a169;
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.download-btn:hover {
    background-color: #2f855a;
    transform: translateY(-1px);
}

.download-icon {
    width: 1.25rem;
    height: 1.25rem;
}

.file-size {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-left: 0.5rem;
}

/* Actions */
.project-actions {
    display: flex;
    gap: 1rem;
    margin: 2rem 0;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.edit-btn {
    background-color: #4299e1;
    color: white;
    
}

.edit-btn:hover {
    background-color: #3182ce;
    transform: translateY(-1px);
}

.delete-btn {
    background-color: #e53e3e;
    color: white;
    border: none;
    cursor: pointer;

}

.delete-btn:hover {
    background-color: #c53030;
    transform: translateY(-1px);
}

.action-icon {
    width: 1rem;
    height: 1rem;
}

/* Responsividade */
@media (max-width: 640px) {
    .project-show-container {
        padding: 0 1rem;
    }
    
    .project-title-page {
        font-size: 1.5rem;
    }
    
    .project-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .project-actions {
        flex-direction: column;
    }
    
    .action-btn {
        justify-content: center;
    }
}
</style>