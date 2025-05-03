<h3>Create Notification</h3>
<form action="{{ route('notifications.store', $user->id) }}" method="POST">
    @csrf
    <div>
        <label for="type">Type:</label>
        <input type="text" name="type" required>
    </div>

    <div>
        <label for="data">Data:</label>
        <textarea name="data" required></textarea>
    </div>

    <button type="submit">Send Notification</button>
</form>
