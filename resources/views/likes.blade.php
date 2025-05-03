<!-- Post content here -->
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>

<!-- Like Section -->
<div class="likes">
    <p>{{ $post->likes->count() }} Likes</p>

    <!-- Check if the user already liked this post -->
    @if ($post->likes->where('user_id', Auth::id())->isEmpty())
        <!-- User hasn't liked the post yet -->
        <form action="{{ route('likes.store', $post) }}" method="POST">
            @csrf
            <button type="submit">Like</button>
        </form>
    @else
        <!-- User has liked the post -->
        <form action="{{ route('likes.destroy', $post) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Unlike</button>
        </form>
    @endif
</div>
