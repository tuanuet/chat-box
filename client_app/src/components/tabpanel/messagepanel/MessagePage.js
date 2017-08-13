import React, {PropTypes} from 'react';
import MessageList from './MessageList';
import ChatInput from './ChatInput';

const MessagePage = ({messages, topicName, roomId, onChange, messageInput, onKeyUp, fileUpload, getMetaLink}) => {
    let roomType = `Room Type: ${topicName}`;
    return(
        <div className="tab-content br-n pn">
            <div className="tab-pane active">
                <div className="row">
                    <div className="col-lg-8">
                        <div>
                            <div>{roomType}</div>
                        </div>
                        <MessageList
                            messages={messages}
                            getMetaLink={getMetaLink}
                            roomId = {roomId}
                        />

                        <ChatInput
                            onChange={onChange}
                            messageInput={messageInput}
                            onKeyUp={onKeyUp}
                            fileUpload={fileUpload}
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

MessagePage.propTypes = {
    messages: PropTypes.array.isRequired,
    topicName: PropTypes.string.isRequired,
    roomId: PropTypes.number,
    onChange: PropTypes.func.isRequired,
    messageInput: PropTypes.string.isRequired
}

export default MessagePage;
