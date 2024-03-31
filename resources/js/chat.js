const chat_first_id = Math.min(user_id, other_user_id),
    chat_second_id = Math.max(user_id, other_user_id);
Echo.private(`chat.${chat_first_id}.${chat_second_id}`).listen(
    "ChatSent",
    (e) => {
        displayMessage(e.chat);
        jumpToLatest();
    }
);
const chat_connection_status = document.querySelector(
    "#chat-connection-status"
);

window.Echo.connector.pusher.connection.bind("connecting", function () {
    chat_connection_status.innerHTML = "Connecting to chat...";
});
window.Echo.connector.pusher.connection.bind("connected", function () {
    chat_connection_status.innerHTML = "Connected to chat";
});
window.Echo.connector.pusher.connection.bind("unavailable", function () {
    chat_connection_status.innerHTML = "Reconnecting...";
});
function jumpToLatest() {
    const messages = document.querySelector("#messages");
    messages.scrollTo(0, messages.scrollHeight + 100);
}
jumpToLatest();
function displayMessage(msg) {
    let listItem = document.createElement("li");
    listItem.classList = "m-1 p-2 d-inline-block rounded-3";
    const isOwnMsg = user_id === parseInt(msg.sender_id);
    if (!isOwnMsg) {
        listItem.classList += " bg-secondary text-light align-self-start ";
    } else {
        listItem.classList += " bg-primary text-light align-self-end";
    }

    listItem.innerText = msg.content;
    document.querySelector("#messages").appendChild(listItem);
}
function sendMessage(e) {
    e.preventDefault();
    const message_box = document.querySelector("#message");
    if (message_box.value != "") {
        axios
            .post("/api/chat", {
                recipient_id: other_user_id,
                content: message_box.value,
            })
            .then((res) => {})
            .catch((e) => {
                console.log(e);
                let toast_message = `<div class="toast show align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    Couldn't send message. Please try again.
                    ${e.code} (${e.response.status})
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
                document.querySelector("#toasts").innerHTML += toast_message;
            });
        message_box.value = "";
    }
}
document
    .querySelector("#send-msg-form")
    .addEventListener("submit", sendMessage);
