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
    <h1>Editar Archivo</h1>
    <form action="{{ route('files.update', $file->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="upload">Selecciona un nuevo archivo:</label>
        <input type="file" name="upload" id="upload" accept=".jpg, .jpeg, .png">

        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="{{ route('files.show', $file->id) }}">Volver a la Vista Detallada</a>
</div>
