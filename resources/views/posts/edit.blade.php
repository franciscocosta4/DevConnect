@extends('layouts.app')

@section('content')
    <h1>Editar Post</h1>

    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PUT')

        <label>Conteúdo</label>
        <textarea name="content" required>{{ $post->content }}</textarea>

        <button type="submit">Guardar</button>
    </form>
@endsection
