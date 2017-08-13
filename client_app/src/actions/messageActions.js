import * as types from './actionTypes';
import MessageApi from '../api/messageApi';
import toastr from 'toastr'

export function serverSendMessage(message, roomId) {
    return {type: types.SERVER_SEND_MESSAGE, message, roomId};
}

export function loadMessagesSuccess(messages, roomId) {
    console.log("load messages success");
    console.log(messages);
    return {type: types.LOAD_MESSAGES_SUCCESS, messages, roomId};
}

export function adminSendMessage(message) {
    return {type: types.ADMIN_SEND_MESSAGE, message};
}

export function adminUploadFile(data, roomId) {
    console.log("admin uploads file");
    return function (dispatch) {
        MessageApi.uploadFile(data)
            .then(res => res.data)
            .then(response => {
                console.log("response");
                console.log(response);
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
    console.log("run function load messages from server");
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
