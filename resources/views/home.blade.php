@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="flex min-h-screen bg-gray-100">

  <!-- Sidebar gauche (menu principal) -->
  <aside class="hidden md:flex flex-col w-72 p-4 space-y-2 text-sm text-gray-800 sticky top-0 h-screen overflow-y-auto bg-white">
    <div class="flex items-center space-x-3 hover:bg-gray-200 rounded-lg p-3 cursor-pointer" onclick="window.location.href='{{ route('profile') }}'">
      <img src="{{ $authUser->profile_photo ? asset('storage/' . $authUser->profile_photo) : asset('images/user.png') }}" class="w-8 h-8 rounded-full" alt="Profil">
      <span class="font-semibold">{{$authUser->name}}</span>
    </div>
    <div class="flex items-center space-x-3 hover:bg-gray-200 rounded-lg p-3 cursor-pointer" onclick="window.location.href='{{ route('friends.index') }}'">
      <img src="{{asset('images/friends.png')}}" class="w-9 h-9" alt="Amis">
      <span>Amis</span>
    </div>
    <div class="flex items-center space-x-3 hover:bg-gray-200 rounded-lg p-3 cursor-pointer" onclick="window.location.href='{{ route('groups.index') }}'">
      <img src="{{asset('images/groupes.png')}}" class="w-9 h-9" alt="Groupes">
      <span>Groupes</span>
    </div>
  </aside>

  <!-- Fil d’actualité -->
  <main class="flex-1 max-w-3xl mx-auto p-4 space-y-4">
    
    <!-- Zone de création de post -->
    <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center space-x-4">
        <img src="{{ $authUser->profile_photo ? asset('storage/' . $authUser->profile_photo) : asset('images/user.png') }}" class="w-8 h-8 rounded-full" alt="Profil">
        <input type="text" placeholder="Quoi de neuf, {{$authUser->name}} ?" class="w-full bg-gray-100 p-2 rounded-full focus:outline-none">
      </div>
      <div class="flex justify-around text-sm text-gray-600 mt-3 border-t pt-2">
        <button class="flex items-center space-x-1 hover:text-red-500">📹 <span>Vidéo en direct</span></button>
        <button class="flex items-center space-x-1 hover:text-green-500" onclick="openModal()">📷 <span>Photo/Vidéo</span></button>
        <button class="flex items-center space-x-1 hover:text-yellow-500">😊 <span>Humeur</span></button>
      </div>
    </div>

    <!-- Exemple de publication -->
    @foreach ($posts as $post)
    <div class="bg-white rounded shadow p-4 mb-4 relative">
      <div class="flex items-start justify-between mb-2">
          <div class="flex items-center">
              <img src="{{ $post->user->profile_photo_url ?? asset('images/user.png') }}" alt="Photo de profil" class="w-10 h-10 rounded-full mr-3">
              <div>
                  <a href="{{url('profile/'. $post->user->id)}}" class="font-semibold">{{ $post->user->name }}</a>
                  <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
              </div>
          </div>
          @if (auth()->id() === $post->user_id && $authUser->id === $post->user->id)
          <div class="relative">
              <!-- Bouton ⋯ -->
              <button onclick="toggleMenu({{ $post->id }})" class="text-black font-bold text-2xl px-2">⋯</button>

              <!-- Menu déroulant -->
              <div id="menu-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">
                <button onclick="openEditModal({{ $post->id }}, '{{ $post->content }}', '{{ $post->image_url ?? '' }}', '{{ $post->video_url ?? '' }}')" class="block px-4 py-2 text-sm text-blue-500 hover:bg-gray-100">Modifier</button>
                  <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette publication ?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100">Supprimer</button>
                  </form>
              </div>
          </div>
          @endif
      </div>

      <p class="mb-2 text-gray-800">{{ $post->content }}</p>
        @if (!empty($post->image))
          <img src="{{ asset('storage/' . $post->image)}}" alt="Image du post" class="rounded w-full h-64 object-cover object-center">
        @endif
      </div>
    @endforeach
  </main>

  <!-- Sidebar droite (contacts) -->
  <aside class="hidden lg:flex flex-col w-72 p-4 space-y-3 text-sm text-gray-800 sticky top-0 h-screen overflow-y-auto bg-white">
      
  </aside>

</div>
@endsection
