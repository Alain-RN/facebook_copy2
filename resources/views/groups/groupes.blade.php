@extends('layouts.app')

@section('title', 'Groupes')

@section('content')

<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar gauche -->
    <div class="w-[350px] bg-white shadow-md p-4">
      <h2 class="text-xl font-bold mb-4">Groupes</h2>
      <input type="text" placeholder="Rechercher des groupes"
             class="w-full p-2 mb-4 text-sm border rounded bg-gray-100" />
  
      <button class="mt-4 w-full bg-blue-600 text-white text-sm py-2 rounded">
        + Créer un nouveau groupe
      </button>
  
      <h3 class="mt-6 font-semibold text-sm text-gray-600">Groupes que vous gérez</h3>

  
      <h3 class="mt-6 font-semibold text-sm text-gray-600">Groupes dont vous êtes membre</h3>
    </div>
  
    <!-- Zone principale -->
    <div class="flex-1 p-6">
      <div class="max-w-2xl mx-auto bg-white shadow rounded overflow-hidden">
        <!-- Header du post -->
        <div class="flex items-start px-4 py-3">
          <img src="{{asset('images/user.png')}}" class="w-10 h-10 rounded-full mr-3" />
          <div>
            <p class="text-sm">
              <span class="font-semibold">Goupe Name</span>
            
            </p>
            <p class="text-xs text-gray-500">
              <span class="font-semibold text-blue-600">Groupes member</span> {date de la publication}
            </p>
          </div>
        </div>
  
        <!-- Texte du post -->
        <div class="px-4 text-sm mb-2">
          title pub
        </div>
  
        <!-- Vidéo ou image -->
        <div class="w-full h-64 bg-gray-200 relative">
          <img src="https://placehold.co/600x300" class="w-full h-full object-cover" />
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-black bg-opacity-50 p-2 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z" />
              </svg>
            </div>
          </div>
        </div>
      
      </div>
    </div>
  </div>
  

@endsection