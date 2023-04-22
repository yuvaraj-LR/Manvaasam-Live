<?php
session_start();
?>
<style>
    .FloatingBox {
        position: relative;
        cursor: pointer;
        width: 90%;
        max-width: 400px;
        min-height: 80vh;
        margin: 10px auto;
        height: 70%;
        color: #fff;
        background: #fafafa;
        border-radius: 5px;
        display: none;
    }

    .FloatingBox.show {
        display: flex;
    }

    .FloatingBoxInner {
        position: relative;
        width: 100%;
        height: 100%;
        background: #fff;
    }

    .FloatingBox img {
        height: 50px;
    }

    .typing-area {
        padding: 10px 20px 10px 0;
        display: flex;
        justify-content: space-between;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .typing-area input {
        height: 45px;
        width: calc(100% - 58px);
        font-size: 16px;
        padding: 0 13px;
        border: 1px solid #e6e6e6;
        outline: 0;
        border-radius: 5px 0 0 5px;
    }

    .typing-area input {
        height: 45px;
        width: calc(100% - 43px);
        font-size: 16px;
        padding: 0 13px;
        border: 1px solid #e6e6e6;
        outline: 0;
        border-radius: 5px 0 0 5px;
    }

    .typing-area button {
        color: #fff;
        width: 40px;
        border: none;
        outline: 0;
        background: #333;
        font-size: 19px;
        cursor: pointer;
        opacity: 0.7;
        border-radius: 0 5px 5px 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-box {
        position: absolute;
        overflow-y: auto;
        height: 62vh;
        width: 100%;
    }

    .chat-box .text {
        position: absolute;
        top: 45%;
        left: 50%;
        width: calc(100% - 50px);
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .chat-box .chat p {
        word-wrap: break-word;
        padding: 8px 16px;
        box-shadow: 0 0 32px rgb(0 0 0 / 8%), 0 16px 16px -16px rgb(0 0 0 / 10%);
    }

    .chat-box .outgoing {
        display: flex;
    }

    .chat-box .outgoing .details {
        margin-left: auto;
        max-width: calc(100% - 130px);
    }

    .outgoing .details p {
        background: #333;
        color: #fff;
        border-radius: 18px 18px 0 18px;
    }

    .chat-box .incoming {
        display: flex;
        align-items: flex-end;
        text-align: left !important;
    }

    .chat-box .incoming img {
        height: 35px;
        width: 35px;
    }

    .chat-box .incoming .details {
        margin-right: auto;
        margin-left: 10px;
        max-width: calc(100% - 130px);
    }

    .incoming .details p {
        background: #fff;
        color: #333;
        border-radius: 18px 18px 18px 0;
    }

    .chat-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2px;
        margin-bottom: 10px;
    }

    .overlayInputBox {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 2;
        background: #fff;
    }

    #userNameForm {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        height: 65px;
        z-index: 2;
        background: #fff;
    }
</style>
<div class="FloatingBox card border-1 p-2 text-center show">
    <div>
        <img src="https://manvaasam.com/image/products/manvasam_logo1.png">
    </div>
    <div class="p-2"></div>
    <div class="FloatingBoxInner">
        <div class="chat-box">
            <div class="alertMessage">

            </div>
            <div class="contentContainer"></div>
        </div>
    </div>
    <form class="typing-area" id="chatForm" method="POST">
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <input type="hidden" name="user_id" value="<?= $_SESSION['email'] ?>">
        <input type="hidden" name="user_name" value="<?= $_SESSION['name'] ?>">
        <input type="hidden" name="user_contact" value="<?= $_SESSION['phone'] ?>">
        <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                <g fill="none">
                    <path d="M1.724 1.053a.5.5 0 0 0-.714.545l1.403 4.85a.5.5 0 0 0 .397.354l5.69.953c.268.053.268.437 0 .49l-5.69.953a.5.5 0 0 0-.397.354l-1.403 4.85a.5.5 0 0 0 .714.545l13-6.5a.5.5 0 0 0 0-.894l-13-6.5z" fill="currentColor"></path>
                </g>
            </svg>
        </button>
    </form>
</div>
<script>
    document.querySelector('form#chatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var message = document.querySelector('form#chatForm input[name=message]').value;
        var user_id = document.querySelector('form#chatForm input[name=user_id]').value;
        var user_name = document.querySelector('form#chatForm input[name=user_name]').value;
        var user_contact = document.querySelector('form#chatForm input[name=user_contact]').value;
        if (message.length > 0) {
            message = sanitize(message);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://manvaasam.com/sendMessage.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    response = response.trim();
                    if (response === '1') {
                        var chat = document.querySelector('.chat-box .contentContainer');
                        var text = '<div class="chat outgoing"><div class="details"><p>' + message + '</p></div></div>'
                        chat.insertAdjacentHTML('beforeend', text);
                        document.querySelector('.alertMessage').innerHTML = '<div class="alert alert-info" role="alert"><span class="message">You will get Notify when the admins comes online</span></div>'
                        document.querySelector('form#chatForm input[name=message]').value = '';
                    } else {
                        alert(response);
                    }
                }
            };
            xhr.send('message=' + message + '&user_id=' + user_id + '&user_name=' + user_name + '&user_contact=' + user_contact);
        }
    });


    function getMessages() {
        var user_id = "<?= $_SESSION['email'] ?>";
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://manvaasam.com/getMessages.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                response = response.trim();
                if (response === 'Error') {
                    alert(response);
                } else {
                    response = JSON.parse(response);
                    var chat = document.querySelector('.chat-box .contentContainer');
                    chat.innerHTML = '';
                    for (var i = 0; i < response.length; i++) {
                        if (response[i].sender == "you") {
                            var text = '<div class="chat outgoing"><div class="details"><p>' + response[i].message + '</p></div></div>'
                            chat.insertAdjacentHTML('beforeend', text);
                        } else {
                            var text = '<div class="chat incoming"><div class="details"><p> <span style="font-size:75%;font-weight:bold" >' + response[i].sender.toUpperCase() + '</span><br/>' + response[i].message + '</p></div></div>'
                            chat.insertAdjacentHTML('beforeend', text);
                        }
                    }
                }
            }
        };
        xhr.send('id=' + user_id);
    }
    setInterval(getMessages, 2000);

    function sanitize(string) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#x27;',
            "/": '&#x2F;',
        };
        const reg = /[&<>"'/]/ig;
        return string.replace(reg, (match) => (map[match]));
    }
</script>