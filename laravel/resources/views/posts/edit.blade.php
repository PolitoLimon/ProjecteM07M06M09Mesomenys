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
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="title">
        <input type="text" name="description">
        <label for="upload">Selecciona un nuevo archivo:</label>
        <input type="file" name="upload" id="upload" accept=".jpg, .jpeg, .png">

        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="{{ route('posts.show', $post->id) }}">Volver a la Vista Detallada</a>
</div>
