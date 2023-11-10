@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
       </ul>
    </div>
@endif

<div>
    <h1>Detalles del Archivo</h1>
    <div>
        <strong>Tamaño del Archivo:</strong> {{ $post->filesize }} bytes
    </div>
    <div>
        <strong>Fecha de Subida:</strong> {{ $post->created_at }}
    </div>
    <hr>

    <img src="{{ asset('storage/' . $post->file->filepath) }}" alt="Image" class="w-50 h-50 mb-4">

    <hr>

    <a href="{{ route('posts.edit', $post->id) }}">Editar</a>

    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>

    <a href="{{ route('posts.index') }}">Volver al Listado</a>
</div>
