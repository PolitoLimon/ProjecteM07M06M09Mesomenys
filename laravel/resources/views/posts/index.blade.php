<div>
    <h2>Files</h2>

    <div>
        @foreach ($posts as $post)
        <div>
            <p>ID: {{ $post->id }}</p>
            <p>Filepath: {{ $post->file->filepath }}</p>
            <p>Filesize: {{ $post->file->filesize }}</p>
            <p>Created: {{ $post->created_at }}</p>
            <p>Updated: {{ $post->updated_at }}</p>
            <a href="{{ route('posts.show', $post->id) }}">Show</a>
        </div>
        @endforeach

        <hr>

        <a href="{{ route('posts.create') }}" role="button">Add Image</a>
    </div>
</div>
