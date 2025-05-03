<!-- filepath: /home/noelisoa/facebook/resources/views/posts/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Modifier la publication</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Contenu -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
            <textarea name="content" id="content" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('content', $post->content) }}</textarea>
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image (optionnel)</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="mt-4 rounded" alt="Image actuelle">
            @endif
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('posts.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection