<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Places') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('places.update', $place->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-lg shadow-md">
                @csrf
                @method('PUT')

                <x-input label="Titulo" name="title" value="{{ $place->title }}" />
                <x-input label="Coordenadas" name="coordenadas" />
                <x-textarea label="Descripcion" name="descripcion" rows="4">{{ $place->description }}</x-textarea>

                <div class="mb-4">
                    <label for="imagen" class="block text-gray-700 font-bold">Imagen actual:</label>
                    <img src="{{ asset('storage/' . $place->file->filepath) }}" alt="Image" class="w-22 mb-4">
                </div>

                <x-input type="file" label="Selecciona un nuevo archivo" name="upload" class="border rounded w-full py-2 px-3 text-gray-700" />

                <x-button type="submit" label="Guardar" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded" />
            </form>

            <a href="{{ route('places.index') }}" class="mt-4 inline-block text-gray-500 hover:text-gray-700">Volver</a>
        </div>
    </div>
</x-app-layout>