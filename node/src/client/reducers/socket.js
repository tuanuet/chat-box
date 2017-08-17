import io from 'socket.io-client';
const socket = io('localhost:3000/chat');
export default function (state = socket) {
    return state;
}