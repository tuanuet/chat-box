var socket = io.connect('http://127.0.0.1:3000');
var socketID;


var adminData = {
    'assignee': 1,
    'room_id' :2,
    'sender_id' : 0
}

//event joim room
var join_room = function(){
    socket.emit('admin-join-room', adminData);
    console.log('admin join to room ' + adminData.room_id);
}

socket.on('server-confirm-join');

//send message to server
var send_chat = function() {
    var msg = $('#chat_message').val();
    $('#chat_message').val('');
    if(msg) {

        socket.emit('admin-send-message', {
            name: "Admin",
            message: msg,
            sender_id: 0,
            room_id : adminData.room_id
        });
    }
    else {
        alert("Please enter a message");
    }
};

//event send chat
$(document).ready(function(){
    $('#chat_message').keypress(function(e){
        if(e.keyCode === 13){
            send_chat();
            return false;
        }
    });

    $('#send').click(function(e){
        e.preventDefault();
        send_chat();
        return false;
    });
});

//receive message
socket.on('server-send-message', function(data){
    data.name;
    data.message;
    if (data !== null && typeof data !== 'object') {
        data = jQuery.parseJSON(data);
    }

    var block = '<div class="rowcont">';
    block += '<p class="textchat">';
    block += '<span class="name">'+ data.user +'</span> ' + data.message;
    block += '</p>';
    block += '</div>';

    $( "#messages" ).append(block);

    var count = $("#messages > div.rowcont").length;

    if (count > 50) {
        $("#messages > div.rowcont").slice(0, 30).remove();
    }

    $('#messages').animate({
        scrollTop: $('#messages .rowcont:last-child').position().top
    }, 'slow');
});
