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
    <h2>Dashboard</h2>

    <div>
        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
            @csrf
            <label for="upload">File:</label>
            <input type="file" name="upload"/>

            <button type="submit">Create</button>
            <button type="reset">Reset</button>
            <a href="{{ route('files.index') }}">Go Back</a>
        </form>
    </div>
</div>
