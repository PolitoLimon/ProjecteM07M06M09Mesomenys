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
        <strong>Tamaño del Archivo:</strong> {{ $file->filesize }} bytes
    </div>
    <div>
        <strong>Fecha de Subida:</strong> {{ $file->created_at }}
    </div>
    <hr>

    <img src="{{ asset("storage/{$file->filepath}") }}" alt="File Image" />

    <hr>

    <a href="{{ route('files.edit', $file->id) }}">Editar</a>

    <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>

    <a href="{{ route('files.index') }}">Volver al Listado</a>
</div>
