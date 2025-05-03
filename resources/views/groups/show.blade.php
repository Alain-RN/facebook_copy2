<h3>Create a New Group</h3>

<form action="{{ route('groups.store') }}" method="POST">
    @csrf
    <label for="name">Group Name</label>
    <input type="text" name="name" id="name" required>
    <label for="description">Description</label>
    <textarea name="description" id="description"></textarea>
    <label for="privacy">Privacy</label>
    <select name="privacy" id="privacy">
        <option value="public">Public</option>
        <option value="private">Private</option>
    </select>
    <button type="submit">Create Group</button>
</form>
