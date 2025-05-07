@extends('layouts.app')  {{-- On dit ici qu’on utilise le layout "app.blade.php" --}}

@section('title', 'Profil de l’utilisateur')
@section('content') 
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Cover photo -->
    <div class="relative w-full h-64 bg-cover bg-center" style="background-image: url('{{ $user->cover_photo ? Storage::url($user->cover_photo) : asset('images/default-cover.jpg') }}');">
      <!-- Profile picture -->
      <div class="absolute bottom-0 left-6 transform translate-y-1/2">
      @if(isset($user) && !empty($user->profile_photo))
        <img class="w-40 h-40 rounded-full border-4 border-white object-cover shadow-lg" src="{{ Storage::url($user->profile_photo) }}" alt="Profil">
      @else
        <img class="w-40 h-40 rounded-full border-4 border-white object-cover shadow-lg" src="{{ asset('images/user.png') }}">
      @endif

      @if ($authUser->id === $user->id)
        <div class="absolute bottom-0 right-0 bg-white text-black p-2 rounded-full cursor-pointer hover:bg-gray-200 shadow">
        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="relative">
          @csrf
          @method('PUT')
          <label for="profile-photo-upload" class="flex items-center justify-center">
            <img src="{{ asset('images/camera.png') }}" alt="Upload Icon" class="w-6 h-6">
          </label>
          <input type="file" id="profile-photo-upload" name="profile_photo" class="hidden" onchange="this.form.submit()">
        </form>
        </div>
      @endif
      </div>

      <!-- Upload cover photo button -->
      @if ($authUser->id === $user->id)
      <form action="{{ route('profile.cover.update') }}" method="POST" enctype="multipart/form-data" class="absolute top-4 right-4">
        @csrf
        @method('PUT')

        <label for="cover-photo-upload" class="bg-gray-800 text-white px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
          Modifier la couverture
        </label>
        <input type="file" id="cover-photo-upload" name="cover_photo" class="hidden" onchange="this.form.submit()">
      </form>
      @endif
    </div>
    
    <!-- Info utilisateur -->
    <div class="bg-white pt-20 px-6 pb-4 shadow">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between">
      <div>
        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
        <a href="#friends" class="text-gray-600" >{{$friends->count()}} ami(s)</a>
      </div>
      <div class="mt-4 md:mt-0 flex space-x-2">
        @if (Auth::check() && $authUser->id !== $user->id)
        @if ($friendshipStatus === 'none')
        <form action="{{ route('friends.request', $user->id) }}" method="POST">
          @csrf
          <button type="submit"
            class="flex items-center bg-blue-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-blue-600 transition">
            <img src="{{ asset('images/add.png') }}" alt="Ajouter" class="w-5 h-5 mr-2">
            Ajouter ami
          </button>
        </form>
        @elseif ($friendshipStatus === 'pending')
        <form action="{{ route('friends.cancel', $user->id) }}" method="GET">
          @csrf
          <button type="submit" 
          class="flex items-center bg-blue-500 text-white font-semibold py-2 px-4 rounded-full shadow hover:bg-blue-600 transition duration-200">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6 6L14 14M14 6L6 14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
            Annuler la demande
          </button>
        </form>
        @elseif ($friendshipStatus === 'accepted')
        <form action="{{ route('friends.cancel', $user->id) }}" method="GET">
          <button class="flex items-center bg-gray-200 text-black font-semibold py-2 px-4 rounded-full shadow hover:bg-gray-300 transition duration-200" type="submit">
            <img src="/images/alreadyFriend.png" alt="Ami(e)" class="w-4 h-4 mr-2">
            Amis
          </button>
        </form>
        @endif
        @else
          <a href="{{ route('profile.edit') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Modifier le profil</a>
        @endif
                @if ($authUser->id !== $user->id)
          <button id="chatProfile" 
            value="{{ $user->id }}"
            data-name="{{ $user->name }}" 
            data-photo="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}"
            class="flex items-center bg-gray-200 text-black font-semibold py-2 px-4 rounded-full shadow hover:bg-gray-300 transition duration-200">
              <img src="/images/messenger.png" alt="Chat" class="w-5 h-5 mr-2">
              Message
          </button>
        @endif
      </div>
      </div>
    </div>
    <div class="bg-white shadow rounded-lg mt-6">
      <ul class="flex justify-around md:justify-start space-x-4 md:space-x-8 px-4 py-2 border-b">
        <li>
          <a href="#publications" class="text-gray-600 hover:text-blue-600 font-semibold border-b-4 border-transparent hover:border-blue-600 transition duration-150 pb-2">
            <span class="block text-center">Publications</span>
          </a>
        </li>
        <li>
          <a href="#about" class="text-gray-600 hover:text-blue-600 font-semibold border-b-4 border-transparent hover:border-blue-600 transition duration-150 pb-2">
            <span class="block text-center">À propos</span>
          </a>
        </li>
        <li>
          <a href="#friends" class="text-gray-600 hover:text-blue-600 font-semibold border-b-4 border-transparent hover:border-blue-600 transition duration-150 pb-2">
            <span class="block text-center">Amis</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-4xl mx-auto mt-6 px-4">
      <!-- Section Publications -->
      <div id="publications" class="mt-6">
        @if ($authUser->id === $user->id)
          <div class="bg-white p-4 rounded shadow mb-4">
            <div class="flex items-center mb-4">
              <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}" class="w-10 h-10 rounded-full mr-3" alt="">
              <input type="text" placeholder="Exprimez-vous, Jean…" class="w-full px-4 py-2 bg-gray-100 rounded-full focus:outline-none" />
            </div>
            <div class="flex justify-around text-sm text-gray-600 border-t pt-2">
              <button class="flex items-center space-x-1 hover:text-blue-600">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a1 1 0 00-1 1v1h16V4a1 1 0 00-1-1H4zM3 8h14v9a1 1 0 01-1 1H4a1 1 0 01-1-1V8z"/></svg>
                <span>Vidéo en direct</span>
              </button>
              <button class="flex items-center space-x-1 hover:text-blue-600" onclick="openModal()">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H4zm3 3a3 3 0 100 6 3 3 0 000-6zm7 8H6a1 1 0 01-1-1v-.586l2.293-2.293a1 1 0 011.414 0L12 14.414l1.293-1.293a1 1 0 011.414 0L17 15.414V16a1 1 0 01-1 1z"/></svg>
                <span>Photo/Vidéo</span>
              </button>
              <button class="flex items-center space-x-1 hover:text-blue-600">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-11a1 1 0 01.993.883L11 8v2a1 1 0 01-1.993.117L9 10V8a1 1 0 011-1zm0 6a1 1 0 110 2 1 1 0 010-2z"/></svg>
                <span>Humeur</span>
              </button>
            </div>
          </div>
        @endif

        @foreach ($posts as $post)
          <div class="post bg-white rounded shadow p-4 mb-4 relative">
            <div class="flex items-start justify-between mb-2">
              <div class="flex items-center">
                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}" alt="Photo de profil" class="w-10 h-10 rounded-full mr-3">
                <div>
                  <p class="font-semibold">{{ $user->name }}</p>
                  <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
              </div>
              @if (auth()->id() === $post->user_id && $authUser->id === $user->id)
                <div class="relative">
                  <button onclick="toggleMenu({{ $post->id }})" class="text-black font-bold text-2xl px-2">⋯</button>
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
              <img src="{{ asset('storage/' . $post->image) }}" alt="Image du post" class="rounded w-full h-96 object-cover object-center">
            @endif

            <div class="mt-4 pt-2 text-sm text-gray-600">
              <!-- Ligne emojis + compteurs -->
              <div class="flex justify-between items-center mb-1">
                <div class="flex items-center space-x-1">
                  <span class="like-count text-sm" data-postid="{{ $post->id }}">
                    {{ $post->likes->count() > 0 ? $post->likes->count() . ' Like(s)' : '' }}
                  </span>
                </div>
              </div>
            
              <!-- Ligne boutons -->
              <div class="flex justify-around border-t pt-4 text-gray-600 text-sm font-semibold">
                <button
                data-postid="{{ $post->id }}"
                data-liked="{{ $post->liked ? 'true' : 'false' }}"
                class="likeBtn flex items-center space-x-1 {{ $post->liked ? 'text-blue-500' : '' }}">
                <img
                  src="{{ $post->liked ? '/images/likeblue.png' : '/images/like.png' }}"
                  alt="like"
                  class="like w-5 h-5 object-contain mt-[-7.5px]" />
                <span class="like-text">J’aime</span>
              </button>

              <button
                data-postId="{{ $post->id }}"
                data-userId="{{ $user->id }}"
                data-userName="{{ $user->name }}"
                data-userPhoto="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/user.png') }}"
                data-postContent="{{ $post->content }}"
                data-postImage="{{ $post->image ? asset('storage/' . $post->image) : '' }}"
                data-timePost="{{ $post->created_at }}"
                data-liked="{{ $post->liked ? 'true' : 'false' }}"
                data-postlike="{{ $post->likes->count() }}"
                class="openPublicationPopupBtn flex items-center space-x-1 hover:text-blue-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Commenter</span>
              </button>

              </div>
            </div>
          </div>
        @endforeach
        @if ($posts->isEmpty())
          <p class="text-center text-gray-500">Aucune publication pour le moment.</p>
        @endif
      </div>

      <!-- Section À propos -->
      <div id="about" class="mt-6 hidden">
        <div class="bg-white p-6 rounded-md shadow-sm border border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">À propos</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-sm text-gray-700">
            <div>
              <div class="text-gray-500 uppercase text-xs mb-1">Nom</div>
              <div class="font-medium">{{ $user->name }}</div>
            </div>
            <div>
              <div class="text-gray-500 uppercase text-xs mb-1">Email</div>
              <div class="font-medium">{{ $user->email }}</div>
            </div>
            <div>
              <div class="text-gray-500 uppercase text-xs mb-1">Date de naissance</div>
              <div class="font-medium">
                {{ $user->date_of_birth ? $user->date_of_birth->format('d/m/Y') : 'Non renseignée' }}
              </div>
            </div>
            <div>
              <div class="text-gray-500 uppercase text-xs mb-1">Genre</div>
              <div class="font-medium">{{ $user->gender ?? 'Non renseigné' }}</div>
            </div>
            <div class="md:col-span-2">
              <div class="text-gray-500 uppercase text-xs mb-1">Bio</div>
              <div class="font-medium">{{ $user->bio ?? 'Non renseignée' }}</div>
            </div>
            <div class="md:col-span-2">
              <div class="text-gray-500 uppercase text-xs mb-1">Localisation</div>
              <div class="font-medium">{{ $user->location ?? 'Non renseignée' }}</div>
            </div>
          </div>
        </div>
      </div>
      

      <!-- Section Amis -->
      <div id="friends" class="mt-6 hidden">
        <div class="bg-white p-4 rounded shadow">
          <h2 class="text-xl font-bold mb-4">Amis</h2>
          @if ($friends->isNotEmpty())
          <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($friends as $friend)
            <li class="flex items-center space-x-4 bg-gray-100 p-4 rounded shadow">
              <img src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('images/user.png') }}" alt="Photo de profil" class="w-12 h-12 rounded-full">
              <div>
              <a href="{{url('profile', $friend->id)}}"><p class="font-semibold">{{ $friend->name }}</p></a>
              <p class="text-sm text-gray-500">{{ $friend->email }}</p>
              </div>
            </li>
            @endforeach
          </ul>
          @else
          <p class="text-center text-gray-500">Aucun ami pour le moment.</p>
          @endif
        </div>
        </div>
    </div>
    <x-publication-popup :post="$post" :authUser="$authUser" />
    <script>
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          document.querySelectorAll('div[id]').forEach(section => {
            section.classList.add('hidden');
          });
          document.getElementById(targetId).classList.remove('hidden');
        });
      });

    </script>
  
</div>

@endsection