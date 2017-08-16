import React, {PropTypes} from 'react';

const ChatInput = ({messageInput, onChange, onKeyUp, fileUpload}) => {
    return (
        <div className="chat-footer">
            <input
                className="textarea"
                type="text"
                placeholder="Type here!"
                onChange={onChange}
                value={messageInput}
                onKeyUp={onKeyUp}
            />
            <div className="btn-footer">
                <button className="btn-primary waves-effect waves-light pull-right"> <i className="fa fa-star"></i> </button>
                <button className="fileupload btn-pink waves-effect waves-light pull-right">
                    <i className="glyphicon glyphicon-picture"></i>
                    <input type="file" accept="image/*" className="upload" onChange={fileUpload}/>
                </button>
                <button className="fileupload btn-purple waves-effect waves-light pull-right">
                    <i className="glyphicon glyphicon-paperclip"></i>
                    <input type="file" onChange={fileUpload} className="upload"/>
                </button>

            </div>
        </div>
    );

}

ChatInput.propTypes = {
    onChange: PropTypes.func.isRequired,
    messageInput: PropTypes.string.isRequired
};

export default ChatInput;
