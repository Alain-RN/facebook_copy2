@extends('layouts.app')
@section('title', 'Modifier le profil')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden">
        
        <!-- Photo de couverture -->
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden">
        
            <!-- Photo de couverture -->
            <div class="relative h-56 bg-gray-200">
                <img id="cover-preview" src="{{ $user->cover_photo ? asset('storage/' . $user->cover_photo) : 'https://via.placeholder.com/800x200' }}" 
                     alt="Photo de couverture" 
                     class="w-full h-full object-cover">
                <div class="absolute bottom-2 right-2">
                    <label class="cursor-pointer bg-white px-3 py-1 rounded shadow text-sm text-gray-700 hover:bg-gray-100">
                        Modifier couverture
                        <input type="file" name="cover_photo" id="cover_photo_input" class="hidden" form="profile-form" accept="image/*">
                    </label>
                </div>
            </div>
    
            <!-- Photo de profil -->
            <div class="relative">
                <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img id="profile-preview" src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/150' }}" 
                             alt="Photo de profil" 
                             class="w-full h-full object-cover">
                    </div>
                    <label class="block text-center text-sm mt-2 text-gray-700">
                        <span class="cursor-pointer bg-white px-3 py-1 rounded shadow text-sm hover:bg-gray-100">
                            Modifier photo
                            <input type="file" name="profile_photo" id="profile_photo_input" class="hidden" form="profile-form" accept="image/*">
                        </span>
                    </label>
                </div>
                <div class="h-20"></div>
            </div>

        <!-- Formulaire -->
        <div class="p-6">
            <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                           class="mt-1 block w-full h-12 px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                           class="mt-1 block w-full h-12 px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Date de naissance -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" 
                           class="mt-1 block w-full h-12 px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Genre -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Genre</label>
                    <select name="gender" id="gender" class="mt-1 block w-full h-12 px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Sélectionner</option>
                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Homme</option>
                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Femme</option>
                        <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                    <textarea name="bio" id="bio" rows="3" 
                              class="mt-1 block w-full px-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <!-- Localisation -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Localisation</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                           class="mt-1 block w-full h-12 px-4 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('profile') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Annuler</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
