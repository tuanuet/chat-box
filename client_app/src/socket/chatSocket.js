import io from 'socket.io-client';
import * as types from '../actions/actionTypes';
import * as messageActions from '../actions/messageActions';
import * as tabActions from '../actions/tabActions';
import * as roomActions from '../actions/roomActions';
import * as config from '../config/config';

let socket = null;

export function chatMiddleware() {
    return next => (action) => {
        const result = next(action);

        if (socket && action.type === types.ADMIN_SEND_MESSAGE) {
            socket.emit('admin-send-message', action.message);
        } else if (socket && action.type === types.ADMIN_JOIN_ROOM) {
            socket.emit('admin-join-room', {room: action.room, assignee: 1}); //hard code assignee
        }

        return result;
    };
}


export default function createSocket(store) {
    socket = io(config.SOCKET_SERVER);


    socket.emit('admin-join-default-room',{},function (success) {
        console.log('admin join default room',success);
    });


    socket.on('server-send-message', data => {
        addNewMessage(data);
    });

    socket.on('admin-send-message', data => {
        addNewMessage(data);
    });

    socket.on('server-confirm-join', data => {
        store.dispatch(roomActions.adminJoinRoomSuccess(data.room));
        store.dispatch(tabActions.createTab(data.room));
        store.dispatch(messageActions.loadMessages(data.room.id));

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


