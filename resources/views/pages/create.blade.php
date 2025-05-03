<h3>Create a New Page</h3>
<form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="name">Page Name:</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label for="description">Page Description:</label>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label for="profile_photo">Profile Photo:</label>
        <input type="file" name="profile_photo">
    </div>

    <button type="submit">Create Page</button>
</form>
