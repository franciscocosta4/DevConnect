<div class="container">
  <header class="header">
    <div class="header-content">
      <div>
        <h1 class="title">Editar Projeto</h1>
        <p class="subtitle">Edite as informações do projeto</p>
      </div>
      <a href="{{ route('admin.projects') }}" class="btn btn-secondary">
        ← Voltar
      </a>
    </div>
  </header>

  <div class="card">
    <div class="card-header">
      <h3>Informações do Projeto</h3>
    </div>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="form">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="user_id">Usuário Proprietário</label>
        <select name="user_id" id="user_id" class="select @error('user_id') error @enderror">
          <option value="">Selecione um usuário</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $project->user_id) == $user->id ? 'selected' : '' }}>
              {{ $user->name }} ({{ $user->username }})
            </option>
          @endforeach
        </select>
        @error('user_id')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="title">Título do Projeto</label>
        <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" placeholder="Digite o título do projeto" class="input @error('title') error @enderror" />
        @error('title')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="description">Descrição</label>
        <textarea name="description" id="description" rows="4" placeholder="Digite a descrição do projeto" class="textarea @error('description') error @enderror">{{ old('description', $project->description) }}</textarea>
        @error('description')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="visibility">Visibilidade</label>
        <select name="visibility" id="visibility" class="select @error('visibility') error @enderror">
          <option value="public" {{ old('visibility', $project->visibility) == 'public' ? 'selected' : '' }}>Público</option>
          <option value="private" {{ old('visibility', $project->visibility) == 'private' ? 'selected' : '' }}>Privado</option>
        </select>
        @error('visibility')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      @if($project->zip_file_path)
      <div class="form-group">
        <label>Arquivo ZIP Atual</label>
        <div class="file-current">
          <span>{{ basename($project->zip_file_path) }}</span>
          <a href="{{ asset('storage/' . $project->zip_file_path) }}" download class="file-download">Download</a>
        </div>
      </div>
      @endif

      <div class="form-group">
        <label for="zip_file">{{ $project->zip_file_path ? 'Substituir Arquivo ZIP' : 'Arquivo ZIP' }}</label>
        <input type="file" name="zip_file" id="zip_file" accept=".zip" class="file-input @error('zip_file') error @enderror" />
        <p class="file-info">Tamanho máximo: 10MB. Formato aceito: .zip</p>
        @error('zip_file')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="info-extra">
        <h4>Informações Adicionais</h4>
        <div class="info-grid">
          <div><strong>Slug:</strong> {{ $project->slug }}</div>
          <div><strong>Criado em:</strong> {{ $project->created_at->format('d/m/Y H:i') }}</div>
          <div><strong>Atualizado em:</strong> {{ $project->updated_at->format('d/m/Y H:i') }}</div>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="if(confirm('Tem certeza que deseja remover este projeto?')) { document.getElementById('delete-form').submit(); }" class="btn btn-danger">Remover Projeto</button>

        <div>
          <a href="{{ route('admin.projects') }}" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Projeto</button>
        </div>
      </div>
    </form>

    <form id="delete-form" action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display:none;">
      @csrf
      @method('DELETE')
    </form>
  </div>
</div>
<style>
    /* Reset simples */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
}

.container {
  max-width: 1024px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.title {
  font-size: 2rem;
  font-weight: 700;
  color: #111827;
}

.subtitle {
  color: #4B5563;
  font-size: 1rem;
}

.btn {
  font-weight: 600;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
  color: white;
  user-select: none;
  text-align: center;
}

.btn-primary {
  background-color: #2563EB;
}

.btn-primary:hover {
  background-color: #1D4ED8;
}

.btn-secondary {
  background-color: #6B7280;
}

.btn-secondary:hover {
  background-color: #4B5563;
}

.btn-danger {
  background-color: #DC2626;
}

.btn-danger:hover {
  background-color: #B91C1C;
}

.card {
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px rgb(0 0 0 / 0.1);
  padding-bottom: 2rem;
}

.card-header {
  border-bottom: 1px solid #E5E7EB;
  padding: 1.5rem 2rem 1rem 2rem;
}

.card-header h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
}

.form {
  padding: 1.5rem 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.input,
.textarea,
.select,
.file-input {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 1px solid #D1D5DB;
  border-radius: 0.375rem;
  font-size: 1rem;
  color: #111827;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.input:focus,
.textarea:focus,
.select:focus,
.file-input:focus {
  border-color: #3B82F6;
  box-shadow: 0 0 0 2px #3B82F6;
  outline: none;
}

.textarea {
  resize: vertical;
  min-height: 100px;
}

.error {
  border-color: #EF4444 !important;
}

.error-message {
  color: #DC2626;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

.file-info {
  font-size: 0.875rem;
  color: #6B7280;
  margin-top: 0.25rem;
}

.file-current {
  display: flex;
  align-items: center;
  background-color: #F9FAFB;
  padding: 0.75rem;
  border-radius: 0.5rem;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: #4B5563;
}

.file-download {
  margin-left: auto;
  font-weight: 600;
  color: #2563EB;
  text-decoration: none;
  cursor: pointer;
}

.file-download:hover {
  color: #1E40AF;
}

.info-extra {
  background-color: #F9FAFB;
  border-radius: 0.5rem;
  padding: 1rem 1.5rem;
  margin-bottom: 1.5rem;
}

.info-extra h4 {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.75rem;
  font-size: 1rem;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  font-size: 0.875rem;
  color: #4B5563;
}

.form-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1.5rem;
  border-top: 1px solid #E5E7EB;
}

.form-actions > div {
  display: flex;
  gap: 1rem;
}

</style>