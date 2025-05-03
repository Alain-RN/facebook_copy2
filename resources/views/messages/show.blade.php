<h3>Conversation</h3>
<div>
    @foreach($messages as $message)
        <div>
            <strong>{{ $message->sender->name }}:</strong> {{ $message->content }}
            @if($message->receiver_id == Auth::id() && !$message->is_read)
                <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST">
                    @csrf
                    <button type="submit">Mark as Read</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
