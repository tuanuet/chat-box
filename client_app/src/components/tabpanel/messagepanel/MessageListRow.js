import React, {PropTypes} from 'react';
import * as messageTypes from '../../../config/messageTypes';

const MessageListRow = ({message, messageId, getMetaLink}) => {
    let content = null;
    console.log("messageeeeeee");
    console.log(message);
    if (message.message.type == messageTypes.DEFAULT_MESSAGE) {
        content = <p>{message.message.content}</p>
    } else if (message.message.type == messageTypes.IMAGE_MESSAGE) {
        content =
            <a href={message.message.content}>
                <img src={message.message.content} width={320} height={240}/>
            </a>
    }

    let className = message.message.type != messageTypes.IMAGE_MESSAGE? "li-chat":"li-image";

    return(
        <li key={messageId}
            className={message.senderId == 0? `self ${className}`:`other ${className}`}
            data-toggle="tooltip"
            data-placement="left"
            title={message.createdAt?message.createdAt:"time sent error"}
        >
            {content}
        </li>
    );
};

MessageListRow.propTypes = {
    message: PropTypes.object.isRequired
}

export default MessageListRow;
