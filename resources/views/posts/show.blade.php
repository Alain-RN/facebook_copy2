<div class="comments">
    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="comment">
            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
            @if ($comment->user_id === Auth::id())
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            @endif
        </div>
    @endforeach

    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <textarea name="content" required placeholder="Write a comment..."></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>
