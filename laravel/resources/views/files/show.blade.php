{{ $file->name }}
<img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" />

<!-- Enlace para editar (edit) -->
<a href="{{ route('files.edit', $file->id) }}" class="btn btn-primary">Edit</a>

<!-- Formulario para eliminar (destroy) -->
<form method="POST" action="{{ route('files.destroy', $file->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
