import io from 'socket.io-client';
import * as types from '../actions/actionTypes';
import * as messageActions from '../actions/messageActions';
import * as tabActions from '../actions/tabActions';
import * as roomActions from '../actions/roomActions';
import * as config from '../config/config';

let socket = null;

let Store = null;

export function chatMiddleware() {
    return next => (action) => {
        const result = next(action);

        if (socket && action.type === types.ADMIN_SEND_MESSAGE) {
            socket.emit('client-send-message', action.message, function (data) {
                let message = {
                    id: data.messageId,
                    senderId: data.senderId,
                    senderName: data.name,
                    message: {
                        content: data.message,
                        type: data.type
                    },
                    metaLink: false,
                    createdAt: data.createdAt
                };
                addNewMessage(message, action.message.roomId);
            });
        } else if (socket && action.type === types.ADMIN_SEND_REQUEST_SOCKET) {
            socket.emit('admin-join-room', action.room,function (ackValidation) {
                if (!ackValidation)    return;
                Store.dispatch(roomActions.adminJoinRoomSuccess(action.room));
                Store.dispatch(tabActions.createTab(action.room));
                Store.dispatch(messageActions.loadMessages(action.room.id));
            }); //hard code assignee
        }

        return result;
    };
}

function addNewMessage(message, roomId) {

    Store.dispatch(messageActions.serverSendMessage(message, roomId));
}


export default function createSocket(store) {
    Store = store;
    socket = io(config.SOCKET_SERVER);


    socket.emit('admin-join-default-room',{}, function (ack) {
    });


    socket.on('server-send-message', data => {
        let message = {
            id: data.messageId,
            senderId: data.senderId,
            senderName: data.name,
            message: {
                content: data.message,
                type: data.type
            },
            metaLink: false,
            createdAt: data.createdAt
        };
        console.log(message);
        addNewMessage(message, data.roomId);
    });

    socket.on('server-send-inactive-room', function (data) {
        let room = {
            id: data.roomId,
            topic: data.topic,
            customerName: data.customerName,
            createdAt: data.createdAt,
            status: 1
        }

        store.dispatch(roomActions.addNewRoom(room));
    })

    socket.on('client-close-room', function (roomId) {
        toastr.info("Client has just left the room!");
        let message = {
            id: 0,
            senderId: 0,
            senderName: "System",
            message: {
                content: "Client has just left the room.\nPlease give the tag of the room (Resolved, Resolving or Can't resolve).",
                type: 100
            },
            metaLink: false,
            createdAt: new Date().toLocaleString()
        };

        ddNewMessage(message, roomId);
    });

}


