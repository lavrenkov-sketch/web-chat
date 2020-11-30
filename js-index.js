var nameInput = document.getElementById('name-input');
var messageInput = document.getElementById('message-input');

function handleKeyUp(e) {
    if (e.keyCode === 13) {
        sendMessage();
    }
}

function ClearChatHistory() {
    var select = document.getElementById('message-box');
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
}

function sendMessage() {
    name = nameInput.value;
    message = messageInput.value;

    if (!name) return alert('Пожалуйста заполните nickname');
    else if (!message) return alert('Пожалуйста введите текст сообщения');
    else {
        var select = document.getElementById('message-box');

        //Удалить элементы
        // if (select.childElementCount >= 5) {
        //     do {
        //         if (select.firstChild) {
        //             select.removeChild(select.firstChild);
        //         }
        //     } while (select.childElementCount >= 5);
        // }

        var div = document.createElement('div');
        var author = document.createElement('span');
        author.className = 'author';
        author.innerHTML = nameInput.value;
        var message = document.createElement('span');
        message.className = 'messsage-text';
        message.innerHTML = messageInput.value;

        div.appendChild(message);
        div.appendChild(author);

        div.className = 'message-class';
        document.getElementById('message-box').appendChild(div);

        var name = nameInput.value.trim(),
            message = messageInput.value.trim();

        var ajax = new XMLHttpRequest();
        ajax.open('POST', 'php-send-message.php', true);
        ajax.setRequestHeader(
            'Content-type',
            'application/x-www-form-urlencoded'
        );
        ajax.send('name=' + name + '&message=' + message);

        var topPos = div.offsetTop;
        document.getElementById('message-box').scrollTop = topPos;
        messageInput.value = '';
    }
}

// web sockets
window.WebSocket = window.WebSocket || window.MozWebSocket;

var connection = new WebSocket('ws://localhost:8080');
var connectingSpan = document.getElementById('connecting');
connection.onopen = function () {
    connectingSpan.style.display = 'none';
};
connection.onerror = function (error) {
    connectingSpan.innerHTML = 'Ошибка подключения к серверу !';
};
connection.onmessage = function (message) {
    console.log('Получили сообщение!');
    var data = JSON.parse(message.data);
    var div = document.createElement('div');
    div.className = 'message-class';
    var author = document.createElement('span');
    author.className = 'author';
    author.innerHTML = data.name;
    var message = document.createElement('span');
    message.className = 'messsage-text';
    message.innerHTML = data.message;

    div.appendChild(author);
    div.appendChild(message);

    document.getElementById('message-box').appendChild(div);
};
