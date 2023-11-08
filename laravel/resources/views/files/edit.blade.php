<form method="POST" action="{{ route('files.update', $file->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="upload">File:</label>
        <input type="file" class="form-control" name="upload" accept="image/*">
    </div>
    <!-- Otros campos del formulario para editar -->
    <button type="submit" class="btn btn-primary">Update</button>
</form>