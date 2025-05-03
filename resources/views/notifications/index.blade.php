<h3>Notifications</h3>

<div>
    @foreach($notifications as $notification)
        <div>
            <p>{{ $notification->type }}: {{ $notification->data }}</p>
            <small>{{ $notification->created_at->diffForHumans() }}</small>
            @if(!$notification->is_read)
                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit">Mark as Read</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
