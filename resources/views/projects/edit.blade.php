@extends('layouts.app')

@section('content')
<div class="project-edit-container">
    <div class="edit-header">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <a href="{{ route('projects.index') }}">Projetos</a>
            <span>/</span>
            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
            <span>/</span>
            <span>Editar</span>
        </nav>
        <h1 class="edit-title">Editar Projeto: {{ $project->title }}</h1>
    </div>

    <form class="project-edit-form" action="{{ route('projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Título</label>
            <input  type="text" id="title" name="title" style="    width: 100%;
    padding: 0.75rem;
    border: 1px solid #cbd5e0;
    border-radius: 0.5rem;
    font-size: 1rem;" class="form-input" value="{{ old('title', $project->title) }}" required>
            @error('title')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descrição</label>
            <textarea id="description" name="description" class="form-input form-textarea">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="visibility" class="form-label">Visibilidade</label>
            <select id="visibility" name="visibility" class="form-input form-select">
                <option value="public" {{ old('visibility', $project->visibility) == 'public' ? 'selected' : '' }}>Público</option>
                <option value="private" {{ old('visibility', $project->visibility) == 'private' ? 'selected' : '' }}>Privado</option>
            </select>
        </div>

        <div class="form-group">
            <label for="zip_file" class="form-label">Atualizar Ficheiro (opcional)</label>
            <div class="file-upload">
                <input type="file" id="zip_file" name="zip_file" class="form-input form-file">
                @if($project->zip_file_path)
                <div class="current-file">
                    <svg class="file-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                    </svg>
                    <span>Ficheiro atual: {{ basename($project->zip_file_path) }}</span>
                </div>
                @endif
            </div>
            @error('zip_file')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn primary-btn">
                <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar Alterações
            </button>
            <a href="{{ route('projects.show', $project->slug) }}" class="cancel-btn">
                <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

<style>
    /* Project Edit Page Styles */
.project-edit-container {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

.edit-header {
    margin-bottom: 2rem;
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

.edit-title {
    font-size: 1.75rem;
    color: #1a365d;
    margin: 0.5rem 0;
    font-weight: 700;
}

.project-edit-form {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #cbd5e0;
    border-radius: 0.5rem;
    font-size: 1rem;
}

.form-input:focus {
    outline: none;
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

.form-textarea {
    min-height: 500px;

    resize: vertical;
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.file-upload {
    margin-top: 0.5rem;
}

.current-file {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    color: #4a5568;
    font-size: 0.9rem;
}

.file-icon {
    width: 1rem;
    height: 1rem;
    color: #718096;
}

.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.primary-btn {
    background-color: #4299e1;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.primary-btn:hover {
    background-color: #3182ce;
    transform: translateY(-1px);
}

.cancel-btn {
    background-color: #e2e8f0;
    color: #4a5568;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.cancel-btn:hover {
    background-color: #cbd5e0;
    transform: translateY(-1px);
}

.action-icon {
    width: 1rem;
    height: 1rem;
}

/* Responsividade */
@media (max-width: 640px) {
    .project-edit-container {
        padding: 0 1rem;
    }
    
    .edit-title {
        font-size: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .primary-btn, .cancel-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>