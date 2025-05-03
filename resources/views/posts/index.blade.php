<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fil d'actualité</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <h1 class="text-2xl font-bold mb-4">Fil d'actualité</h1>

        @foreach ($posts as $post)
            <div class="bg-white rounded shadow p-4 mb-4">
                <div class="flex items-center mb-2">
                    <img src="{{ $post->user->profile_photo_url ?? 'https://via.placeholder.com/50' }}" alt="Photo de profil" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <p class="mb-2">{{ $post->content }}</p>
                @if (!empty($post->image))
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image du post" class="rounded w-full h-64 object-cover">
                @endif
            </div>
        @endforeach

        @if ($posts->isEmpty())
            <p class="text-center text-gray-500">Aucune publication pour le moment.</p>
        @endif
    </div>
</body>
</html>