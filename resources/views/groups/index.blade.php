<h3>All Groups</h3>

@foreach ($groups as $group)
    <div>
        <h4><a href="{{ route('groups.show', $group->id) }}">{{ $group->name }}</a></h4>
        <p>{{ $group->description }}</p>
        <p>Privacy: {{ $group->privacy }}</p>
        <p>Owner: {{ $group->owner->name }}</p>
        @if ($group->members->contains(Auth::id()))
            <form action="{{ route('groups.leave', $group->id) }}" method="POST">
                @csrf
                <button type="submit">Leave Group</button>
            </form>
        @else
            <form action="{{ route('groups.join', $group->id) }}" method="POST">
                @csrf
                <button type="submit">Join Group</button>
            </form>
        @endif
    </div>
@endforeach
