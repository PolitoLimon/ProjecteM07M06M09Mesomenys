<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Place') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            <h1>Create Place</h1>
            <form method="POST" action="{{ route('places.store') }}" enctype="multipart/form-data" class="bg-white p-4 rounded-lg shadow-md">
                @csrf
                <x-input-field label="Titulo" name="title" class="w-full p-2 border rounded-md" />
                <x-input-field label="Coordenadas" name="coordenadas" class="w-full p-2 border rounded-md" />
                <x-textarea-field label="Descripcion" name="descripcion" class="w-full p-2 border rounded-md" rows="4" />
                <x-input-field type="file" label="Imagen" name="upload" class="w-full p-2 border rounded-md" />
                <div class="flex space-x-4">
                    <x-submit-button label="Crear" class="bg-blue-500 hover:bg-blue-600" />
                    <x-reset-button label="Limpiar" class="bg-gray-300 hover:bg-gray-400" />
                    <a href="{{ route('places.index') }}">Volver</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
