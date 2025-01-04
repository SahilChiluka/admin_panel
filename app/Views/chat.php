<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="<?= base_url('assets/js/jquery_min.js') ?>"></script>
    <script src="<?= base_url('assets/js/socketCDN.js') ?>"></script>
<style>
        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .people-list .chat-list li:hover {
            background: #efefef;
        }

        .chat .chat-history {
            padding: 20px;
            height: 400px;
            overflow-y: auto;
        }

        .message {
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            max-width: 70%;
            clear: both;
        }

        .sender-message {
            background: #007bff;
            color: white;
            float: right;
        }

        .receiver-message {
            background: #e9ecef;
            color: black;
            float: left;
        }

        .chat-input {
            padding: 20px;
            border-top: 1px solid #eaeaea;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .loggedUser {
            font-size: 20px;
            font-weight: bold;
            color: black;
        }
</style>
</head>
<body>
    <div class="container">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="loggedUser"><?= session('name') ?></div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                    <?php foreach($users as $user) { ?>
                        <?php if($user['username'] !== session('name')) { ?>
                            <li class="clearfix users" data-username="<?= $user['username'] ?>">
                                <div class="name"><?= $user['username'] ?></div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <h6 class="receiver">Select a user to chat</h6>
                </div>
                <div class="chat-history" id="messages">
                    <!-- Messages will appear here -->
                </div>
                <div class="chat-input">
                    <input type="text" id="chat-input" placeholder="Enter message..." size="50">
                    <button id="send-button">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const socket = io('http://localhost:3000');
        const username = '<?= session('name') ?>';
        let currentReceiver = null;

        socket.emit('username', username);

        document.querySelectorAll('.users').forEach(user => {
            user.addEventListener('click', () => {
                currentReceiver = user.dataset.username;
                document.querySelector('.receiver').textContent = currentReceiver;
                document.getElementById('chat-input').disabled = false;
                document.getElementById('send-button').disabled = false;

                document.getElementById('messages').innerHTML = '';
                socket.emit('joinRoom', { 
                    sender: username, 
                    receiver: currentReceiver 
                });
            });
        });

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (message && currentReceiver) {
                socket.emit('send-message', {
                    sender: username,
                    receiver: currentReceiver,
                    message: message
                });
                input.value = '';
            }
        }

        document.getElementById('send-button').addEventListener('click', sendMessage);

        document.getElementById('chat-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        socket.on('previousMessages', (messages) => {
            const chatHistory = document.getElementById('messages');
            chatHistory.innerHTML = '';
            
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${msg.sender === username ? 'sender-message' : 'receiver-message'}`;
                messageDiv.textContent = msg.message;
                chatHistory.appendChild(messageDiv);
            });
            
            chatHistory.scrollTop = chatHistory.scrollHeight;
        });

        socket.on('new-message', (message) => {
            const chatHistory = document.getElementById('messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${message.sender === username ? 'sender-message' : 'receiver-message'}`;
            messageDiv.textContent = message.message;
            chatHistory.appendChild(messageDiv);
            chatHistory.scrollTop = chatHistory.scrollHeight;
        });
    </script>
