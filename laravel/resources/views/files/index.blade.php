<div>
    <h2>Files</h2>

    <div>
        @foreach ($files as $file)
        <div>
            <p>ID: {{ $file->id }}</p>
            <p>Filepath: {{ $file->filepath }}</p>
            <p>Filesize: {{ $file->filesize }}</p>
            <p>Created: {{ $file->created_at }}</p>
            <p>Updated: {{ $file->updated_at }}</p>
            <a href="{{ route('files.show', $file->id) }}">Show</a>
        </div>
        @endforeach

        <hr>

        <a href="{{ route('files.create') }}" role="button">Add Image</a>
    </div>
</div>
