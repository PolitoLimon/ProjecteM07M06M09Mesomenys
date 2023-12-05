@extends('layouts.box-app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
@endsection

@section('box-content')
    <div class="flex flex-col items-center justify-center">
        <!-- Nombre del Lugar -->
        <h2 class="text-2xl font-bold my-4">
            {{ $place->name }}
        </h2>

        <!-- Imagen -->
        <img class="w-full md:w-1/2" src="{{ asset('storage/'.$file->filepath) }}" title="{{ $place->name }}" />

        <!-- Descripción -->
        <div class="my-4 p-4">
            <p class="text-lg">
                {{ $place->description }}
            </p>
        </div>

        <!-- Botones -->
        <div class="flex space-x-4 my-4">
            <x-primary-button href="{{ route('places.edit', $place) }}">
                {{ __('Edit') }}
            </x-primary-button>
            <x-danger-button href="{{ route('places.delete', $place) }}">
                {{ __('Delete') }}
            </x-danger-button>
            <x-secondary-button href="{{ route('places.index') }}">
                {{ __('Back to list') }}
            </x-secondary-button>
        </div>

        <!-- Añadir a Favoritos -->
        @php
            $isFavorited = $place->favorited->contains('id', auth()->id());
        @endphp
        <form action="{{ route('places.favorite', ['place' => $place->id]) }}" method="POST" class="mb-5">
            @csrf
            <button class="text-3xl bg-transparent border-none hover:text-yellow-500 focus:outline-none">
                {{ $isFavorited ? '⭐️' : '✩' }}
            </button>
        </form>
    </div>
@endsection