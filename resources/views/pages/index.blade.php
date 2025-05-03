<h3>My Pages</h3>

<div>
    @foreach($pages as $page)
        <div>
            <h4>{{ $page->name }}</h4>
            <p>{{ $page->description }}</p>
            <a href="{{ route('pages.show', $page->id) }}">View</a>
            <a href="{{ route('pages.edit', $page->id) }}">Edit</a>
            <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach
</div>

<a href="{{ route('pages.create') }}">Create New Page</a>
