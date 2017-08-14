import React, {PropTypes} from 'react';
import MessageListRow from './MessageListRow';
import * as Helper from '../../../utils/manageRoomHelper';

const MessageList = ({messages, getMetaLink, roomId}) => {
    return(

        <ol className="chat">
            {messages.map((message) =>{
                if(typeof message.metaLink === 'boolean' && message.metaLink == false) {
                    getMetaLink(message, roomId);
                }

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
