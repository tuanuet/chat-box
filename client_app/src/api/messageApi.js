import axios from 'axios';
import * as config from '../config/config';

class MessageApi {
    static getMessages(roomId) {
        return axios.get(`${config.HOST}${config.GET_MESSAGE_FROM_ROOM_ID}?roomid=${roomId}`);
    }

    static uploadFile(data) {
        return axios.post(`${config.HOST}${config.UPLOAD_FILE}`, data);
    }
}

export default MessageApi;
