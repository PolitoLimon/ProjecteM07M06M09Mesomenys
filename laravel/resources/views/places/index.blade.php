<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Places') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8 h-full">
        <a href="{{ route('places.create') }}" class="mb-4 inline-block">Añadir imagen</a>
        <form action="{{ route('search') }}" method="GET" class="mb-4">
            <x-input label="Buscar" name="search" class="w-full p-2 border rounded-md" />
            <x-button type="submit" label="Buscar" />
        </form>
        <div class="h-full">
            <div class="p-6 bg-white border-b border-gray-200 h-full">
                @forelse ($places as $place)
                    <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-md">
                        <div class="mb-4">
                            <span>{{ $place->user->name ?? 'Usuario Desconocido' }}</span>
                        </div>
                        <h1 class="text-2xl mb-2">{{ $place->title }}</h1>
                        <p>{{ $place->description }}</p>
                        <a href="{{ route('places.show', $place->id) }}">
                            <img src="{{ asset('storage/' . $place->file->filepath) }}" alt="Imagen" class="mt-4 w-full rounded-lg shadow-md">
                        </a>
                    </div>
                @empty
                    <p>No se encontraron lugares.</p>
                @endforelse
            </div>
            {{ $places->links() }}
        </div>
    </div>
</x-app-layout>

