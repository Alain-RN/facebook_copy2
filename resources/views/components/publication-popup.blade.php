<div id="PublicationPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-2xl h-[90vh] mx-4 rounded-lg shadow-lg flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h2 id="publicationHeader" class="text-lg font-semibold">{{ $post->title }}</h2>

            <button id="closePublicationPopupBtn"
                    class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full text-gray-600 hover:text-red-500 hover:bg-gray-300 text-3xl leading-none">
                &times;
            </button>
        </div>

        <div class="flex-grow overflow-y-auto space-y-4 p-4">
            <div class="flex items-center space-x-3">
                <img id="profilePublication" src="{{ asset('images/user.png') }}" alt="User" class="h-10 w-10 rounded-full">
                <div>
                    <p id="postOwner" class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                    <p id="timePost" class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div id="contentPublication" class="text-sm text-gray-800">{{ $post->content }}</div>
                <div id="imagePost" class="w-full bg-gray-200 rounded-lg">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto rounded-lg">
                    @endif
                </div>
            </div>

            <div class="flex gap-2 flex-col">
                <div class="flex items-center text-sm text-gray-600"></div>

                <div class="flex justify-around border-t border-b text-sm text-gray-700 pt-2 pb-2">
                    <button data-postId="{{ $post->id }}" data-liked="{{ $post->liked ? 'true' : 'false' }}" class="likeBtn flex items-center space-x-1 {{ $post->liked ? 'text-blue-500' : '' }}">
                        <img src="{{ $post->liked ? '/images/likeblue.png' : '/images/like.png' }}" alt="like" class="like w-5 h-5 object-contain mt-[-7.5px]" />
                        <span class="like-text">J’aime</span>
                    </button>

                    <button class="hover:text-blue-600 font-semibold">Commenter</button>
                </div>
            </div>

            <div id="commentsContainer" class="p-4 space-y-2 text-sm"></div>
        </div>

        <div class="p-4 border-t" data-post-id="{{ $post->id }}">
            <div class="flex items-center gap-3">
                <input type="hidden" id="postId" value="{{ $post->id }}">
                <input id="commentInput" type="text" placeholder="Répondre en tant que {{ $authUser->name }}" class="flex-grow border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button id="submitComment">
                    <img src="/images/send.png" alt="Envoyer" class="w-7 h-7 cursor-pointer">
                </button>
            </div>
        </div>
    </div>
</div>
