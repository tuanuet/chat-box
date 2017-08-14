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
            socket.emit('admin-send-message', action.message, function (data) {
                console.log(data);
            });
        } else if (socket && action.type === types.ADMIN_SEND_REQUEST_SOCKET) {
            socket.emit('admin-join-room', action.room,function (ackValidation) {
                console.log(ackValidation);
                if (!ackValidation)    return;
                Store.dispatch(roomActions.adminJoinRoomSuccess(action.room));
                Store.dispatch(tabActions.createTab(action.room));
                Store.dispatch(messageActions.loadMessages(action.room.id));
            }); //hard code assignee
        }

        return result;
    };
}


export default function createSocket(store) {
    Store = store;
    socket = io(config.SOCKET_SERVER);


    socket.emit('admin-join-default-room',{}, function (ack) {
    });


    socket.on('server-send-message', data => {
        addNewMessage(data);
    });

    socket.on('admin-send-message', data => {
        addNewMessage(data);
    });

    socket.on('server-confirm-join', data => {


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

    function addNewMessage(data) {
        let message = {
            id: data.id,
            senderId: data.senderId,
            senderName: data.name,
            message: {
                content: data.message,
                type: data.type
            },
            metaLink: false,
            createdAt: data.createdAt
        };
        store.dispatch(messageActions.serverSendMessage(message, data.roomId));
    }
}


