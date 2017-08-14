import * as types from './actionTypes';
import MessageApi from '../api/messageApi';
import toastr from 'toastr'

export function serverSendMessage(message, roomId) {
    return {type: types.SERVER_SEND_MESSAGE, message, roomId};
}

export function loadMessagesSuccess(messages, roomId) {
    return {type: types.LOAD_MESSAGES_SUCCESS, messages, roomId};
}

export function adminSendMessage(message) {
    return {type: types.ADMIN_SEND_MESSAGE, message};
}

function updateMessageMetaLink(roomId, id, metaLink) {
    return {type: types.UPDATE_MESSAGE_META_LINK, roomId, id, metaLink};
}

export function getMetaLink(message, roomId) {
    return function (dispatch) {
        MessageApi.getMetaLink(message)
            .then(res => res.data)
            .then(data => {
                let metaLink = null;
                    if(data.result == true) {
                        metaLink= {
                            title: data.meta.title,
                            description: data.meta.description,
                            image: data.meta.image
                        }
                    } else {
                        metaLink = true;
                    }

                dispatch(updateMessageMetaLink(roomId, message.id, metaLink));

            })
            .catch(error => {
                throw (error);
            })
    }
}

export function adminUploadFile(data, roomId) {
    return function (dispatch) {
        MessageApi.uploadFile(data)
            .then(res => res.data)
            .then(response => {
                let message = {
                    senderId: 0,
                    senderName: data.name,
                    message: {
                        content: response.content,
                        type: response.type
                    },
                    roomId: roomId,
                    createdAt: new Date().toLocaleString()
                };
                dispatch(adminSendMessage(message))
            })
            .catch(error => {
                toastr.error("Upload file failed");
                throw (error)
            });
    }
}

export function loadMessages(roomId) {
    return function (dispatch) {
        MessageApi.getMessages(roomId)
            .then(res => res.data)
            .then(messages => {
                dispatch(loadMessagesSuccess(messages, roomId))
            })
            .catch(error => {
                throw (error)
            });
    }
}
