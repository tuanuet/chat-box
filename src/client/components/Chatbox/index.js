import React from 'react';

import {
    addMessage,
    setAdmin,
    fetchMetadata
} from '../../actions/action';

import * as MessageTypes from '../../constants/MessageTypes';
import {execLink} from '../../actions/execLink';
class ChatBox extends React.Component {

    componentDidMount() {

        const {dispatch, socket, customer, room, topic} = this.props;

        socket.emit('client-send-join-room',{customer,room,topic});

        socket.on('server-send-join-room', (({success}) => console.log(`join room ${success}`)));

        socket.on('server-send-message', ({name, message, type}) => {
            console.log({name, message, type});
            let date = new Date().getHours() + ':' + new Date().getSeconds();

            dispatch(addMessage('other', name, {content: message, type}, date));

            let link = execLink(message);
            if (link) {
                dispatch(fetchMetadata(link, message));
            }

        });

        socket.on('server-send-admin-joined', ({name}) => {
            dispatch(setAdmin(name));
            dispatch(addMessage(
                'other',
                '',
                {content: `Admin ${name} xin chao quy khach`, type: MessageTypes.NOTIFICATION},
                '')
            );
        });

        socket.on('server-send-rating', () => {
            dispatch(addMessage(
                'other',
                '',
                {content: '', type: MessageTypes.RATING},
                '')
            );
        });

    }

    render() {
        return (
            <div className="chat-box">
                {this.props.children}
            </div>
        );
    }
}


export default ChatBox;
