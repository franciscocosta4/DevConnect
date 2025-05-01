<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="create-project-container">
        <h3 class="create-project-title">Criar novo projeto</h3>

        <form class="project-form" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Título</label>
                <input type="text" id="title" name="title" style="        width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.5rem;
            font-size: 1rem;
            " class="form-input @error('title') error @enderror" required>
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="description" class="form-label">Descrição</label>
                <textarea id="description" name="description" class="form-input form-textarea"></textarea>
            </div>

            <div class="form-group">
                <label for="visibility" class="form-label">Visibilidade</label>
                <select id="visibility" name="visibility" class="form-input form-select">
                    <option value="public">Público</option>
                    <option value="private">Privado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="zip_file" class="form-label">Ficheiro do Projeto</label>
                <input type="file" id="zip_file" name="zip_file" class="form-input form-file" required>
            </div>

            <button type="submit" class="submit-btn">Criar Projeto</button>
        </form>
    </div>
@endsection
<style>
    /* Create Project Page Styles */
    .create-project-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .create-project-title {
        font-size: 1.6rem;
        color: #1a365d;
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .project-form {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 2rem;
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
        min-height: 150px;
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

    .form-file {
        padding: 0.5rem;
    }

    .submit-btn {
        background-color: #4299e1;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .submit-btn:hover {
        background-color: #3182ce;
    }

    /* Adicione ao custom.css */
    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-input.error {
        border-color: #e53e3e;
    }
</style>