

//send message to server


$(document).ready(function () {

    var send_chat = function () {
        contentMsg = tab_id + ' .chat_message';
        console.log(contentMsg);
        var msg = $(contentMsg).val();
        $(contentMsg).val('');
        console.log(msg);
        if (msg) {

            socket.emit('client-send-message', {
                name: "Admin",
                message: msg,
                sender_id: 0,
                room_id: adminData.room_id
            });

            var blockSelf = '<li class="self">';
            blockSelf += '<div class="msg">';
            blockSelf += '<p class="sender"><a href="">' + '</a></p>';
            blockSelf += '<p>' + msg + '</p>';
            blockSelf += '<time>' + '20:10' + '</time>';
            blockSelf += '</div></li>';
            var contentChat = tab_id + " .chat";
            $(contentChat).append(blockSelf);
        }
        else {
            alert("Please enter a message");
        }
    };

    var socket = io.connect('http://127.0.0.1:3000/chat');


    socket.emit('admin-join-room', {
        assignee: adminData.assignee,
        room_id: adminData.room_id
    });

    console.log("join room successfully");

    socket.on('server-confirm-join', function (data) {
        console.log(data);
    });



    $(document).on('keypress','#chat_message', function (e) {
        if (e.charCode === 13) {
            send_chat();
            return false;
        }
    });

    var btnSendId = tab_id + ' .icon-send';
    $(document).on('click', '.icon-send', function (e) {
        send_chat();
    });

    socket.on('server-send-message', function (data) {

        if (data !== null && typeof data !== 'object') {
            data = jQuery.parseJSON(data);
        }


        var block = '<li class="other">';
        block += '<div class="msg">';
        block += '<p class="sender"><a href="">' + data.name + '</a></p>';
        block += '<p>' + data.message + '</p>';
        block += '<time>' + '20:10' + '</time>';
        block += '</div></li>';

        var contentChat = tab_id + " .chat";
        $(contentChat).append(block);

    });

    // socket.on('')

});