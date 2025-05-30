<div class="container">
  <header class="header">
    <div class="header-content">
      <div>
        <h1 class="title">Editar Utilizador</h1>
        <p class="subtitle">Atualize os dados do utilizador</p>
      </div>
      <a href="{{ route('admin.users') }}" class="btn btn-secondary">
        ← Voltar
      </a>
    </div>
  </header>

  <div class="card">
    <div class="card-header">
      <h3>Informações do Utilizador</h3>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="form">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="input @error('name') error @enderror" />
        @error('name')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="username">Nome de Utilizador</label>
        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="input @error('username') error @enderror" />
        @error('username')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="input @error('email') error @enderror" />
        @error('email')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="bio">Biografia</label>
        <textarea name="bio" id="bio" rows="4" class="textarea @error('bio') error @enderror">{{ old('bio', $user->bio) }}</textarea>
        @error('bio')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      @if($user->cv_path)
        <div class="form-group">
          <label>CV Atual</label>
          <div class="file-current">
            <span>{{ basename($user->cv_path) }}</span>
            <a href="{{ asset('storage/' . $user->cv_path) }}" download class="file-download">Download</a>
          </div>
        </div>
      @endif

      <div class="form-group">
        <label for="cv_path">{{ $user->cv_path ? 'Substituir CV' : 'CV' }}</label>
        <input type="file" name="cv_path" id="cv_path" accept=".pdf" class="file-input @error('cv_path') error @enderror" />
        <p class="file-info">Tamanho máximo: 2MB. Formato aceito: PDF</p>
        @error('cv_path')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      @if($user->avatar)
        <div class="form-group">
          <label>Avatar Atual</label>
          <div class="file-current">
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar atual" style="height: 48px; border-radius: 50%;">
          </div>
        </div>
      @endif

      <div class="form-group">
        <label for="avatar">{{ $user->avatar ? 'Substituir Avatar' : 'Avatar' }}</label>
        <input type="file" name="avatar" id="avatar" accept="image/*" class="file-input @error('avatar') error @enderror" />
        <p class="file-info">Tamanho máximo: 2MB. Formato: imagem</p>
        @error('avatar')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>

      <div class="info-extra">
        <h4>Informações Adicionais</h4>
        <div class="info-grid">
          <div><strong>Registado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
          <div><strong>Última atualização:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</div>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="if(confirm('Tem a certeza que deseja remover este utilizador?')) { document.getElementById('delete-form').submit(); }" class="btn btn-danger">Remover Utilizador</button>

        <div>
          <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary">Atualizar Utilizador</button>
        </div>
      </div>
    </form>

    <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:none;">
      @csrf
      @method('DELETE')
    </form>
  </div>
</div>

<style>
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

.file-current img {
  max-height: 48px;
  border-radius: 50%;
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
