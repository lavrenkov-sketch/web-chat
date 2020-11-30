function ClearChatHistory() {
    var select = document.getElementById('message-box');
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
}

function WhoDevelop() {
    alert('Курсовой: Web чат Лавренков Н.В ИТС-7 +375298265482');
}
