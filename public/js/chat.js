let receiverId = null;
let photoUser;
let userName;

function loadMessages() {
    if (!receiverId) return;
    $.get(`/messenger/to/${receiverId}`, function(data) {
        let messagesHtml = '';
        data.forEach(function(message) {
            let isSender = message.sender_id == window.authUserId;
            if (isSender) {
                messagesHtml += `
                <div class="flex justify-end items-end gap-2 mb-2">
                    <div class="bg-blue-500 text-white px-4 py-2 rounded-2xl rounded-tr-none max-w-xs text-sm break-words">
                        ${message.content}
                    </div>
                    <img src="${window.authUserProfilePhoto}" alt="Moi" class="w-8 h-8 rounded-full">
                </div>`;
            } else {
                messagesHtml += `
                    <div class="flex items-start gap-2 mb-2">
                        <img alt="User" src="${photoUser ?? '/images/user.png'}" class="userProfile w-8 h-8 rounded-full">
                        <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-2xl rounded-tl-none max-w-xs text-sm break-words">
                            ${message.content}
                        </div>
                    </div>`;
            }
        });

        $('#messagesContainer').html(messagesHtml);
        $('#messagesContainer').animate({
            scrollTop: $('#messagesContainer')[0].scrollHeight
        }, 300);
    });
}

let messageInterval = setInterval(loadMessages, 2000);

// Écouteur d'envoi du message - défini une seule fois
function sendMessage() {
    const content = $('#messageInput').val();       
    if (content.trim() === '' || !receiverId) {
        return;
    }       
    $.ajax({
        url: '/messenger/send_message',
        method: 'POST',
        data: {
            receiver_id: receiverId,
            content: content,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            $('#messageInput').val('');
            // Tu peux recharger les messages ici si nécessaire
        },
        error: function(xhr) {
            alert('Message sending failed');
        }
    });
    }

    $('#sendMessageButton').on('click', sendMessage);
// Appui sur Entrée dans l'input
    $('#messageInput').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); // Empêche un saut de ligne
            sendMessage();
        }
    });

    function openChatWithUser(button) {
        if (!button) return;
        // alert('aaaa')
    
        const userId = button.value;
        receiverId = userId;

        if(button !== document.getElementById('chatProfile')) {
            userName = button.querySelector('p').innerText;
            photoUser = button.querySelector('img').src;
        } else {
            userName = button.dataset.name;
            photoUser = button.dataset.photo ? button.dataset.photo : '/images/user.png';
        }

        document.getElementById('chatUserName').innerText = userName;
        document.getElementById('chatUserPhoto').src = photoUser;

        document.getElementById('linkToUser').href = `/profile/${userId}`;
    
        document.getElementById('chatPopup').classList.remove('hidden');
    
        loadMessages();
    }

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.bb');
        if (button) openChatWithUser(button);
    });

    const button = document.getElementById('chatProfile');
    button.addEventListener('click', function () {
        openChatWithUser(button);
    });

    function closeChat() {
        document.getElementById('chatPopup').classList.add('hidden');
        clearInterval(messageInterval);
    }
