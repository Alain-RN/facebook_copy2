<!-- filepath: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar styles (optional) */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        #search-results {
            max-height: 300px;
            overflow-y: auto;
        z-index: 50;
        }   
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md sticky top-0 z-50 flex items-center justify-between px-4 py-2">
            <!-- Left section -->
            <div class="flex items-center space-x-2">
                <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <a href="{{url('/home')}}">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.294h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </a>
                </div>
                <div class="relative">
                    <input type="text" id="search" placeholder="Rechercher sur Facebook" class="hidden md:block bg-gray-100 rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 hidden md:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <div id="search-results" class="absolute bg-white shadow-lg rounded-lg w-full mt-2">
                        <ul>
                            <li>Alain</li>
                            <li>alain</li>
                            <li>dshfd</li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <!-- Center section (Navigation Icons) -->
            <nav class="hidden md:flex flex-grow justify-center space-x-2 lg:space-x-6">
                <a href="{{route("home")}}" class="{{ request()->routeIs('home') ? 'text-blue-600 border-b-4 border-blue-600' : 'text-gray-600' }} px-4 lg:px-8 py-3 hover:bg-gray-100 rounded-lg transition duration-150" onclick="console.log('Clicked: Home')">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"> <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/> </svg>
                </a>
                <a href="{{route("friends.index")}}" class="{{ request()->routeIs('friends.index') ? 'text-blue-600 border-b-4 border-blue-600' : 'text-gray-600' }} px-4 lg:px-8 py-3 hover:bg-gray-100 rounded-lg transition duration-150" onclick="console.log('Clicked: Friends')">
                     <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /> </svg>
                </a>
                 <a href="{{route('groups.index')}}" class="{{ request()->routeIs('groups.index') ? 'text-blue-600 border-b-4 border-blue-600' : 'text-gray-600' }} px-4 lg:px-8 py-3 hover:bg-gray-100 rounded-lg transition duration-150" onclick="console.log('Clicked: Groups')">
                     <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </a>
            </nav>
    
            <!-- Right section (Profile, Menu) -->
            <div class="flex items-center space-x-2" >
                <a href="{{route('profile')}}" class="hidden lg:flex items-center space-x-2 bg-gray-200 hover:bg-gray-300 rounded-full p-1 pr-3 transition duration-150">
                    <img src="{{ $authUser->profile_photo ? asset('storage/' . $authUser->profile_photo) : asset('images/user.png') }}" alt="Profile" class="rounded-full h-7 w-7">
                    <span class="font-semibold text-sm">Utilisateur</span>
                </a>
                <a href="" title="blackberry messenger icons" class="px-1">
                    <img src="{{asset('images/messenger.png')}}" alt="Messenger" class="h-8 w-8">
                </a>
                <button class="bg-gray-200 rounded-full p-2 hover:bg-gray-300 transition duration-150">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </button>
                <div class="relative">
                    <button onclick="toggleDropdown()" class="bg-gray-200 rounded-full p-2 hover:bg-gray-300 transition duration-150">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 15.5a1 1 0 01-.71-.29l-4-4a1 1 0 111.42-1.42L12 13.09l3.29-3.3a1 1 0 111.42 1.42l-4 4a1 1 0 01-.71.29z" />
                        </svg>
                    </button>
                    <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">

            <div class="">
                @yield('content')
            </div>

        </main>

        <div id="postModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
                <!-- En-tête -->
                <div class="flex justify-between items-center border-b p-4">
                    <h2 class="text-xl font-bold">Créer une publication</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
          
                <!-- Contenu -->
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-4 space-y-4">
                    @csrf
          
                    <!-- Champ de contenu -->
                    <textarea name="content" rows="4" class="w-full border rounded p-2" placeholder="Qu'avez-vous en tête ?" required></textarea>
          
                    <!-- Ajouter une image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Ajouter une image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
          
                    <!-- Ajouter une vidéo -->
                    <div>
                        <label for="video" class="block text-sm font-medium text-gray-700">Ajouter une vidéo</label>
                        <input type="file" name="video" id="video" accept="video/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
          
                    <!-- Boutons -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Publier
                        </button>
                    </div>
                </form>
            </div>
          </div>
    </div>

    <div id="editPostModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
            <!-- En-tête -->
            <div class="flex justify-between items-center border-b p-4">
                <h2 class="text-xl font-bold">Modifier la publication</h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenu -->
            <form action="" method="POST" enctype="multipart/form-data" class="p-4 space-y-4">
                @csrf
                @method('PUT')

                <!-- Champ de contenu -->
                <textarea name="content" rows="4" class="w-full border rounded p-2" placeholder="Modifier votre publication" required></textarea>

                <!-- Ajouter une image -->
                <div>
                    <label for="editImage" class="block text-sm font-medium text-gray-700">Modifier l'image</label>
                    <input type="file" name="image" id="editImage" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Ajouter une vidéo -->
                <div>
                    <label for="editVideo" class="block text-sm font-medium text-gray-700">Modifier la vidéo</label>
                    <input type="file" name="video" id="editVideo" accept="video/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    
</body>
</html>