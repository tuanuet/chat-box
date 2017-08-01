
var tab_id;
$(document).ready(function () {

    /**
     * append a new chat tab when click join room
     */
    $('.btn-join-room').click(function () {
        var url = '/chat/' + $(this).data('roomid');
        adminData.room_id = $(this).data('roomid');
        tab_id = '#' + adminData.room_id;

        /** socket send join event to chat server*/
        socket.emit('admin-join-room', {
            assignee: adminData.assignee,
            room_id: adminData.room_id
        });

        /** server confirm join */
        socket.on('server-confirm-join', function (data) {
            console.log(data);
        });

        /** ajax get chat data */
        $.ajax({
            url:url,
            type: 'get',

            success: function(data){

                /** get data from ajax */
                var room_type = data['room_type'];
                var messages = data['messages'];
                var room = data['room'];
                var customer = $.parseJSON(data['customer']);

                /** append new tab with name of customer */
                var tab = '<li class="">\n' +
                            '<a href="#'+ adminData.room_id +'" data-toggle="tab" aria-expanded="false" class="tab-select">'+ customer.name+
                            '<i class="close-tab btn btn-close fa fa-close"></i></a>' +
                            '</li>';
                $('#list-room-chat').append(tab);


                // document.getElementById('room-chat')

                //console.log($('#tab-room-chat').next().click());

                /** append chat content **/
                console.log(adminData.room_id);
                var roomType =
                    '<div class="tab-pane" id='+ adminData.room_id +'>' +
                        '<div class="row">' +
                            '<div>Room Type: ' + room_type + '</div>' +
                            '<ol class="chat">';

                var contentChat="";

                $.each(messages, function (index, value) {
                    /** determine a message of admin or customer*/
                    var selfOther;
                    if(value["sender_id"] != 0) {
                        selfOther = '<li class="other">';
                    }else {
                        selfOther = '<li class="self">';
                    }
                    /** list of messages **/
                    var listMsg =
                        '<div class="msg">' +
                            '<p class="sender">' +
                                '<a href="#">'+ value["sender_name"] +'</a>' +
                            '</p>' +
                            '<p>'+ value["content"] +'</p>' +
                            '<time>'+ value["sent_time"] +'</time>' +
                        '</div>' +
                        '</li>';

                    contentChat +=selfOther + listMsg;

                });
                console.log(contentChat);

                var inputChat =
                            '</ol>' +
                            '<input class="textarea chat_message" type="text" name="message" id="chat_message" placeholder="Type" />' +
                            '<img class="icon-send" src="/images/send-icon.png" alt="" id="icon-send">' +
                        '</div>' +
                    '</div>';


                // console.log(roomType + contentChat + inputChat);
                $('#room-chat').after(roomType + contentChat + inputChat);
                $('#list-room-chat li:last-child a').click();


            },

            error: function (data) {
                console.log(data);
                console.log("error");
            }
        });

        $(document).on('click', '.tab-select', function () {
            tab_id = $(this).attr('href');
            adminData.room_id = tab_id.substr(1);
        });


        /**
         * remove tab when click 'x' button
         */
        $(document).on('click', '.close-tab', function () {
            $(this).parent().remove();
        });
    });
});


/**
 * remove tab when click 'x' button
 **/

function removeTab()
{
    $(this).remove();
}