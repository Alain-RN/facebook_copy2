function openEditModal(postId, content, imageUrl = null, videoUrl = null) {
    const modal = document.getElementById('editPostModal');
    const form = modal.querySelector('form');
    const textarea = modal.querySelector('textarea[name="content"]');

    // Set form action
    form.action = `{{ route('posts.update', ':postId') }}`.replace(':postId', postId);

    // Set content
    textarea.value = content;

    // Optionally handle image and video previews
    if (imageUrl) {
        const imagePreview = document.createElement('div');
        imagePreview.innerHTML = `<img src="${imageUrl}" alt="Image actuelle" class="w-full h-auto rounded mb-2">`;
        textarea.parentNode.insertBefore(imagePreview, textarea);
    }

    if (videoUrl) {
        const videoPreview = document.createElement('div');
        videoPreview.innerHTML = `<video controls class="w-full h-auto rounded mb-2"><source src="${videoUrl}" type="video/mp4"></video>`;
        textarea.parentNode.insertBefore(videoPreview, textarea);
    }

    modal.classList.remove('hidden');
}

function openEditModal(postId, content) {
    const modal = document.getElementById('editPostModal');
    modal.querySelector('textarea[name="content"]').value = content;
    modal.querySelector('form').action = `/posts/${postId}`;
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editPostModal').classList.add('hidden');
}

function openModal() {
    document.getElementById('postModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('postModal').classList.add('hidden');
}
function toggleMenu(postId) {
    const menu = document.getElementById(`menu-${postId}`);
    const isVisible = !menu.classList.contains('hidden');
    
    // Fermer tous les menus d'abord
    document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add('hidden'));

    // Afficher le menu cliqué si ce n'était pas déjà visible
    if (!isVisible) {
        menu.classList.remove('hidden');
    }
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(e) {
    if (!e.target.closest('button') && !e.target.closest('[id^="menu-"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add('hidden'));
    }
});
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.classList.toggle('hidden');
}

            // Close dropdown when clicking outside
document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('dropdownMenu');
    if (!e.target.closest('button') && !e.target.closest('#dropdownMenu')) {
        dropdown.classList.add('hidden');
    }
});

document.getElementById('cover_photo_input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('cover-preview').src = URL.createObjectURL(file);
    }
});

document.getElementById('profile_photo_input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('profile-preview').src = URL.createObjectURL(file);
    }
});

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
    section.classList.add('hidden');
    });
    document.getElementById(sectionId).classList.remove('hidden');
}
