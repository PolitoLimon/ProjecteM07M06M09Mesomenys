@extends('layouts.box-app')

@section('box-title')
    {{ __('Post') . " " . $post->id }}
@endsection

@section('box-content')
<div class="flex flex-wrap md:flex-nowrap">
    <!-- Columna de la Imagen -->
    <div class="w-full md:w-1/2">
        <img class="w-full" src="{{ asset('storage/'.$file->filepath) }}" alt="Image preview"/>

        <!-- Botones justo debajo de la imagen -->
        <div class="my-4">
            @can('update', $post)
                <x-primary-button href="{{ route('posts.edit', $post) }}">
                    {{ __('Edit') }}
                </x-primary-button>
            @endcan
            @can('delete', $post)
                <x-danger-button href="{{ route('posts.delete', $post) }}">
                    {{ __('Delete') }}
                </x-danger-button>
            @endcan
            <x-secondary-button href="{{ route('posts.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>

            <!-- Botón de Likes -->
            <form method="POST" action="{{ $liked ? route('posts.unlike', $post) : route('posts.like', $post) }}" class="inline-block">
                @csrf
                @if($liked)
                    @method('DELETE')
                @endif
                <x-primary-button type="submit">
                    {{ $liked ? 'Unlike' : 'Like' }}
                </x-primary-button>
            </form>
        </div>
    </div>

    <!-- Columna de Contenido -->
    <div class="w-full md:w-1/2 md:pl-4">
        <!-- Título y descripción -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold">{{ $post->title }}</h2>
            <p class="text-lg">{{ $post->body }}</p>
        </div>

        <!-- Likes -->
        <div class="mb-4">
            <strong>Likes: </strong>{{ $post->likes_count }}
        </div>
    </div>
</div>
@endsection