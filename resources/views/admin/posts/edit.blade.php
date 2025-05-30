<div class="container">
  <header class="header">
    <div class="header-content">
      <div>
        <h1 class="title">Editar Post</h1>
        <p class="subtitle">Edite o conteúdo do post</p>
      </div>
      <a href="{{ route('admin.posts') }}" class="btn btn-secondary">
        ← Voltar
      </a>
    </div>
  </header>

  <div class="card">
    <div class="card-header">
      <h3>Informações do Post</h3>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="form" novalidate>
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="user_id">Autor do Post</label>
        <select name="user_id" id="user_id" class="select @error('user_id') error @enderror">
          <option value="">Selecione um usuário</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
              {{ $user->name }} ({{ $user->username }})
            </option>
          @endforeach
        </select>
        @error('user_id')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="content">Conteúdo do Post</label>
        <textarea name="content" id="content" rows="6" class="textarea @error('content') error @enderror" placeholder="Digite o conteúdo do post">{{ old('content', $post->content) }}</textarea>
        @error('content')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="info-extra">
        <h4>Informações Adicionais</h4>
        <div class="info-grid">
          <div><strong>Autor Atual:</strong> {{ $post->user->name }} ({{ $post->user->username }})</div>
          <div><strong>Criado em:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</div>
          <div><strong>Atualizado em:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}</div>
          <div><strong>Total Comentários:</strong> {{ $post->comments->count() }}</div>
          <div><strong>Total Likes:</strong> {{ $post->likedByUsers->count() }}</div>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="if(confirm('Tem certeza que deseja remover este post?')) { document.getElementById('delete-form').submit(); }" class="btn btn-danger">Remover Post</button>

        <div>
          <a href="{{ route('admin.posts') }}" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Post</button>
        </div>
      </div>
    </form>

    <form id="delete-form" action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:none;">
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