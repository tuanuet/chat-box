import React, {PropTypes} from 'react';
import MessageListRow from './MessageListRow';
import * as Helper from '../../../utils/manageRoomHelper';

const MessageList = ({messages, getMetaLink}) => {
    return(

        <ol className="chat">
            {messages.map((message) =>{
                let messageId = Helper.getIndexOfMessageInArray(message, messages);
                return <MessageListRow message={message} messageId={messageId}/>
                })
            }
        </ol>

    );
};

MessageList.propTypes = {
    messages: PropTypes.array.isRequired
}

export default MessageList;
