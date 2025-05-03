@extends('layouts.app')  {{-- On dit ici qu’on utilise le layout "app.blade.php" --}}

@section('title', 'Amis de l’utilisateur')
@section('content') 

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-[350px] bg-white shadow-md p-4 hidden md:block">
    <h2 class="text-2xl font-semibold mb-4">Ami(e)s</h2>
    <nav class="space-y-2 text-gray-700">
    <div class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 cursor-pointer" onclick="showSection('invitations')">
      <span class="text-xl">📩</span>
      <span>Invitations</span>
    </div>

    <div class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 cursor-pointer" onclick="showSection('all-friends')">
      <span class="text-xl">👥</span>
      <span>Tou(te)s les ami(e)s</span>

      <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
        {{ $friends->count() }}
      </span>
    </div>

  </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-4">

    <div id="invitations" class="section">
    <h2 class="text-xl font-bold">Invitations</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-4 ml-4">
      @foreach ($friendRequests as $friendRequest)
      <div class="bg-white shadow rounded overflow-hidden w-[250px]">
        <img src="{{ $friendRequest->user->profile_photo ? asset('storage/'.$friendRequest->user->profile_photo) : asset('images/user.png') }}" alt="Profile Image" class="w-40 h-40 object-cover rounded-full mx-auto mt-4" />
      <div class="p-3">
        <a class="font-semibold" href="{{url('profile', $friendRequest->user->id)}}">{{ $friendRequest->user->name }}</a>
        <p class="text-sm text-gray-500 mb-2">{{$friends->count()}} am(s)</p>
        <form action="{{ route('friends.accept', $friendRequest->id) }}" method="GET" class="mb-1">
        @csrf
        <button type="submit" class="w-full bg-blue-600 text-white py-1 rounded hover:bg-blue-700">Confirmer</button>
        </form>
        <form action="{{ route('friends.reject', $friendRequest->id) }}" method="GET">
        @csrf
        <button type="submit" class="w-full bg-gray-200 text-gray-700 py-1 rounded hover:bg-gray-300">Supprimer</button>
        </form>
      </div>
      </div>
      @endforeach
    </div>
    </div>


    <div id="all-friends" class="section hidden">
      <h2 class="text-xl font-bold">Tou(te)s les ami(e)s</h2>
  
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-4 ml-4">
      @foreach ($friends as $friend)
      <div class="bg-white shadow rounded overflow-hidden w-[250px]">
        <img
          src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('images/user.png') }}"
          alt="Profile Image"
          class="w-40 h-40 object-cover rounded-full mx-auto mt-4"
        />
        <div class="p-3 text-center">
          <a
            class="font-semibold mt-4 block text-lg text-gray-800"
            href="{{ url('profile', $friend->id) }}"
          >
            {{ $friend->name }}
          </a>
          <p class="text-sm text-gray-500 mb-2">Ami(e)</p>
        </div>
      </div>
      @endforeach
      </div>

    </div>
    
  </main>

  </div>

@endsection